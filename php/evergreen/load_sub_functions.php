<?php

//editing handling overhead goes here




//these functions check for various editing panel submissions, harvest
//post data, and call functions
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
        $old_password = get_post("password");
        $confirm_password = get_post("confirm_password");
        $user_id = get_post("user_id");
        $lname = get_post("lname");
        $fname = get_post("fname");
        $phone = get_post("phone");
        $new_password = get_post("new_password");
        update_user( $email, $fname, $lname, $phone, $new_password, $confirm_password, $old_password);
        
        
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
        $set_end = get_post($set_end);
        $set_start = get_post($set_start);
        $set_id = get_post($set_id);
        $show_name = get_post($show_name);
        
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
        $add_show = get_post("add_show");
        $show_website = get_post("show_website");
        $show_name = get_post("show_name");
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
        $user_email = get_post("user_email");
        add_show_user($show_name, $email);
    }
    elseif (get_post("remove_show_user"))
    {
        /*harvest:
         user_email
        show_name
        call: 
        */
        $show_name = get_post("show_name");
        $user_email = get_post("user_email");
        remove_show_user($show_name, $email);
        
    }
    elseif (get_post("update_track"))
    {
        $start_date = get_post("start_date");
        $start_hour = get_post("start_hour");
        $start_min = get_post("start_min");
        $start_sec = get_post("start_sec");
        
        $start = new DateTime($start_date);
        $start = date_time_set($start, $start_hour, $start_min, $start_sec);
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
      add_track($track_id, $track_name, $artist_id, $artist_name, $album_id, $album_name, $label_name, $label_website, $album_id, $album_name, $album_website, $artist_id, $artist_name, $artist_website, $artist_desc);
      
    }
    
}

//checks edit post varibles (see documentation)and suggests an editing panel
//queries the database and sets any additional post variables
//for the entity being edited.
//many of these functions also double as adding methods,
//in this case the post variables are not set (the forms will load blank)
//this function places and editing panel address in $_POST["edit_panel"]

function load_edit_panel(){
    if (get_post("edit_dj"))
    {
        $dj_id = get_post("dj_id");
        if ($dj_id)
        {
            global $mysqli;
            $query = "";
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
        $show_id = get_post("show_id");
        if ($show_id){
             /*query and set:
         show_desc
        show_website
        show_name*/
        }
    }
    elseif (get_post("edit_show_user") && manager()){
        set_post("edit_panel", "php/panels/edit_show_user.php"); 
    }
    elseif (get_post("edit_track"))
    {
        $track_id = get_post("track_id");
        $set_id = get_post("set_id");
    
        if ($track_id && dj() && (aux() || false /*is_user_show*/))
        {
            /*query and load
             *track_name
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
        }
        set_post("edit_panel", "php/panels/track_edit.php"); 
    }
    
}

?>