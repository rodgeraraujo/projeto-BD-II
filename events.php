<?php
include 'includes/header_session.php';

if( isset($_SESSION['user_id']) ){
    include 'map_active.php';
}else{
    header("Location: index.php");
}
