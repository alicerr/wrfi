<?php
    //cleans strings for html and sql safety
    //INPUT: none
    //VISIBLE ACTION: none
    //OUTPUT: cleaned string (may be null)
    function clean($string)
    {
        $string = strip_tags($string);
        $string = trim($string);
        $string = (mysql_real_escape_string($string));
        return $string;
    }
    function set_session($name, $arg){
        $cleaned_arg = clean($arg);
        if ($cleaned_arg){$_SESSION[$name] = $cleaned_arg; $set = true;}
        return $cleaned_arg;
    }
    function get_session($name){
        if (isset($_SESSION[$name])) return $_SESSION[$name]; else return null;
    }
    function unset_session($name){
        unset($_SESSION[$name]);
    }
    
    function set_global($name, $arg){
        $cleaned_arg = clean($arg);
        if ($cleaned_arg){$_GLOBAL[$name] = $cleaned_arg; $set = true;}
        return $cleaned_arg;
    }
    function get_global($name){
                if (isset($_GLOBAL[$name])) return $_GLOBAL[$name]; else return null;
    }
    function unset_global($name){
                unset($_GLOBAL[$name]);
    }
    function set_post($name, $arg){
        $cleaned_arg = clean($arg);
        if ($cleaned_arg){$_POST[$name] = $cleaned_arg; $set = true;}
        return $cleaned_arg;
    }
    function get_post($name){
                if (isset($_POST[$name])) return $_POST[$name]; else return null;
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
                if (isset($_GET[$name])) return $_GET[$name]; else return null;
    }
    function unset_get(){
                unset($_GET[$name]);
    }
?>