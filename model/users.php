<?php
    function getAll(PDO $pdo): array{
		$res = $pdo->prepare('SELECT * FROM users');
		$res->execute();
		
		return $res->fetchAll();
    }
?>