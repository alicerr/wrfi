jQuery(document).ready(function($){
	$('#sid_track_name').autocomplete({
		source: 'php/model/db_track_title_search.php',
		select:function(evt, ui){
			this.form.artist_name.value = ui.item.artist_name;
			this.form.artist_website.value = ui.item.artist_website;
			this.form.artist_desc.value = ui.item.artist_description;
			//this.form.album_id.value = ui.item.album;
			this.form.album_name.value = ui.item.album_title;
			this.form.album_website.value = ui.item.album_website;
			//this.form.label_name.value = ui.item.label_name;
			this.form.label_website.value = ui.item.label_website;
		}
	});
});