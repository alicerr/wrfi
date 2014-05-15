<!--form for editing or adding dj variables-->
	<form method="post">
    	<input type="text" name="dj_id" class="hide" value ="<?php echo(get_post("dj_id")); ?>" /><br>
    	<label>DJ name:</label><input type="text" name="dj_name" value = "<?php echo(get_post("dj_name")); ?>" /><br>
    	<label>DJ website:</label><input type="text" name="dj_website" value = "<?php echo(get_post("dj_website")); ?>" /><br>
		<label>DJ description:</label>
		<textarea name="dj_desc" cols = "100" rows = "4"><?php echo(get_post("dj_desc")); ?></textarea>
		<input type="submit" name="update_dj" value="Save changes" />

	</form>
