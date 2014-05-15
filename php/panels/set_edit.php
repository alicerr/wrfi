<!--show edit/add-->
	<form method="post">
	<?php
	$show_name = get_post("show_name");
	if (manager())
		//managers can change shows
		draw_show_select();
	else
		echo($show_name);
	?>
        <label>Set start:</label><input type="datetime-local" name="set_start" class="manager" value = "<?php echo(get_post("set_start")); ?>" required /><br>
		<label>Set end:</label><input type="datetime-local" name="set_end" class="manager" value = "<?php echo(get_post("set_end")); ?>" required /><br>
        <label>Set description:</label><textarea name="set_description"><?php echo(get_post("set_desc")); ?></textarea><br>
        <label>Set website:</label>https://www.<input type="text" name="set_website" value = "<?php echo(get_post("set_link")); ?>" /><br>
        <input type="text" name="set_id" class="hide" value = "<?php echo(get_post("set_id")); ?>"/>
        <input type="submit" name="update_set" value="Save changes" />
    </form>
