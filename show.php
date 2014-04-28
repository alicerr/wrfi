<?php
start_session();
require "php/model/get_set_unset_functions.php";
//this pages title
$pageTitle = "Show";
//this pages url
$GLOBALS['base_url'] = "show.php".clean(get_get("show_name"));
//page spec styles
$styles = array();
//page spec. scripts
$scripts = array();
//function called by content area
function content_function(){ load_show(); }
//load html
require "php/templetes/top.php";
?>