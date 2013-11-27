<?php
if (!isset($_GET['email']) || !isset($_GET['key']))
{
    header("Location: http://" . $_SERVER['SERVER_NAME']);
    die();
}

$email = $_GET['email'];
$hash = $_GET['key'];


$query = "SELECT 1 FROM users WHERE email = :email AND email_hash = :hash";
$query_params = array(':email' => $email,
                      ':hash' => $hash);

try
{
    $stmt = $db->prepare($query);
    $result = $stmt->execute($query_params);
}
catch(PDOExceptoin $e)
{
    die();   
}

$row = $stmt->fetch();

// Valid email and hash, activate the user
if ($row)
{
    $query = "UPDATE users SET active = 1 WHERE email = :email";
    $query_params = array(':email' => $email);
    
    try
    {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch(PDOException $e)
    {
        die();   
    }
    
    echo "<div class=\"postinfo\">Your account has been activated!<br>You will be redirected in 3 seconds</div>";
    header("refresh:3;url=http://" . $_SERVER['SERVER_NAME'] . "/login");
}
else
{
    header("Location: http://" . $_SERVER['SERVER_NAME']);
    die();
}

?>