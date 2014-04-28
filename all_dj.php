<?php
start_session();
$pageTitle = "All DJs";
$GLOBALS['base_url'] = "all_dj.php";
$styles = array();
$scripts = array();
function content_function(){ load_all_djs(); }
require "php/templetes/top.php";
?>
