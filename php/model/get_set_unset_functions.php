<?php
    //one cleaner and getters, setters, and unsetters for
    //GET/POST/SESSION/GLOBAL
    //FORMAT: get/set/unset_post/session/get/global(name, [value])
    //three admin level functions:
    //manager(), aux(), dj() which return true if user is at least tat level
    
    //getters return null if value is not set, or a cleaned value
    //setters return cleaned string
    //unset does not return


    //cleans strings, or arrays of strings for html and sql safety
    //INPUT: anything
    //VISIBLE ACTION: none
    //OUTPUT: cleaned string (may be null) if a string or string array,
    //wont touch non-strings
    
    function clean($string)
    {
        if (is_array($string)){
            for ($i = 0; $i < count($string); $i++)
            $string[$i] = clean($string[$i]);
        }
        elseif(is_string($string)){
            $string = strip_tags($string);
            $string = trim($string);
            $string = (mysql_real_escape_string($string));
        }
        return $string;
    }
    
    function set_session($name, $arg){

            $_SESSION[$name] = $arg;
      
    }
    function get_session($name){
       if (isset($_SESSION[$name])) return $_SESSION[$name];
       else return "";
    }
    function unset_session($name){
        unset($_SESSION[$name]);
    }
    
    function set_global($name, $arg){
        $cleaned_arg = clean($arg);
        if ($cleaned_arg){$GLOBALS[$name] = $cleaned_arg; $set = true;}
        return $cleaned_arg;
    }
    function get_global($name){
                if (isset($GLOBALS[$name])) return clean($GLOBALS[$name]); else return null;
    }
    function unset_global($name){
                unset($GLOBALS[$name]);
    }
    function set_post($name, $arg){
        $cleaned_arg = clean($arg);
        if ($cleaned_arg){$_POST[$name] = $cleaned_arg; $set = true;}
        return $cleaned_arg;
    }
    function get_post($name){
                if (isset($_POST[$name])) return clean($_POST[$name]); else return null;
    }
    function unset_post($name){
                unset($_POST[$name]);
    }
    function set_get($name, $arg){
        $cleaned_arg = clean($arg);
        if ($cleaned_arg){$_GET[$name] = $cleaned_arg; $set = true;}
        return $cleaned_arg;
    }
    function get_get($name){
                if (isset($_GET[$name])) return clean($_GET[$name]); else return null;
    }
    function unset_get(){
                unset($_GET[$name]);
    }
     //three admin level functions:
    //manager(), aux(), dj() which return true if user is at least tat level
    function aux(){ return get_session("user_level") && get_session("user_level") > 1;}
    function manager(){ return get_session("user_level") && get_session("user_level") > 2;}
    function dj(){ return get_session("user_level") && get_session("user_level") > 0;}
    //is show of user
    function is_show_user($show_name){
        $shows = get_session("user_shows");
            return $shows && in_array($show_name, $shows);
    }
    
?>