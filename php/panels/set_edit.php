<!DOCTYPE html>

<html>
	<form method="post">
        Set start: <input type="datetime-local" name="set_start" class="manager"
	value = "<?php echo(get_post("set_start")); ?>" /><br>
        Set end: <input type="datetime-local" name="set_end" class="manager"
	value = "<?php echo(get_post("set_end")); ?>" /><br>
        Set description: <textarea name="set_description">
		<?php echo(get_post("set_desc")); ?>
	</textarea><br>
        Set website: https://www.<input type="text" name="set_website" value = "<?php echo(get_post("set_link")); ?>" /><br>
        <input type="text" name="set_id" class="hide"
	       value = "<?php echo(get_post("set_id")); ?>"/>
        <input type="submit" name="update_set" value="Save changes" />
    </form>
</html>