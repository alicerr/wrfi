
<form method="post">
	<input type="text" name="user"  required class = "hide"
					value = "<?php echo(get_post("user_id")); ?> "  />
    <label>First name:</label><input type="text" name="fname" required 
					value = "<?php echo(get_post("fname")); ?> "  /><br>
	<label>Last name:</label><input type="text" name="lname"
					value = "<?php echo(get_post("lname")); ?>" /><br>
	<label>Phone #:</label><input type="text" name="phone"
				      
					value = "<?php echo(get_post("phone")); ?>" /><br>
    <input type="text" name="user_id" class="hide" value = "<?php echo(get_post("user_id")); ?>"/>
	<label>Email:</label><input type="email" name="email"
					value = "<?php echo(get_post("email")); ?>"  /><br>
	<?php if (get_post("user_id") == get_session("user_id") || !manager()) {
		
	echo('<label>Password:</label><input type = "password" name = "password" required /><br>
	<label>New Password (leave blank to keep current password):</label><input type = "password" name = "new_password" /><br>
    <label>Confirm New Password:</label><input type = "password" name = "confirm_password" /><br>
	<input type="submit" value="Update My Settings" name = "update_user" />');
	}
	else{
		echo('<input type="submit" value="Save Changes" name = "update_user" />');
	}
	?>
	
</form>
