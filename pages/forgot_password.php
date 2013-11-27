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
				print("\t\t\t<div class=\"postinfo\">An email has been sent to " . $email . "</div>\n");	
			}
			
		}
	}	
}

?>
                    <form class="centerform" method="POST" action="/account/forgot_password">
                        <div class="forminfo">Please enter the email associated with your account</div>
                        <input type="text" name="email" placeholder="Email" />
<?php if ($error) print ("\t\t\t<div class=\"error\">" . $error . "</div>\n"); ?>
                        <input style="width:304px" type="submit" value="Submit" />
                    </form>