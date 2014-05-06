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
    table_start();
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
            cell($artist_name, "artist_name name"),
            cell($artist_desc, "artist_desc desc"),
            cell($artist_website, "artist_website website")
        )));
    }
    table_stop();
    
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
        table_start();
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
            $email = email_link($email);
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
        table_stop();
    }
}

function load_all_djs(){
    global $mysqli;
    
    //feilds:
    //dj_name <link to dj.php?dj_id=$dj_id
    //dj_desc
    //dj_website
    //dj_shows <--shows the dj has played tracks on, link to show.php?show_name=$show_name
    $query = "SELECT dj_id, dj_name, dj_desc, dj_website, fname, lname, email FROM dj INNER JOIN user ON user.user_id = dj.user_id";
    $res = $mysqli->query($query);
    table_start();
     echo(hline(array(
                    hcell("DJ/Host", "dj_name name" ),
                    hcell("About", "dj_desc desc"),
                    hcell("Website", "dj_website"),
                    hcell("Name", "name aux"),
                    hcell("Email", "email aux")
                        )));
    
    while($r = $res->fetch_assoc()){
        $dj_name = $r["dj_name"];
        $dj_name = local_link($dj_name, "dj.php?dj_id=".$r["dj_id"]);
        $dj_desc = $r["dj_desc"];
        $dj_website = world_link("", $r["dj_website"]);
        $name = "";
        $email = "";
        if (aux() || true)
        {
            $name = $r["fname"]." ".$r["lname"];
            $email = email_link($r["email"]);
            
        }
        echo(line(array(
            cell($dj_name, " name dj_name"),
            cell($dj_desc, "desc dj_desc"),
            cell($dj_website, "dj_website website"),
            cell($name, " name full_name aux"),
            cell($email, " email aux "))));
 
    }
    table_stop();
    
}



function load_set(){
    global $mysqli;
    //BLOCK:
    //show_name<--link show.php?show_name=$show_name
    //set_desc
    //set_link
    $set_id = get_get("set_id");
    $query = "SELECT * FROM sets INNER JOIN shows ON sets.show_name = shows.show_name WHERE set_id = $set_id";
    $res = "";

    if ($set_id) $res = $mysqli->query($query);
    
    if ($res && $res->num_rows > 0){
        $r = $res->fetch_assoc();
        $set_id = $r["set_id"];
        $set_desc = $r["set_desc"];
        $set_link = world_link("", $r["set_link"]);
        $set_start = $r["set_start"];
        $set_end = $r["set_end"];
        $show_name = $r["show_name"];
        $show_name = local_link($show_name, "show.php?show_name=".urlencode($show_name));
        $edit = "";
        if (true || aux() || is_show_user($show_name))
        {
        //form w/ set_id hiddin and name = "edit_set"
            $edit = tiny_form("edit_set", "Edit", "set_id", $set_id );
            if (true || manager()){
                //form w/ set_id hiddin and name = "delete_set"
                $edit = $edit.tiny_form("delete_set", "Delete", "set_id", $set_id );
            }
        }    
        //print block
        echo(block($show_name, "START: ".$set_start."</br>END: ".$set_end, $set_desc, $set_link, $edit));
                $query ="SELECT track.track_id,
                    TIME(start) as start_time,
                    start, track_name,
                    artist_name,
                    artist.artist_id,
                    album.album_id,
                    album_name,
                    label.label_name,
                    album_website,
                    label_website, duration,
                    dj.dj_id,
                    dj_name
                    FROM track_played INNER JOIN
                    dj ON dj.dj_id = track_played.dj_id
                    INNER JOIN sets
                    ON track_played.set_id = sets.set_id
                    INNER JOIN track
                    on track_played.track_id = track.track_id
                    LEFT OUTER JOIN artist
                    on track.artist_id = artist.artist_id
                    LEFT OUTER JOIN album
                    on track.album_id = album.album_id
                    LEFT OUTER JOIN label
                    on album.label_name = label.label_name
                    WHERE sets.set_id = $set_id
                    ORDER BY start";
                   $query = str_replace("\r\n"," ", $query);

        $res = $mysqli->query($query);
        if ($res->num_rows > 0){
            table_start();
            echo(hline(array(
                             hcell("Start", "time start"),
                             hcell("Air Time", "audit time duration"),
                             hcell("Name", "track_name name"),
                             hcell("Artist", "artist_name name audit"),
                             
                             hcell("Album", "album_name name"),
                             hcell("Label", "label_name name"),
                             hcell("Played By", " dj_name name" ),
                             hcell("Edit", "edit dj_show form "),
                             hcell("Delete", "dj_show delete form")
                             
                            )));
            while($r = $res->fetch_assoc()){
                $start_time = $r["start_time"];
                $duration = $r["duration"];
                $track_name = local_link($r["track_name"], "search.php?search=".urlencode($r["track_name"])."&amp;type=all&amp;submit_search=Search");
                $artist_name = $r["artist_name"];
                $artist_name = local_link($artist_name, "artist.php?artist_id=".$r["artist_id"]);
                $album_name = world_link($r["album_name"], $r["album_website"]);
                $label_name = world_link($r["label_name"], $r["label_website"]);
                $dj_name = local_link($r["dj_name"], "dj.php?dj_id=".$r["dj_id"]);
                $edit = "";
                $delete ="";
                if (true || aux() || $is_show_user($show_name) )
                {
                    $edit = tiny_form("edit_track", "Edit", "start", $r["start"]);
                    $delete = tiny_form("delete_track", "Delete", "start", $r["start"]);
                }
            echo(line(array(
                cell($start_time, "start_time time"),
                cell($duration, "duration time"),
                cell($track_name, "track_name name"),
                cell($artist_name, "artist_name name"),
                cell($album_name, "album name name"),
                cell($label_name, "label_name name"),
                cell($dj_name, "dj_name name"),
                cell($edit, "edit dj_show"),
                cell($delete, "delete dj_show")
                
            )));
            
        }
        table_stop();
        }
        else
        echo("no tracks found");
    }
    else echo("set not found");
        
    
    
    //LINE:
    //set_tracks
        //start
        //track_name
        //artist <--link artist?artist_id=$artist_id
        //album <--link album_website
        //label <--link label_website
        //dj <--link dj_website
        //duration

        //form w/ start hiddin and name = "edit_track"
        //form w/ start hiddin and name = "delete_track"

}

