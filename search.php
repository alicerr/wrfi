<?php
start_session();
require "php/model/get_set_unset_functions.php";
//this pages title
$pageTitle = "Search";
//this pages url
$GLOBALS['base_url'] = "search.php".clean(get_get("search"));
//page spec styles
$styles = array();
//page spec. scripts
$scripts = array();
//function called by content area
function content_function(){ load_search(); }
//load html
require "php/templetes/top.php";
?>