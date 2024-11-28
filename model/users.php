<?php
    function getAll(PDO $pdo): array{
		$res = $pdo->prepare('SELECT * FROM users');
		$res->execute();
		
		return $res->fetchAll();
    }

	function toggleEnabled(PDO $pdo, int $id): void{
		$res = $pdo->prepare('UPDATE users SET enabled = NOT enabled WHERE id = :id');
		$res->bindParam(':id', $id, PDO::PARAM_INT);
	}
?>