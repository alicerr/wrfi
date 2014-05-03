<?php
//ACCESSES GLOBALS error_message, GLOBALS message
//PRINTS error messages found
//Called by templetes/top.php
function draw_message()
    {
    echo("draw_message called");
    if (isset($GLOBALS["error_message"])) echo ("<div id = \"error_message\">" . $GLOBALS['error_message'] . "</div>");
    if (isset($GLOBALS["message"])) echo ("<div id = \"message\">" . $GLOBALS['message'] . "</div>");
    if (isset($GLOBALS["error_message"]) || isset($GLOBALS["message"])) echo("<script> document.write(\"<div id = \\\"click\\\">click here to dismiss message</div>\");</script>");
    }
?>