<?php
// fails ar login formu

// action seit
if( $X[2] ) {
	$login = trim($_POST['login']);
	$pass = _hash( trim($_POST['pass']) );

	$res = db("SELECT * FROM users WHERE login='$login' AND pass='$pass'");
	if( count($res) ) {
		$_SESSION['USER'] = $login;
		exit('<script>parent.alert("Veiksmīgi ielogojies");
			parent.location.href="/new_comment";
		</script>');
	}
	else{
		exit('<script>parent.alert("Nepareizs logins vai parole");</script>');
	}
	exit('<script>parent.document.getElementById("error").innerHTML="Nepareizs logins vai parole";</script>');
}

//HTML =============
$STYLE .= '
	.login_form input{
		width: 200px;
		background-color: '.$COLORS[3].';
		height: 30px;
	}
';

$INSERT .= '
<br><br>
<center>
<form method="post" class="login_form" target="hframe">
	<div id="error" style="color: red;"></div>
	<input type="text" name="login" placeholder="Login"><br>
	<input type="password" name="pass" placeholder="Parole"><br>
	<input type="submit" value="login">
<iframe name="hframe" style="display: none;"></iframe><br>
</form>
<a class="btn_a" href="/registracija" style="display: block; 
	background-color: '.$COLORS[3].'
	width: 150px;">Reģistrēties<a>
</center>
';


?>