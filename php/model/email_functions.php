<?php
/*validate email adresses and send mail functions. Grouped together because of
 *a common theme only */


//INPUT: subject string, content string, email address, user name
//VISIBLE ACTION: none, but should recieve email
//OUTPUT: none
//code from stack overflow, like 8 projects ago
function email($subject, $contents, $address, $user_name)
    {
    $to = $address;
    $subject = $subject;
    $body = "Dear User, \n $contents \n \n Sincerely, \n The project 5 site robot \n\n at: " . get_time();
    $headers = 'WRFI radio someone@wrfi.org' . "\r\n";
    $headers.= 'Reply-To: ' . $to . "\r\n";
    $headers.= 'X-Mailer: PHP/' . phpversion();
    $headers.= "MIME-Version: 1.0\r\n";
    $headers.= "Content-type: text/html; charset=iso-8859-1\r\n";
    mail($to, $subject, $body, $headers);
    }
//uses a php to validate the email. It is pickier than the html form is
//INPUT: email address to be validated
//ACTIONS: Prints a message to the user if the email is invalid
//OUTPUT: email after validation (null if failure)
function validate_email($email)
    {
    $good = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!$good) print_error_message("Email address invalid");
    return $good;
    }
?>