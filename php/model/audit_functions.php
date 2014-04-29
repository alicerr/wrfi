
<?php

//these functions will support the auditing process
function get_user_by_email($email){
    //return user_id
}


function track_id($track_name, $album_name, $artist_name){
    //(string, string, string)->track_id 
//finds any matches on these criteria. If album name or artist name is null in either the database or the incoming feilds the null catagory is considered a match. 
}
function color_track($start){}
// time string -> sting
//takes in a track start time and returns <div class = "error_type">error type</div> (can be no error)

function warn_track($track){}
//takes in a track record and returns a string describing the problem with the track, as well as the track start, set start, track name, and show name.
//null if no error



function warn_set($set_id){
//takes in a set_id, queries the user table to get an email address, fname, lname, show name. Composes a missive with a description of the problem as well as any tracks in the set that have a problem.
//uses function email($subject, $contents, $address, $user_name) to send the email. Expect that multiple users will be associated with the show and multiple emails should be sent.
//feel free to query get_session($dj_name) to sign the letter.
}

function color_set($start){}
//time string -> sting
//takes in a track start time and returns <div class = "error_type cell">error type</div> (can be no error)<div class = "email_report cell"><form method = "post"><input type="text" class = "hide" value = "$set_id" name = "set_id"><input type = "submit" value = "email" name = "email"> </form> </div>
