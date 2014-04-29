<?php
//this is very much a work in progress, I am not sure how to rep. the search
//a lot of this will be deleted

//show feilds from each table I might want
$show_f = array("shows.show_name", "shows.show_desc", "shows.show_website");
$set_f = array("set.set_desc", "set.set_link" );
$album_f = array("album.album_website", "album.album_name", "album.label_name");
$artist_f = array("artist.artist_desc", "artist.artist_name", "artist.artist_website");
$dj_f = array("dj.dj_name", "dj.dj_desc", "dj.dj_website");
$label_f = array("label.label_website"); //label_name is in album
$track_f = array("track.track_name");

//possible join structure for a complex search, with possible field array below
$shows_to_album =     "shows
    LEFT OUTER JOIN set
    ON set.show_name = show.show_name
    LEFT OUTER JOIN track_played
    ON set.set_id = track_played.set_id
    LEFT OUTER JOIN track
    ON track_played.track_id = track.track_id
    LEFT OUTER JOIN artist
    ON track.artist_id = artist.artist_id
    LEFT OUTER JOIN album
    ON track.album_id = album.album_id
    LEFT OUTER JOIN label
    ON album.label_name = label.label_name";
$shows_to_album_f = array_merge($show_f, $set_f, $track_f, $artist_f, $album_f, $label_f);

//possible join structure for a complex search, with possible field array below
 $dj_to_show =   "dj
    LEFT OUTER JOIN track_played
    ON dj.dj_id = track_played.dj_id
    LEFT OUTER JOIN track
    ON track_played.track_id = track.track_id
    LEFT OUTER JOIN artist
    ON track.artist_id = artist.artist_id
    LEFT OUTER JOIN album
    ON track.album_id = album.album_id
    LEFT OUTER JOIN label
    ON album.label_name = label.label_name
    LEFT OUTER set ON
    track_played.set_id = set.set_id
    LEFT OUTER JOIN shows
    ON shows.show_name = set.show_name";
$dj_to_show_f = array_merge($dj_f, $track_f, $album_f, $label_f, $set_f, $show_f);

//possible join structure for a complex search, with possible field array below
$track_played_to_label_and_dj = 
    "track_played
    LEFT OUTER JOIN track
    ON track_played.track_id = track.track_id
    LEFT OUTER JOIN artist
    ON track.artist_id = artist.artist_id
    LEFT OUTER JOIN album
    ON track.album_id = album.album_id
    LEFT OUTER JOIN label
    ON album.label_name = label.label_name
    LEFT OUTER set ON
    track_played.set_id = set.set_id
    LEFT OUTER JOIN shows
    ON shows.show_name = set.show_name
    LEFT OUTER JOIN dj
    ON dj.dj_id = track_played.dj_id";
$track_played_to_dj_f = array_merge($track_f, $artist_f, $album_f, $label_f, $set_f, $show_f);


//allfeilds for tables
$show_t = array("shows.show_name", "shows.show_desc", "shows.show_website");
$set_t = array("set.set_desc", "set.set_link",  "set_id", "set_start", "set.show_name", "set.set_end");
$album_t = array("album.album_website", "album.album_name", "album.label_name","album.album_id");
$artist_t = array("artist.artist_desc", "artist.artist_name", "artist.artist_website", "artist.artist_id");
$dj_t = array("dj.dj_name", "dj.dj_desc", "dj.dj_website", "dj.dj_id", "user.user_id");
$label_t = array("label.label_website", "label.label_name"); //label_name is in album
$track_t = array("track.track_name",  "track.track_id", "track.artist_id", "track.album_id", "track.length");
$track_played_t = array("track_played.start", "track_played.dj_id", "track_played.duration", "track_played.track_id", "track_played.set_id");
$user_t = array("user_id", "user.email", "user.fname", "user.lname", "user.phone", "user.created", "user.level_id", "user.password");

//search for dj only
function search_dj($criteria){
    $guts = guts_of_search(array("dj.dj_name", "dj.dj_desc", "dj.dj_website"), $criteria);
    $query = "SELECT DISTINCT dj_name, dj_id, user_id, dj_desc, dj_website
            FROM dj
            INNER JOIN track_played
            ON track_played.dj_id = dj.dj_id
            $guts
            ORDER BY COUNT(track_played.start_time)";
    return query($query, false);
    
}

