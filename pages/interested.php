<?php

$errors = array();

if (!empty($_POST))
{
	if (empty($_POST['parent_name']))
		$errors['parent_name'] = 'Please enter your full name';
	else
		if (!preg_match('/^[a-zA-Z \']+$/', $_POST['parent_name']))
			$errors['parent_name'] = 'The name you entered is invalid';
	
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        $errors["email"] = "Invalid email";
	
	if (!preg_match('/^[a-zA-Z0-9 \'&\-]*$/', $_POST['employer']))
		$errors['employer'] = 'Invalid employer. You entered a character that is not accepted';
	
	$num_children = $_POST['num_children'];
	
	for ($i = 1; $i <= $num_children; $i++)
	{
		$name = $_POST['child_name_' . $i];
		$dob = $_POST['dob_' . $i];
		$gender = $_POST['gender_' . $i];
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
					<input type="text" name="parent_name" placeholder="Parent's full name" maxlength="50" required>
					<input type="text" name="email" placeholder="Email Address" maxlenth="50" required>
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
