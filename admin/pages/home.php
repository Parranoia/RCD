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

$num_parents = count($rows);

$query = 'SELECT COUNT(*) FROM interested_children';
try
{
    $stmt = $db->prepare($query);
    $stmt->execute();
}
catch(PDOException $e)
{
    die();
}
$row = $stmt->fetch();
$num_children = $row['COUNT(*)'];

$query = 'SELECT gender, COUNT(*) FROM interested_children GROUP BY gender';
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

if ($rows[0]['gender'] === 'Male')
{
    $num_male = $rows[0]['COUNT(*)'];
    $num_female = $rows[1]['COUNT(*)'];
}
else
{
    $num_female = $rows[0]['COUNT(*)'];
    $num_male = $rows[1]['COUNT(*)'];
}

if (!$num_male)
    $num_male = 0;
if (!$num_female)
    $num_female = 0;
?>
                <h1>Home Page</h1>
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
        if ($i === 2)
            echo "Interested Parents: " . $num_parents;
        if ($i === 3)
            echo "Interested Children: " . $num_children;
        if ($i === 4)
            echo "Childen Ratio (M/F): " . $num_male . "/" . $num_female;
        echo "</td>\n";
        echo "\t\t\t<td>" . $recently_registered[$i] . "</td>\n";
        echo "\t\t\t<td>" . $recent_parents[$i] . "</td>\n";
        echo "\t\t    </tr>\n";
    }
?>
                </table>