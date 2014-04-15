<?php
$error = "";

if (!empty($_POST))
{
	if (empty($_POST['email']))
	{
		$error = 'Please enter an email';
	}
	else
	{
		$email = htmlentities($_POST['email']);
		
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        	$error = "Invalid email";	
		
		if (empty($errors))
		{
			$query = "SELECT 1 FROM users WHERE email = :email";
			$query_params = array(':email' => $email);
            
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
			
			if (!$row)
				$error = "An account with that email doesn't exist";
			else 
			{
			    // Random key generated to "authenticate" the user
			    $key = md5(uniqid(rand(), true));
                
                // First check to see if user has already tried to send a recovery link
                $query = "SELECT `key_hash`, `user` FROM forgot_password WHERE user = (SELECT id FROM users WHERE email = :email)";
                $query_params = array(':email' => $email);
                
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
                
                // If user has already requested for their password to be reset
                // No need to send them an entirely new key, just use the old key
                if ($row)
                    $key = $row['key'];
                
                // We now have the proper key generated, lets send that email
                /**
                 * Sending Email
                 */
                include_once('PHPMailer/class.phpmailer.php');
                $mail = new PHPMailer();
                
                $mail->IsSMTP();
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'ssl';
    
                $mail->Host = $email_config['host'];
                $mail->Port = $email_config['port'];
                $mail->Username = $email_config['username'];
                $mail->Password = $email_config['password'];
                $mail->From = $email_config['username'];
                
                $mail->FromName = 'Radford Child Development';
                $mail->Subject = 'Radford Child Development | Password Recovery';
                
                $message = 
'Click the link below to reset your password
http://' . $_SERVER['SERVER_NAME'] . '/account/recover_password?email=' . $email . '&key_hash=' . $key;
                
                $mail->Body = $message;
                $mail->IsHTML(false);
                
                $mail->addAddress($email);
                /**
                 * End sending email
                 */
                 
                if(!$mail->Send())
                    echo '<div class="error center">Error sending email</div>';
                else
                {
                    $mail->ClearAddresses(); 
                    
                    // Recall from earlier whether or not this user has already sent for a recovery
                    // If they already have a record in the database, no need to send it again
                    if (!$row)
                    {
                        $query = "INSERT INTO forgot_password (`user`, `key_hash`) VALUES ((SELECT id FROM users WHERE email = :email), :key_hash)";
                        $query_params = array(':email' => $email,
                                              ':key_hash' => $key);
                        
                        try
                        {
                            $stmt = $db->prepare($query);
                            $stmt->execute($query_params);
                        }
                        catch(PDOException $e)
                        {
                            die();
                        }
                    }
                
				    print("\t\t\t<div class=\"postinfo\">An email has been sent to " . $email . "</div>\n");	
                }
			}
			
		}
	}	
}

?>
                    <form class="centerform" method="POST" action="/account/forgot_password">
                        <div class="forminfo">Please enter the email associated with your account</div>
                        <input type="text" name="email" placeholder="Email" />
<?php if ($error) print ("\t\t\t<div class=\"error\">" . $error . "</div>\n"); ?>
                        <input type="submit" value="Submit" />
                    </form>