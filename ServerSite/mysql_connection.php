<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

$db_connection = @mysqli_connect("localhost", "s3030235", "ninglowb", "s3030235") OR die("Could not connect to MySQL!".mysqli_connect_error());
mysqli_set_charset($db_connection, 'utf8');
?>