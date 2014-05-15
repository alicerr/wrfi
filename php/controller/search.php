
<?php
/*
Purpose: load content for a search
Input:none
Output:none
Accesses: none directly
Modifies: none
Visual effects: none directly
Database effects: none
Other: this sets seach_sql in the post feild and then calls content load functions.
(controller/content_load.php). Which functions are called is dependent on the area,
for example all will call several, but djs will only call load_all_djs, artitist will
call load_all_artists, and show wil call load_all_show and then load_all_sets
*/
function load_search(){
    $type = get_get("type");
    $search = get_get("search");
    if ($search && $type){
        if($type == "all")
        {}
        elseif($type =="dj")
        {}
        elseif($type == "artist")
        {}
        elseif($type == "show")
        {}
    }
}