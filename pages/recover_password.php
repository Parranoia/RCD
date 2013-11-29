<?php
if (!isset($_GET['email']) || !isset($_GET['key']))
{
    header("Location: http://" . $_SERVER['SERVER_NAME']);
    die();
}

$email = $_GET['email'];
$key = $_GET['key'];

$query = "SELECT 1 FROM forgot_password WHERE user = (SELECT id FROM users WHERE email = :email) AND `key` = :key";
$query_params = array(':email' => $email,
                      ':key' => $key);
                      
 try
 {
     $stmt = $db->prepare($query);
     $result = $db->execute($query_params);
 }
 catch(PDOException $e)
 {
     die();
 }
 
 // If a row was returned
 if ($stmt->fetch())
 {
     
 }

?>