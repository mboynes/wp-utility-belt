<?php
global $words, $limit;

$words = file( get_template_directory() . '/assets/words.txt' );
$limit = count( $words ) - 1;

function some_random_word() {
	global $words, $limit;
	return preg_replace( '/\s/', '', $words[ rand( 0, $limit ) ] );
}

$passwords = array();
for ( $i = 0; $i < 5; $i++ ) {
	$passwords[] = some_random_word() . rand( 10, 99 ) . substr( str_shuffle( '!@#$%&()' ), 0, 1 ) . ucfirst( some_random_word() );
}
?>


		<div id="passwords">
			<div class="view-container span6">
				<!-- <div class="well"> -->
					<h3>Here are some random passwords for you</h3>
					<dl>
					<?php foreach ( $passwords as $password ) : ?>
						<dt><pre><?php echo $password ?></pre></dt>
					<?php endforeach; ?>
					</dl>
				<!-- </div> -->
				<a href="#" class="reload btn" data-page="passwords"><i class="icon-refresh"></i> Refresh</a>
			</div>
		</div>
