<?php
	require "Model/users.php";

	$users = getAll($pdo);
	
	require "View/users.php";
?>