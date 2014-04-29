<?php

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

require_once "php/view/draw_contents.php";
require_once "php/view/draw_css_script.php";
require_once "php/view/draw_message.php";


require_once "php/controller/content_load.php";
require_once "php/controller/load_sub_functions.php";
//look for changes to a user's database entries that eed session information to be reloaded
update_user_state();

//update history stack
update_history(); 

//login or out if needed
login_logout();

//look for editing commits
check_for_edits();

//look for editing panel requests
load_edit_panel();

?>