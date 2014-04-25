<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/include/Child.class.php');

/*
 * Parent has a full name, employer, email, and number of children
 * The child has a full name, dob, and a gender
 */
$query = 'SELECT id, name, email, employer, num_children, phone_number FROM interested_parents ORDER BY id ASC';
try
{
    $stmt = $db->prepare($query);
    $stmt->execute();
}
catch (PDOException $e)
{
    die();
}
$parents = $stmt->fetchAll();

$query = 'SELECT parent, name, dob, gender FROM interested_children ORDER BY parent ASC';
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
$children = array(array());

foreach ($rows as $row)
{
    $name = $row['name'];
    $dob = $row['dob'];
    $gender = $row['gender'];
    $parent = $row['parent'];
    $children[$parent][] = new Child($name, $dob, $gender);
}

function print_interested_list($parents, $children)
{
    foreach ($parents as $parent)
    {
        echo "\t\t<div class=\"parent_info\">\n";
        echo "\t\t    <p>" . str_replace(' and ', ' | ', $parent['name']) . "</p>\n";
        if ($parent['num_children'] > 1)
            echo "\t\t    <p>" . $parent['num_children'] . " Children</p>\n";
        else 
            echo "\t\t    <p>" . $parent['num_children'] . " Child</p>\n";
        echo "\t\t    <i class=\"fa fa-chevron-right\"></i>\n";
        echo "\t\t</div>\n";
        
        echo "\t\t<div class=\"child_info\">\n";
        echo "\t\t    <p><b>Email</b>: " . $parent['email'] . "</p>\n";
        echo "\t\t    <p><b>Phone</b>: " . $parent['phone_number'] . "</p>\n";
        if ($parent['employer']) echo "\t\t    <p><b>Employer</b>: " . $parent['employer'] . "</p>\n";
        
        $temp = $children[$parent['id']];
        foreach ($temp as $child)
        {
            echo "\t\t\t<div class=\"parent_info collapse\">\n";
            echo "\t\t\t    <p>" . $child->getName() . "</p>\n";
            echo "\t\t\t    <i class=\"fa fa-chevron-right\"></i>\n";
            echo "\t\t\t</div>\n";
            echo "\t\t\t<div class=\"child_info collapse\">\n";
            echo "\t\t\t    <p>" . $child->getDob() . "</p>\n";
            echo "\t\t\t    <p>" . $child->getGender() . "</p>\n";
            echo "\t\t\t</div>";
        }
        echo "\t\t</div>\n";
    }
}

?>
                <h1>Interested List</h1>
<?php print_interested_list($parents, $children); ?>
