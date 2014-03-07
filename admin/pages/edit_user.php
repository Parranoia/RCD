<?php
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
    
    if (!$row)
    {
        echo '<h3>Invalid ID</h3>';
    }
    else 
    {
        echo "\t\t<h1>Edit User</h1>\n";
        echo "\t\t<form action=\"/admin/edit_user?id=" . $id . "\" method=POST id=\"user_form\">\n";
        echo "\t\t    <label for=\"username\">Username</label>\n";
        echo "\t\t    <input type=\"text\" name=\"username\" value=\"" . $row['username'] . "\">\n";
        echo "\t\t    <label for=\"email\">Email</label>\n";
        echo "\t\t    <input type=\"text\" name=\"email\" value=\"" . $row['email'] . "\">\n";
        echo "\t\t    <label for=\"privilege\">Privilege Level</label>\n";
        echo "\t\t    <select name=\"privilege\">\n";        
        echo "\t\t\t<option value=\"0\""; if ($row['privilege'] == 0) echo " selected=\"selected\""; echo ">0 User</option>\n";
        echo "\t\t\t<option value=\"1\""; if ($row['privilege'] == 1) echo " selected=\"selected\""; echo ">1 Admin</option>\n";
        echo "\t\t\t<option value=\"2\""; if ($row['privilege'] == 2) echo " selected=\"selected\""; echo ">2 Super Admin</option>\n";
        echo "\t\t    </select>\n";
        echo "\t\t    <label for=\"active\">Active</label>\n";
        echo "\t\t    <select name=\"active\">\n";
        echo "\t\t\t<option value=\"0\""; if ($row['active'] == 0) echo " selected=\"selected\""; echo ">No</option>\n";
        echo "\t\t\t<option value=\"1\""; if ($row['active'] == 1) echo " selected=\"selected\""; echo ">Yes</option>\n";
        echo "\t\t    </select>\n";
        echo "\t\t    <input disabled=\"disabled\" type=\"submit\" value=\"Save\">\n";
        echo "\t\t</form>\n";
    }
}
?>
                <script>
                    $(document).ready(function() {
                        $('input, select').change(function() {
                            $('input[type=submit]').removeAttr('disabled');
                        });
                    });
                </script>