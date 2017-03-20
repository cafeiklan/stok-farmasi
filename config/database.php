<?php

	$host="localhost"; // Host name 
	$username="root"; // Mysql username 
	$password="123"; // Mysql password 
	$db_name="far_stok"; // Database name 
	
	// Connect to server and select databse.
	try
	{
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$db = new PDO('mysql:host='.$host.';dbname='.$db_name.';charset=utf8', $username, $password);
	}
	catch(Exception $e)
	{
		die('Error : ' . $e->getMessage());
	}
	
	date_default_timezone_set('Asia/Jakarta');
	
	//untuk paginasi mysqli
	$conn       = new mysqli( $host, $username, $password, $db_name );
?>