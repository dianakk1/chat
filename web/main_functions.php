<?php

// paroles hash
function _hash($pass) {
	return( md5( $pass.md5( $pass ) ) );
}
// funkcija lai pariet uz citu lappu
function go( $url ) {
	included_files();
	header('Location: https://27e478a2-e856-4f62-bee6-30231e372338-00-1n1zvk0gcdqaf.janeway.replit.dev'.( $url ? $url : '/' ) );
	exit;
}

// faili
function included_files() {
	$incs = $_SESSION['INCLUDED_FILES'];
	if ( !count($incs) ) {
		$incs = array();
	}

	$incs[3] = $incs[2];
	$incs[2] = $incs[1];
	$incs[1] = get_included_files();
	$_SESSION['INCLUDED_FILES'] = $incs;
}




function U( ){ 
	$n = func_num_args( );
	$arg = func_get_args( );
	$str = array(  );
	$e = $arg[0];
	for( $i = 0; $i < $n; $i++  ){
		if( $arg[$i] )$str[] = 'X['.( $i ).']='.$arg[$i];
	}

	return '/?x='.implode( '&', $str );
}
?>