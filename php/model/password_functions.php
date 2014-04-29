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
        $name = user_name();
        if ($name){
            $query = "SELECT * FROM user WHERE email = \"$name\"";
            $user_entry = $mysqli->query($query);

            if ($user_entry)
                {
                $user_entry = $user_entry->fetch_assoc();
                if (isset($user_entry["user_password"]))
                    {
                    $password = hash('sha256', $password . "yadayadayada");

                    $good = ($user_entry['user_password'] == $password);
                    if ($good) $good = $user_entry["level_id"];
                }
            }
        }
        return $good;

}

?>