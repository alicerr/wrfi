<!--add or edit a track-->
	<form method="post">
		<input type="number" name="track_id" class="hide" value = "<?php echo(get_post("track_id")); ?>" />

		<!--title and time info-->	
        <label>Track title:</label><input type="text" name="track_name" id="sid_track_name" value = "<?php echo(get_post("track_name")); ?>" required /><br>
		<label>Starting time:</label><input type="number" min = "0" max = "12" width = "2" name="start_hour" value = "<?php echo(get_post("start_hour")); ?>" required />:
		<input type="number" min = "0" max = "59" width = "2" name="start_min" value = "<?php echo(get_post("start_min")); ?>" required />:
	    <input type="number" min = "0" max = "59" width = "2" name="start_sec" value = "<?php echo(get_post("start_sec")); ?>" required />
		<select name = "start_am_pm" value = "<?php echo(get_post("start_am_pm")); ?>" >
			<option value ="am">AM</option>
			<option value ="pm">PM</option>
		</select>
		<input type="date" name="start_date" value = "<?php echo(get_post("start_date")); ?>" required />
		<br>
		<label>Playtime:</label>
		<input type="number" min = "0" max = "64" width = "2" name="duration_min" value = "<?php echo(get_post("duration_min")); ?>" required />:
		<input type="number" min = "0" max = "59" width = "2" name="duration_sec" required value = "<?php echo(get_post("duration_sec")); ?>" /><br>
		<label>Full Track Length:</label>
		<input type="number" min = "0" max = "12" width = "2" name="length_hour" value = "<?php echo(get_post("length_hour")); ?>" />:
		<input type="number" min = "0" max = "12" width = "2" name="length_min" value = "<?php echo(get_post("length_min")); ?>" />:
		<input type="number" min = "0" max = "59" width = "2" name="length_sec" value = "<?php echo(get_post("length_sec")); ?>" /><br>
		<input number = "text" class = "hide" name = "artist_id"value = "<?php echo(get_post("artist_id")); ?>" />
		<!--artist info-->
	    <label>Artist name:</label><input type="text" name="artist_name" value = "<?php echo(get_post("artist_name")); ?>" /><br>
		<label>Artist website:</label>https://www.<input type="text" name="artist_website" value ="<?php echo(get_post("artist_website")); ?>" /> <br>
	    <label>Artist description:</label><input type = "text" name="artist_desc" value = "<?php echo(get_post("artist_desc")); ?>" /><br>
		<br/>
	    <!--album info-->
		<input type="number" name="album_id" class="hide" value = "<?php echo(get_post("album_id")); ?>" />
		<label>Album:</label><input type="text" name="album_id" value = "<?php echo(get_post("album_name")); ?>" /><br>
		<label>Album title:</label><input type="text" name="album_name" value = "<?php echo(get_post("album_name")); ?>" /> <br>
		<label>Album Website:</label>https://www.<input type="text" name="album_website" value = "<?php echo(get_post("album_website")); ?>" /><br>	      
		<!--label info-->
		<label>Label:</label><input type="text" name="label_name" value = "<?php echo(get_post("label_name")); ?>" /><br>
		<label>Label website:</label>https://www.<input type="text" name="label_website" value = "<?php echo(get_post("label_website")); ?>" /><br>
	    <input type="submit" value="Save changes" name="update_track" />
    </form>
