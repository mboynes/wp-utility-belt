<?php

function ub_stopwatch( $start_time, $stop_time = false ) {
	if ( $stop_time ) {
		$time = $stop_time - $start_time;
	} else {
		$time = microtime( true ) - $start_time;
	}

	if ( $time > 1 ) {
		return number_format( $time, 3 ) . ' s';
	} else {
		return number_format( $time * 1000, 1 ) . ' ms';
	}
}

function ub_ensure_ajaxurl() { ?>
	<script type="text/javascript">var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';</script>
	<?php
}
add_action( 'wp_head', 'ub_ensure_ajaxurl', 5 );


function ub_home() {
	header( "Content-Type: text/plain" );
	$_POST = stripslashes_deep( $_POST );
	if ( isset( $_POST['code'] ) ) {
		if ( false === eval( $_POST['code'] ) )
			echo 'PHP Error encountered, execution halted';
	}
	exit;
}
add_action( 'wp_ajax_home', 'ub_home' );


function ub_benchmark() {
	if ( 'get' == strtolower( $_SERVER['REQUEST_METHOD'] ) ) {
		get_template_part( 'pages/benchmark' );
	} else {
		header( "Content-Type: text/plain" );
		$_POST = stripslashes_deep( $_POST );
		$iterations = empty( $_POST['iterations'] ) ? 1000000 : absint( $_POST['iterations'] );

		if ( ! empty( $_POST['env'] ) ) {
			if ( false === eval( $_POST['env'] ) ) {
				echo 'PHP Error encountered in Environment code, execution halted';
				exit;
			}
		}

		if ( ! empty( $_POST['code_a'] ) ) {
			if ( ! empty( $_POST['code_b'] ) ) {

				$order = array( 'a', 'b' );
				shuffle( $order );

				@ob_end_clean();
				echo "Starting benchmark with {$iterations} iterations in the order " . strtoupper( implode( '-', $order ) ) . "\n";
				echo "=================================================================\n";
				echo "Sample Run, Code A:\n";
				if ( false === eval( $_POST['code_a'] ) ) {
					echo 'PHP Error encountered in code A, execution halted';
					exit;
				}
				echo "\nSample Run, Code B:\n";
				if ( false === eval( $_POST['code_b'] ) ) {
					echo 'PHP Error encountered in code A, execution halted';
					exit;
				}

				$times = array(
					'a' => array(),
					'b' => array(),
				);

				ob_start();
				$loops = ceil( $iterations / 1000 );
				for ( $j = 0; $j <= $loops; ++$j ) {
					$i = 0;
					$start = microtime( true );
					while ( $i < $iterations && $i < $j * 1000 ) {
						$i++;
						@ob_clean();
						if ( false === eval( $_POST[ 'code_' . $order[0] ] ) ) {
							ob_end_flush();
							echo 'PHP Error encountered in code A, execution halted';
							break 2;
						}
					}
					$times[ $order[0] ][] = microtime( true ) - $start;

					$i = 0;
					$start = microtime( true );
					while ( $i < $iterations && $i < $j * 1000 ) {
						$i++;
						@ob_clean();
						if ( false === eval( $_POST[ 'code_' . $order[1] ] ) ) {
							ob_end_flush();
							echo 'PHP Error encountered in code B, execution halted';
							break 2;
						}
					}
					$times[ $order[1] ][] = microtime( true ) - $start;
				}

				@ob_end_clean();
				echo "\n=================================================================";
				echo "\nCode A total time: ";
				$total = array_sum( $times['a'] );
				if ( $total > 1 ) {
					echo number_format( $total, 3 ) . ' s';
				} else {
					echo number_format( $total * 1000, 1 ) . ' ms';
				}
				echo "\nCode B total time: ";
				$total = array_sum( $times['b'] );
				if ( $total > 1 ) {
					echo number_format( $total, 3 ) . ' s';
				} else {
					echo number_format( $total * 1000, 1 ) . ' ms';
				}

			} else {
				// We're just benchmarking one block of code
				$start = microtime( true );
				$i = 0;
				@ob_end_clean();
				echo "Starting benchmark with {$iterations} iterations\n";
				echo "================================================\n";
				echo "Sample Run:\n";
				if ( false === eval( $_POST['code_a'] ) ) {
					echo 'PHP Error encountered, execution halted';
					exit;
				}
				ob_start();
				while ( $i++ < $iterations ) {
					if ( false === eval( $_POST['code_a'] ) ) {
						ob_end_flush();
						echo 'PHP Error encountered, execution halted';
						break;
					}
					@ob_clean();
				}
				@ob_end_clean();
				echo "\n================================================\n";
				echo "Total time: " . ub_stopwatch( $start );
			}
		}
	}
	exit;
}
add_action( 'wp_ajax_benchmark', 'ub_benchmark' );


