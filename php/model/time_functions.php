<?php
//used to update time in the tables (to record modifications to the database)
//INPUT: none
//VISIBLE ACTION: none
//OUTPUT: time with "" 
function get_time()
    {
    return ("\"" . date('Y-m-d H:i:s') . "\"");
    }


?>