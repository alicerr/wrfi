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
    $error_message = str_replace("BREACK", "<br>", $error_message);
    if ($error_message) $error_message = substr($error_message, 4)."<br>";
    $message = str_replace("BREACK", "<br>", $message);
    if ($message) $message = substr($message, 4)."<br>";
    
    if (get_global('error_message')) echo ("<div id = \"error_message\">" . $error_message . "</div>");
    //prints any message to message panel
    if (get_global('message')) echo ("<div id = \"message\">" . $message . "</div>");
    //writes 'click to dismiss' using js
    if (get_global('message') || get_global('error_message'))
        echo("<script> document.write(\"<div id = \\\"click\\\">click here to dismiss message</div>\");</script>");
    else
        echo("<style>#message_block{display: none;}</style>");
    
    }
    
   function draw_show_select(){
        $query = "SELECT show_name FROM shows ORDER BY show_name";
        global $mysqli;
        
        $res = $mysqli->query($query);
        echo('<label>Show Name:</label> <select name = "show_name" >');
        $current = get_post("show_name");
        while ($r = $res->fetch_assoc()){
            $selected = "";
            if ($current = $r["selected"]) $selected = "selected";
            echo('<option value="'.$r["show_name"].'" '.$selected.' >'.$r["show_name"].'</option>');
        }
        echo('</select><br>');
        
    }
    function draw_user_select(){
        $query = "SELECT fname, lname, email, user_id FROM user ORDER BY fname";
        global $mysqli;
        
        $res = $mysqli->query($query);
        echo('<label>User Name:</label> <select name = "user" >');
        $current = get_post("show_name");
        while ($r = $res->fetch_assoc()){
            $selected = "";
            if ($current = $r["selected"]) $selected = "selected";
            echo('<option value="'.$r["user_id"].'" '.$selected.' >'.$r["fname"]." ".$r["lname"]." ".$r["email"].'</option>');
        }
        echo('</select><br>');
    }

?>