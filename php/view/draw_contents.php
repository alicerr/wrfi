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
    function draw_line($cell_strng_array){
        return '<div class = "line" >'.implode(" ",$cell_strng_array).'</div>';
    }
    //return a cell with 1+ classes  from class array, holding guts
    function draw_cell( $guts, $class_array){
        return "<div class = \"cell ".implode(" ", $class_array)." >$guts</div>";
    }
    
    //return a heading cell, with classes 
    function draw_heading_cell($guts, $class_array){
        echo("<div class = \"cell ".implode(" ", $class_array)." >$guts</div>");
    }
    //return a linked content, if $link is not null, else return just text content
    function make_link($content, $link){
        if ($link) return "<a href=\"http://www.$link\">$content</a>";
        else return $content;
    }
    
    function show_access($show_name){
        $shows = get_session("user_shows");
        return aux() || ($shows && in_array($show_name, $user_shows));}

//will be used to produce safe links
    function generate_link($base, $type, $id){
        return urlencode("$base?$type=$id");
    }
    //returns a single button form with a hidden id value
function  make_tiny_form($submit_name, $submit_value, $hide_name, $hide_value){
        return'<form method="post"><input type="text" name="'.$hide_name.'" value="'.$hide_value.'" class = "hide" required />
        <input type = "submit" name = "'.$submit_name.'" value="'.$submit_value.'" /></form>';
    }
    
//returns a block formated display with up to three sections
function make_block($title, $sub_heading, $text){
    //todo
}
function draw_heading($heading_cell_string_array){
    return '<div class = "head line" >'.implode(" ",$heading_cell_string_array).'</div>';
}

 
  
            
    
?>