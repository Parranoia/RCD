<?php

function print_user($id, $username, $email, $privilege, $active, $errors)
{
    echo "\t\t<h1>Edit User</h1>\n";
    echo "\t\t<form action=\"/admin/edit_user?id=" . $id . "\" method=POST id=\"user_form\">\n";
    
    echo "\t\t    <label for=\"username\">Username</label>\n";
    if (isset($errors['username'])) echo "\t\t    <div class=\"error\">" . $errors['username'] . "</div>";
    echo "\t\t    <input type=\"text\" name=\"username\" value=\"" . $username . "\">\n";
    
    echo "\t\t    <label for=\"email\">Email</label>\n";
    if (isset($errors['email'])) echo "\t\t    <div class=\"error\">" . $errors['email'] . "</div>";
    echo "\t\t    <input type=\"text\" name=\"email\" value=\"" . $email . "\">\n";
    
    echo "\t\t    <label for=\"privilege\">Privilege Level</label>\n";
    echo "\t\t    <select name=\"privilege\">\n";        
    echo "\t\t\t<option value=\"0\""; if ($privilege == 0) echo " selected=\"selected\""; echo ">0 User</option>\n";
    echo "\t\t\t<option value=\"1\""; if ($privilege == 1) echo " selected=\"selected\""; echo ">1 Admin</option>\n";
    echo "\t\t\t<option value=\"2\""; if ($privilege == 2) echo " selected=\"selected\""; echo ">2 Super Admin</option>\n";
    echo "\t\t    </select>\n";
    
    echo "\t\t    <label for=\"active\">Active</label>\n";
    echo "\t\t    <select name=\"active\">\n";
    echo "\t\t\t<option value=\"0\""; if ($active == 0) echo " selected=\"selected\""; echo ">No</option>\n";
    echo "\t\t\t<option value=\"1\""; if ($active == 1) echo " selected=\"selected\""; echo ">Yes</option>\n";
    echo "\t\t    </select>\n";
    
    echo "\t\t    <input disabled=\"disabled\" type=\"submit\" value=\"Save\">\n";
    echo "\t\t</form>\n";
}

if ($_SESSION['user']['privilege'] !== 2)
{
    redirect('/admin');
    die();
}
if (empty($_GET['id']))
{
    redirect('/admin/users');
    die();
}
else 
{
    $id = $_GET['id'];
    $errors = array();
    
    $query = 'SELECT username, email, privilege, active FROM users WHERE id = :id';
    $query_params = array(':id' => $id);
    try
    {
        $stmt = $db->prepare($query);
        $stmt->execute($query_params);
    }   
    catch (PDOException $e)
    {
        die();
    }
    $row = $stmt->fetch();
    
    if ($row)
    {
    
        if (empty($_POST))
        {
            print_user($id, $row['username'], $row['email'], $row['privilege'], $row['active'], $errors);
        }
        else
        {        
            if (!preg_match('/^[A-Za-z][A-Za-z0-9]{3,14}$/', $_POST['username']))
                $errors["username"] = "Username must be between 4 and 15 characters long, start with a letter, and may only contain alphanumeric characters";
            
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
                $errors["email"] = "Invalid email";
            
            if (empty($errors))
            {
                $query = 'UPDATE users SET username = :username, email = :email, active = :active, privilege = :privilege WHERE id = :id';
                $query_params = array(':username' => $_POST['username'],
                                      ':email' => $_POST['email'],
                                      ':privilege' => $_POST['privilege'],
                                      ':active' => $_POST['active'],
                                      ':id' => $id);
                try
                {
                    $stmt = $db->prepare($query);
                    $stmt->execute($query_params);
                }        
                catch (PDOException $e)
                {
                    die();
                }
                
                echo "<h3>User updated!<br>You will be redirected shortly</h3>";
    
                redirect('/admin/users', 3000);
                die();
            }
            else
            {
               print_user($id, $row['username'], $row['email'], $row['privilege'], $row['active'], $errors);
            }
        }
    }
    else
    {
        echo '<h3>Invalid user ID</h3';
    }
    
    
}
?>