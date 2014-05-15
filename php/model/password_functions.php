<?php
//generates a random password, for password resets
//http://stackoverflow.com/questions/6101956/generating-a-random-password-in-php
//INPUT: none 
//VISIBLE ACTION: none
//OUTPUT: password
function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
//checks a password against a hashed password with salt "yadayadayada"
//returns level_id for user if succesful, false if no match
function check_password($password){
        global $mysqli;
        $good = false;
        $user_id = get_session("user_id");
        //echo($password);
        if ($user_id){
            $query = "SELECT * FROM user WHERE user_id = \"$user_id\"";
            $user_entry = $mysqli->query($query);

            if ($user_entry)
                {
                $user_entry = $user_entry->fetch_assoc();
                if (isset($user_entry["password"]))
                    {
                    $password = hash_it($password);
                    //echo($user_entry["password"]);
                    $good = ($user_entry['password'] == $password);
                    if ($good) $good = $user_entry["level_id"];
                }
            }
        }
        return $good;

}
function hash_it($string){
    
    return hash('sha256', $string . "yadayadayada");
    //return($string);
}
function reset_password($email){
    global $mysqli;
    $query = "SELECT * FROM user WHERE email = '$email'";
    //echo($query);
    if ($email){
        $res = $mysqli->query($query);
        
        if (warn(mysqli_num_rows($res) > 0, "user not found")){
            
            $r = $res->fetch_assoc();
            $pw = randomPassword();
            $password = hash_it($pw);
            //print_message("here2");
            $user_id = $r["user_id"];
            $query =  "UPDATE user
                        SET password = '$password'
                        WHERE user_id = $user_id";
                        
            $changed = feedback_op(query($query, false),
            "new password emailed", "password not changed");
            echo($pw);
        
            if ($user_id && $changed){
                
                //print_message("here");
                
                $fname = $r["fname"];
                $subject = "Hello from WRFI radio!";
                $body = "Dear $fname\n
                    \n
                    \n
                    \nYour new password is:
                    \n$pw
                     \nIf you feel this email was generated in error, 
                
                    \nplease contact a program manager
                    
                    \n
                    \n
                    \nHave a wonderful day!
                    \n
                    \nSincerely,
                    \n
                    \nThe WRFI Site Robot";
            email($subject, $body, $email);
        }
    }
    }
}

?>