function load_artist()
{
        global $mysqli;
    //BLOCK:
    //artist_name<-link artist website
    //artist_desc
    $artist_id = get_get("artist_id");
    if ($artist_id){
        $query = "SELECT * FROM artist WHERE artist_id = $artist_id";
        $res = $mysqli->query($query);
        if ($res->num_rows)
        {
            $r = $res->fetch_assoc();
            $artist_name = world_link($r["artist_name"], $r["artist_website"]);
            $edit = "";
            if (dj())
                $edit = tiny_form("edit_artist", "Edit", "artist_id", $artist_id);
                 //form w/ set_id hiddin and name = "edit_artist"
            
            $query ="SELECT track.track_id,
                    TIME(start) as start_time,
                    start, track_name,
                    album.album_id,
                    album_name,
                    label.label_name,
                    album_website,
                    label_website, duration,
                    dj.dj_id,
                    length,
                    dj_name,
                    sets.show_name,
                    sets.set_id
                    FROM track_played INNER JOIN
                    dj ON dj.dj_id = track_played.dj_id
                    INNER JOIN sets
                    ON track_played.set_id = sets.set_id
                    INNER JOIN track
                    on track_played.track_id = track.track_id
                    LEFT OUTER JOIN artist
                    on track.artist_id = artist.artist_id
                    LEFT OUTER JOIN album
                    on track.album_id = album.album_id
                    LEFT OUTER JOIN label
                    on album.label_name = label.label_name
                    WHERE artist.artist_id = $artist_id
                    GROUP BY track.track_id
                    ORDER BY start DESC";
                   $query = str_replace("\r\n"," ", $query);

                    $res = $mysqli->query($query);
                if ($res && $res->num_rows > 0){
            table_start();
            echo(hline(array(
                            
                             hcell("Name", "track_name name"),
                             hcell("Album", "album_name name"),
                             hcell("Label", "label_name name"),
                             
                             hcell("Length", "time duration"),
                             hcell("Last Play", "datetime start"),
                             hcell("On", "Show_name name"),
                             hcell("Set", "set_id website"),
                             hcell("Played By", " dj_name name" ),
                            
                             
                            )));
            while($r = $res->fetch_assoc()){
                
                

                $track_name = local_link($r["track_name"], "search.php?search=".urlencode($r["track_name"])."&amp;type=all&amp;submit_search=Search");

                $album_name = world_link($r["album_name"], $r["album_website"]);
                $label_name = world_link($r["label_name"], $r["label_website"]);
                $length = $r["length"];
                $start=$r["start"];
                $show_name = local_link($r["show_name"], "show.php?show_name=".urlencode($r["show_name"]));
                $set = local_link("Set", "set.php?set_id=".$r["set_id"]);
                $dj_name = local_link($r["dj_name"], "dj.php?dj_id=".$r["dj_id"]);
                
                
            echo(line(array(
                cell($track_name, "track_name name"),
                cell($album_name, "album name name"),
                cell($label_name, "label_name name"),
                cell($length, "length time"),
                cell($start, "datetime time"),
                cell($show_name, "show_name name"),
                cell($set, "set_link link"),  
                cell($dj_name, "dj_name name")

                
            )));
            
        }
        table_stop();
        }
        else
        print_error_message("no tracks found");
    }
    else print_error_message("artist not found");
    
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
        

    
    
}
}

