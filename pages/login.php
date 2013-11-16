<?php

// If already logged in, redirect to the homepage
if (isset($_SESSION['user']) || !empty($_SESSION['user']))
{
    header("Location: http://" . $_SERVER['SERVER_NAME']);
    die();
}

$user = "";
$errors = array();

// Check if data has been submitted or not
if (!empty($_POST))
{
    $query = "SELECT id, username, password, salt, email, active FROM users WHERE username = :username";
    
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
        if ($row['active'] == 0) // Account has not been verified
        {
            $errors[] = 'Your account\'s email address has not been verified';
            $errors[] = 'Please check your email for the activation link';
        }
        
        // Make sure there are no errors before logging them in
        if (empty($errors))
        {
            // Remove sensitive information from being stored later
            unset($row['salt']);
            unset($row['password']);
            
            $_SESSION['user'] = $row;
            
            header("Location: http://" . $_SERVER['SERVER_NAME']);
            die();
        }
    }
    else
    {
        $errors[] = 'Username or password incorrect';
        $user = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
    }
}

?>
            <?php
                print('<code>');
                foreach ($errors as $error)
                    print($error . '<br>');
                print('</code>');
            ?>
            <form class="registerlogin" action="/login" method="POST">
            	<a class="small" href="/register">Don't have an account?</a>
                <input type="text"  maxlength="15"name="username" placeholder="Username" value="<?php echo $user ?>" />
                <a class="small" href="#">Forgot Username?</a>
                <input type="password" maxlength="18" name="password" placeholder="Password" />
                <a class="small" href="#">Forgot Password?</a>
                <input type="submit" value="Login" />
            </form>
