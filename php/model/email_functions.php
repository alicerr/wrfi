<?php
/*validate email adresses and send mail functions. Grouped together because of
 *a common theme only */


//INPUT: subject string, content string, email address, user name
//VISIBLE ACTION: none, but should recieve email
//OUTPUT: none
//code from stack overflow, like 8 projects ago
function email($subject, $body, $email)
    {
    
    
    $headers = 'WRFI radio someone@wrfi.org' . "\r\n";
    $headers.= 'Reply-To: ' . $email . "\r\n";
    $headers.= 'X-Mailer: PHP/' . phpversion();
    $headers.= "MIME-Version: 1.0\r\n";
    $headers.= "Content-type: text/html; charset=iso-8859-1\r\n";
    mail($email, $subject, $body, $headers);
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