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
        
    }
    elseif (get_post("add_show_user"))
    {
        /*harvest:
         user_email
        show_name
        call: add_show_user($show_name, $email)
        */
    }
    elseif (get_post("remove_show_user"))
    {
        /*harvest:
         user_email
        show_name
        call: 
        */
        
    }
    elseif (get_post("update_track"))
    {
        /*harvest:
        *track_id
       track_name
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
       artist_website
       //convert times!!!!
       then
       call: add_track($track_id, $track_name, $artist_id, $artist_name, $album_id, $album_name, $label_name, $label_website, $album_id, $album_name, $album_website, $artist_id, $artist_name, $artist_website, $artist_desc)
       */
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