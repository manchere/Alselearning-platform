<?php 
$HOST  = 'localhost';
$USER = 'alselearning';
$PASS = 'alselearning';
$DBNAME = 'alselearning';

$con  = new mysqli($HOST,$USER,$PASS,$DBNAME);

if($con === false)
{
    die('Database encountered connection problems. Please try again later. '. $con->connect_error);
}
?>