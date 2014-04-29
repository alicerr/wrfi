<!--edit shows-->
	<form method="post">
	<?php
	$show_name = get_post("show_name");
	if (manager() && !$show_name)
		//managers can add shows
		echo('<input type="text" name = "show_name" value = "" required />');
	else
		echo("<h2>$show_name</h2>");
	?>
	<br />
    	Show description: <textarea name="show_description">
		<?php echo(get_post("show_desc")); ?>
	</textarea>
    	Show website: https://<input type="text" name="show_website"
	value = "<?php echo(get_post("show_website")); ?>" /><br />
    	<input type="submit" name="update_show" value="Save changes" /> 
	</form>
