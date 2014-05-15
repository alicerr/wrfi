<?php


//requirements of site
require_once "php/model/email_functions.php";
require_once "php/model/get_set_unset_functions.php";
require_once "php/model/error_message_functions.php";
require_once "php/model/query_functions.php";
require_once "php/model/time_functions.php";
require_once "php/model/search_functions.php";
require_once "php/model/login_functions.php";
require_once "php/model/password_functions.php";
require_once "php/model/insert_functions.php";
require_once "php/model/history_functions.php";
require_once "php/model/delete_functions.php";

require_once "php/view/draw_contents.php";
require_once "php/view/draw_css_script.php";
require_once "php/view/draw_message.php";


require_once "php/controller/content_load.php";
require_once "php/controller/load_sub_functions.php";
require_once "php/controller/search.php";
$search = "";
//make and store my_sqli
require_once "php/evergreen/config.php";
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($mysqli->connect_error){print_message("Database connection Error");}

//print_error_message(get_session("user_level")."user_level");
//update history stack
update_history(); 
seach_css();
//login or out if needed
update_user_state();

//look for editing commits
check_for_edits();

//look for editing panel requests
load_edit_panel();

?>