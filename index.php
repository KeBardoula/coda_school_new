<?php
require 'include/database.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/bootstrap.min.css"/>
        <title></title>
    </head>
    <body>
        <div class="container">
            <h1>Connexion</h1>
            <?php
                require 'controller/login.php';
            ?>
        </div>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>