function load_dj(){
    global $mysqli;
    //BLOCK:
    //dj name (h1)<--link dj website
    //dj_desc 
    global $mysqli;
    //BLOCK:
    //artist_name<-link artist website
    //artist_desc
    $dj_id = get_get("dj_id");
    if ($dj_id){
        $query = "SELECT * FROM dj INNER JOIN user ON user.user_id = dj.user_id  WHERE dj_id = $dj_id";
        $res = $mysqli->query($query);
        if ($res->num_rows > 0)
        {
            $r = $res->fetch_assoc();
            
            $dj_name = world_link($r["dj_name"], $r["dj_website"]);
            $dj_desc = $r["dj_desc"];
            $edit = "";
            if ($r["user_id"] == get_session("user_id")) $edit = tiny_form("edit_dj", "Edit", "dj_id", $dj_id);
            
            $shows = false;
            $query = "SELECT show_name FROM dj INNER JOIN user ON user.user_id = dj.user_id LEFT OUTER JOIN show_user ON user.user_id = show_user.user_id  WHERE dj_id = $dj_id ORDER BY show_name";
            $res = $mysqli->query($query);
            while($r = $res->fetch_assoc()){
                $show_name = $r["show_name"];
                if ($show_name) $shows = $shows."<h2>".local_link($show_name, "show.php?show_name=".urlencode($show_name))."</h2>";
            }
            if ($shows) {
                
                $shows = "Afilliated with Shows:</h2>$shows<h2>";
            }
           
           
            echo(block($dj_name, $shows, $dj_desc, "", $edit));
            
           
                 //form w/ set_id hiddin and name = "edit_artist"
            
            $query ="SELECT track.track_id, start, track_name, album.album_id, artist_name, artist_website, artist.artist_id, album_name, label.label_name, album_website, label_website, duration, dj.dj_id, length, dj_name, sets.show_name, sets.set_id FROM track_played INNER JOIN dj ON dj.dj_id = track_played.dj_id INNER JOIN sets ON track_played.set_id = sets.set_id INNER JOIN track on track_played.track_id = track.track_id LEFT OUTER JOIN artist on track.artist_id = artist.artist_id LEFT OUTER JOIN album on track.album_id = album.album_id LEFT OUTER JOIN label on album.label_name = label.label_name WHERE dj.dj_id = $dj_id ORDER BY start DESC";
                   $query = str_replace("\r\n"," ", $query);
                 
                    $res = $mysqli->query($query);
                if ($res && $res->num_rows > 0){
                    table_start();
                    echo(hline(array(
                                    
                                     
                                     hcell("Date", "datetime start"),
                                     hcell("On Show", "Show_name name"),
                                     hcell("Set", "set_id website"),
                                     hcell("Track", "track_name name"),
                                     hcell("Artist", "artist_name name audit"),
                                     hcell("Album", "album_name name"),
                                     hcell("Label", "label_name name"),
                                    
                                     hcell("Edit", "edit dj_show form "),
                                     hcell("Delete", "dj_show delete form")
                                     
                                    )));
            while($r = $res->fetch_assoc()){
                    
               
                $track_name = local_link($r["track_name"], "search.php?search=".urlencode($r["track_name"])."&amp;type=all&amp;submit_search=Search");
                $artist_name = $r["artist_name"];
                $artist_name = local_link($artist_name, "artist.php?artist_id=".$r["artist_id"]);
                $album_name = world_link($r["album_name"], $r["album_website"]);
                $label_name = world_link($r["label_name"], $r["label_website"]);

               
                $start=$r["start"];
                $show_name = local_link($r["show_name"], "show.php?show_name=".urlencode($r["show_name"]));
                $set = local_link("Set", "set.php?set_id=".$r["set_id"]);
                $edit = "";
                $delete = "";
                 if (true || aux() || $is_show_user($show_name) )
                {
                    $edit = tiny_form("edit_track", "Edit", "start", $r["start"]);
                    $delete = tiny_form("delete_track", "Delete", "start", $r["start"]);
                }
                
            echo(line(array(
                 cell($start, "datetime time"),
                cell($show_name, "show_name name"),
                cell($set, "set_link link"),
                
                cell($track_name, "track_name name"),
                cell($artist_name, "artist_name name"),
                cell($album_name, "album name name"),
                cell($label_name, "label_name name"),
                
                cell($edit, "edit dj_show"),
                cell($delete, "delete dj_show")

                
            )));
            
        }
        table_stop();
        }
        else
        print_error_message("no tracks played");
    }
    else print_error_message("dj not found");
    

    }
}

