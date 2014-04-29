<?php
session_start();
//this pages title
$pageTitle = "All Users";
//this pages url
$GLOBALS['base_url'] = "all_user.php";
//page spec styles
$styles = array();
//page spec. scripts
$scripts = array();
//function called by content area
function content_function(){ load_all_users(); }
//load html
require "php/templetes/top.php";
?>