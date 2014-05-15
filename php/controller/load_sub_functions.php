<?php

/*these functions are used
 *to harvest contents from editing panels
 *and call database modification functions
 *
 *this file directly controlls model/insert_functions.php
 */




/*
Purpose: load content into editing panel
Input:none
Output:none
Accesses: 
Modifies: none
Visual effects: none directly (called functions trigger status messages)
Database effects: addition/modification of records, via subfunctions in model/insert_funtions.php
Other: set to load is determined by set_id in GET
*/
function check_for_edits()
{
 
    if(get_post("update_dj"))
    {
        /*harvest:
         *dj_id
        dj_name
        dj_desc
        dj_website
        
        call:
        add_dj($dj_id, $dj_name, $user_id, $dj_desc, $dj_website)
        reload_user_info();
        */
        $dj_id = get_post("dj_id");
        
        $dj_desc = get_post("dj_desc");
        $dj_website = get_post("dj_website");
        $user_id = get_session("user_id");
        $dj_name = get_post("dj_name");
        add_dj($dj_id, $dj_name, $user_id, $dj_desc, $dj_website);
        
    }
    elseif (get_post("update_artist"))
    {
        /*
        harvest:
        artist_desc
        artist_website
        artist_id
        call:
        add_artist($artist_id, $artist_name, $artist_desc, $artist_website)
        */
        $artist_desc = get_post("artest_desc");
        $artist_desc = get_post("artist_website");
        $artist_id = get_post("artist_name");
        $artist_desc = get_post("artist_desc");
        
        add_artist($artist_id, $artist_name, $artist_desc, $artist_website);
        
    }
    elseif (get_post("update_user"))
    {
        /*harvest:
         *phone
        email
        password
        new_password
        confirm_password
        user_id
        lname
        fname
        call:
        update_user( $email, $fname, $lname, $phone, $new_password, $confirm_password, $old_password)
        reload_user_info();
        */
        $email =get_post("email");
        $password = get_post("password");
        //echo($password);
        $confirm_password = get_post("confirm_password");
        $user_id = get_post("user_id");
        $lname = get_post("lname");
        $fname = get_post("fname");
        $phone = get_post("phone");
        $user_id = get_post("user_id");
        $new_password = get_post("new_password");
        //echo("PP".$new_password."PP");
        update_user($user_id, $email, $fname, $lname, $phone, $password, $new_password, $confirm_password);
        
        
    }
    elseif (get_post("update_set"))
    {
        /*harvest:
         *set_start
        set_end
        set_desc
        set_id
        show_name
        call:
        
        */
        $set_end = get_post("set_end");
        $set_start = get_post("set_start");
        $set_id = get_post("set_id");
        $show_name = get_post("show_name");
        $set_desc = get_post("set_desc");
        $set_link = get_post("set_link");
        add_set( $set_id, $set_start, $set_end, $show_name, $set_desc, $set_link);
        
    }
    elseif (get_post("update_show"))
    {
        /*harvest:
         add_show
        show_desc
        show_website
        show_name
        call: add_show($show_name, $show_desc, $show_website)
        */
        
        $show_website = get_post("show_website");
        $show_name = get_post("show_name");
        $show_desc = get_post("show_desc");
        
        add_show($show_name, $show_desc, $show_website);
        
    }
    elseif (get_post("add_show_user"))
    {
        /*harvest:
         user_email
        show_name
        call: add_show_user($show_name, $email)
        */
        $show_name = get_post("show_name");
        $user = get_post("user");
        //echo($user."USER");
        add_show_user($show_name, $user);
    }
    elseif (get_post("remove_show_user"))
    {
        /*harvest:
         user_email
        show_name
        call: 
        */
        $show_name = get_post("show_name");
        $user_id = get_post("user");
        remove_show_user($show_name, $user_id);
        
    }
    elseif (get_post("update_track"))
    {
        $start_date = get_post("start_date");
        $start_hour = get_post("start_hour");
        $ap = get_post("start_am_pm");
        //echo($ap);
        if ($ap == "pm" && $start_hour) $start_hour = $start_hour + 12;
        $start_min = get_post("start_min");
        $start_sec = get_post("start_sec");
        
        $start = ($start_date." ".$start_hour.":$start_min:$start_sec");
        echo($start);
           /*harvest:
        *track_id
        
       track_name
       start_hour
       start_min
       start_sec
       start_am_pm
       start_date*/
       $track_name = get_post("track_name");
       $duration_min = get_post("duration_min");
       $duration_sec = get_post("duration_sec");
       $duration = (60* $duration_min) + $duration_sec;
       
       $length_hour = get_post("length_hour");
       $length_min = get_post("length_min");
       $length_sec = get_post("length_sec");
       $length = 60*60*$length_hour + 60*$length_min + $length_sec;
      /* duration_min
       duration_sec
       
       length_hour
       length_min
       length_sec
       
       album_id
       album_name
       album_website
       
       artist_id
       artist_name
       artist_website
       //convert times!!!!
       then
       call: add_track($track_id, $track_name, $artist_id, $artist_name, $album_id, $album_name, $label_name, $label_website, $album_id, $album_name, $album_website, $artist_id, $artist_name, $artist_website, $artist_desc)
       */
      $album_id = get_post("album_id");
      $album_name = get_post("album_name");
      $album_website = get_post("album_website");
      
      $artist_name = get_post("artist_name");
      $artist_website = get_post("artist_website");
      $artist_id = get_post("artist_id");
      $artist_desc = get_post("artist_desc");
      $label_name = get_post("label_name");
      $label_website = get_post("label_website");
      $track_id = get_post("track_id");
      $set_id = get_post("set_id");
      
      
      add_track_played($start, $duration, $length, 
                       $set_id, $track_id, $track_name, $artist_id,
                       $artist_name, $album_id, $album_name, $label_name,
                       $label_website, $album_id, $album_name, $album_website,
                       $artist_id, $artist_name, $artist_website, $artist_desc);
    }
    elseif (get_post("disable_user") && is_manager()){
        disable_user(get_post("user_id"));
    }
    elseif (get_post("enable_user") && is_manager()){
        enable_user(get_post("user_id"));
    }
    elseif (get_post("delete_set") && is_manager()){
        delete_set(get_post("set_id"));
    }
    elseif (get_post("delete_track") && (is_manager() || is_user_show())){
        delete_track(get_post("start"));
    }
    
}

