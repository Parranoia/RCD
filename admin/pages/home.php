<?php
$users_r = 0;
$users_p = 0;
$recently_registered = array();
$recent_parents = array();

$query = 'SELECT COUNT(*) FROM users';
try
{
    $stmt = $db->prepare($query);
    $stmt->execute();
}
catch (PDOException $e)
{
    die();
}
$row = $stmt->fetch();
$users_r = $row['COUNT(*)'];

$query = 'SELECT COUNT(*) FROM users WHERE active = 0';
try
{
    $stmt = $db->prepare($query);
    $stmt->execute();
}
catch (PDOException $e)
{
    die();
}
$row = $stmt->fetch();
$users_p = $row['COUNT(*)'];

$query = 'SELECT username FROM users ORDER BY id DESC LIMIT 5';
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

foreach ($rows as $row)
    $recently_registered[] = $row['username'];

$query = 'SELECT name FROM interested_parents ORDER BY id DESC LIMIT 5';
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

foreach($rows as $row)
    $recent_parents[] = $row['name'];
?>
                <table>
                    <tr>
                        <th>User Statistics</th>
                        <th>Recently Registered Users</th>
                        <th>Recently Interested Parents</th>
                    </tr>
<?php
    for ($i = 0; $i < 5; $i++)
    {
        echo "\t\t    <tr>\n";
        echo "\t\t\t<td>";
        if ($i === 0)
            echo "Registered Users: " . $users_r;
        if ($i === 1)
            echo "Pending Users: " . $users_p;
        echo "</td>\n";
        echo "\t\t\t<td>" . $recently_registered[$i] . "</td>\n";
        echo "\t\t\t<td>" . $recent_parents[$i] . "</td>\n";
        echo "\t\t    </tr>\n";
    }
?>
                </table>