<?php
    require "Model/users.php";
    define('BASE_URL_USERS', 'index.php?component=users');

    if (isset($_GET['action']) == 'toggle_enabled' || isset($_GET['action']) == 'delete') {
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = cleanString($_GET['id']);
            switch ($_GET['action']) {
                case 'toggle_enabled':
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
            }
        }
    }

    if (isset($_POST['edit_button'])) {
        $username = !empty($_POST['username']) ? $_POST['username'] : null;
        $password = !empty($_POST['pass']) ? $_POST['pass'] : null;
        $confirm = !empty($_POST['confirm']) ? $_POST['confirm'] : null;
        $email = !empty($_POST['email']) ? $_POST['email'] : null;
        $enabled = !empty($_POST['enabled']) ? true : false;
        $id = $_GET['id'];
        if (!is_numeric($id)) {
            $errors[] = 'id au mauvais format';
        }

        if (
            !empty($username) &&
            !empty($email)
        ) {
            $username = cleanString($username);
            $email = cleanString($email);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'email invalide';
            }

            $res = _count($pdo, $username, $id);

            if ($res['user_number'] !== 0) {
                $errors[] = 'Le username est déjà utilisé';
            }

            if (empty($errors)) {
                $res = update($pdo, $id, $username, $email, $enabled);
                if(!empty($res)) {
                    $errors[] = $res;
                }
                header('location: ' . BASE_URL_USERS);
            }

            if(
                !empty($password) &&
                !empty($confirm) &&
                !empty($errors)
            ) {
                $password = cleanString($password);
                $confirm = cleanString($confirm);

                if ($confirm !== $password) {
                    $errors[] = 'Le mot de passe et sa confirm sont différents';
                } else {
                    $confirm = null;
                    $password = password_hash($password, PASSWORD_DEFAULT);
                    $res  = updatePassword($pdo, $id, $password);
                    if(!empty($res)) {
                        $errors[] = $res;
                    }
                }

            }
        }
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        if (!is_numeric($id)) {
            $errors[] = 'id au mauvais format';
        } else {
            $user = get($pdo, $id);
            if(!is_array($user)) {
                $errors[] = $user;
            }
        }
    }

    if (isset($_POST['create_button'])) {
        $username = !empty($_POST['username']) ? $_POST['username'] : null;
        $password = !empty($_POST['password']) ? $_POST['password'] : null;
        $confirm = !empty($_POST['confirm']) ? $_POST['confirm'] : null;
        $email = !empty($_POST['email']) ? $_POST['email'] : null;
        $enabled = !empty($_POST['enabled']) ? true : false;

        if (
            !empty($username) &&
            !empty($email) &&
            !empty($password) &&
            !empty($confirm)
        ){
            $username = cleanString($username);
            $email = cleanString($email);
            $password = cleanString($password);
            $confirm = cleanString($confirm);

            if ($confirm !== $password) {
                $errors[] = 'Le mot de passe et sa confirmation sont différents';
            } else {
                $confirm = null;
                $password = password_hash($password, PASSWORD_DEFAULT);
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'email invalide';
            }



            if (empty($errors)) {

                $res = _count($pdo, $username);

                if ($res['user_number'] !== 0) {
                    $errors[] = 'Le username est déjà utilisé';
                }

            if (empty($errors)) {
                create($pdo, $username, $email, $enabled, $password);
            }
            }
        } else {
            $errors[] = 'Tous les champs sont obligatoires';
        }
    }

    $search = isset($_POST['search']) ? $_POST['search'] : null;
    $orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : null;
    
    $users = getAll($pdo, $search, $orderBy);
    if (!is_array($users)){
        $errors[] = $users;
    }

    require "View/users.php";
?>