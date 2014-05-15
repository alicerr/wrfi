
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
function seach_css(){
    global $styles;
    $type = get_get("type");
    $search = get_get("search");
        if ($search && $type){
        if($type == "all")
        {}
        elseif($type =="dj")
        {
            array_push($styles, "style/all_dj.css");
        }
        elseif($type == "artist")
        {
            array_push($styles, "style/all_artist.css");
        }
        elseif($type == "show")
        {
        
            array_push($styles, "style/all_show.css");
        }
    }
}
function load_search(){
    $type = get_get("type");
    $search = get_get("search");
    if ($search && $type){
        if($type == "all")
        {}
        elseif($type =="dj")
        {
            search_only_dj($search);
            load_all_djs();
        }
        elseif($type == "artist")
        {
            search_only_artist($search);
            load_all_artists();
        }
        elseif($type == "show")
        {
            search_only_show($search);
            load_all_shows();
            
        }
    }
}