function ub_wordpress() {
	if ( 'get' == strtolower( $_SERVER['REQUEST_METHOD'] ) ) {
		get_template_part( 'pages/wordpress' );
	}
	exit;
}
add_action( 'wp_ajax_wordpress', 'ub_wordpress' );


function ub_elasticsearch() {
	if ( 'get' == strtolower( $_SERVER['REQUEST_METHOD'] ) ) {
		get_template_part( 'pages/elasticsearch' );
	} else {
		$_POST = stripslashes_deep( $_POST );
		if ( !isset( $_POST['es_url'], $_POST['es_query'] ) )
			die( 'Invalid query' );

		# Remember for next time
		set_transient( 'es_url', $_POST['es_url'], 365 * DAY_IN_SECONDS );
		set_transient( 'es_query', $_POST['es_query'], 365 * DAY_IN_SECONDS );

		$request = wp_remote_post( $_POST['es_url'], array(
			'headers' => array( 'Content-Type' => 'application/json' ),
			'body' => $_POST['es_query']
		) );
		var_export( $request );
	}
	exit;
}
add_action( 'wp_ajax_elasticsearch', 'ub_elasticsearch' );


function ub_passwords() {
	if ( 'get' == strtolower( $_SERVER['REQUEST_METHOD'] ) ) {
		get_template_part( 'pages/passwords' );
	} else {

	}
	exit;
}
add_action( 'wp_ajax_passwords', 'ub_passwords' );


function ub_regex() {
	if ( 'get' == strtolower( $_SERVER['REQUEST_METHOD'] ) ) {
		get_template_part( 'pages/regex' );
	} else {
		$_POST = stripslashes_deep( $_POST );
		switch ( $_POST['regex'] ) {
			case 'Match':
				if ( preg_match( $_POST['expression'], $_POST['content'], $matches ) )
					echo htmlentities( var_export( $matches, 1 ) );
				else
					echo "No matches Found";
				break;

			case 'Match All':
				if ( $count = preg_match_all( $_POST['expression'], $_POST['content'], $matches ) )
					echo "$count matches found\n", htmlentities( var_export( $matches, 1 ) );
				else
					echo "No matches found";
				break;

			case 'Replace':
				if ( $count = preg_match_all( $_POST['expression'], $_POST['content'], $matches ) )
					echo "$count matches found\n";
				else
					echo "No matches found\n";
				echo htmlentities( preg_replace( $_POST['expression'], $_POST['replace'], $_POST['content'] ) );
				break;
		}
	}
	exit;
}
add_action( 'wp_ajax_regex', 'ub_regex' );


function ub_printf() {
	if ( 'get' == strtolower( $_SERVER['REQUEST_METHOD'] ) ) {
		get_template_part( 'pages/printf' );
	} else {
		$_POST = stripslashes_deep( $_POST );
		vprintf( $_POST['printf_format'], preg_split( '/[\r\n]+/', $_POST['printf_arguments'] ) );
	}
	exit;
}
add_action( 'wp_ajax_printf', 'ub_printf' );


