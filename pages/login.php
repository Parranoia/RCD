<?php

// If already logged in, redirect to the homepage
if (isset($_SESSION['user']) || !empty($_SESSION['user']))
{
    header("Location: http://" . $_SERVER['SERVER_NAME']);
    die();
}

$user = "";

// Check if data has been submitted or not
if (!empty($_POST))
{
    $query = "SELECT id, username, password, salt, email FROM users WHERE username = :username";
    
    $query_params = array(':username' => $_POST['username']);
    
    try
    {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch(PDOException $e)
    {
        die();   
    }
    
    $success = false;
    
    $row = $stmt->fetch();
    if ($row)
    {
        // Hash the user-given password and compare with what's in the db
        $pass_hash = hash('sha256', $_POST['password'] . $row['salt']);
        
        if ($pass_hash === $row['password'])
            $success = true;
    }
    
    if ($success)
    {
        // Remove sensitive information from being stored later
        unset($row['salt']);
        unset($row['password']);
        
        $_SESSION['user'] = $row;
        
        header("Location: http://" . $_SERVER['SERVER_NAME']);
        die();
    }
    else
    {
        $user = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
        header("Location: http://" . $_SERVER['SERVER_NAME'] . "/login");
        die();
    }
}

?>
            <?php
                if ($user != "")
                    print("<code style='color:red'>Username or password incorrect</code><br />");
            ?>
            <form class="registerlogin" action="/login" method="POST">
            	<a class="small" href="/register">Don't have an account?</a>
                <input type="text"  maxlength="15"name="username" placeholder="Username" value="<?php echo $user ?>" />
                <a class="small" href="#">Forgot Username?</a>
                <input type="password" maxlength="18" name="password" placeholder="Password" />
                <a class="small" href="#">Forgot Password?</a>
                <input type="submit" value="Login" />
            </form>
