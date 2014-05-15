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
        
        $fc = substr($fc, $max);
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
    if (strpos($string, "www.") >= 0)
    {
        return substr($string, strpos($string, "www.") + 4 );
    }
    else if (strpos($string, "://") >= 0)
    {
        return substr($string, strpos($string, "https://") + 3 );
    }
    else if (strpos($string, "https:") >= 0)
    {
        return substr($string, strpos($string, "https:") + 6 );
    }
        else if (strpos($string, "http:") >= 0)
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
    elseif ( $label_name && !get_label($label_name) && op_feedback(any_dj_query("INSERT INTO label (label_name, label_website) VALUES ('$label_name', '$label_website')", false),
                                     "label $label_name updated",
                                     "label $label_name was not updated"))
            $changed = $label_name;
    return $changed;
            
}
//returns string : ", $feild='$string' " if $string is not null
//else null. Used to not overwrite nin null feilds
function update_if_set($string, $feild){ if ($string) return " , $feild = '$string' "; else return $string;}

//adds or updates artist, dependent on artist_id (if id == 0 then adds )
//does not overwrite content feilds with null feilds
//informs user of issues
//validates feilds
//returns artist_id if successful, null if not
function add_artist($artist_id, $artist_name, $artist_desc, $artist_website){
    $artist_name = valid_f($artist_name, null, null, false);
    $artist_desc = valid_f($artist_desc, null, null, true);
    $artist_website = valid_f(website_f($artist_website), null, null, true);
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
                                 VALUES ('$artist_name', '$artist_desc', '$artist_website')", false),
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
    $album_name = valid_f($album_name, null, null, false);
    $album_website = valid_f(website_f($album_website), null, null, false);
    $label_name = add_label($label_name, $label_website);
    $changed = false;
    if ($album_name && $album_id > 0
        && feedback_op(any_dj_query("UPDATE album SET album_name = '$album_name'".
                                    update_if_set($album_website).
                                    update_if_set($label_name, "label_name")."
                                    WHERE album_id = $album_id", false), "album $album_name updated", "album $album_name not updated"))
        $changed = $album_id;
    elseif ($album_name &&
            feedback_op(any_dj_query("INSERT INTO album (album_name, album_website, label_name) VALUES ('$album_name', '$album_website', '$label_name')", false),
                        "album $album_name updated", "album $album_name not updated"))
    $changed = last_id();
    return $changed;
    
}
//updates user
//DOES overwrite content feilds with null feilds
//informs user of issues
//validates feilds
//returns user_id if successful, null if not
//will only query session for user_id unless manager
function update_user( $email, $fname, $lname, $phone, $new_password, $confirm_password, $old_password){
    $user_id = get_session($user_id);
    if (manager() && get_post("user_id")) $user_id = get_post("user_id");
    $email = valid_email($email);
    $fname = valid_f($fname, 1, 50, "first name", false);
    $lname = valid_f($lname, 1, 50, "last name", true);
    $phone = valid_f($phone, 1, 15, "phone", true);
    $password = valid_f($password, 8, 100, "password", false);
    $changed = false;
    if ($password) $password = hash_password($password);
    $old_password =  (feedback_op(check_password($old_password), null, "Old password not recognized"));
    $passwords_match = feedback_op($confirm_password == $password, null, "passwords do not match");
    if ($email && $fname && $user_id  && ($passwords_match || !$new_password) && $confirm_password &&
            feedback_op(query("UPDATE user
                        SET email = '$email',
                        fname = '$fname',
                        lname = '$lname',
                        phone = '$phone' ".update_if_set($password, "password")." WHERE user_id = $user_id", false),
            "personal information updated", "personal information not updated")){
    $changed = $user_id;
    //generate email
    }
    return $changed;
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
    if ($changed)
    {
        //email user new password here
        //insert dj here                                   
    }
    return $changed;
    
}
//adds or updates dj_name, dependent on dj_id (if id == 0 then adds )
//does not overwrite content feilds with null feilds
//informs user of issues
//validates feilds
//returns dj_id if successful, null if not
//user_id comes from session, or user has manager status
function add_dj($dj_id, $dj_name, $user_id, $dj_desc, $dj_website){
    $dj_name = valid_f($djname, null, null, "dj name", false);
    $dj_desc = valid_f($dj_desc, null, null, "dj description", true);
    $dj_website = valid_f(website_f($dj_website), null, null, true);
    $cred = $user_id > 0 && get_session("user_id") || manager();
    $changed = false;
    if ($dj_id > 0 && $dj_name  && $cred &&
        feedback_op(query(" UPDATE dj SET dj_name = '$dj_name' && dj_website = '$dj_website' && dj_desc = '$dj_desc' WHERE dj_id = dj_id", false),
                    "$dj_name updated", "$dj_name not updated"))
        $changed = $dj_id;
    elseif ($dj_name && $cred &&
            feedback_op(query("INSERT INTO dj (dj_name, dj_desc, dj_website) VALUES
                              ('$dj_name', '$dj_desc', '$dj_website')"), "$dj_name updated", "$dj_name not updated", false))
        $changed = last_id();
    return $changed;
}
//adds or updates show, dependent on artist_id (if id == 0 and manager then adds )
//does not overwrite content feilds with null feilds
//informs user of issues
//validates feilds
//returns show_name if successful, null if not
function add_show($show_name, $show_desc, $show_website){
    $show_name = valid_f($show_name, null, null, "show name", false);
    $show_desc = valid_f($show_desc, null, null, "show description", true);
    $show_website = valid_f(website_f($show_website), null, null, "show website", true);
    $exists = $get_show($show_name);
    $cred = warn(is_user_show($show_name) || manager(), "Please log in as an affiliated user or a manager to change $show_name details");
    $changed = false;
    if ($exists && $show_name && $cred &&
        feedback_op(query("UPDATE shows SET show_desc =
                          '$show_desc', show_website = '$show_website'
                          WHERE show_name = '$show_name'", false), "$show_name updated", "$show_name not updated"))
        $changed = $show_name;
    elseif ($show_name && manager() &&
            feedback_op(query("INSERT INTO shows (show_name, show_desc, show_website)
                              VALUES ('$show_name','$show_desc', '$show_website')", false), "$show_name added", "$show_name was not added"))
        $changed = $show_name;
    
    return $changed;
}
//adds show_user affiliation
//does not overwrite content feilds with null feilds
//informs user of issues and success
//validates feilds
//returns artist_id if successful, null if not
function add_show_user($show_name, $email){
    /**$changed = $false;
    $exists = query("SELECT * FROM show_user WHERE user_id = $user_id AND show_name = '$show_name'");
    $user = get_user_by_email($email);
    $user_id = 0;
    if ($user) $user_id = $user['user_id'];
    if (warn(!$exists, "user is already affiliated with show") &&
        $user_id && $show_name &&
        feeback_op(manager_query("INSERT INTO show_user (user_id, show_id)
                                 VALUES ('$user_id', '$show_id')", false),
                   "$user affiliated with $show_name",
                   "$user not affiliated with show"))                  
        $changed = [$user_id, $show_name];
   return $changed;**/
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
function add_track($track_id, $track_name, $artist_id, $artist_name, $album_id, $album_name, $label_name, $label_website, $album_id, $album_name, $album_website, $artist_id, $artist_name, $artist_website, $artist_desc)
{
   
    
    if ($album_name) $album_id =  add_album($album_id, $album_name, $album_website, $label_name, $label_website);
    warn($label_name && !$album_name, "labels are only recorded for albums, but an album can be a single track, if it was released as such");
    if ($artist_name) $artist_id = add_artist($artist_id, $artist_name, $artist_desc, $artist_website);
    $possible_track_id = track_id($track_name, $album_name, $artits_name);
    if ($track_id == 0) $track_id = $possible_track_id;
    $changed = false;
    if ($track_id > 0 && warn($track_name, "please enter a track name") && feedback_op(any_dj_query("UPDATE track SET track_name = '$track_name'".update_if_set($artist_id, "artist_id").update_if_set($album_id, "album_id").update_if_set($length, "length")." WHERE track_id = $track_id", false), " track updated in database ", "track not updated "))
    $changed = $track_id;
    elseif ($track_id  == 0 &&
            warn($track_name, "please enter a track name")
            && feedback_op(any_dj_query("INSERT INTO track (track_name, artist_id, album_id, length)
                                        VALUES ('$track_name', '$artist_id', '$album_id'", false),
                           " track added to database ",
                           "track added "))
    $changed = last_id();
    
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
function add_track_played($edit_start, $add, $start, $duration, $set_id, $track_id, $track_name, $artist_id, $artist_name, $album_id, $album_name, $label_name, $label_website, $album_id, $album_name, $album_website, $artist_id, $artist_name, $artist_website, $artist_desc){
    $set_id = can_edit_at_time($start);
    $dj_id = get_session('current_dj_id');
    $changed = false;
    if ($track_name) $track_id =  add_track($track_id, $track_name, $artist_id, $artist_name, $album_id, $album_name, $label_name, $label_website, $album_id, $album_name, $album_website, $artist_id, $artist_name, $artist_website, $artist_desc);
    if ($edit_start) delete_track_played($edit_start);
    if ($set_id && $dj_id && $track_id && feedback_op(query("INSERT into track_played (start, dj_id, duration, track_id, set_id)
                                                            VALUES ('$start', '$dj_id', '$duration', '$track_id', '$set_id') ")))
        $changed = $start;
    return $changed;
    
}
//adds a set
//manager level
//returns set_id if success
function add_set( $set_id, $set_start, $set_end, $show_name, $set_desc, $set_link){
    $changed = false;
    $show_name = valid_f($show_name, null, null, "show name", false);
    $set_desc = valid_f($set_desc, null, null, "set description", true);
    $set_link = valid_f(website_f($set_link), null, null, true);
    if (manager() && $start && $end && $show_name && does_not_cross($start, $end, $set_id) && $set_id &&
        feedback_op(query("UPDATE set (set_start, show_name, set_end, set_desc, set_link)
                          VALUES ('$set_start', '$show_name', '$set_end', '$set_desc', '$set_link') WHERE set_id = $set_id"), " Set of $show_name updated" , "set of $show_name not updated"))
    $changed = $set_id;
    elseif (manager() && $start && $end && $show_name && $set_id == 0 && does_not_cross($start, $end, $set_id) &&
            feedback_op(query("INSERT into set (set_id, set_start, set_end, show_name, set_desc, set_link)
                              VALUES ('$set_id', '$set_start', '$set_end', '$show_name', '$set_desc', '$set_link')"), "$show_name added at $set_start", "$show_name not added"))
    $changed = last_id();
    elseif($set_id != 0 && is_right_dj(is_show_user($show_name)) &&
           feedback_op(query("UPDATE set SET set_desc = '$set_desc' ,
                 set_link = '$set_link'
                 WHERE set_id = '$set_id'
                 AND show_name = '$show_name' ", false),
           "$show_name at $set_start updated",
           "$show_name at $set_start not updated"));
    $changed = $set_id;
    return $changed;
    
           

}
//deletes a set
//returns true if sucess
function delete_set($set_id)
{
    return manager_query("Delete * FROM set WHERE set_id = $set_id");
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
    
    $query = "SELECT * FROM label WHERE label_name =  $label_name";
    $res = query($query);
    return $res;
}



?>