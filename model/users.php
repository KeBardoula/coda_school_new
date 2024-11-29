<?php
    function getAll(PDO $pdo, string | null $search = null, string | null $orderBy = null){
        $query = 'SELECT * FROM users';
    
        if ($search !== null) {
            $query .= ' WHERE id LIKE :search OR username LIKE :search OR email LIKE :search';
        }

        if ($orderBy !== null) {
            $query .= " ORDER BY $orderBy";
        }
    
        try {
            $res = $pdo->prepare($query);
    
            if ($search !== null) {
                $res->bindValue(':search', "%$search%");
            }
            $res->execute();
            return $res->fetchAll();
        } catch (PDOException $e) {
            return $e->getMessage(); // Correction ici
        }
    }

	function toggleEnabled(PDO $pdo, int $id): void{
		$res = $pdo->prepare('UPDATE users SET enabled = NOT enabled WHERE id = :id');
		$res->bindParam(':id', $id, PDO::PARAM_INT);
		$res->execute();
	}
	
	function deleteUsers(PDO $pdo, int $id): void{
		try {
			$res = $pdo->prepare('DELETE FROM users WHERE id = :id');
			$res->bindParam(':id', $id, PDO::PARAM_INT);
			$res->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
    function get(PDO $pdo, int $id)
    {
        try {
            $res = $pdo->prepare("SELECT * FROM users WHERE id = :id");
            $res->bindParam(':id', $id, PDO::PARAM_INT);
            $res->execute();
            return $res->fetch();
        } catch (Exception $e) {
            return "Erreur de requete : {$e->getMessage()}";
        }
    }
    function _count(PDO $pdo, string $username, int $id = null)
    {
        $query = "SELECT COUNT(*) AS user_number FROM users WHERE username = :username";

        if ($id !== null) {
            $query = $query . " AND id <> :id";
        }

        try {
            $state = $pdo->prepare($query);
            $state->bindParam(':username', $username, PDO::PARAM_STR);

            if ($id !== null) {
                $state->bindParam(':id', $id, PDO::PARAM_INT);
            }

            $state->execute();
            return $state->fetch();
        } catch (Exception $e) {
            return "Erreur de verification du username {$e->getMessage()}";
        }
    }

	function update(PDO $pdo, int $id, string $username, string $email, bool $enabled)
    {
        try {
            $res = $pdo->prepare("UPDATE `users` SET username = :username, 
                    email = :email, enabled = :enabled WHERE id = :id");
            $res->bindParam(':id', $id, PDO::PARAM_INT);
            $res->bindParam(':username', $username);
            $res->bindParam(':email', $email);
            $res->bindParam(':enabled', $enabled, PDO::PARAM_BOOL);
            $res->execute();
        } catch (Exception $e) {
            return "Erreur de requete : {$e->getMessage()}";
        }
    }
    function create(PDO $pdo, string $username, string $email, bool $enabled, string $password)
    {
        try {
            $state = $pdo->prepare('INSERT INTO users (`username`, `email`, `password`, `enabled`) 
                        VALUES (:username, :email, :password, :enabled)');
            $state->bindParam(':username', $username);
            $state->bindParam(':email', $email);
            $state->bindParam(':password', $password);
            $state->bindParam(':enabled', $enabled, PDO::PARAM_BOOL);
            $state->execute();
        } catch (Exception $e) {
            return "Erreur à la création du user {$e->getMessage()}";
        }
    }
    function updatePassword(PDO $pdo, int $id, string $password)
    {
        try {
            $res = $pdo->prepare("UPDATE `users` SET password = :password WHERE id = :id");
            $res->bindParam(':id', $id, PDO::PARAM_INT);
            $res->bindParam(':password', $password);
            $res->execute();
        } catch (Exception $e) {
            return "Erreur de requete : {$e->getMessage()}";
        }
    }
?>