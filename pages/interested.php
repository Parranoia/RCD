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
				        var temp = $('#childForm_1').wrap('<fieldset>').parent();  
				        $('#parentForm').nextAll().remove();
				        var num = $('#num_children').val();
				        for (var i = 1; i <= num; i++) {
				        	temp.children().attr('id', 'childForm_' + i);
				            temp.children().children('legend:first').text('Child #' + i);
				            temp.children().children(':nth-child(2)').attr('name', 'child_name' + i);
				            temp.children().children(':nth-child(3)').attr('name', 'child_age' + i);
				            $('#interested').append(temp.html());
				        }
				    });
				});
			</script>
			<form id="interested" class="centerform" method="POST" action="/interested">
				<fieldset id="parentForm">
					<legend>Parent Information</legend>
					<input type="text" name="parent_name" placeholder="Parent's full name">
					<input type="text" name="email" placeholder="Email Address">
					<span class="small">How many children are you interested in enrolling?</span>
					<select id="num_children" required>
<?php for ($i = 1; $i < 11; $i++) print("\t\t\t\t\t\t<option value=\"$i\">$i</option>\n"); ?>
					</select>
				</fieldset>
				<fieldset id="childForm_1">
					<legend>Child # 1</legend>
					<input type="text" name="child_name1" placeholder="Child's full name">
					<input type="text" name="child_age1" placeholder="Child's age">
				</fieldset>
			</form>
