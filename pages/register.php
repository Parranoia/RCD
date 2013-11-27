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
    
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        $errors["email"] = "Invalid email";
    // Username must start with a letter, then is followed by 3-14 alphanumeric characters
    if (empty($_POST['username']))
        $errors["username"] = "Please enter a username";
	// If username is not empty
	else 
	{
		if (!preg_match('/^[A-Za-z][A-Za-z0-9]{3,14}$/', $_POST['username']))
            $errors["username"] = "Username must be between 4 and 15 characters long, start with a letter, and may only contain alphanumeric characters";
	}
    if (empty($_POST['password']))
        $errors["password"] = "Please enter a password";
	else 
	{
        if (!preg_match('/^[a-zA-Z0-9.-_!]{8,18}$/', $_POST['password']))
        {
            if (strlen($_POST['password']) < 8 || strlen($_POST['password']) > 18)
                $errors['password'] = "Password must be between 8 and 18 characters long";
            else
            {
                // Find out what characters failed the check
                $invalid_chars = preg_replace('/([a-zA-Z0-9.\-_!]*)/', '', $_POST['password']);
                $char_arr = str_split($invalid_chars);
                
                // Remove duplicates
                $char_arr = array_unique($char_arr);
                
                $msg = "Password cannot contain the following: ";
                foreach ($char_arr as $char)
                    $msg .= $char . ' ';
                $msg = $substr($msg, 0, strlen($msg) - 2);
                $errors['password'] = $msg;
            }
        }
        else if ($_POST['password'] !== $_POST['pass_confirm'])
            $errors["password"] = "Passwords do not match";
	}
    
    //if (empty($email_errors) && empty($username_errors) && empty($password_errors))
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
            $errors["username"] = "This username already exists";
        
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
            $errors["email"] = "This email is already in use";
        
        if (empty($errors))
        {        
            $query = "INSERT INTO users (username, password, salt, email, active, email_hash) VALUES
                        (:username, :password, :salt, :email, :active, :hash)";
            
            $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
            
            $email_hash = md5(uniqid(rand(), true));
            
            $password = hash('sha256', $_POST['password'] . $salt);
            
            $query_params = array(':username' => $_POST['username'],
                                  ':password' => $password,
                                  ':salt'     => $salt,
                                  ':email'    => $_POST['email'],
                                  ':active'   => 0,
                                  ':hash'     => $email_hash);
            
            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $e)
            {
                die();   
            }
            
            $email = $_POST['email'];
            
            include_once('PHPMailer/class.phpmailer.php');
            $mail = new PHPMailer();
            
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';

            $mail->Host = 'rs14.websitehostserver.net';
            $mail->Port = '465';
            $mail->Username = 'noreply@radfordchilddevelopment.org';
            $mail->Password = 'passwordhere';
            $mail->From = 'noreply@radfordchilddevelopment.org';
            
            $mail->FromName = 'Radford Child Development';
            $mail->Subject = 'Radford Child Development | Account Activation';
            
            $message = 
'Thank you for registering at Radford Child Development!
Your account has been created and now just needs to verify this email.
                
Click the link below to activate your account
http://' . $_SERVER['SERVER_NAME'] . '/account/verify?email=' . $email . '&key=' . $email_hash;
            
            $mail->Body = $message;
            $mail->IsHTML(false);
            
            $mail->AddAddress($email, $_POST['username']);
            
            if(!$mail->Send())
                echo 'Error sending email';
            else
                $mail->ClearAddresses();
            
            print('<div class=\"postinfo\">Thank you for registering! An email has been sent to ' . $email . ' to activate your account</div>');
            
            //header("Location: http://" . $_SERVER['SERVER_NAME'] . "/login");
            //die();
        }
    }
}

?>

            <form class="centerform" action="/register" method="post" >
                <?php
                    if (isset($errors["email"]))
                        print("<div class=\"error\">" . $errors['email'] . "</div>");
                ?>
                <input type="email" maxlenth="50" name="email" placeholder="Email" value="<?php if (isset($_POST['email'])) echo htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8'); ?>" />
                <?php
                    if (isset($errors["username"]))
                        print("<div class=\"error\">" . $errors['username'] . "</div>");
                ?>
                <input type="text" maxlength="15" name="username" placeholder="Username" value="<?php if (isset($_POST['username'])) echo htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8'); ?>"/>
                <?php
                    if (isset($errors["password"]))
                        print("<div class=\"error\">" . $errors['password'] . "</div>");
                ?>
                <input type="password" maxlength="18" name="password" placeholder="Password" />
                <input type="password" maxlength="18" name="pass_confirm" placeholder="Confirm Password" />
                <input style="width:304px" type="submit" value="Register" />
            </form>