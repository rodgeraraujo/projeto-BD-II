<?php
require("includes/config.php");

// Gets data from URL parameters.
if(isset($_GET['add_location'])) {
    add_location();
}
if(isset($_GET['confirm_location'])) {
    confirm_location();
}

function add_location(){
    $con=mysqli_connect ("localhost", 'root', '','geolocaliza');
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }
    $lat = $_GET['lat'];
    $lng = $_GET['lng'];
    $title =$_GET['title'];
    $theme =$_GET['theme'];
    $date_begin = $_GET['date_begin'];
    $date_end = $_GET['date_end'];
    $userId = $_GET['userId'];
    

    // Inserts new row with place data.
    $query = sprintf("INSERT INTO events_location " .
        " (id, lat, lng, title, theme, date_begin, date_end, user_id) " .
        " VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s');",
        mysqli_real_escape_string($con,$lat),
        mysqli_real_escape_string($con,$lng),
        mysqli_real_escape_string($con,$title),
        mysqli_real_escape_string($con,$theme),
        mysqli_real_escape_string($con,$date_begin),
        mysqli_real_escape_string($con,$date_end),
        mysqli_real_escape_string($con,$userId));

    $result = mysqli_query($con,$query);
    echo"Inserted Successfully";
    if (!$result) {
        die('Invalid query: ' . mysqli_error($con));
    }
}
function confirm_location(){
    $con=mysqli_connect ("localhost", 'root', '','geolocaliza');
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }
    $id =$_GET['id'];
    $confirmed =$_GET['confirmed'];
    // update location with confirm if admin confirm.
    $query = "update events_location set location_status = $confirmed WHERE id = $id ";
    $result = mysqli_query($con,$query);
    echo "Inserted Successfully";
    if (!$result) {
        die('Invalid query: ' . mysqli_error($con));
    }
}
function get_confirmed_locations(){
    $con=mysqli_connect ("localhost", 'root', '','geolocaliza');
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }
    // update location with location_status if admin location_status.
    $sqldata = mysqli_query($con,"select id, lat, lng, title, theme, date_begin, date_end, location_status, user_id as isconfirmed from events_location WHERE  location_status = 1
  ");

    $rows = array();

    while($r = mysqli_fetch_assoc($sqldata)) {
        $rows[] = $r;

    }

    $indexed = array_map('array_values', $rows);
    //  $array = array_filter($indexed);

    echo json_encode($indexed);
    if (!$rows) {
        return null;
    }
}
function get_all_locations(){
    $con=mysqli_connect ("localhost", 'root', '','geolocaliza');
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }
    // update location with location_status if admin location_status.
    $sqldata = mysqli_query($con,"select id, lat, lng, title, theme, date_begin, date_end, location_status, user_id as isconfirmed from events_location
  ");

    $rows = array();
    while($r = mysqli_fetch_assoc($sqldata)) {
        $rows[] = $r;

    }
  $indexed = array_map('array_values', $rows);
  //  $array = array_filter($indexed);

    echo json_encode($indexed);
    if (!$rows) {
        return null;
    }
}
function array_flatten($array) {
    if (!is_array($array)) {
        return FALSE;
    }
    $result = array();
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $result = array_merge($result, array_flatten($value));
        }
        else {
            $result[$key] = $value;
        }
    }
    return $result;
}
function formated_date($date){
    $ano= substr($date, 6);
    $mes= substr($date, 3,-5);
    $dia= substr($date, 0,-8);
    return $ano."-".$mes."-".$dia;
}