//returns res. for SELECT $mod FROM table_structure (WHERE is inc. in $crit) (ORDER_BY is inc in sort_crit)
function search($mod, $feilds, $table_structure, $crit, $sort_crit){
    $query = "SELECT $mod $feilds FROM $table_structure $crit $sort_crit";
    return query($query, false);
    
}
//res for only show and set tables
function search_only_show($criteria){
    $crit = guts_of_search(array("shows.show_name", "shows.show_desc", "shows.show_website", "set.set_desc"), $criteria);
    $feilds = "*";
    $table_structure = " shows LEFT OUTER JOIN ON set WHERE set.show_name = shows.show_name ";
    $sort_crit = "ORDER BY COUNT(set.set_id)";
    return search(null, $feilds, $table_structure, $crit, $sort_crit);
}
//res only for dj, ordered by most recent track played
function search_only_dj($criteria){
    $crit = guts_of_search(array("dj.dj_name", "dj.dj_desc", "dj.dj_website"), $criteria);
    $feilds = "*";
    $table_structure = "  FROM dj
            LEFT_OUTER_JOIN track_played
            ON track_played.dj_id = dj.dj_id ";
    $sort_crit = "ORDER BY COUNT(track_played.start_time)";
    return search(null, $feilds, $table_structure, $crit, $sort_crit);
}
//search only artist
function search_only_artist($criteria){
    $crit = guts_of_search(array("artist.artist_name", "artist.artist_desc", "artist.artist_website"), $criteria);
    $feilds = "*";
    $table_structure = "  FROM artist ";
    $sort_crit = "ORDER BY artist.artist_name";
    return search(null, $feilds, $table_structure, $crit, $sort_crit);
}
//search only track, album, label
function search_only_track($criteria){
    $crit = guts_of_search(array("track.track_name",
                                 "artist.artist_name",
                                 "album.album_name",
                                 "label.label_name",
                                 "album.album_website",
                                 "label.label_website",
                                 "artist.artist_desc",
                                 "artist.artist_website"), $criteria);
    $feilds = "*";
    $table_structure = "  FROM track LEFT OUTER JOIN album ON track.album_id = album.album_id LEFT OUTER JOIN label ON album.label_name label.label_name ";
    $sort_crit = " ORDER BY track.track_name";
    return search(null, $feilds, $table_structure, $crit, $sort_crit);
}
//[shows, sets, djs, tracks, artists]

//first attempt at search all
function search_all($criteria){
    
     $crit = guts_of_search(array("track.track_name",
                                 "artist.artist_name",
                                 "album.album_name",
                                 "label.label_name",
                                 "album.album_website",
                                 "label.label_website",
                                 "artist.artist_desc",
                                 "artist.artist_website"), $criteria);
    $feilds = "*";
    $table_structure = "  FROM track LEFT OUTER JOIN album ON track.album_id = album.album_id LEFT OUTER JOIN label ON album.label_name label.label_name ";
    $sort_crit = " ORDER BY track.track_name";
}

    
    

    

//removes puct and returns crit for searching an array of places fr words in the string
//givin places to look = [feild1, feild2] and  string to find = "word1.word2 word3"
//returns "WHERE (feild1 LIKE '%word1%' OR feil2 LIKE word1 OR feild3 LIKE word1) AND
 //(feild1 LIKE '%word2%' OR feil2 LIKE '%word2%' OR feild3 LIKE '%word2%') AND
 //(feild1 LIKE '%word3%' OR feil2 LIKE '%word3%' OR feild3 LIKE '%word3%')
function guts_of_search($places_to_look, $string_to_find)
{
    $crit = preg_replace('/[^a-z0-9\']+/i', ' ', $crit);
    $crit = clean($string_to_find);
    $crit = trim($crit);
    $crit = explode(' ', $crit);
    $hold = array();
    foreach ($crit as $c){
        $hold_inner = array();
        foreach($places_to_look as $place)
        {
            array_push($hold_inner, ($place." LIKE '%$c%'"));
        }
        array_push($hold, "( ".implode(" OR ", $hold_inner)." ) ");
    }
    $guts = " WHERE ".$implode(" AND ", $hold)." ";
    
}
?>