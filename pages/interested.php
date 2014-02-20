<?php

$errors = array();

if (!empty($_POST))
{
	include_once($_SERVER['DOCUMENT_ROOT'] . '/include/Child.class.php');
	
	if (empty($_POST['parent_name']))
		$errors['parent_name'] = 'Please enter your full name';
	else
		if (!preg_match('/^[a-zA-Z \']+$/', $_POST['parent_name']))
			$errors['parent_name'] = 'The name you entered is invalid';
	
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        $errors["email"] = "Invalid email";
	
	if (!preg_match('/^[a-zA-Z0-9 \'&\-]*$/', $_POST['employer']))
		$errors['employer'] = 'Invalid employer. You entered a character that is not accepted';
	
	// Only proceed if there weren't any problems with the parent's info
	// No point in processing all of the children if the result is an error anyway
	if (empty($errors))
	{	
		$num_children = $_POST['num_children'];
		
		$children = array();

		for ($i = 1; $i <= $num_children; $i++)
		{
			$name = $_POST['child_name_' . $i];
			$dob = $_POST['dob_' . $i];
			// Not possible for gender to be empty
			$gender = $_POST['gender_' . $i];
			
			if (empty($name))
				$errors['child_name'] = 'You did not enter a child\'s name';
			else 
				if (!preg_match('/^[a-zA-Z \']+$/', $_POST['parent_name']))
					$errors['child_name'] = 'The child\'s name you entered is invalid';
			
			// Check if the date of birth was selected
			if (empty($dob))
				$errors['dob'] = 'You did not enter your child\'s date of birth';
			
			if (!empty($errors))
				break;
			
			$test = new Child($name, $dob, $gender);
			
			$children[] = new Child($name, $dob, $gender);
		}
		
		// If we are still in the clear, send all the data to the database
        if (empty($errors))
        {
			$query = 'SELECT 1 FROM interested_parents WHERE email = :email';
            
            $query_params = array(':email' => $_POST['email']);
            
            try
            {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch (PDOException $e)
            {
                die();
            }
            
            if ($stmt->fetch())
            {
                $errors['email'] = 'Someone has already registered with this email address';
            }
            else 
            {
                $query = 'INSERT INTO interested_parents (name, email, employer, num_children) VALUES ' .
                    '(:name, :email, :employer, :num_children)';
                 
                $query_params = array(':name' => $_POST['parent_name'],
                                      ':email' => $_POST['email'],
                                      ':employer' => $_POST['employer'],
                                      ':num_children' => $num_children);
                 
                try
                {
                    $stmt = $db->prepare($query);
                    $result = $stmt->execute($query_params);
                }
                catch (PDOException $e)
                {
                    die();
                }
                 
                $query = 'SELECT id FROM interested_parents WHERE email = :email';
                 
                $query_params = array(':email' => $_POST['email']);
                 
                 
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
                $parent_id = $row['id'];
                 
                 
                $query = 'INSERT INTO interested_children (parent, name, dob, gender) VALUES ';
                 
                for ($i = 1; $i <= $num_children; $i++)
                    $query .= '(:parent, :name' . $i . ', ' .
                              ':dob' . $i . ', ' .
                              ':gender' . $i . '), ';
                $query = substr($query, 0, -2);
                 
                $query_params = array();
                $query_params[':parent'] = $parent_id;
                 
                foreach ($children as $key => $child) 
                {
                    $query_params[':name' . ($key + 1)] = $child->getName();
                    $query_params[':dob' . ($key + 1)] = $child->getDob();
                    $query_params[':gender' . ($key + 1)] = $child->getGender();
                }
                 
                try
                {
                    $stmt = $db->prepare($query);
                    $result = $stmt->execute($query_params);
                }
                catch (PDOException $e)
                {
                    die();
                }
               
             } 
        }
    }
}

?>
			<h1>Interested in Radford Child Development?</h1>
			<div class="center">
				<p>If you are interested in enrolling your child here in the future please fill out the form below<br>
				<span class="error">Note: This does not guarantee a spot, it is only showing your interest.</span>
				</p>
			</div>
			<form id="interested" class="centerform" method="POST" action="/interested">
				<fieldset id="parentForm">
					<legend>Parent Information</legend>
					<?php
                        if (!empty($errors['parent_name']))
                            print('<div class=\"error\">' . $errors['parent_name'] . '</div>');
					?>
					<input type="text" name="parent_name" placeholder="Parent's full name" maxlength="50" required>
					<?php
                        if (!empty($errors['email']))
                            print('<div class=\"error\">' . $errors['email'] . '</div>');
                    ?>
					<input type="text" name="email" placeholder="Email Address" maxlenth="50" required>
					<?php
                        if (!empty($errors['employer']))
                            print('<div class=\"error\">' . $errors['employer'] . '</div>');
                    ?>
					<input type="text" name="employer" placeholder="Current Employer" maxlength="100">
					<span class="small">How many children are you interested in enrolling?<br></span>
					<select id="num_children" name="num_children" required>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
					</select>
				</fieldset>
				<?php
                    if (!empty($errors['child_name']))
                        print('<div class=\"error\">' . $errors['child_name'] . '</div>');
                    if (!empty($errors['dob']))
                        print('<div class=\"error\">' . $errors['dob'] . '</div>');
                ?>
				<fieldset id="childForm_1">
					<legend>Child #1</legend>
					<input type="text" name="child_name_1" placeholder="Child's full name" maxlength="50" required>
					<input id="dob_1" type="text" class="dob" name="dob_1" placeholder="Date of Birth" maxlength="12" required>
					<select name="gender_1" required>
						<option value="Male">Male</option>
						<option value="Female">Female</option>
					</select>
				</fieldset>
				<input type="submit" value="Submit" />
			</form>
