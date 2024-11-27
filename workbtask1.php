<?php
function connectToDatabase()
{
	$mysqli = new mysqli("localhost", "2323425", "Sardaruza1r12", "db2323425");
	if($mysqli -> connect_error)
	{
	   echo "Failed to connect to MYSQL: " . $mysqli -> connect_error;
	   exit();
	}
	return $mysqli;
}
?>