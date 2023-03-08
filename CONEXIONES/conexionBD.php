<?php
$db_params = parse_ini_file( dirname(__FILE__).'./../../parametros_con.ini', true );

$conn = new mysqli($db_params['host'], $db_params['user'], $db_params['password'], $db_params['dbname'].mysqli_connect_error()) ;
if(!$conn){
    die("Cannot connect to the database.". $conn->error);
}


