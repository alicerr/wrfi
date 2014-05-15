<?php
//FINISHED
//ADD COMMENTS

/*
Purpose: validates a feild, providing error message feedback if it does not validate
Input: feild (value), min length (if null defaults to 1), max length (if null defaults to 255), feildname,
is the feld allowed to be null? (boolean)
Output: cleaned feild (value)
Accesses: none
Modifies: none
Visual  effects: error message if null and not null, or if no null and not meeting length requirments
Database effects: none
Other:  none
*/
function valid_f($feild, $min, $max, $feild_name, $null_allowed){
    $fc = clean($feild);
    if (!$max) $max = 255;
    if (!$min) $min = 1;
    if ((!$fc && !$null_allowed) || ($fc && strlen($fc) < $min))//string length below min, but present, or null not allowed
         print_error_message("$feild_name must have at least $min charecter(s)");
    elseif ($fc && $max < strlen($fc)){ //max exceeded
        
        $fc = substr($fc,0,  $max);
        print_error_message("$feild_name must have at most $max charecters, I had to shorten it to: $fc");
    }
    return $fc;
}
/*
Purpose: removes the begining part f a website link for storage, so that we
can make links out of stored links
Input: website string
Output: website string with http... removed
Accesses: none
Modifies: none
Visual effectL: none
Database effects: none
Other:  none
*/
function website_f($string){
    if (strpos($string, "www.") > 0)
    {
        return substr($string, strpos($string, "www.") + 4 );
    }
    else if (strpos($string, "https:") > 0)
    {
    
        return substr($string, strpos($string, "https:") + 6 );
    }
        else if (strpos($string, "http:") > 0)
    {
        return substr($string, strpos($string, "http:") + 5 );
    }
    return $string;
}
//tries to find label w/ same name to update
//if none adds new label
//does not overwrite content feilds with null feilds
//informs user of issues
//validates feilds
//returns label_name if successful, null if not
function add_label($label_name, $label_website)
{
    $label_name = valid_f($label_name, null, null, "label name", false );
    $label_website = valid_f(website_f($label_website), null, null, "label website", true );
    $changed = false;
    if ($label_name &&
        get_label($label_name) &&
        $label_website && op_feedback(
                               any_dj_query("UPDATE label SET label_website = '$label_website' WHERE label_name = '$label_name'", false),
                               "label $label_name updated",
                               "label $label_name was not updated")){$changed = $label_name;}
    elseif ( $label_name && !get_label($label_name) && op_feedback(any_dj_query("INSERT INTO label (label_name, label_website) VALUES ('$label_name', ".not_null($label_website).")", false),
                                     "label $label_name updated",
                                     "label $label_name was not updated"))
            $changed = $label_name;
    return $changed;
            
}
//returns string : ", $feild='$string' " if $string is not null
//else null. Used to not overwrite nin null feilds
function update_if_set($string, $feild){ if ($string) return " , $feild = '$string' "; else return "";}

