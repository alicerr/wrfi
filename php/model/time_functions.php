<?php
//used to update time in the tables (to record modifications to the database)
//INPUT: none
//VISIBLE ACTION: none
//OUTPUT: time with "" 
function get_time()
    {
    return ("\"" . date('Y-m-d H:i:s') . "\"");
    }

function does_not_cross($set_id, $set_start, $set_end){
    $bad = false;
    //echo($set_start);
    //echo($set_end);
    if ($set_start) $set_start = form_to_sql($set_start);
    if ($set_end) $set_end = form_to_sql($set_end);
    if ($set_id = 0 && warn(!$set_start || !$set_end, "please specify a start and end")) $bad = $true;
    elseif($set_start || $set_end){
        if (!$set_start || !$set_end){
            $query = "SELECT set_start, set_end FROM sets WHERE set_id = \"$set_id\"";
            global $mysqli;
            $res = $mysqli->query($query);
            if ($res){
                $r = $res->fetch_assoc();
                if (!$set_start) $set_start = $r["set_start"];
                
                if (!$set_end) $set_end = $r["set_end"];
               
                
            }
            
        }
        $start = strtotime($set_start);
        $end = strtotime($set_end);
           // echo("<br>".$start);
    //echo("<br>".$end);
        $bad = !(warn($start < $end, "shows cannot start after they end") && warn($start * 24 *60 *60 > $end, "Shows cannot be more than a day"));
        if (!$bad){
            $set = "";
            if ($set_id) $set = " && WHERE set_id = $set_id";
           $query = "SELECT * FROM sets WHERE (set_start > '$set_start' && set_start < '$set_end') ||
           (set_end <= '$set_end' && set_end > '$set_start') ".$set;
           echo ($query);
           global $mysqli;
           $res = $mysqli->query($query);
           if (mysqli_num_rows($res) > 0){
                $r = $res->fetch_assoc();
               print_error_message("conflict with ".$r["show_name"]." at ".$r["set_start"]." to ".$r["set_end"]);
               $bad = true;
           }
        }
        
    }
return !$bad;
}
function form_to_sql($date){
    
    $h = strtotime($date);
    
    $f = date("Y-m-d H:i:s", $h);
    return $f;
}
function sql_to_form($date){
    if ($date){
    $h = strtotime($date);
    //if (!$date) $h = date();
    $f = date("Y-m-d\Th:i", $h);

    return $f;
    }
    else
    return"";
}
function sql_to_form_date($date){
    $h = strtotime($date);
    if (!$date) $h = new DateTime();
    $f = date("Y-m-d", $h);
    
    
    return $f;
}
function uni_to_sql($date){
    return date("Y-m-d H:i:s", $date);
    
}

?>