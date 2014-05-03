<?php
session_start();
$pageTitle = "All DJs";
$GLOBALS['base_url'] = "all_dj.php";
$styles = array();
$scripts = array();
function content_function(){ echo("here"); print_error_message("here"); load_all_djs(); }
require "php/templetes/top.php";
?>
