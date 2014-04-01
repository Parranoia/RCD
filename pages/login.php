<?php

// If already logged in, redirect to the homepage
if (!empty($_SESSION['user']))
{
    redirect();
    die();
}

$user = "";
$errors = array();

// Check if data has been submitted or not
if (!empty($_POST))
{
    $query = "SELECT id, username, password, salt, email, active, privilege FROM users WHERE username = :username";
    
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
            
            $row['privilege'] = (int)$row['privilege'];
            
            $_SESSION['user'] = $row;
            
            redirect();
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
            <form id="login_form" class="centerform" action="/login" method="POST">
                <?php
                    if (!empty($errors))
                        foreach ($errors as $error)
                            print ("<div class=\"error\">" . $error . "</div>\n\t\t\t");
                ?>
            	<a class="small" href="/register">Don't have an account?</a>
                <input tabindex="1" type="text" autofocus="autofocus" maxlength="15" name="username" placeholder="Username" value="<?php echo $user ?>" />
                <a class="small" href="#">Forgot Username?</a>
                <input tabindex="2" type="password" maxlength="18" name="password" placeholder="Password" />
                <a class="small" href="/account/forgot_password">Forgot Password?</a>
                <input type="submit" value="Login" />
            </form>
