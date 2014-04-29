
<?php

//I need to think throuh exactly where and what eatch catagory should display
//see model/search.php for work on this please
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