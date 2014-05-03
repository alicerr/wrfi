<?php
//Content loading functios, largly using line content
//will call various queries and view functions to draw each part of a site,
//View functions:
//draw_line($cell_string_array),
//draw_cell($string, $class_array),
//make_link($string, $link)
//make_tiny_form($submit_name, $submit_value, $hide_name, $hide_value)
//make_block($title, $sub_heading, $text)
//draw_heading($heading_cell_string_array)
//draw_heading_cell

//the feilds of each function are described
//often lines will link to an entity page with an
//editing button for the right users, so if something
//looks like it should be editable consider the links
//available first.

//each of this functions is called by a single page, and corelates to that pages content

function load_all_shows()
{
    global $mysqli;
    
    //feilds:
    //show_name <- create link show.php?show_name=$show_name
    //remember to run link through url converter, many show names will have whitespace
    
    //show_desc
    //show_website
    //order by show_name
    

     
    
}

function load_all_artists()
{
    global $mysqli;
    
    //feilds:
    //artist_name <--link artist.php?artist_id=$artist_id
    //artist_desc
    //artist website
    
}

function load_all_users(){
    if (aux()){
        global $mysqli;
        
        //f:
        
        //fname
        //lname
        //email
        //phone
        //associated shows <-link show.php?show_id=$show_id
        if (manager())
        {
            //
            //form w/
            //input type submit name="edit_user" value = "Edit"
            //input type numbr name=user_id value = $user_id class = hide
            
            if ($user_level == 1)//<--level for user being looked at
             {
             //form w/
            //input type submit name="disable_user" value = "Disable"
            //input type numbr name=user_id value = $user_id class = hide
            //use disable_user($user_id)
             }
            
            if ($user_level == 0)
            
            {
                //<--level for user being looked at
             //form w/
            //input type submit name="enable_user" value = "Disable"
            //input type numbr name=user_id value = $user_id class = hide
            //use enable_user($user_id)
            }
        }
        
        
        
        
    }
}

function load_all_djs(){
    //feilds:
    //dj_name <link to dj.php?dj_id=$dj_id
    //dj_desc
    //dj_website
    //dj_shows <--shows the dj has played tracks on, link to show.php?show_name=$show_name
    if (aux())
    {
        //user fname, lname
        //user email
        
    }
}



function load_set(){
    global $mysqli;
    //BLOCK:
    //show_name<--link show.php?show_name=$show_name
    //set_desc
    //set_link
    if (aux() || is_show_user($show_name))
    {
        //form w/ set_id hiddin and name = "edit_set"
        if (manager()){
        //form w/ set_id hiddin and name = "delete_set"
        }
    }
    
    //LINE:
    //set_tracks
        //start
        //track_name
        //artist <--link artist?artist_id=$artist_id
        //album <--link album_website
        //label <--link label_website
        //dj <--link dj_website
        //duration
        if (aux() || is_show_user($show_name))
        {
        //form w/ start hiddin and name = "edit_track"
        //form w/ start hiddin and name = "delete_track"
        }
}

function load_artist()
{
        global $mysqli;
    //BLOCK:
    //artist_name<-link artist website
    //artist_desc
    if (dj())
    {
        //form w/ set_id hiddin and name = "edit_artist"
        
    }
    
    //LINE:
    //set_tracks
        //start
        //track_name
        //artist <--link artist?artist_id=$artist_id
        //album <--link album_website
        //label <--link label_website
        //show_name <--link to show.php?show_name=$show_name
        //set <--No description, or id, just "set" with link to set.php?set_id=$set_id
        //dj <--link dj.php?dj_id=$dj_id
        //duration
        $show_name = "";
        if (aux() || is_show_user($show_name))
        {
        //form w/ start hiddin and name = "edit_track"
        }

    
    
}

function load_dj(){
        global $mysqli;
    //BLOCK:
    //dj name (h1)<--link dj website
    //dj_desc 
    if (manager() || is_dj(get_get("dj_id")))
    {
        //form w/ dj_id hiddin and name = "edit_dj"
    }
    
    //LINE:
    //set_tracks
        //start
        //track_name
        //artist <--link artist?artist_id=$artist_id
        //album <--link album_website
        //label <--link label_website
        //dj 
        //duration
        //if (aux() || is_show_user($show_name))
        //{
        //form w/ start hiddin and name = "edit_track"
        //}
}


function load_schedule()
{
    $before =  get_get("before");
    $after = get_get("after");
    //may need to covert to sql date
    //query sets with before and after, if set, limit 100 sets
    //if nothing set, assume looking for upcoming shows (shows that have not ENDED yet)
    
    //find  newest and oldest from latest query
    //button link for "older"
    //button link for "newer"
    //LINE
        //set_start
        //set_end
        //show_name <--link show.php?show_name=$show_name
        //set_desc
        //link <--not set_link rather set.php?set_id=$set_id
        if (manager())
        {
             //form w/ set_id hiddin and name = "edit_set"
            //form w/ set_id hiddin and name = "delete_set"
        }
        
    //load schedule for next 7 days

    //button link for "older"
    //button link for "newer"
    //link: schedule.php&before=$oldest, $newest (these may need to be in unicode date format)
}

function load_show()
{
           global $mysqli;
    //BLOCK:
    //show_name (h1)<--link to show website
    //show_desc 
    if (manager() || false /*is_user_show*/)
    {
        //form w/ show_name hiddin and name = "edit_show"
    }
    
    //LINE:
    //sets
        //set_start
        //set_end
        //set_desc
        //link <--not set_link rather set.php?set_id=$set_id
        if (aux() || false /*is_user_show*/)
        {
        //form w/ start hiddin and name = "edit_show"
        }
}



?>