<?php
	session_start();
	require "Includes/database.php";
	require "Includes/function.php";
	$errors = [];
	
	if(isset($_GET['deconnect'])){
		session_destroy();
		header("Location: index.php");
		exit;
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="container">
	<?php
		if (isset($_SESSION['auth'])) {
            require "_partials/navbar.php";
			
			if (isset($_GET['component'])) {
				$componentName = cleanString($_GET['component']);
				if (file_exists("Controller/{$componentName}.php")) {
					require "Controller/$componentName.php";
				}
			}
		} else {
			require 'Controller/login.php';
		}
		require "_partials/errors.php";
	?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>