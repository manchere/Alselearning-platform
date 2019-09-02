<?
//Starting the session
session_start();
 
//Resetting all the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();
 
header("location: index.php#login-sec");
exit;
?>