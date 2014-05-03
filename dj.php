<?php
session_start();
require "php/model/get_set_unset_functions.php";
//this pages title
$pageTitle = "Dj";
//this pages url
$GLOBALS['base_url'] = "dj.php?".clean(get_get("dj_id"));
//page spec styles
$styles = array();
//page spec. scripts
$scripts = array();
//function called by content area

function content_function(){ load_dj(); }
//load html
require "php/templetes/top.php";print_error_message("testing");
?>