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
                    <tr>
                        <td>Registered Users: <?php echo $users_r ?></td>
                        <td><?php echo $recently_registered[0] ?></td>
                        <td><?php echo $recent_parents[0] ?></td>
                    </tr>
                    <tr>
                        <td>Pending Users: <?php echo $users_p ?></td>
                        <td><?php echo $recently_registered[1] ?></td>
                        <td><?php echo $recent_parents[1] ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><?php echo $recently_registered[2] ?></td>
                        <td><?php echo $recent_parents[2] ?></td>
                    </tr>
                </table>