<?php
//functions for drawing contents
//draw_line($cell_string_array),
//draw_cell($string, $class_array),
//make_link($string, $link)
//make_tiny_form($submit_name, $submit_value, $hide_name, $hide_value)
//make_block($title, $sub_heading, $text)
//draw_heading($heading_cell_string_array)
//draw_heading_cell($contents, $class_array())
    
    //return a table line from a cell aray
    function line($cell_strng_array){
        return "<div class = \"line bline\" >\n\t\t".implode($cell_strng_array, " \n\t\t")."\n\t</div>";
    }
    //return a table line from a cell aray
    function hline($cell_strng_array){
        return "<div class = \"hline line\" >\n\t\t".(implode($cell_strng_array, " \n\t\t"))."\n\t</div>";
    }
    //return a cell with 1+ classes  from class array, holding guts
    function cell( $guts, $class){
        return "\n<div class = \"cell bcell $class\" >\n\t$guts\n</div>";
    }
    
    //return a heading cell, with classes 
    function hcell($guts, $class){
        return("\n<div class = \"hcell cell $class\" >\n\t$guts\n</div>");
    }
    function table_title($title){
        echo("\n<h2 class = \"table_title\" >$title</h2>\n");
    }
    function table_start(){
        echo("<div class = \"table\">");
    }
    function table_stop(){
        echo("</div>");
    }
    
    //creates links
    //If content is not null:
    //return a linked content, if $link is not null, else return just text content
    //Else:
    //return a linked "Link", if $link is not null, else returns "Not Listed"
    function world_link($content, $link){
        if (!$content && $link) $content = "Link";
        elseif (!$content) $content = "Not Listed";
        if ($link) return "\n<a href=\"http://$link\">\n\t$content\n</a>";
        else return $content;
    }
    


    function local_link($content, $link){
        
        if ($link) return "\n<a href=\"$link\">\n\t$content\n</a>";
        else return $content;
    }
    
    function show_access($show_name){
        $shows = get_session("user_shows");
        return aux() || ($shows && in_array($show_name, $user_shows));}

//will be used to produce safe links
    function get_link($base, $type, $id){
        if (!$base && $type && $id)
            {
            $base = get_global("base_url");
            return "$base?$type=".urlencode($id);
            }
        else
            return "";
    }
    //returns a single button form with a hidden id value
function  tiny_form($submit_name, $submit_value, $hide_name, $hide_value){
        return"\n<form method=\"post\">\n\t<input type=\"text\" name=\"".$hide_name."\" value=\"".$hide_value."\" class = \"hide\" required />\n\t
        <input type = \"submit\" name = \"".$submit_name."\" value=\"".$submit_value."\" />\n</form>";
    }
//returns an email link
function email_link($email){
 
    if ($email) return "\n<a href=\"mailto:wrfiVolunteer@$email\" > \n\t$email \n</a>";
    else return "not listed";
}
//returns a block formated display with up to three sections
function block($title, $sub_heading, $text, $after, $edit){
    return("<div class = \"edit\">\n<h1 class = \"title\" >\n\t$title\n</h1>\n<h2 class= \"subheading\">\n\t$sub_heading\n</h2>\n<p class =\"blocktext\">\n\t$text\n</p>\n<h3>\n\t$after</h3>\n$edit\n</div>");
}

function nullweb($website){
    if ($website) return world_link("Website", $website);
    else return "not listed";
}
 
  
            
    
?>