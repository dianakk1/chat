<?php

$s = $_SERVER['REQUEST_URI'];

$U = array();

$s = preg_replace( '/\?[^\?]*$/', '', $s );
if( $s == '/' ) return;

$s = rawurldecode( $s );
$U = explode( '/', $s );


if( $U[1] == 'new_comment' ) {
	$X = array( 1, 1, 1 );
	if( $U[2] == 'submit_form' ) {
		$X[2] = 2;
	}
}

if( $U[1] == 'login' ) {
	$X = array(2,1);
	if( $U[2] == 'submit_form' ) {
		$X[2] = 1;
	}
}

if( $U[1] == 'registracija' ) {
	$X = array(2,2);
	if( $U[2] == 'submit_form' ) {
		$X[2] = 1;
	}
}

?>