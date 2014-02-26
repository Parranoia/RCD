<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/include/Child.class.php');

/*
 * Parent has a full name, employer, email, and number of children
 * The child has a full name, dob, and a gender
 */
$query = 'SELECT id, name, email, employer, num_children FROM interested_parents ORDER BY id ASC';
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
        echo '<div class="parent_info">';
        echo '<p>' . $parent['name'] . '</p>';
        echo '<p>' . $parent['email'] . '</p>';
        if ($parent['employer']) echo '<p>' . $parent['employer'] . '</p>';
        if ($parent['num_children'] > 1)
            echo '<p>' . $parent['num_children'] . ' Children</p>';
        else 
            echo '<p>' . $parent['num_children'] . ' Child</p>';
        echo '<i class="fa fa-chevron-right"></i>';
        echo '</div>';
        
        echo '<div class="child_info">';
        echo '<ul>';
        
        $temp = $children[$parent['id']];        
        foreach ($temp as $child)
        {
            echo '<li>';
            echo $child->getName();
            echo '<ul>';
            echo '<li>' . $child->getDob() . '</li>';
            echo '<li>' . $child->getGender() . '</li>';
            echo '</ul>';
            echo '<li>';            
        }
        echo '</ul>';
        echo '</div>';
    }
}

?>
                <h1>Interested Page...</h1>
                <?php print_interested_list($parents, $children); ?>
                
                <script>
                $('.parent_info').click(function() {
                    $(this).next().slideToggle('slow'); 
                    $(this).toggleClass('toggled');
                    $(this).children('.fa').toggleClass('fa-chevron-right fa-chevron-down');
                });
                </script>
