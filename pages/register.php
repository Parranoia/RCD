<?php

// Redirect if user is already logged in
if (isset($_SESSION['user']) || !empty($_SESSION['user']))
{
    header("Location: http://" . $_SERVER['SERVER_NAME']);
    die();
}

// Stores any errors that occur
$email_errors = array();
$username_errors = array();
$password_errors = array();

// Check whether or not data has been submitted
if (!empty($_POST))
{
    
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
    {
        $email_errors[] = "Invalid email";
    }
    // Username must start with a letter, then is followed by 3-14 alphanumeric characters
    if (empty($_POST['username']))
    {
        $username_errors[] = "Please enter a username";
    }
	// If username is not empty
	else 
	{
		if (!preg_match('/^[A-Za-z][A-Za-z0-9]{3,14}$/', $_POST['username']))
    	{
        	$username_errors[] = "Username must be between 4 and 15 characters long, start with a letter, and may only contain alphanumeric characters";
    	}	
	}
    if (empty($_POST['password']))
    {
        $password_errors[] = "Please enter a password";
    }
	else 
	{
		if ($_POST['password'] !== $_POST['pass_confirm'])
	    {
	        $password_errors[] = "Passwords do not match";
	    }	
		else 
		{
			// Password can only contain alphanumeric characters, and `!`, `.`, `-`, `_`, `+`
		    // Must also be between 8 and 18 characters long
			if (!preg_match('/^[a-zA-Z0-9!.-_+]{8,18}$/', $_POST['password']))
			{
				$password_errors[] = "Password must be between 8 and 18 characters long and may only contain alphanumeric characters and `!`, `.`, `-`, `_`, `+`";
			}	
		}
	}
    
    if (empty($email_errors) && empty($username_errors) && empty($password_errors))
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
            $username_errors[] = "This username already exists";
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
            $email_errors[] = "This email is already in use";
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
            $mail->Username = 'yourgmail@gmail.com';
            $mail->Password = 'gmailpassword';
            
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

            <form class="registerlogin" action="/register" method="post" >
                <input type="email" maxlenth="50" name="email" placeholder="Email" value="<?php if (isset($_POST['email'])) echo htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8'); ?>" />
                <?php 
                	if (!empty($email_errors))
					{
						print("<div class=\"error\">\n");
							foreach($email_errors as $error)
								print($error);
						print("</div>\n");
					}
				?>
                <input type="text" maxlength="15" name="username" placeholder="Username" value="<?php if (isset($_POST['username'])) echo htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8'); ?>"/>
                <?php 
                	if (!empty($username_errors))
					{
						print("<div class=\"error\">\n");
							foreach($username_errors as $error)
								print($error);
						print("</div>\n");
					}
				?>
                <input type="password" maxlength="18" name="password" placeholder="Password" />
                <?php 
                	if (!empty($password_errors))
					{
						print("<div class=\"error\">\n");
							foreach($password_errors as $error)
								print($error);
						print("</div>\n");
					}
				?>
                <input type="password" maxlength="18" name="pass_confirm" placeholder="Confirm Password" />
                <input style="width:304px" type="submit" value="Register" />
            </form>