//adds or updates artist, dependent on artist_id (if id == 0 then adds )
//does not overwrite content feilds with null feilds
//informs user of issues
//validates feilds
//returns artist_id if successful, null if not
function add_artist($artist_id, $artist_name, $artist_desc, $artist_website){
    $artist_name = valid_f($artist_name, null, null, "artist name", false);
    $artist_desc = valid_f($artist_desc, null, null, "artist_desc", true);
    $artist_website = valid_f(website_f($artist_website), null, null, "artist_website", true);
    $changed = false;
    if ($artist_name &&
        $artist_id > 0 &&
        feedback_op(
                    any_dj_query("UPDATE artist SET artist_name = '$artist_name'".
                                 update_if_set($artist_website, "artist_website").
                                 update_if_set($artist_desc, "artist_desc")." WHERE artist_id = $artist_id", false),
                    "artist $artist_name updated", "artist $artist_name not updated"))
        $changed = $artist_id;
    elseif ($artist_name && feedback_op(
                    any_dj_query("INSERT INTO artist (artist_name, artist_desc, artist_website)
                                 VALUES ('$artist_name', ".not_null($artist_desc).", ".not_null($artist_website).")", false),
                    "artist $artist_name updated", "artist $artist_name not updated"))
        $changed = last_id();
    return $changed;
    }

//adds or updates album, dependent on album_id (if id == 0 then adds )
//adds label if feilds provided
//does not overwrite content feilds with null feilds
//informs user of issues
//validates feilds
//returns album_id if successful, null if not
function add_album($album_id, $album_name, $album_website, $label_name, $label_website){
    $album_name = valid_f($album_name, null, null,"album name", false);
    $album_website = valid_f(website_f($album_website), null, null, "album website", false);
    $label_name = add_label($label_name, $label_website);
    $changed = false;
    
    if ($album_name && $album_id > 0){
        
        $changed =  feedback_op(any_dj_query("UPDATE album SET album_name = '$album_name'".
                                    update_if_set($album_website, "album_website").
                                    update_if_set($label_name, "label_name")."
                                    WHERE album_id = $album_id", false), "album $album_name updated", "album $album_name not updated");
    }
    elseif ($album_name){
           
            $changed = feedback_op(any_dj_query("INSERT INTO album (album_name, album_website, label_name) VALUES ('$album_name', ".not_null($album_website)." , ".not_null($label_name).")", false),
                        "album $album_name updated", "album $album_name not updated");
    if ($changed) $changed = last_id();
    }
    return $changed;
    
}
//updates user
//DOES overwrite content feilds with null feilds
//informs user of issues
//validates feilds
//returns user_id if successful, null if not
//will only query session for user_id unless manager
function update_user( $user_id, $email, $fname, $lname, $phone, $password, $new_password, $confirm_password){
    $user_id = get_session("user_id");
    //echo("<script>alert(\"".get_post("user")."\")</script>");
    if (manager()) $user_id = get_post("user_id");
    if (manager() && get_post("user_id") == 0) {
               
                $new = true;
        
    }
    else
    
    
         $new = false;
    
    $email = validate_email($email);
    warn($email, "Email required");
    $fname = valid_f($fname, 1, 50, "first name", false);
    $lname = valid_f($lname, 1, 50, "last name", true);
    $phone = valid_f($phone, 7, 15, "phone", true);
    //echo("USER ID: ".get_post("user_id"));
   
    $changed = false;
    //if ($password) $password = hash_it($password);
    $pass =  (warn(check_password($password) || manager(), "Password not recognized"));

    if (!$new && $email && $fname && $user_id  && $pass ){
        $query = "UPDATE user
                        SET email = '$email',
                        fname = '$fname',
                        lname = '$lname',
                        phone = '$phone'  WHERE user_id = $user_id";
           // echo($query);
            $changed = feedback_op(query($query, false),
            "personal information updated", "personal information not updated");
            
    
    }
    elseif ($new && warn(manager(), "please log in as a manager to continue") && $email && $fname ){
        $pw = randomPassword();
        $password = hash_it($pw);
        $dj_name = $fname;
        $query = "INSERT INTO user 
                        (email, phone, fname, lname, password)
                        VALUES ('$email', '$phone', '$fname', '$lname', '$password')";
        //echo($query);
        $changed = feedback_op(query($query, false),
            "personal information updated", "personal information not updated");
        $user_id = last_id();
        $query = "INSERT INTO dj (dj_name, user_id, dj_desc) VALUES ('$dj_name', '$user_id', 'Welcome to WRFI $fname!')";
        if ($changed)
            feedback_op(query($query,false),
            "personal information updated", "personal information not updated");
        if ($user_id && $changed){
            $query = "SELECT * FROM user WHERE user_id = $user_id";
            global $mysqli;
            $res = $mysqli ->query($query);
            $email = $r["email"];
            $fname = $r["fname"];
            $subject = "Welcome to WRFI radio!";
            $body = "DEAR $fname\n
                    \n
                    \nWelcome to WRFI!
                    \nYour initial password is:
                    \n$pw
                    \n
                    \nWe've also taken the liberty of issuing an initial host/dj name for you,
                    \nit's just your first name, so please feel free to edit this when you log in!
                    \n
                    \n
                    \nIt's Great to have you on board!
                    \n
                    \nSincerely,
                    \n
                    \nThe WRFI Site Robot";
            email($subject, $body, $email);
        }
    }
            
            
            
    
    
    
    
    //echo("<br />PP".$new_password);
    $new_password2 = "";
    if ($new_password) $new_password2 = valid_f($new_password, 8, 50, "new password", false);
    //echo("<br />PP".$new_password2);
    if ($new_password2 && warn($new_password2 == $confirm_password, "passwords do not match" ))
        {
            $new_password = hash_it($new_password2);
            $query = "UPDATE user
                        SET password = '$new_password'
                        WHERE user_id = $user_id";
             $changed =  feedback_op(query($query, false),
            "password updated", "password not updated");
        if ($user_id && $changed){
            $query = "SELECT * FROM user WHERE user_id = $user_id";
            global $mysqli;
            $res = $mysqli ->query($query);
            $r = $res->fetch_assoc();
            $email = $r["email"];
            $fname = $r["fname"];
            $subject = "Welcome to WRFI radio!";
            $body = "DEAR $fname\n
                    \n
                    \nHello from WRFI!
                    \nYou changed your password on the WRFI site
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
    return $changed;
}
}
//adds user, manager level
//does not overwrite content feilds with null feilds
//informs user of issues
//validates feilds
//returns artist_id if successful, null if not
function insert_user( $email, $fname, $lname, $phone, $dj_name){
 $email = validate_email($email);
    $fname = valid_f($fname, 1, 50, "first name", false);
    $lname = valid_f($lname, 1, 50, "last name", true);
    $phone = valid_f($phone, 1, 15, "phone", true);
    $dj_name = valid_f($dj_name, null, null, "dj name", false);
    $password = random_password();
    $h_password = hash_password($password);
    $changed = false;
    if ($email && $fname && $password && $dj_name &&
        feedback_op(manager_query("INSERT INTO user
                                  (email, fname, lname, phone, created, password)
                                  VALUES ('$email', '$fname', ' $lname', '$phone',".get_time()." , $h_password)"), " user $fname at $email entered ", " user not created ", false))
        $changed = last_id();
    
    return $changed;
    
}
//adds or updates dj_name, dependent on dj_id (if id == 0 then adds )
//does not overwrite content feilds with null feilds
//informs user of issues
//validates feilds
//returns dj_id if successful, null if not
//user_id comes from session, or user has manager status
function add_dj($dj_id, $dj_name, $user_id, $dj_desc, $dj_website){
    $dj_name = valid_f($dj_name, null, null, "dj name", false);
    $dj_desc = valid_f($dj_desc, null, 1000, "dj description", true);
    $dj_website = valid_f(website_f($dj_website), null, null, "dj_website", true);
    $cred = array_find($dj_id, get_session("dj_ids"));
    
    $changed = false;
    $user_id = get_session("user_id");
    //echo($dj_id."dj_id\n");
    if ($dj_id > 0 && $dj_name  && warn($cred, "NO CRED")){
        $changed = feedback_op(query(" UPDATE dj SET dj_name = '$dj_name', dj_website = '$dj_website', dj_desc = '$dj_desc' WHERE dj_id = $dj_id", false),
                    "$dj_name updated", "$dj_name not updated");
        echo("<br />$changed CHANGED<br />");
        if ($changed) $changed = $dj_id;
}
        
    elseif ($dj_name){ 
         $changed =  feedback_op(query("INSERT INTO dj (user_id, dj_name, dj_desc, dj_website) VALUES
                              ($user_id,'$dj_name', '$dj_desc', '$dj_website')", false),
                                 "$dj_name added", "$dj_name not added", false);
        $changed = last_id();
    }
    if ($changed) reload_user_info();
    if ($changed) header('Location: '."dj.php?dj_id=$dj_id");
    return $changed;
}
//adds or updates show, dependent on artist_id (if id == 0 and manager then adds )
//does not overwrite content feilds with null feilds
//informs user of issues
//validates feilds
//returns show_name if successful, null if not
function add_show($show_name, $show_desc, $show_website){
    
    $query = "SELECT * FROM shows WHERE show_name LIKE '$show_name'";
    global $mysqli;
    $res = $mysqli->query($query);
    $exists = (mysqli_num_rows($res) > 0);
    
    $show_name = valid_f($show_name, null, null, "show name", false);
    $show_desc = valid_f($show_desc, null, 500, "show description", true);
    
    $show_website = valid_f(website_f($show_website), null, null, "show website", true);
    
    $cred = warn(array_find($show_name, get_session("shows")) || manager(), "Please log in as an affiliated user or a manager to change $show_name details");
    $changed = false;
    if ($exists && $show_name && $cred)
        $changed  = feedback_op(query("UPDATE shows SET show_desc =
                          '$show_desc', show_website = '$show_website'
                          WHERE show_name = '$show_name'", false), "$show_name updated", "$show_name not updated");
        
    elseif ($show_name && manager() &&
            feedback_op(query("INSERT INTO shows (show_name, show_desc, show_website)
                              VALUES ('$show_name','$show_desc', '$show_website')", false), "$show_name added", "$show_name was not added"))
        $changed = $show_name;
    if ($changed) header('Location: '."show.php?show_name=".urlencode($show_name));
    return $changed;
}
//adds show_user affiliation
//does not overwrite content feilds with null feilds
//informs user of issues and success
//validates feilds
//returns artist_id if successful, null if not
function add_show_user($show_name, $user_id){
    $changed = false;
    global $mysqli;
    $query = "SELECT * FROM show_user WHERE user_id = $user_id AND show_name = '$show_name'";
    echo($query);
    $exists = false;
    $res = $mysqli->query($query);
    $exists = mysqli_num_rows($res) > 0;
    //$user = get_user_by_email($email);
    //$user_id = 0;
    //if ($user) $user_id = $user['user_id'];
    if (warn(!$exists, "user is already affiliated with show") &&
        $user_id && $show_name && warn(manager(), "please log in as a manager to continue") && 
        feedback_op(query("INSERT INTO show_user (user_id, show_name)
                                 VALUES ('$user_id', '$show_name')", false),
                   "User affiliated with $show_name",
                   "User not affiliated with show"))                  
        $changed = array($user_id, $show_name);
   return $changed;
}
//track entry
//adds/updates label if content provided
//then album
//then artist
//then track
//does not overwrite content feilds with null feilds
//informs user of issues and success
//validates feilds
//returns track_id if successful, null if not
function add_track($track_id, $track_name, $length, $artist_id,
                   $artist_name, $album_id, $album_name, $label_name,
                   $label_website, $album_id, $album_name, $album_website,
                   $artist_id, $artist_name, $artist_website, $artist_desc)
{
   
    
    if ($album_name) $album_id =  add_album($album_id, $album_name, $album_website, $label_name, $label_website);
    warn($label_name && !$album_name, "labels are only recorded for albums, but an album can be a single track, if it was released as such");
    if ($artist_name) $artist_id = add_artist($artist_id, $artist_name, $artist_desc, $artist_website);
    //$possible_track_id = track_id($track_name, $album_name, $artits_name);
    //if ($track_id == 0) $track_id = $possible_track_id;
    $changed = false;
    if ($track_id > 0 &&
        warn($track_name, "please enter a track name") &&
        feedback_op(any_dj_query("UPDATE track SET track_name = '$track_name'"
                                 .update_if_set($artist_id, "artist_id")
                                 .update_if_set($album_id, "album_id")
                                 .update_if_set($length, "length")
                                 ." WHERE track_id = $track_id", false), " track updated in database ", "track not updated "))
    $changed = $track_id;
    elseif ($track_id  == 0 &&
            warn($track_name, "please enter a track name")
            && feedback_op(any_dj_query("INSERT INTO track (track_name, artist_id, album_id, length)
                                        VALUES ('$track_name', ".not_null($artist_id)." , ".not_null($album_id). ", ".not_null($length)." )", false),
                           " track added to database ",
                           "track added "))
    $changed = last_id();
    if ($changed ) $track_id = $changed;
    return $track_id;
    
    
}
//track_played entry
//adds/updates label if content provided
//then album
//then artist
//then track
//then track_played
//does not overwrite content feilds with null feilds
//informs user of issues and success
//validates feilds
//returns start if successful, null if not
function add_track_played( $start, $duration, $length,
                          $set_id, $track_id, $track_name, $artist_id,
                          $artist_name, $album_id, $album_name, $label_name,
                          $label_website, $album_id, $album_name, $album_website,
                          $artist_id, $artist_name, $artist_website, $artist_desc){
    
    $dj_id = get_session('current_dj_id');
   // echo("here");
    $changed = false;
    $pass = false;
    if ($set_id == 0){
        $min_start = uni_to_sql(strtotime($start) - 60*5);
        $max_start = uni_to_sql(strtotime($start) + 60 * 5);
        $aux_query = ("SELECT * FROM sets WHERE set_start < '$start' && set_end > '$start'");
        $user_id = get_session("user_id");
        $user_query = ("SELECT * FROM sets INNER JOIN shows ON sets.show_name = shows.show_name INNER JOIN show_user on show_user.show_name = shows.show_name WHERE set_start < '$max_start' && set_end > '$min_start' && show_user.user_id = $user_id");
        if (aux()) $query = $aux_query;
        else $query = $user_query;
     //   echo($query);
        global $mysqli;
        $res = $mysqli->query($query);
        $pass = false;
        if (mysqli_num_rows($res) > 2  ){
       
            $query = ("SELECT * FROM sets INNER JOIN shows ON sets.show_name = shows.show_name INNER JOIN show_user on show_user.show_name = shows.show_name WHERE set_start < '$start' && set_end > '$start' && show_user.user_id = $user_id");
            //echo($query);
            
            $res = $mysqli->query($query);
        }
        if (warn(mysqli_num_rows($res) > 0, "set at that time not found, or not available for editing")){
            $r = $res->fetch_assoc();
            $set_id = $r["set_id"];
            $show_name = $r["show_name"];
            $pass = true;
            
           
        }
    }
    elseif($set_id > 0){
        $query = "SELECT * FROM track_played WHERE start = '$start'";
        global $mysqli;
        $not_changed = (mysqli_num_rows($mysqli->query($query)) > 0);
        $user_id = get_session("user_id");
        $user_query = ("SELECT * FROM sets INNER JOIN shows ON sets.show_name = shows.show_name INNER JOIN show_user on show_user.show_name = shows.show_name WHERE  show_user.user_id = $user_id && set_id = $set_id");
        $pass = ( aux() ||  mysqli_num_rows($mysqli->query($query)) > 0);
        echo($query);
        if (!$not_changed){
          $min_start = uni_to_sql(strtotime($start) - 60*5);
          $max_start = uni_to_sql(strtotime($start) + 60 * 5);
        
            $aux_query = ("SELECT * FROM sets WHERE set_start < '$start' && set_end > '$start' && set_id = $set_id");
            $user_id = get_session("user_id");
            $user_query = ("SELECT * FROM sets INNER JOIN shows ON sets.show_name = shows.show_name INNER JOIN show_user on show_user.show_name = shows.show_name WHERE set_start < '$max_start' && set_end > '$min_start' && show_user.user_id = $user_id && set_id = $set_id");
            if (aux()) $query = $aux_query;
            else $query = $user_query;
         //   echo($query);
            $res = $mysqli->query($query);
            if (warn(mysqli_num_rows($res) > 0, "That show at that time not found, or not available for editing")){
                $pass = true;

           
            }
            else $pass = false;
        }
    }
    
    
    if ($pass) $track_id  =  add_track($track_id, $track_name, $length, $artist_id,
                   $artist_name, $album_id, $album_name, $label_name,
                   $label_website, $album_id, $album_name, $album_website,
                   $artist_id, $artist_name, $artist_website, $artist_desc);
   
    if ($pass && $track_id && $set_id){
        if (get_post("dj_id") && aux()) $dj_id = get_post("dj_id");
        
        
        global $mysqli;
        $mysqli->query($query);
        
        
        $query = ("DELETE FROM track_played WHERE start = '$start'");
        $mysqli->query($query);
        
        $changed = feedback_op(query("INSERT into track_played (start, dj_id, duration, track_id, set_id)
                                                            VALUES ('$start', '$dj_id', '$duration', '$track_id', '$set_id') ", false), "Track saved", "track not saved");
        $changed = $start;
        if ($changed)  header('Location: '."set.php?set_id=$set_id");
    }
    return $changed;
    
}
//adds a set
//manager level
//returns set_id if success
function add_set( $set_id, $set_start, $set_end, $show_name, $set_desc, $set_link){
    $changed = false;
    $show_name = valid_f($show_name, null, null, "show name", false);
    $set_desc = valid_f($set_desc, null, null, "set description", true);
    $set_link = valid_f(website_f($set_link), null, null, "set link",  true);
    $bogus = !does_not_cross($set_id, $set_start, $set_end);
    //echo($set_desc."SET DESC");
    if (manager() && $set_id && warn(!$bogus, "SHOW TIMES cross another show, or each other") ){
        $changed = feedback_op(query("UPDATE sets SET set_link = \"$set_link\" ".
                                     update_if_set($set_start, "set_start").
                                     update_if_set($set_end, "set_end").
                                     update_if_set($set_desc, "set_desc").
                                     update_if_set($show_name, "show_name").
                                     "WHERE set_id = $set_id", false), " Set of $show_name updated" , "set of $show_name not updated");
    
    }
    elseif (is_manager() && $set_id == 0 && !$bogus){
            $changed = feedback_op(query("INSERT into sets (set_id, set_start, set_end, show_name, set_desc, set_link)
                              VALUES ('$set_id', '$set_start', '$set_end', '$show_name', '$set_desc', '$set_link')", false), "$show_name added at $set_start", "$show_name not added");
    }
    elseif($set_id != 0 && is_user_show())
          $changed =  feedback_op(query("UPDATE sets SET 
                                    set_link = '$set_link'".
                                     update_if_set($set_desc, "set_desc").
                                     "WHERE set_id = $set_id", false), " Set of $show_name updated" , "set of $show_name not updated");

    return $changed;
    
           

}

//deletes a track played
//retrurns start is success
function delete_track_played($start){
    $changed = false;
    if (can_edit_at_time($start) && feedback_op(query("DELETE from track_played WHERE start = start", $suppress_warnings), "track removed from $start", "track not removed from $start"))
        $changed = $start;
    return $changed;
    
}


//returns results with the same label name
//used in add_label
function get_label($label_name)
{
    
    $query = "SELECT * FROM label WHERE label_name =  '$label_name'";
    global $mysqli;
    $res = $mysqli->query($query);
    if (mysqli_num_rows($res) > 0){
        $exists = true;
    }
    else $exists = false;
    
    return $exists;
}



?>