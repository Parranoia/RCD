<?php
if ($_SESSION['user']['privilege'] !== 2)
{
    redirect('/admin');
    die();
}

$query = 'SELECT id, username, email, privilege, active FROM users';
try
{
    $stmt = $db->prepare($query);
    $stmt->execute();
}
catch (PDOException $e)
{
    die();
}
$rows = $stmt->fetchAll();
?>
                <h1>Manage Users</h1>
                <table>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Privilege</th>
                    <th>Active</th>
                    <th>Manage</th>
<?php
foreach ($rows as $row)
{
    echo "\t\t    <tr>\n";
    echo "\t\t\t<td>" . $row['username'] . "</td>\n";
    echo "\t\t\t<td>" . $row['email'] . "</td>\n";
    echo "\t\t\t<td>" . get_privilege((int)$row['privilege']) . " (" . $row['privilege'] . ")</td>\n";
    echo "\t\t\t<td>" . (((int)$row['active']) === 0 ? "No" : "Yes") . "</td>\n";
    echo "\t\t\t<td class=\"center\"><a href=\"/admin/edit_user?id=" . $row['id'] . "\"><i class=\"fa fa-cog fa-lg\"></i></a></td>\n";
    echo "\t\t    </tr>\n";
}
?>
                </table>