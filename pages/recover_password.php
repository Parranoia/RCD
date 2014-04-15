<?php
if (!isset($_GET['email']) || !isset($_GET['key_hash']))
{
    redirect();
    die();
}

$error = "";

$email = $_GET['email'];
$key = $_GET['key_hash'];

$query = "SELECT 1 FROM forgot_password WHERE `user` = (SELECT id FROM users WHERE email = :email) AND `key_hash` = :key_hash";
$query_params = array(':email' => $email,
                      ':key_hash' => $key);
                      
 try
 {
     $stmt = $db->prepare($query);
     $result = $stmt->execute($query_params);
 }
 catch(PDOException $e)
 {
     die();
 }
 
 // This is a valid request
 if ($stmt->fetch())
 {
     // Check if this is a post request or not
    if (!empty($_POST))
    {
        $pass = $_POST['pass'];
        $pass_confirm = $_POST['pass_confirm'];
         
        if (!preg_match('/^[a-zA-Z0-9.-_!]{8,18}$/', $pass))
        {
            if (strlen($pass) < 8 || strlen($pass) > 18)
                $error = "Password must be between 8 and 18 characters long";
            else
            {
                // Find out what characters failed the check
                $invalid_chars = preg_replace('/([a-zA-Z0-9.\-_!]*)/', '', $pass);
                $char_arr = str_split($invalid_chars);
                
                // Remove duplicates
                $char_arr = array_unique($char_arr);
                
                $msg = "Password cannot contain the following: ";
                foreach ($char_arr as $char)
                    $msg .= $char . ' ';
                $msg = $substr($msg, 0, strlen($msg) - 2);
                $error = $msg;
            }
        }
        else if ($pass !== $pass_confirm)
            $error = "Passwords do not match";
        
        // If there was no error, proceed with processing
        if (!$error)
        {
            // Generate a new salt and encrypt a new password
            $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
            $password = hash('sha256', $pass . $salt);
            
            $query = "UPDATE users SET password = :password, salt = :salt WHERE email = :email";
            $query_params = array(':password' => $password,
                                  ':salt' => $salt,
                                  ':email' => $email);
                                  
            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch (PDOException $e)
            {
                die();
            }
            
            // Delete the row from forgotten password
            $query = "DELETE FROM forgot_password WHERE user = (SELECT id FROM users WHERE email = :email)";
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
            
            print("<div class=\"postinfo\">Your password has been updated!<br>You will be redirected in 5 seconds</div>");
            
            redirect("/login", 5000);
        }
    }
 }
else // Redirect them since this is not a valid key and email combination
{
    header("Location: http://" . $_SERVER['SERVER_NAME']);
    die();
}

?>
                    <div class="forminfo">Please enter your new password</div>
                    <form class="centerform" method="POST" action="/account/recover_password?email=<?php echo $email?>&key=<?php echo $key?>">
<?php
    if ($error)
        print("\t\t\t<div class=\"error\">" . $error . "</div>\n");
?>
                        <input type="password" name="pass" placeholder="New Password" />
                        <input type="password" name="pass_confirm" placeholder="Confirm Password" />
                        <input type="submit" value="Submit" />
                    </form>
