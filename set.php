<?php
start_session();
require "php/model/get_set_unset_functions.php";
//this pages title
$pageTitle = "Set";
//this pages url
$GLOBALS['base_url'] = "set.php?".clean(get_get("set_id"));
//page spec styles
$styles = array();
//page spec. scripts
$scripts = array();
//function called by content area
function content_function(){ load_set(); }
//load html
require "php/templetes/top.php";
?>