<?php
    function draw_cell($class_array, $guts){
        echo("<div class = \"cell ".implode(" ", $class_array)." >$guts</div>");
    }
    function draw_heading_cell($class_array, $guts){
        echo("<div class = \"cell ".implode(" ", $class_array)." >$guts</div>");
    }
    function make_link($content, $link){
        if ($link) return "<a href=\"http://www.$link\">$content</a>";
        else return $content;
    }
    function show_access($show_name){
        $shows = get_session("user_shows");
        return aux() || ($shows && in_array($show_name, $user_shows));}

    function generate_link($base, $type, $id){
        return urlencode("$base?$type=$id");
    }
    //arrays
    //names
    //view level
    
    //edit level
    //is show releated
    //is set
    
    
    function draw_edit_form($type, $id){
        
            return "<form action = \"".get_global('base_url')."\" method = \"post\">

                        <type = \"input\" class = \"hide\" name = \"$type_id\" value = \"".$item[$item_id_feild]."\" />
                        <type = \"input\" class = \"hide\" name = \"$type\" value = \"".$type."\" />
                        <type=\"Submit\" class = \"edit_button\" name = \"edit\" value = \"edit\">
                        </form>";

        
    }
    function draw_delete_form( $type, $id){

            return "<form action = \"".get_global('base_url')."\" method = \"post\">

                        <type = \"input\" class = \"hide\" name = \"$type_id\" value = \"".$id."\" />
                        <type = \"input\" class = \"hide\" name = \"$type\" value = \"".$type."\" />
                        <type=\"Submit\" class = \"delete_button\" name = \"delete\" value = \"delete\">
                        </form>";
    
        
    }
    function draw_block($title, $description, $link, $type, $id)
    {
        
        echo("<h1>".make_link($title, $link)."</h1>
             <p>$description</p>");
        if (($type == "dj" && in_dj_ids($dj)) ||
            ($type == "artist" && dj()) ||
            ($type == "show" && (aux() || is_show_user($id))) ||
            ($type == "set" && (aux() || is_set_user($id))))
        draw_edit_form($type,  $id);
        
    }
    function remove_dot($string){
        if (strpos($string, ".") >=0)
            return substr($string, strpos($string, "."));
        else
            return $string;
    }
    function draw_lines($results, $names, $edit_level, $is_track_played, $is_set, $id_feild, $type, $visable){
        $user_level = get_session('user_level');
        echo("<div class = \"heading\">");
        for ($i = 0; $i < count($names); $i++){
            $visable[$i] = $visible[$i] - $user_level;
            if ($visible[$i] <= 0)
            {
                draw_heading_cell($names[$i]);
            }
        }
        echo("</div>");
        echo ("<div class = \"table\">");
        foreach($results  as $result){
            echo("<div class = \"line\">");
            for ($i = 0; $i < count($result); $i++){
                if ($visible[$i] <= 0)
                {
                    draw_cell($result[$i]);
                }
            }
            if ($is_track_played && is_show_user($result['show.show_name'])){
                draw_cell(draw_edit_form("track_played", $result["start"]));
                draw_cell(draw_delete_form("track_played", $result["start"]));
            }
            if ($is_set && manager()){
                draw_cell(draw_edit_form("set", $result["set_id"]));
                draw_cell(draw_delete_form("set", $result["set_id"]));
            }
            
            echo("</div>");
        }
        
        echo ("</div>");
    }
      
            
    
?>