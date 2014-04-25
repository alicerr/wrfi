<?php

//dj makes a request that only a specific set of djs can make
//(variosus functions are provided for this)
//INPUT: bool from the right validation function (determined by show or by time)
//ACTION: tell user to log in to continue (user actions are not visable to guests, assumed time out)
//OUTPUT: string if validated, null if not
function is_right_dj($right)
    {
    warn($right, "please log in as a DJ with access to this to continue.");
    return $right;
    }
    
//user makes a request that only a logged in user can make
//INPUT: none
//ACTION: tell user to log in to continue (user actions are not visable to guests, assumed time out)
//OUTPUT: string if validated, null if not
function is_dj()
    {
    $right = dj();
    warn($right, "please log in as a DJ with access to this to continue.");
    return $right;
    }
//checks if current user has admin status when user requests an admin action
//ACTION: tell user to log in to continue (admin actions are not visable to non-admins, assumed time out)
//RETURNS: true if admin, false if not
function is_aux()
    {
    $is_admin = aux();
    warn($is_admin, "please log in as an aux to continue.");
    return $is_admin;
    }
//checks if current user has admin status when user requests an admin action
//ACTION: tell user to log in to continue (admin actions are not visable to non-admins, assumed time out)
//RETURNS: true if admin, false if not
function is_manager()
    {
    $is_admin = manager();
    warn($is_admin, "please log in as a manager to continue.");
    return $is_admin;
    }
//wrapper that prints a warning if a condition is not met
//INPUT: condition status (bool), message if status is false
//VISIBLE ACTION: a warning if the condition is not met
//OUTPUT: the condition status
function warn($b, $message)
    {
    if (!$b) print_error_message($message);
    return $b;
    }
    
//prints an error message to the user 
//INPUT: message string
//VISIBLE ACTION: prints reddish message to top bar (section d)
//OUTPUT: none
function print_error_message($message)
    {
    //if other messages are in que then this one is appended
    set_global(get_global('error_message')."<p>$message</p>");
    }
//prints a message to the user
//(black text in the top bar)
//INPUT: message string
//VISIBLE ACTION: prints message to top bar (section d)
//OUTPUT: none
function print_message($message)
    {
    //if other messages are in que then this one is appended
    set_global(get_global('error_message')."<p>$message</p>");
    }
    
    function op_feedback($op, $succ_message, $fail_message)
    {
        if ($op && $succ_message)
            print_message($suc_message);
        elseif ($fail_message)
            print_error_message($fail_message);
    }

?>