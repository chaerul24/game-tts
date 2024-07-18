<?php
$server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "mygame";

$con = mysqli_connect($server, $db_user, $db_pass, $db_name);
if(mysqli_connect_errno()){
    die('Tidak terhubung!');
}