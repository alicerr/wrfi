<?php
function valid_f($feild, $min, $max, $feild_name, $null_allowed){
    $fc = clean($feild);
    if (!$fc && !$min && !$null_allowed)
        print_error_message("$feild_name must have at least one charecter");
    elseif ($min &&( (!$fc && !$null_allowed) || ($fc && strlen($fc) < $min)) )
         print_error_message("$feild_name must have at least $min charecter(s)");
    elseif ($fc && $max < strlen($fc))
        print_error_message("$feild_name must have at most $max charecters");
    elseif ($fc && !$max && 255 < strlen($fc))
        print_error_message("$feild_name must have at most 255 charecters");   
}
function website_f($string){
    if (strpos($string, "www.") >= 0)
    {
        return substr($string, strpos($string, "www.") + 4 );
    }
    return $string;
}
function add_label($label_name, $label_website)
{
    $label_name = valid_f($label_name, null, null, "label name", false );
    $label_website = valid_f(website_f($label_website), null, null, "label website", true );
    if ($exists &&
        get_label($label_name) &&
        $label_website && op_feedback(
                               any_dj_query("UPDATE label SET label_website = '$label_website' WHERE label_name = '$label_name'"),
                               "label $label_name updated",
                               "label $label_name was not updated")){$changed = $label_name;}
    elseif ( label_name && op_feedback(any_dj_query("INSERT INTO label (label_name, label_website) VALUES ('$label_name', '$label_website')"),
                                     "label $label_name updated",
                                     "label $label_name was not updated"))
            $changed = $label_name;
    return $cahnged;
            
}
function update_if_set($string, $feild){ if ($string) return " , $feild = '$string' "; else return $string;}
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
                                 update_if_set($artist_desc, "artist_desc")." WHERE artist_id = $artist_id"),
                    "artist $artist_name updated", "artist $artist_name not updated"))
        $changed = $artist_id;
    elseif ($artist_name && feedback_op(
                    any_dj_query("INSERT INTO artist (artist_name, artist_desc, artist_website)
                                 VALUES ('$artist_name', '$artist_desc', '$artist_website')"),
                    "artist $artist_name updated", "artist $artist_name not updated"))
        $changed = last_id();
    return $changed;
    }
    
function add_album($album_id, $album_name, $album_website, $label_name, $label_website){
    $album_name = valid_f($album_name, null, null, false);
    $album_website = valid_f(website_f($album_website), null, null, false);
    $label_name = add_label($label_name, $label_website);
    $changed = false;
    if ($album_name && $album_id > 0
        && feedback_op(any_dj_query("UPDATE album SET album_name = '$album_name'".
                                    update_if_set($album_website).
                                    update_if_set($label_name, "label_name")."
                                    WHERE album_id = $album_id"), "album $album_name updated", "album $album_name not updated"))
        $changed = $album_id;
    elseif ($album_name &&
            feedback_op(any_dj_query("INSERT INTO album (album_name, album_website, label_name) VALUES ('$album_name', '$album_website', '$label_name')"),
                        "album $album_name updated", "album $album_name not updated"))
    $changed = last_id();
    return $changed;
    
}
function get_label($label_name)
{
    
    $query = "SELECT * FROM label WHERE label_name =  $label_name";
    $res = query($query);
    return $res;
}



?>