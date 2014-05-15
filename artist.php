<?php
session_start();
require "php/model/get_set_unset_functions.php";
//this pages title
$pageTitle = "Artist";
//this pages url
$GLOBALS['base_url'] = "artist.php?artist_id=".clean(get_get("artist_id"));
//page spec styles
$styles = array("style/artist.css");
//page spec. scripts
$scripts = array();
//function called by content area
function content_function(){ load_artist(); }
//load html
require "php/templetes/top.php";
?>