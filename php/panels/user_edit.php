
<form method="post">
    	First name: <input type="text" name="fname" required />
    	Last name: <input type="text" name="lname" />
    	Phone #: <input type="text" name="phone" />
    	<input type="text" name="user_id" class="hide" value = "<?php get_post("user_id"); ?>"/>
	Email: <input type="email" name="email" />
	Password:<input type = "password" name = "password" required />
	New Password (leave blank to keep current password):<input type = "password" name = "new_password" />
    	Confirm New Password: <input type = "password" name = "confirm_password" />
	<input type="submit" value="Update My Settings" name = "update_user" />
    </form>
