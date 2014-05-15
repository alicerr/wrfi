<!--form for editing an artist's content-->
<form method="post">
	<label>Artist name:</label><input type="text" name="artist_name" value = "<?php echo(get_post("artist_name")); ?>" /><br>
	<label>Artist description:</label><textarea name="artist_desc"><?php echo(get_post("artist_desc")); ?></textarea><br>
	<label>Artist website:</label> http://www.<input type="text" name="artist_website" value ="<?php echo(get_post("artist_website")); ?>"/><br>
	<input type = "text" value = "<?php get_post('artist_id'); ?>" class = "hide" name = "artist_id" value = "<?php echo(get_post("artist_name")); ?>" /> 
	<input type="submit" name="update_artist" value="Save artist" />
</form>
