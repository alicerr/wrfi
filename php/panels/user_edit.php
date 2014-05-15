
<form method="post">
    <label>First name:</label><input type="text" name="fname" required /><br>
	<label>Last name:</label><input type="text" name="lname" /><br>
	<label>Phone #:</label><input type="text" name="phone" /><br>
    <input type="text" name="user_id" class="hide" value = "<?php get_post("user_id"); ?>"/>
	<label>Email:</label><input type="email" name="email" /><br>
	<label>Password:</label><input type = "password" name = "password" required /><br>
	<label>New Password (leave blank to keep current password):</label><input type = "password" name = "new_password" /><br>
    <label>Confirm New Password:</label><input type = "password" name = "confirm_password" /><br>
	<input type="submit" value="Update My Settings" name = "update_user" />
</form>
