<?php
//FINISHED
/*
 *this file contains the many warning messages and event triggers used to notify
 *the user of exactly what went wrong. These are all written in php,
 *in the message window.
 *
 *many of these functions are wrappers, passing content through them while reporting
 *on conditions.
 *
 *these functions are used heavily throughout the site, they do not directly modify
 *the display. Rather they load content into post[message] and post[error_message]
 *
 */


/*
Purpose: warn a user if they are trying to do something dj+ level, and are not logged
Input: none
Output:none
Accesses: none
Modifies: none
Visual effects:
    message: none
    error message: if warns user if SESSION[user_id] is not set (user is not logged in)
Database effects: none
Other: none
*/
function is_dj()
    {
    $right = dj();
    
    warn($right, "please log in as a DJ with access to this to continue.");
    return $right;
    }
/*
Purpose: warn a user if they are trying to do aux+ activity and are dj level
Input: boolean
Output:none
Accesses: none
Modifies: none
Visual effects:
    message: none
    error message: if SESSION[user_level] < 2 warn user
Database effects: none
Other: none
*/
function is_aux()
    {
    $is_admin = aux();
    warn($is_admin, "please log in as an aux to continue.");
    return $is_admin;
    }
/*
Purpose: warn a aux- if they are trying to do something at manager level
Input: boolean
Output:none
Accesses: none
Modifies: none
Visual effects:
    message: none
    error message: if SESSION[user_level] < 3  warn user
Database effects: none
Other: none
*/
function is_manager()
    {
    $is_admin = manager();
    warn($is_admin, "please log in as a manager to continue.");
    return $is_admin;
    }
/*
Purpose: wrapper to take a message and print it if a condition is not met,
without interuptig program flow. This is often used in if statements to let the user
know exactly why something was rejected
Input: boolean, message string
Output: boolean (unmodified)
Accesses: none
Modifies: none
Visual effects:
    message: none
    error message: if false then warns user
Database effects: none
Other: none
*/
function warn($b, $message)
    {
    if (!$b) print_error_message($message);
    return $b;
    }
    
/*
Purpose: adds message to error messages in printing queue GLOBAL[error_message]
Input: message string
Output:none
Accesses: none
Modifies: none
Visual effects:
    message: none
    error message: message string
Database effects: none
Other: none
*/
function print_error_message($message)
    {
        
    //if other messages are in que then this one is appended
    set_global("error_message", get_global('error_message')."BREACK"."$message");
    }
/*
Purpose: adds message to messages in printing queue GLOBAL[message]
Input: message string
Output:none
Accesses: none
Modifies: none
Visual effects:
    message: message string
    error message: none
Database effects: none
Other: none
*/
function print_message($message)
    {
    //if other messages are in que then this one is appended
    set_global("message", get_global('message')."BREACK"."$message");
    }
  
/*
Purpose: wraps an operation and provides feeback about it's sucess/failure
Input: boolean, message string, error message string
Output:boolean (unmodified)
Accesses: none
Modifies: none
Visual effects:
    message: message string if boolean = true
    error message: error message string if boolean = false
Database effects: none
Other: used to wrap database insertions/updates
*/
function op_feedback($op, $succ_message, $fail_message)
{
    if ($op && $succ_message)
        print_message($succ_message);
    elseif ($fail_message)
        print_error_message($fail_message);
    return $op;
}
function feedback_op($op, $succ_message, $fail_message)
{
   return op_feedback($op, $succ_message, $fail_message);
}
function is_user_show(){
    return ((get_post("show_name") && array_find(get_post("show_name"), get_session("shows"))) ||
            (get_post("set_id") && array_find(get_post("set_id"), get_session("set_ids"))));
}
function is_user_show_get(){
    return ((get_get("show_name") && array_find(get_get("show_name"), get_session("shows"))) ||
            (get_get("set_id") && array_find(get_get("set_id"), get_session("set_ids"))));
}
            
            

?>