<?php

function last_id(){
    global $mysqli;
    return $mysqli::mysqli_insert_id;
}
function query($query, $suppress_warnings){
    global $mysqli;
    $results = $mysqli->query($query);
    $ret = null;
    if ($results){
        $ret = mysqli_fetch_assoc($results);
        
    }
    elseif (!$suppress_warnings){
        print_error_message("Database error: ", $mysqli->error);
    }
    return $ret;   
}

function manager_query($query, $suppress_warnings){
    if ($suppress_warnings && manager())
       return query($query, $suppress_warnings);
    elseif (is_manager()) //will print warning if eval is false
       return query($query, $suppress_warnings);
    else
        return null  ; 
}
function aux_query($query, $suppress_warnings){
    if ($suppress_warnings && aux())
       return query($query, $suppress_warnings);
    elseif (is_aux()) //will print warning if eval is false
       return query($query, $suppress_warnings);
    else
        return null;
    
}
function any_dj_query($query, $suppress_warnings){
    if ($suppress_warnings && dj())
       return query($query, $suppress_warnings);
    elseif (dj()) //will print warning if eval is false
       return query($query, $suppress_warnings);
    else
        return null;
    
}
function time_dj_query($query, $suppress_warnings, $time){
    if ($suppress_warnings && time_dj($time))
       return query($query, $suppress_warnings);
    elseif (dj()) //will print warning if eval is false
       return query($query, $suppress_warnings);
    else
        return null;
    
}
//returns [true, show name, set id] for djs with valid cred. for making a track entry at a givin time,
//[true, null, null] for aux+
//and [false, null, null] for anyone else
function time_dj($time){
    $min_time = sql_time($time - 60*5);
    $max_time = sql_time($time + 60*5);
    $user_id = user_id();
    $valid_dj = logged_in() && aux(); //all aux+ are valid
    $show_name = null;
    $set_id = null;
    if (!$valid_dj){
        $query = "SELECT FIRST(set.show_name), set.set_id FROM shows
                INNER JOIN ON set
                ON set.show_name = shows.show_name
                INNER JOIN ON show_user
                ON show_user.show_name = shows.show_name
                AND set.set_start < $min_time
                set.set_end > $max_time AND
                show_user.user_id = $user_id";
        $res = any_dj_query($query, $false);
    
        if ($res && $res->num_rows > 0){
            $valid_dj = true;
            $show_name = $res['show_name'];
            $set_id = $res['set_id'];
        }
    }
    
    return array($valid_dj, $show_name, $set_id);
                             
    
}
//asumes a valid show name (will not inform user if name is invalid)
//returns true if user can modify show at dj level
function show_dj($show_name){
    $user_id = user_id();
    $valid_dj = logged_in() && aux(); //all aux+ are valid
    if (!$valid_dj){
        $query = "SELECT FIRST(set.show_name), set.set_id FROM show_user WHERE user_id = $user_id && show_name = $show_name";
        $res = any_dj_query($query, $false);
        if ($res && $res->num_rows > 0){
            $valid_dj = true;
        }
}
return $valid_dj;
}



?>