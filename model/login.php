<?php
	function getUser(PDO $pdo, string $username): array | bool
	{
		$res = $pdo->prepare('SELECT username, password FROM users WHERE username = :username');
		$res->bindParam(':username', $username);
		$res->execute();
		
		return $res->fetch();
	}