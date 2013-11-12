<?php

// Redirect if user is already logged in
if (isset($_SESSION['user']) || !empty($_SESSION['user']))
{
    header("Location: http://" . $_SERVER['SERVER_NAME']);
    die();
}

// Stores any errors that occur
$errors = array();

// Check whether or not data has been submitted
if (!empty($_POST))
{
    $error_count = 0;
    
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
    {
        $errors[$error_count] = "Invalid email address";
        $error_count++;
    }
    if (!preg_match('/^[A-Za-z][A-Za-z0-9]{3,14}$/', $_POST['username']))
    {
        $errors[$error_count] = "Invalid username";
        $error_count++;
        $errors[$error_count] = "&nbsp;&nbsp;&nbsp;Username can only contain alphanumeric characters";
        $error_count++;
        $errors[$error_count] = "&nbsp;&nbsp;&nbsp;Username must start with a letter";
        $error_count++;
        $errors[$error_count] = "&nbsp;&nbsp;&nbsp;Username must be between 4 and 15 characters long";
        $error_count++;
    }
    if (empty($_POST['username']))
    {
        $errors[$error_count] = "Please enter a username";
        $error_count++;
    }
    if (empty($_POST['password']))
    {
        $errors[$error_count] = "Please enter a password";
        $error_count++;
    }
    if ($_POST['password'] !== $_POST['pass_confirm'])
    {
        $errors[$error_count] = "Passwords do not match";
        $error_count++;
    }
	if (!preg_match('/^[a-zA-Z0-9!.-_+@]{8,18}$/', $_POST['password']))
	{
		$errors[$error_count] = "Password must be between 8 and 18 characters long";
		$error_count++;
		$errors[$error_count] = "Password may only contain alphanumeric characters or `!`, `.`, `-`, `_`, `+`, `@`";
		$error_count++;
	}
    
    if (empty($errors))
    {                
        $query = "SELECT 1 FROM users 
            WHERE username = :username";
        
        $query_params = array(':username' => $_POST['username']); 
        
        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch (PDOException $e)
        {
            die();
        }
        
        $row = $stmt->fetch();
        
        if ($row)
        {
            $errors[$error_count] = "This username already exists";
            $error_count++;
        }
        
        $query = "SELECT 1 FROM users WHERE email = :email";
        
        $query_params = array(':email' => $_POST['email']);
        
        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch (PDOException $e)
        {
            die(); 
        }
        
        $row = $stmt->fetch();
        
        if ($row)
        {
            $errors[$error_count] = "This email is already in use";
            $error_count++;
        }
        
        if (empty($errors))
        {        
            $query = "INSERT INTO users (username, password, salt, email) VALUES
                        (:username, :password, :salt, :email)";
            
            $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
            
            $password = hash('sha256', $_POST['password'] . $salt);
            
            $query_params = array(':username' => $_POST['username'],
                                  ':password' => $password,
                                  ':salt'     => $salt,
                                  ':email'    => $_POST['email']);
            
            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $e)
            {
                die();   
            }
            
            header("Location: http://" . $_SERVER['SERVER_NAME'] . "/index.php?p=login");
            die();
        }
    }
}

?>

            <?php 
                if (!empty($errors))
				{
					print("<code style=\"color:red; font-size: 10px; margin: 0 auto; display: block; width: 325px;\">");
                    foreach ($errors as $error)
                        print($error . "<br>");
					print("</code>");
				}
            ?>
            <form class="registerlogin" action="/index.php?p=register" method="post" >
                <input type="email" maxlenth="50" name="email" placeholder="Email" value="<?php if (isset($_POST['email'])) echo htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8'); ?>" />
                <input type="text" maxlength="15" name="username" placeholder="Username" value="<?php if (isset($_POST['username'])) echo htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8'); ?>"/>
                <input type="password" maxlength="18" name="password" placeholder="Password" />
                <input type="password" maxlength="18" name="pass_confirm" placeholder="Confirm Password" />
                <input type="submit" value="Register" />
            </form>