<?php
function db($sql) {
	try {
		$pdo = new PDO('sqlite:database.sqlite');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql_trimmed = strtolower(trim($sql));
		if (substr($sql_trimmed, 0, 6) === 'select') {
			$stmt = $pdo->query($sql);
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		} else {
			return $pdo->exec($sql);
		}

	} catch (PDOException $e) {
		die("DB kļūda: " . $e->getMessage());
	}
}


?>