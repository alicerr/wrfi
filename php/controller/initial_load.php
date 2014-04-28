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
require_once "php/model/draw_message.php";

//login or out if needed
login_logout();

//look for editing commits
check_for_edits();

//look for editing panel requests
load_edit_panel();
?>