function ub_serialization() {
	if ( 'get' == strtolower( $_SERVER['REQUEST_METHOD'] ) ) {
		get_template_part( 'pages/serialization' );
	} else {
		$_POST = stripslashes_deep( $_POST );
		if ( 'Serialize' == $_POST['serialization'] ) {
			echo serialize( call_user_func( create_function('', "return {$_POST['serializee']};") ) );
		} elseif ( 'JSON Encode' == $_POST['serialization'] ) {
			$JSON_PRETTY_PRINT = defined( 'JSON_PRETTY_PRINT' ) ? JSON_PRETTY_PRINT : null;
			echo json_encode( call_user_func( create_function('', "return {$_POST['serializee']};" ) ), $JSON_PRETTY_PRINT );
		} elseif ( 'JSON Decode' == $_POST['serialization'] ) {
			var_export( json_decode( $_POST['serializee'], true ) );
		} else {
			$unserialized = unserialize( $_POST['serializee'] );
			if ( false !== $unserialized ) {
				var_export( $unserialized );
			} else {
				# There was an error, try to fix it
				# common issue is with crlf
				$serializee = str_replace( array( "\n\r", "\r\n" ), "\n", $_POST['serializee'] );
				$unserialized = unserialize( $serializee );
				if ( false !== $unserialized ) {
					echo "Notice: CRLF newlines corrected\n===============================\n\n";
					var_export( $unserialized );
				} else {
					echo 'Error unserializing data';
				}
			}
		}
	}
	exit;
}
add_action( 'wp_ajax_serialization', 'ub_serialization' );


function ub_time() {
	if ( 'get' == strtolower( $_SERVER['REQUEST_METHOD'] ) ) {
		get_template_part( 'pages/time' );
	} else {
		$_POST = stripslashes_deep( $_POST );
		$content_type = 'text/html';
		$format = isset( $_POST['date_format'] ) ? $_POST['date_format'] : 'Y-m-d H:i:s T';
		$stamp = time();
		if ( isset( $_POST['mktime'], $_POST['mktime'][0], $_POST['mktime'][1], $_POST['mktime'][2], $_POST['mktime'][3], $_POST['mktime'][4], $_POST['mktime'][5] )
			&& '' != implode( '', $_POST['mktime'] )
		) {
			array_walk( $_POST['mktime'], create_function( '&$a', '$a = (int) $a;' ) );
			$stamp = call_user_func_array( 'mktime', $_POST['mktime'] );
			// $mkstamp = call_user_func_array( 'mktime', $_POST['mktime'] );
			// echo "Make Time\n==================================================================\n";
			// echo 'mktime( ' . implode( ', ', $_POST['mktime'] ) . " ) == $mkstamp (" . date( 'Y-m-d H:i:s', $mkstamp ) . ")\n\n";
		} elseif ( isset( $_POST['timestamp'] ) && !empty( $_POST['timestamp'] ) ) {
			$stamp = (int) $_POST['timestamp'];
			// echo "Timestamp\n================================\n";
			// echo "{$_POST['timestamp']} == " . date( 'Y-m-d H:i:s', $_POST['timestamp'] ) . "\n\n";
		} elseif ( isset( $_POST['strtotime'] ) && !empty( $_POST['strtotime'] ) ) {
			$stamp = strtotime( $_POST['strtotime'] );
			// echo "String to Timestamp\n========================================================\n";
			// echo "{$_POST['strtotime']} == " . $stamp . " == " . date( 'Y-m-d H:i:s', $stamp );
		}

		?><html>
		<table class="table table-bordered">
			<tbody>
				<tr>
					<th scope="row">Timestamp</th>
					<td><?php echo $stamp ?></td>
				</tr>
				<tr>
					<th scope="row"><code>mktime</code></th>
					<td><?php echo "mktime( " . date( "G, i, s, n, j, Y", $stamp ) . " )" ?></td>
				</tr>
				<tr>
					<th scope="row">Formatted</th>
					<td><?php echo date( $format, $stamp ) ?></td>
				</tr>
				<tr>
					<th scope="row">Local</th>
					<td><?php echo wp_date( $format, $stamp ) ?></td>
				</tr>
			</tbody>
		</table>
		</html>
		<?php
	}
	exit;
}
add_action( 'wp_ajax_time', 'ub_time' );
