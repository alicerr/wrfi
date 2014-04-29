<?php
session_start();
//this pages title
$pageTitle = "All Shows";
//this pages url
$GLOBALS['base_url'] = "all_show.php";
//page spec styles
$styles = array();
//page spec. scripts
$scripts = array();
//function called by content area
function content_function(){ load_all_shows(); }
//load html
require "php/templetes/top.php";
?>