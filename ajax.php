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

				$remaining = array(
					'a' => $iterations,
					'b' => $iterations,
				);

				ob_start();
				while ( $remaining['a'] && $remaining['b'] ) {
					$start = microtime( true );
					for ( $j = 1; $j <= 1000 && $remaining[ $order[0] ]; $j++ ) {
						@ob_clean();
						$remaining[ $order[0] ]--;

						if ( false === eval( $_POST[ 'code_' . $order[0] ] ) ) {
							ob_end_flush();
							echo "PHP Error encountered in code " . strtoupper( $order[0] ) . ", execution halted";
							break 2;
						}
					}
					$times[ $order[0] ][] = microtime( true ) - $start;

					$start = microtime( true );
					for ( $j = 1; $j <= 1000 && $remaining[ $order[1] ]; $j++ ) {
						@ob_clean();
						$remaining[ $order[1] ]--;

						if ( false === eval( $_POST[ 'code_' . $order[1] ] ) ) {
							ob_end_flush();
							echo "PHP Error encountered in code " . strtoupper( $order[1] ) . ", execution halted";
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


function ub_regex() {
	if ( 'get' == strtolower( $_SERVER['REQUEST_METHOD'] ) ) {
		get_template_part( 'pages/regex' );
	} else {
		$_POST = stripslashes_deep( $_POST );
		switch ( $_POST['regex'] ) {
			case 'Match':
				if ( preg_match( $_POST['expression'], $_POST['content'], $matches ) )
					echo wp_json_encode( $matches, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
				else
					echo "No matches Found";
				break;

			case 'Match All':
				if ( $count = preg_match_all( $_POST['expression'], $_POST['content'], $matches ) )
					echo "$count matches found\n", wp_json_encode( $matches, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
				else
					echo "No matches found";
				break;

			case 'Replace':
				if ( $count = preg_match_all( $_POST['expression'], $_POST['content'], $matches ) )
					echo "$count matches found\n";
				else
					echo "No matches found\n";
				echo preg_replace( $_POST['expression'], $_POST['replace'], $_POST['content'] );
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
			echo wp_json_encode( call_user_func( create_function('', "return {$_POST['serializee']};" ) ), JSON_PRETTY_PRINT );
		} elseif ( 'JSON Decode' == $_POST['serialization'] ) {
			ub_nicer_var_export( json_decode( $_POST['serializee'], true ) );
		} else {
			$unserialized = unserialize( $_POST['serializee'] );
			if ( false !== $unserialized ) {
				ub_nicer_var_export( $unserialized );
			} else {
				# There was an error, try to fix it
				# common issue is with crlf
				$serializee = str_replace( array( "\n\r", "\r\n" ), "\n", $_POST['serializee'] );
				$unserialized = unserialize( $serializee );
				if ( false !== $unserialized ) {
					echo "Notice: CRLF newlines corrected\n===============================\n\n";
					ub_nicer_var_export( $unserialized );
				} else {
					echo 'Error unserializing data';
				}
			}
		}
	}
	exit;
}
add_action( 'wp_ajax_serialization', 'ub_serialization' );

function ub_nicer_var_export( $value, $echo = true ) {
	$export   = var_export( $value, true );
	$patterns = [
		"/array \(/"                       => '[',
		"/^([ ]*)\)(,?)$/m"                => '$1]$2',
		"/=>[ ]?\n[ ]+\[/"                 => '=> [',
		"/([ ]*)(\'[^\']+\') => ([\[\'])/" => '$1$2 => $3',
		'/NULL/'                           => 'null',
	];

	$render = preg_replace( array_keys( $patterns ), array_values( $patterns ), $export );

	if ( $echo ) {
		echo $render;
	} else {
		return $render;
	}
}

function ub_time() {
	if ( 'get' == strtolower( $_SERVER['REQUEST_METHOD'] ) ) {
		get_template_part( 'pages/time' );
	} else {
		$_POST        = stripslashes_deep( $_POST );
		$content_type = 'text/html';
		$format       = isset( $_POST['date_format'] ) ? $_POST['date_format'] : 'Y-m-d H:i:s T';
		$datetime     = new DateTime();
		$timezone     = new DateTimeZone( $_POST['date_timezone'] ?? 'UTC' );
		$stamp        = false;

		$datetime->setTimeZone( new DateTimeZone( 'UTC' ) );

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

		if ( $stamp ) {
			$datetime->setTimestamp( $stamp );
		}

		$datetime->setTimeZone( $timezone );

		?><html>
		<table class="table table-bordered">
			<tbody>
				<tr>
					<th scope="row">Timestamp</th>
					<td><?php echo $datetime->getTimestamp(); ?></td>
				</tr>
				<tr>
					<th scope="row"><code>mktime</code></th>
					<td><?php echo "mktime( " . date( "G, i, s, n, j, Y", $datetime->getTimestamp() ) . " )"; ?></td>
				</tr>
				<tr>
					<th scope="row">Formatted</th>
					<td><?php echo $datetime->format( $format ); ?></td>
				</tr>
				<tr>
					<th scope="row">Local</th>
					<td><?php echo wp_date( $format, $datetime->getTimestamp() ); ?></td>
				</tr>
			</tbody>
		</table>
		</html>
		<?php
	}
	exit;
}
add_action( 'wp_ajax_time', 'ub_time' );
