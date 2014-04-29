<!DOCTYPE html>

<html>
	<form method="post">
    	Show name: <input type="text" name="show_name"
	value = "<?php echo(get_post("show_name")); ?>" /><br>
    	Show description: <textarea name="show_description">
		<?php echo(get_post("show_desc")); ?>
	</textarea>
    	Show website: https://<input type="text" name="show_website"
	value = "<?php echo(get_post("show_website")); ?>" /><br>
    	<input type="submit" name="update_show" value="Save changes" /> 
    </form>
</html>