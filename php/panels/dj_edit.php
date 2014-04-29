<!--form for editing or adding dj variables-->
	<form method="post">
    	<input type="text" name="dj_id" class="hide" "<?php echo(get_post("dj_id")); ?>" />
    	DJ name: <input type="text" name="dj_name"
	value = "<?php echo(get_post("dj_name")); ?>" />
    	
    	DJ website: https://<input type="text" name="dj_website"
	value = "<?php echo(get_post("dj_website")); ?>" />
	<input type="submit" name="edited_dj" value="Save changes" /><br />
	DJ description: <textarea name="dj_desc"
	value = "<?php echo(get_post("dj_desc")); ?>"></textarea><br />

	</form>
