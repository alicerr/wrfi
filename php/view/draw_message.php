<?php
//draws the top bar messages from stroed messages
//INPUT: none (messages are stored by a different function)
//VISIBLE ACTION: prints the messages
//OUTPUT: none
//ACESSES: GLOBALS: 'message', 'error_message'
    function draw_message()
    {
    $error_message = get_global('error_message');
    $message = get_global('message');
    //prints any error messages to message pannel
    if ($error_message) echo ("<div id = \"error_message\">" . $GLOBALS['error_message'] . "</div>");
    //prints any message to message panel
    if ($message) echo ("<div id = \"message\">" . $GLOBALS['message'] . "</div>");
    //writes 'click to dismiss' using js
    if ($message || $error_message)
        echo("<script> document.write(\"<div id = \\\"click\\\">click here to dismiss message</div>\");</script>");
    }
    
    

?>