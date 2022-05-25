<?php

/*Database Credentials*/

define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', 'roaldyen');
define('DB_PASSWORD', '112100');
define('DB_NAME', 'finalproject');

/*Attempt to connect to MySQL Database*/

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

//Check Connection

if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

?>