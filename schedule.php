<?php
session_start();
//this pages title
$pageTitle = "Schedule";
//this pages url
$GLOBALS['base_url'] = "schedule.php";
//page spec styles
$styles = array();
//page spec. scripts
$scripts = array();
//function called by content area
function content_function(){ load_schedule(); }
//load html
require "php/templetes/top.php";
?>