function load_schedule()
{
    global $mysqli;
    $before =  get_get("before");
    $after = get_get("after");
    $sql ="";
    if ($before) $sql = "WHERE date < \"$before\"";
    elseif ($after) $sql = "WHERE date > \"$after\"";
    
    //may need to covert to sql date
    //query sets with before and after, if set, limit 100 sets
    //if nothing set, assume looking for upcoming shows (shows that have not ENDED yet)
    $query = "SELECT set_start, TIME( set_end ) AS end_time, sets.set_id, set_desc, set_link, sets.show_name
FROM sets $sql
LIMIT 0 , 30";
 
    $res = $mysqli->query($query);
    //find  newest and oldest from latest query
    //button link for "older"
    //button link for "newer"
    $newest = "";
    $oldest = "";
    $records ="";
    $sets = "";
    while($r = $res->fetch_assoc()){
        $set_start = $r["set_start"];
        $set_end = $r["end_time"];
        $set_desc = local_link($r["set_desc"], "set.php?set_id=".$r["set_id"]);
        $set_link = world_link("", $r["set_link"]);
        $set_id = $r["set_id"];
        $show_name = local_link($r["show_name"], "show.php?show_name=".$r["show_name"]);
        $edit ="";
        $delete = "";
        $audit="";
        $alert = "";
    
    //LINE
        //set_start
        //set_end
        //show_name <--link show.php?show_name=$show_name
        //set_desc
        //link <--not set_link rather set.php?set_id=$set_id
        if (true || manager())
        {
            //$query = $query = "SELECT fname , lname, phone, email FROM sets INNER JOIN shows ON sets.show_name = shows.show_name LEFT OUTER JOIN show_user ON show_user.show_name = shows.show_name LEFT OUTER JOIN user ON user.user_id = show_user.user_id  WHERE set_id = $set_id";
            
             //$audit_report = "";
             //$users_emal = array();

             $edit = tiny_form("edit_set", "Edit", "set_id", $set_id);
             $delete = tiny_form("delete_set", "Delete", "set_id", $set_id);
        }
        if (true || aux())
        {
            $alert = tiny_form("email_audit", "Email", "set_id", $set_id);
            $audit = tiny_form("audit_set", "Audit", "set_id", $set_id);
        }
        
        if (!$newest) $newest = $set_start;
        $oldest = $set_end;
        
        $sets = $sets.line(array(
                            cell($set_start, "set_start datetime"),
                            cell($set_end, "set_end time"),
                            cell($show_name, "show_name name"),
                            cell($set_desc, "set_desc desc"),
                            cell($set_link, "link set_link"),
                            cell($edit, "edit manager set_edit form"),
                            cell($delete, "delete manager set_edit form "),
                            cell($alert, "form alert aux"),
                            cell($audit, "form audit_record aux")
        ));
    }
    $older = "<a href\"schedule.php?before=$oldest\" class = \"button\">Previous</a>";
    $newer = "<a href\"schedule.php?after=$newest\" class = \"button\">Next</a>";
    
    echo($older);
    echo($newer);
    table_start();
    echo(hline(array(
        hcell("Start", "datetime set_start"),
        hcell("End", "time set_end time"),
        hcell("Show", "show_name name"),
        hcell("Description", "set_desc desc" ),
        hcell("Link", "link set_link"),
        hcell("Edit", "edit manager set_edit form"),
        hcell("Delete", "delete manager edit form"),
        hcell("Warn", "aux form email_record"),
        hcell("Record", "aux form email_record"))));
    echo($sets);
    table_stop();
    echo($older);
    echo($newer);
    if (true || aux()){
        echo('<form method = "post" class = "aux">Audit Spredsheet: <input type="date" name= "before" required /> to <input type="date" name="after" required /><input type = "submit" value = "Audit" /></form>');
    }
    //load schedule for next 7 days

    //button link for "older"
    //button link for "newer"
    //link: schedule.php&before=$oldest, $newest (these may need to be in unicode date format)
}

