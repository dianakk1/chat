<?php
	$HTML = ''; // gatavais html sablons
	$STYLE = ''; // stilam
	$MENU = ''; // menu
	$INSERT = ''; // unikalais kods katrais lappai
	$TOP = ''; // top menu

	define( 'HOST_NAME',	'https://27e478a2-e856-4f62-bee6-30231e372338-00-1n1zvk0gcdqaf.janeway.replit.dev/');

	$COLORS = array(
		0 => '#78b3e2', // zils main
		1 => '#ff2400',	// sarkans
		2 => '#8ee278', // zals 
		3 => '#e3e4e2', // peleks
	);


$X = array( 0, 0, 0 );
print $_GET['x'];
if( isset( $_GET['x'] ) ) {
	parse_str( $_GET['x'] );
}
elseif( isset( $_POST['x'] ) ) {
	parse_str( explode( '&', $_POST['x'] ) );
}


include 'web/request.php';

if( !$X[1] ) $X[1] = 1;
if( !$X[0] ) $X[0] = 1;

?>