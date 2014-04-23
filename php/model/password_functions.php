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
//not to use, just might need the stuff in it
function check_password($password){
        global $mysqli;
        $good = false;
        $name = user_name();
        if ($name){
            $query = "SELECT * FROM user WHERE user_email = \"$name\"";
            $user_entry = $mysqli->query($query);

            if ($user_entry)
                {
                $user_entry = $user_entry->fetch_assoc();
                if (isset($user_entry["user_password"]))
                    {
                    $password = hash('sha256', $password . "yadayadayada");

                    $good = ($user_entry['user_password'] == $password);
                }
            }
        }
        return $good;

}

?>