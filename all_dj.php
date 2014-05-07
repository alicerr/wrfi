<?php
session_start();
$pageTitle = "All DJs";
$base_url = "all_dj.php";
$styles = array("style/all_dj.css");
$scripts = array();
function content_function(){  load_all_djs(); }
require "php/templetes/top.php";
?>
