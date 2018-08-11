<?php
include 'includes/error_report.php';

session_start();

require 'includes/config.php';

if( isset($_SESSION['user_id']) ){

    $records = $conn->prepare('SELECT id,email,name, course, institution, password FROM users WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = NULL;

    if( count($results) > 0){
        $user = $results;
    }

}