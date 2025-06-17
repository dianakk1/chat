<?php
/*
// tabules izveie
try {
		$pdo = new PDO('sqlite:database.sqlite');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$pdo->exec("CREATE TABLE IF NOT EXISTS messages (
				id INTEGER PRIMARY KEY AUTOINCREMENT,
				login TEXT,
				text TEXT,
				time INTEGER
		)");

		echo "Таблица messages успешно создана (или уже существует).";
} catch (PDOException $e) {
		echo "Ошибка при создании таблицы messages: " . $e->getMessage();
}
return;
//*/

if( !$_SESSION['USER'] && $X[2] == 1 ) {
	go('/login');
}
if( $_SESSION['USER']  ) {
	$INSERT 	.= '<a href="/logout">iziet</a>';
}

// action seit
if( $X[2] == 2 ) {
	$text = trim($_POST['text']);
	if( !$text ) {
		exit('<script>parent.alert("Nav teksta");</script>');
	}
	$time = time();
	$login = $_SESSION['USER'];
	
	try{
		$pdo = new PDO('sqlite:database.sqlite');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// ja tabula neeksiste, tad izveido
		$pdo->exec("CREATE TABLE IF NOT EXISTS messages (
			id INTEGER PRIMARY KEY AUTOINCREMENT,
			login TEXT,
			text TEXT,
			time INTEGER
		)");
		
		$stmt = $pdo->prepare("INSERT INTO messages (login, text, time) VALUES (:login, :text, :time)");
		$stmt->execute([':login' => $_SESSION['USER'], ':text' => $text, ':time' => time()]);

		exit('<script>parent.alert("Veiksmīgi publicēts");
		parent.postMessage({action: "redirect", url: "/new_comment"}, "*");
			parent.location.href="/";
		</script>');
	} catch (PDOException $e) {
		exit('<script>parent.alert("Datu bāzes kļūda: '.$e->getMessage().'");</script>');

	}
}

$INSERT .= '
<center>
<div style="width: 600px;">';

	if( !$X[2] ) {
		$INSERT .= 	'<a href="new_comment" class="btn_a"
		style="display: block; margin-top: 20px; height: 30px;
			text-decoration: none; line-height: 30px; border-radius: 10px;
			width: 200px; background-color: '.$COLORS[2].';">Uzrakstīt jaunu komentāru</a></div>';
	}
	else{
		$INSERT .= 	'
			<form method="post" action="/new_comment/submit_form" target="hform"><br>
				<textarea type="text" placeholder="Uzrakstiet komentāru... " name="text"></textarea> <br>
				<input type="submit" value="publicēt"> 
			<iframe name="hform" style="display: none;"></iframe>
			</form>';   
	
	}

	$INSERT .= '
	<div>';
	
		$res = db("SELECT * FROM messages ORDER BY id DESC");
		foreach( $res as $r )	{
			// izvada komentarus
			$INSERT .= '
				<div style="width: 250px; margin: 40px; border:1px solid red;">
					<div style="border: 1px solid black; text-align: left; font-size: 10px; font-weight: 600;">'.htmlspecialchars($r['login'], ENT_QUOTES).'</div>
					<i>'.htmlspecialchars($r['text'], ENT_QUOTES).'</i>
				</div>
			';
		}
	
		$INSERT .= '
	</div>
	';
	
	$INSERT .= '
</div>
</center>
';

//if( !$SESSION['USER'] ) go();
?>