/*
Purpose: load content for editing panel
    BLOCK: set attributes
    LINE: tracks played on set
Input:none
Output:none
Accesses: database if the record is not new (id 0 is always new)
Modifies: none
Visual effects: loads content into edit window, loads editing window by setting post data to
the appropriate includes path in POST[edit_panel], which is accessed when the page is drawn
Database effects: none
Other: will not overwrite post data on feilds if the id is 0, so previous entries are saved.

*/
function load_edit_panel(){
    if (get_post("edit_dj"))
    {
        $dj_id = get_post("dj_id");
        if ($dj_id)
        {
            global $mysqli;
            $query = "SELECT * FROM dj WHERE dj_id = $dj_id";
            $res = $mysqli->query($query);
            if ($res)
            {
                
                $res = $res->fetch_assoc();
                set_post("dj_name", $res["dj_name"]);
                set_post("dj_desc", $res["dj_desc"]);
                set_post("dj_website", $res["dj_website"]);
                
            }
            set_post("edit_panel", "php/panels/dj_edit.php");
        }
        
    }
    elseif (get_post("add_dj"))
    {
        set_post("edit_panel", "php/panels/dj_edit.php");  //new dj name
    }
    elseif (get_post("edit_artist")){
        $artist_id = get_post($artist_id);
        if ($artist_id){
            $query = "SELECT * FROM artist WHERE artist_id = $artist_id";
            global $mysqli;
            $res = $mysqli->query($query);
            if ($res){
                $r=$res->fetch_assoc();
                set_post("artist_desc", $r["artist_desc"]);
                set_post("artist_name", $r["artist_name"]);
                set_post("artist_website", $r["artist_website"]);
            }
            
            /**query and set post data for artist
             artist_desc
            artist_website
            artist_id**/

        }
        set_post("edit_panel", "php/panels/artist_edit.php");
    
    }
    elseif (get_post("edit_user")){
        $user_id = get_session("user_id");
       
        if (get_post("user_id") && manager()) $user_id = get_post("user_id"); //managers can edit other users
        if ($user_id){
            $query = "SELECT * FROM user WHERE user_id = $user_id";
            global $mysqli;
            $res = $mysqli->query($query);
            if ($res){
                $r= $res->fetch_assoc(); 
                set_post("email", $r["email"]);
                set_post("fname", $r["fname"]);
                set_post("lname", $r["lname"]);
                set_post("phone", $r["phone"]);
                set_post("user_id", $user_id);
            }
           /**query and set post data for user
            user_id
            phone
            email
            user_id
            lname
            fname*/
            
        set_post("edit_panel", "php/panels/user_edit.php");
        }
    }
    elseif(get_post("add_user") && (true ||manager())){
        //new user
        set_post("edit_panel", "php/panels/user_edit.php"); 
    }
    elseif(get_post("edit_set"))
    {
        $set_id = get_post("set_id");
        if ($set_id){
            $query = "SELECT * FROM sets WHERE set_id = $set_id";
            global $mysqli;
            $res = $mysqli->query($query);
            if ($res){
                $r = $res->fetch_assoc();
                set_post("set_end", $r["set_end"]);
                set_post("set_start", $r["set_start"]);
                set_post("set_desc", $r["set_desc"]);
                set_post("set_link", $r["set_link"]);
            }
        /*query and set:
         *set_start
            set_end
            set_desc
            set_id
            show_name*/}
        if ($set_id || manager()) //only managers can make new sets
            set_post("edit_panel", "php/panels/set_edit.php");
    //REMOVE
    set_post("edit_panel", "php/panels/set_edit.php"); 
    }
    elseif(get_post("edit_show")){
        $show_name = get_post("show_name");
        if ($show_name){
             /*query and set:
         show_desc
        show_website
        show_name*/
             $query = "SELECT * FROM shows WHERE show_name = '$show_name'";
             
             global $mysqli;
             $res = $mysqli->query($query);
             if ($res){
                $r = $res->fetch_assoc();
                set_post("show_desc", $r["show_desc"]);
                set_post("show_name", $r["show_name"]);
                set_post("show_website", $r["show_website"]);
             }
        }
        set_post("edit_panel", "php/panels/show_edit.php"); 
    }
    elseif (get_post("edit_show_user") && manager()){
        set_post("edit_panel", "php/panels/edit_show_user.php"); 
    }
    elseif (get_post("edit_track"))
    {
        $start = get_post("start");
       
        //echo("edit track");
        if ($start && (aux() || is_user_show()))
        {
            /*query and load
             *track_name
             *
                start_hour
                start_min
                start_sec
                start_am_pm
                start_date
                
                duration_min
                duration_sec
                
                length_hour
                length_min
                length_sec
                
                album_id
                album_name
                album_website
                
                artist_id
                artist_name
                artist_website*/
            $query = "SELECT * FROM track_played LEFT OUTER JOIN track ON track_played.track_id = track.track_id
            LEFT OUTER JOIN artist ON track.artist_id = artist.artist_id
            LEFT OUTER JOIN album ON track.album_id = album.album_id
            LEFT OUTER JOIN label ON album.label_name = label.label_name WHERE start = '$start'";
            //echo($query);
            global $mysqli;
            $res = $mysqli->query($query);
            if ($res){
                $r = $res->fetch_assoc();
                $start = $r["start"];
                $phpdate = strtotime($start);
                $hold = explode(" ", $start);
                $big = explode("-", $hold[0]);
                $small = explode(":", $hold[1]);
                $start_hour = $small[0];
                if ($start_hour >  12){
                    $start_hour = $start_hour - 12;
                    set_post("start_am_pm", "pm");
                    
                }
                set_post("start_hour", $start_hour);
                set_post("start_min", $small[1]);
                set_post("start_sec", $small[2]);
                set_post("start_date", sql_to_form_date($r["start"]));
                
                $dur = $r["duration"];
                $dur = explode(":", $dur);
                if ($dur){
                set_post("duration_min", $dur[0]*60 + $dur[1]);//mins
                set_post("duration_sec", $dur[2]);
                }
                $length = $r["length"];
                
                $l = explode(":", $length);
                if ($length){
                set_post("length_hour", $l[0]);
                set_post("length_min", $l[1]);
                set_post("length_sec", $l[2]);
            }
                set_post("album_id", $r["album_id"]);
                set_post("album_website", $r["album_website"]);
                set_post("album_name", $r["album_name"]);
                set_post("label_name", $r["label_name"]);
                set_post("label_website", $r["label_website"]);
                set_post("track_name", $r["track_name"]);
                set_post("track_id", $r["track_id"]);
                set_post("artist_name", $r["artist_name"]);
                set_post("artist_website", $r["artist_website"]);
                set_post("artist_desc", $r["artist_desc"]);
                set_post("artist_id", $r["artist_id"]);
                set_post("track_id", $r["track_id"]);
                set_post("set_id", $r["set_id"]);
                set_post("dj_id", $r["dj_id"]);
                
                     
                
            }
            
            
            
        }
        set_post("edit_panel", "php/panels/track_edit.php"); 
    }
    elseif (get_post("reset_password")){
        
        $email = get_post("email");
        reset_password($email);
    }
    
}

?>