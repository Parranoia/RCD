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
    // Username must start with a letter, then is followed by 3-14 alphanumeric characters
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
    // Password can only contain alphanumeric characters, and `!`, `.`, `-`, `_`, `+`
    // Must also be between 8 and 18 characters long
	if (!preg_match('/^[a-zA-Z0-9!.-_+]{8,18}$/', $_POST['password']))
	{
		$errors[$error_count] = "Password must be between 8 and 18 characters long";
		$error_count++;
		$errors[$error_count] = "Password may only contain alphanumeric characters or `!`, `.`, `-`, `_`, `+`";
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
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = '465';
            $mail->Username = 'gmailusernamehere';
            $mail->Password = 'gmailpasswordhere';
            
            $mail->From = 'webmaster@web.com';
            $mail->FromName = 'Radford Child Development';
            $mail->Subject = 'Radford Child Development | Account Activation';
            
            $message = 
'Thank you for registering at Radford Child Development!
Your account has been created and now just needs to verify this email.
                
Click the link below to activate your account
http://' . $_SERVER['SERVER_NAME'] . '/index.php?p=verify&email=' . $email . '&code=' . $email_hash;
            
            $mail->Body = $message;
            $mail->IsHTML(false);
            
            $mail->AddAddress($email, $_POST['username']);
            
            if(!$mail->Send())
                echo($mail->ErrorInfo);
            else
                $mail->ClearAddresses();
            
            
            /*$email = $_POST['email'];
            $message = 'Thank you for registering at Radford Child Development!\n' .
                'Your account has been created and now just needs to verify this email.\n\n' .
                'Click the link below to activate your account\n' .
                'http://' . $_SERVER['SERVER_NAME'] . '/verify.php?email=' . $email . '&code=' . $email_hash . '';
            
            $headers = 'From: webmaster@example.com';
            
            mail($email, "Radford Child Development | Account Activation", $message, $headers);                
            */
            print('<div class=\"registersuccess\">Thank you for registering! An email has been sent to ' . $email . ' to activate your account</div>');
            
            //header("Location: http://" . $_SERVER['SERVER_NAME'] . "/login");
            //die();
        }
    }
}

?>

            <?php 
                if (!empty($errors))
				{
					print("<code>");
                    foreach ($errors as $error)
                        print($error . "<br>");
					print("</code>");
				}
            ?>
            <form class="registerlogin" action="/register" method="post" >
                <input type="email" maxlenth="50" name="email" placeholder="Email" value="<?php if (isset($_POST['email'])) echo htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8'); ?>" />
                <input type="text" maxlength="15" name="username" placeholder="Username" value="<?php if (isset($_POST['username'])) echo htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8'); ?>"/>
                <input type="password" maxlength="18" name="password" placeholder="Password" />
                <input type="password" maxlength="18" name="pass_confirm" placeholder="Confirm Password" />
                <input style="width:304px" type="submit" value="Register" />
            </form>