function load_show()
{
           global $mysqli;
           $show_name = get_get("show_name");
           $query = "SELECT * FROM shows WHERE show_name = \"$show_name\"";
           
          
    //BLOCK:
    //show_name (h1)<--link to show website
    //show_desc
    $res = $mysqli->query($query);
    if ($res->num_rows > 0)
    {
        $r = $res->fetch_assoc();
        
        $show_name = $r["show_name"];
        $show_name2 = $show_name;
        $show_desc = $r["show_desc"];
        $show_name = world_link($show_name, $r["show_website"]);
        $query = "SELECT dj_name, dj.dj_id FROM dj INNER JOIN user ON user.user_id = dj.user_id INNER JOIN track_played ON dj.dj_id = track_played.dj_id INNER JOIN sets ON track_played.set_id = sets.set_id WHERE sets.show_name = '$show_name2' ORDER BY start DESC";
        $query = str_replace("\n"," ", $query);
        $res = $mysqli->query($query);
        $djs = "";
        if ($res->num_rows > 0){
            $djs = "Affiliated DJ/Hosts, Past and Present:</h2>";
            while($r = $res->fetch_assoc())
            {
                $djs =$djs."<h2>".local_link($r["dj_name"], "dj.php?dj_id=".$r["dj_id"])."</h2>";
            }
            $djs= $djs."<h2>";
        }
        
    
        if (true|| manager() || is_show_user($show_name2) /*is_user_show*/)
        {
            $edit = tiny_form("edit_show", "Edit", "show_name", $show_name2);
        }
        echo(block($show_name, $djs, $show_desc,"", $edit));
        $query = "SELECT set_start, TIME(set_end) as end_time, set_desc, set_link, set_id FROM sets INNER JOIN shows ON sets.show_name = shows.show_name WHERE sets.show_name = \"$show_name2\" ORDER BY set_start DESC ";

        $res = $mysqli->query($query);
         if ($res->num_rows > 0){
            table_start();
            echo(hline(array(
                hcell("Start", "datetime set_start"),
                hcell("End", "time end_time"),
                hcell("Description", "desc set_desc"),
                hcell("audio link", "link set_link")
            )));
                 
            
            while($r = $res->fetch_assoc())
            {
                $set_start = $r["set_start"];
                $set_end = $r["end_time"];
                $set_desc = local_link($r["set_desc"], "set.php?set_id=".$r["set_id"]);
                $set_link = world_link("", $r["set_link"]);
                echo(line(array(
                    cell($set_start, "datetime set_start"),
                    cell($set_end, "time set_end"),
                    cell($set_desc, "desc set_desc"),
                    cell($set_link, "link set_link")
                )));
            }
            table_stop();
            
        }
        
    }else print_error_message("Show not found");
}



?>