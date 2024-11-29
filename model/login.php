<?php
	function getUser(PDO $pdo, string $username): array | bool
	{
		$res = $pdo->prepare('SELECT * FROM users WHERE username = :username');
		$res->bindParam(':username', $username);
		$res->execute();
		
		return $res->fetch();
	}