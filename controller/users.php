<?php
require "Model/users.php";
define('BASE_URL_USERS', 'index.php?component=users');

if (isset($_GET['action']) && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = cleanString($_GET['id']);

    switch ($_GET['action']) {
        case 'togleEnabled':
            toggleEnabled($pdo, $id);
            header('location: ' . BASE_URL_USERS);
            break;
        case 'delete':
            $delete = deleteUsers($pdo, $id);
            if (!empty($delete)) {
                $errors[] = "Impossible de supprimer l'utilisateur, il est encore lié à une personne";
            } else {
                header('location: ' . BASE_URL_USERS);
            }
            break;
        case 'editate':
            if (isset($_POST['update_button'])) {
                // Récupérer et sécuriser les données du formulaire
                $username = !empty($_POST['username']) ? $_POST['username'] : null;
                $password = !empty($_POST['password']) ? $_POST['password'] : null;
                $email = !empty($_POST['email']) ? $_POST['email'] : null;
        
                // Vérifier que toutes les variables sont définies avant d'appeler la fonction
                if ($username !== null && $email !== null && $password !== null) {
                    editUsers($pdo, $id, $username, $email, $password);
                    header('location: ' . BASE_URL_USERS);
                    exit; // Assurez-vous d'utiliser exit après un header redirect
                } else {
                    $errors[] = "Tous les champs doivent être remplis.";
                }
            }
            break;
        case 'created':
            countUsers($pdo);
            createUsers($pdo); // Pas besoin de passer des paramètres
            header('location: ' . BASE_URL_USERS);
            break;
    }
}

$users = getAll($pdo);
require "View/users.php";
?>