<?php

if ( !is_admin() || ( defined( 'DOING_AJAX') && DOING_AJAX ) )
	require_once( __DIR__ . '/ajax.php' );

function ub_scripts() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'bootstrap', 'https://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.1/js/bootstrap.min.js', array( 'jquery' ), '2.2.1', true );
	wp_enqueue_script( 'application', get_template_directory_uri() . '/application.js', array( 'jquery', 'bootstrap' ), '1.1.0', true );
	wp_enqueue_code_editor(
		array(
			'type'       => 'php',
			'codemirror' => array(
				'lineNumbers' => false,
				'mode'        => 'text/x-php', // PHP mode with an implied `<?php`.
			),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'ub_scripts' );

add_action( 'wp_title', function( $title, $sep, $seplocation ) {
	if ( !$title )
		$title = 'WordPress Utility Belt';
	return $title;
}, 99, 3 );

function ub_require_login() {
	if ( ! is_user_logged_in() ) {
		wp_safe_redirect( wp_login_url() );
	}
}
add_action( 'template_redirect', 'ub_require_login' );

function ub_login_message() {
	return '<p class="message">' . esc_html__( 'You must log in to use the Utility Belt.', 'wp-utility-belt' ) . '</p>';
}
add_filter( 'login_message', 'ub_login_message' );

if ( isset( $_POST['full'] ) ) {
	$_POST = stripslashes_deep( $_POST );

	function ub_force_blank_template( &$wp_query ) {
		$wp_query->is_home = false;
		$wp_query->is_search = true;
	}
	add_action( 'parse_query', 'ub_force_blank_template' );

	function ub_load_blank_template() {
		return get_template_directory() . '/full.php';
	}
	add_filter( 'template_include', 'ub_load_blank_template' );

	if ( isset( $_POST['code'] ) ) {
		if ( isset( $_POST['action'] ) ) {
			$function = function () {
				eval( $_POST['code'] );
			};
			add_action( $_POST['action'], $function, 999, 999 );
		} else {
			if ( false === eval( $_POST['code'] ) )
				echo 'PHP Error encountered';
		}

	}
}
