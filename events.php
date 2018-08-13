<?php
include 'includes/header_session.php';

if( isset($_SESSION['user_id']) ){
    $messageMap = '<b><p style="text-align: justify">Busque por eventos: </p></b>';
    include 'map_active.php';
}else{
    header("Location: index.php");
}
