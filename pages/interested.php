<?php

?>
			<h1>Interested in Radford Child Development?</h1>
			<div class="center">
				<p>If you are interested in enrolling your child here in the future please fill out the form below<br>
				<span class="error">Note: This does not guarantee a spot, it is only showing your interest.</span>
				</p>
			</div>
			<script>
				$(document).ready(function() {
					$('#num_children').change(function() {
						$('#interested').append('<fieldset><legend>Temp</legend></fieldset>');
					});
				});
			</script>
			<form id="interested" class="centerform" method="POST" action="/interested">
				<fieldset>
					<legend>Parent Information</legend>
					<input type="text" name="parent_name" placeholder="Parent's full name">
					<input type="text" name="email" placeholder="Email Address">
					<span class="small">How many children are you interested in enrolling?</span>
					<select id="num_children" required>
<?php for ($i = 1; $i < 11; $i++) print("\t\t\t\t\t\t<option>" . $i . "</option>\n"); ?>
					</select>
				</fieldset>
			</form>
