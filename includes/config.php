<?php
$server = 'localhost'; //Server name
$username = 'root'; //Server username
$password = ''; //Server password
$database = 'login1'; //Database name

try{
	$conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch(PDOException $e){
	die( "Connection failed: " . $e->getMessage());
}