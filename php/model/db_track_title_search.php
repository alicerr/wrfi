<?php

if ( !isset($_REQUEST['term']) )
    exit;

//sql setup
$mysqli2 = new mysqli('localhost', 'firebreath', 'firebreath', 'info230_SP14_firebreath');	

//make query
$result = $mysqli2->query('SELECT * FROM track LEFT OUTER JOIN album ON track.album_id = album.album_id LEFT OUTER JOIN artist ON track.artist_id = artist.artist_id LEFT OUTER JOIN label ON album.label_name = label.label_name WHERE track_name LIKE "'. mysql_real_escape_string($_REQUEST['term']) .'%" ORDER BY track_name ASC LIMIT 5');

//extract data
$data = array();
while($row = $result->fetch_assoc()){
	$data[] = array(
	'value' => $row['track_name'], //track title: track
	'full_track_length' => $row['length'], //consider breaking this into 3 parts for the three fields: track
	'artist_name' => $row['artist_name'], // artist (linked to track by id)
	'artist_website' => $row['artist_website'], // artist
	'artist_description' => $row['artist_desc'], // artist
	//'album' => $row['album_name'], // album (redundant) (linked to track by id)
	'album_title' => $row['album_name'], // album
	'album_website' => $row['album_website'], // album
	//'label' => $row['label_name'], // label (linked to album by name)
	'label_website' => $row['label_website'] // label
	);
}

echo json_encode($data);
flush();
?>