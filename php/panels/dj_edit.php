<!--form for editing or adding dj variables-->
	<form method="post">
    	<input type="text" name="dj_id" class="hide" "<?php echo(get_post("dj_id")); ?>" /><br>
    	DJ name: <input type="text" name="dj_name"
	value = "<?php echo(get_post("dj_name")); ?>" /><br>
    	DJ description: <textarea name="dj_desc"
	value = "<?php echo(get_post("dj_desc")); ?>"></textarea><br>
    	DJ website: https://<input type="text" name="dj_website"
	value = "<?php echo(get_post("dj_website")); ?>" /><br>
    	<input type="submit" name="edited_dj" value="Save changes" />
	</form>
