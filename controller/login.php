<?php
	global $pdo;
	
	require "Model/login.php";
	
	if (isset($_POST['login_button'])) {
		$username = !empty($_POST['username']) ? $_POST['username'] : null;
		$pass = !empty($_POST['pass']) ? $_POST['pass'] : null;
		
		if (!empty($username) && !empty($pass)) {
			$username = cleanString($username);
			$pass = cleanString($pass);
			
			if (isset($pdo)) {
				$user = getUser($pdo, $username);
				$isMatchPassword = is_array($user) && password_verify($pass, $user['password']);
				
				if ($isMatchPassword && $user['enabled']) {
					$_SESSION['auth'] = true;
					$_SESSION['user_id'] = $user['id'];
					$_SESSION['username'] = $user['username'];
					header('location: index.php');
				} elseif (!$user['enabled']) {
					$errors[] = 'Votre compte est désactiver';
				} else {
					$errors[] = 'identification échouée';
				}
			} else {
				$errors[] = 'Connexion à la base de données non disponible';
			}
		}
	}
	
	require "View/login.php";
?>