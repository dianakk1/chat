<?php
// registracijas forma


// action seit
if( $X[2] ) {
	$login = trim($_POST['login']);
	$pass = trim($_POST['pass']);
	$pass2 = trim($_POST['pass2']);

	// validacija
	if( !preg_match('/^[a-zA-Z0-9_]+$/', $login) ) {
		exit('<script>parent.alert("Logins var saturēt tikai burtus, ciparus un _");</script>');
		exit('<script>parent.document.getElementById("error").innerHTML="Logins var saturēt tikai burtus, ciparus un _"</script>');
	}
	if( strlen($login) < 3 ) {
		exit('<script>parent.document.getElementById("error").innerHTML="Logins ir pārāk īss.Vismaz 3 simboli";</script>');
		exit('<script>
			parent.document.getElementById("error").innerHTML="Logins ir pārāk īss.Vismaz 3 simboli";</script>');
	}
	if( strlen($login) > 20 ) {
		exit('<script>parent.alert("Logins ir pārāk garš(vairāk neka 20 simboli)");</script>');
		exit('<script>parent.document.getElementById("error").innerHTML="Logins ir pārāk garš(vairāk neka 20 simboli)"</script>');
	}
	if( strlen($pass) < 3 ) {
		exit('<script>parent.alert("Parole ir pārāk īsa. Vismaz 5 simboli");</script>');
		exit('<script>parent.document.getElementById("error").innerHTML="Parole ir pārāk īsa. Vismaz 5 simboli"</script>');
	}
	if (!preg_match('/[a-zA-Z]/', $pass )) {
		exit('<script>parent.alert("Parolei jāsatur vismaz viens burts");</script>');
	}

	if (!preg_match('/\d/', $pass )) {
		exit('<script>parent.alert("Parolei jāsatur vismaz viens cipars");</script>');
	}
	// ja parole nav vienada
	if( $pass != $pass2 ) {
		exit('<script>parent.alert("Paroles nav vienādas");</script>');
		exit('<script>parent.document.getElementById("error").innerHTML="Paroles nav vienādas";</script>');
	}

	// visi dati pareizi
	//===========

	$pass_hashed = _hash($pass);

	// datu baze
	try {
			$pdo = new PDO('sqlite:database.sqlite');
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// ja tabula neeksiste, tad izveido
			$pdo->exec("CREATE TABLE IF NOT EXISTS users (
					id INTEGER PRIMARY KEY AUTOINCREMENT,
					login TEXT UNIQUE,
					pass TEXT
			)");

			// vai lietotajs jau eksiste
			$stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE login = :login");
			$stmt->execute([':login' => $login]);
			if ($stmt->fetchColumn() > 0) {
					js_error("Šāds lietotājs jau eksistē");
			}

			// jaunais lietotajs datu bazee
			$stmt = $pdo->prepare("INSERT INTO users (login, pass) VALUES (:login, :pass)");
			$stmt->execute([':login' => $login, ':pass' => $pass_hashed]);

			$_SESSION['USER'] = $login;

			// uz sakumu
			exit('<script>
					parent.alert("Lietotājs veiksmīgi reģistrēts");
					document.location.href="/";
			</script>');

	} catch (PDOException $e) {
			js_error("Datu bāzes kļūda: " . $e->getMessage());
	}
}
// funkcija lai izvaditu kļūdu
function js_error($msg) {
		exit('<script>
				parent.alert("'.addslashes($msg).'");
				try {
						parent.document.getElementById("error").innerHTML = "'.addslashes($msg).'";
				} catch(e) {}
		</script>');
}

//HTML =============================
$INSERT .= '
<center>
	<form method="post" action="/registracija/submit_form" target="hframe">
	<div id="error" style="color: red; height: 30px;"></div>
		<input type="text" name="login" placeholder="Login"><br>
		<input type="password" name="pass" placeholder="Parole"><br>
		<input type="password" name="pass2" placeholder="Parole atkartoti"><br>
	<input type="submit" value="Reģistrēties">
<iframe name="hframe" style="display: none;"></iframe>
</form>
</center>
';

?>