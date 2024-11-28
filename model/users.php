<?php
    function getAll(PDO $pdo): array{
		$res = $pdo->prepare('SELECT * FROM users');
		$res->execute();
		
		return $res->fetchAll();
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

	function editUsers(PDO $pdo, int $id, string $username, string $email, string $password): void {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hashage du mot de passe
            $res = $pdo->prepare('UPDATE users SET username = :username, email = :email, password = :password WHERE id = :id');
    
            // Lier les paramètres
            $res->bindParam(':username', $username);
            $res->bindParam(':email', $email);
            $res->bindParam(':password', $hashedPassword);
            $res->bindParam(':id', $id, PDO::PARAM_INT);
    
            // Exécuter la requête
            $res->execute();
    
            // Vérifier si la mise à jour a eu lieu
            if ($res->rowCount() === 0) {
                echo "Aucune mise à jour effectuée. Vérifiez que l'ID existe et que les valeurs sont différentes.";
            }
        } catch (PDOException $e) {
            echo "Erreur à la mise à jour de l'info utilisateur : {$e->getMessage()}";
        }
    }
    function countUsers(PDO $pdo): array{
        if (empty($errors)){
            try {
                $res = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username;");
                $res->bindParam(':username', $username);
                $res->execute();
                $select = $res->fetch();
            } catch (PDOException $e){
                $errors[] = "Erreur de vérification de username {$e->getMessage()}";
            }

            if ($select['user_number'] !== 0){
                $errors[] = "Nom d'utilisateur déjà utilisé";
            }
        }
    }
    function createUsers(PDO $pdo): void {
        if (isset($_POST['create_button'])) {
            $username = !empty($_POST['username']) ? $_POST['username'] : null;
            $password = !empty($_POST['password']) ? $_POST['password'] : null;
            $confirm = !empty($_POST['confirm']) ? $_POST['confirm'] : null;
            $email = !empty($_POST['email']) ? $_POST['email'] : null;
            $enabled = isset($_POST['enabled']) ? true : false; // Si la case est cochée, enabled est true
    
            $errors = []; // Initialiser le tableau d'erreurs
    
            if ($username === null || $password === null || $confirm === null || $email === null) {
                $errors[] = "Tous les champs sont obligatoires.";
            } else {
                $username = cleanString($username);
                $email = cleanString($email);
                $password = cleanString($password);
                $confirm = cleanString($confirm);
    
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "E-mail invalide";
                }
    
                if ($password !== $confirm) {
                    $errors[] = "Les mots de passe ne sont pas identiques";
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                }
    
                if (empty($errors)) {
                    try {
                        $res = $pdo->prepare("INSERT INTO users (username, password, email, enabled) VALUES (:username, :password, :email, :enabled)");
                        $res->bindParam(':username', $username);
                        $res->bindParam(':password', $hashedPassword);
                        $res->bindParam(':email', $email);
                        $res->bindParam(':enabled', $enabled, PDO::PARAM_BOOL);
                        $res->execute();
                    } catch (PDOException $e) {
                        $errors[] = "Erreur à la création de l'utilisateur : {$e->getMessage()}";
                    }
                }
            }
    
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<p style='color:red;'>$error</p>";
                }
            }
        }
    }
?>