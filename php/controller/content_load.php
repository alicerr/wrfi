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


//print all shows
function load_all_shows()
{
    global $mysqli;
    print_message("show name");
    //feilds:
    $query = "SELECT * FROM shows ORDER BY show_name";
    $results = $mysqli->query($query);
    
    //print header
    
    echo(          hline(array(hcell("Show Name","show_name"),
                    hcell("Description", "show_desc"),
                    hcell("Website", "show_website"))));
    while ($r = $results->fetch_assoc()){
        
        $show_name = $r["show_name"];
        $show_name = local_link($show_name, "show.php?show_name=".urlencode($show_name));
        $show_website = $r["show_website"];
        $show_website = nullweb($show_website);
        $show_desc = $r["show_desc"];
    //show_desc
    //show_website
    //order by show_name
        echo(   line(
                array(
                      cell($show_name, "name show_name")
                    , cell($show_desc, "desc show_desc")
                    , cell($show_website, "website show_website")
                    )
                )
             );
    }
}

function load_all_artists()
{
    global $mysqli;

    //feilds:
    //artist_name <--link artist.php?artist_id=$artist_id
    //artist_desc
    //artist website
    $query = "SELECT * FROM artist";
    print_message("hello");
    $results = $mysqli->query($query);
    echo(          hline(array(hcell("Name","name artist_name"),
                    hcell("Description", "desc artist_desc"),
                    hcell("Website", "website artist_website"))));
    while($r = $results->fetch_assoc())
    {
        $artist_name = local_link($r["artist_name"], "artist.php?artist_id=".$r["artist_id"]);
        $artist_desc = $r["artist_desc"];
        $artist_website = nullweb($r["artist_website"]);
        echo(line(array(
            hcell($artist_name, "artist_name name"),
            hcell($artist_desc, "artist_desc desc"),
            hcell($artist_website, "artist_website website")
        )));
    }
    
}

function load_all_users(){
    if (true || aux()){
        global $mysqli;
        
        //f:
        
        $query = "SELECT user.user_id, level_id, fname, lname, phone, email, show_name
                FROM user
                LEFT OUTER JOIN show_user ON user.user_id = show_user.user_id ORDER BY fname, lname, show_name";
        //fname
        //lname
        //email<-link mailto
        //phone
        //associated shows <-link show.php?show_id=$show_id
        echo(hline(array(
                    hcell("Name", "fname"),
                    hcell("", "lname"),
                    hcell("Phone", "phone"),
                    hcell("Email", "email"),
                    hcell("Show", "show_name"),
                    hcell("Edit", "edit form manager"),
                    hcell("Access", "access form manager")
                        )));
        $res = $mysqli->query($query);
        while($r = $res->fetch_assoc()){
            $fname = $r['fname'];
            $lname = $r['lname'];
            $phone = $r['phone'];
            $email = $r['email'];
            $email = email_link($email, $fname." ".$lname);
            $show_name = $r['show_name'];
            $show_name = local_link($show_name, "show.php?show_name=".urlencode($show_name));
            $edit = "";
            $access = "";
            if (true || manager())
            {
            
                //make_tiny_form($submit_name, $submit_value, $hide_name, $hide_value)
                //
                //form w/
                //input type submit name="edit_user" value = "Edit"
                //input type numbr name=user_id value = $user_id class = hide
                    $edit = tiny_form("edit_user", "Edit", "user_id", $r["user_id"]);
                $user_level = $r["level_id"];
                if ($user_level == 1)//<--level for user being looked at
                 {
                 //form w/
                //input type submit name="disable_user" value = "Disable"
                //input type numbr name=user_id value = $user_id class = hide
                //use disable_user($user_id)
                    $access = tiny_form("disable_user", "Disable", "user_id", $r["user_id"]);
                 }
                
                elseif ($user_level == 0)
                
                {
                    //<--level for user being looked at
                 //form w/
                //input type submit name="enable_user" value = "Disable"
                //input type numbr name=user_id value = $user_id class = hide
                //use enable_user($user_id)
                    $access = tiny_form("enable_user", "Enable", "user_id", $r["user_id"]);
                }
            }   
            
            echo(line(array(
                cell($fname, "fname"),
                cell($lname, "lname"),
                cell($phone, "phone"),
                cell($email, "email"),
                cell($show_name, "show name"),
                cell($edit, "edit form manager"),
                cell($access, "access form manager")
            )));
            
        
        
        
        
        
    
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