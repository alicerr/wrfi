<?php
//FINISHED
    /*One cleaning function for strings or arrays of strings,
     *sanitiving them for site use
     *
     *the reast of these are getters, setters, and unsetters
     *for global/session/post/get. This allows getters to
     *simply return null if something is unset,
     *and streamlines the cleaning of code throughout the
     *site, reducing errors.
     *
     *Because all of these functions are very standard I will
     *only provide templets.
     *
     *get_?
     *Input: string name of variable to acess
     *Output: null if unset, else the cleaned value of the variable
     *
     *set_?
     *Input: sting variable name, string variable value
     *Output: cleaned variable
     *Note: cleans value before setting it
     *
     *unset_?
     *Input: variable name to unset
     *Output: none
     *
     *clean
     *Input: String or array of strings
     *Output: cleaned strig or array of strings
     */
    
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
            $i = stripos($string, ("\\\\"));
            while($i > -1){
                $string = str_replace("\\\\", "\\", $string);
                                      $i = stripos($string, ("\\\\"));
            }
            $i = stripos($string, ("\\\"\\\""));
            while($i > -1){
                $string = str_replace("\\\"\\\"", "\\\"", $string);
                                      $i = stripos($string, ("\\\\"));
            }
            $i = stripos($string, ("\\'\\'"));
            while($i > -1){
                $string = str_replace("\\'\\'", "\\'", $string);
                                      $i = stripos($string, ("\\\\"));
            }
            
        }
        return $string;
    }
    function not_null($thing){
        if ($thing) return "'$thing'";
        else return "NULL";
    }
    function set_session($name, $arg){
    
            $arg = clean($arg);
            if ($arg) $_SESSION[$name] = $arg;
            return $arg;
      
    }
    function array_find($val, $arr){
        $found = false;
        if (is_array($arr))
            foreach($arr as $a)
               $found = $found || ($a == $val);
        return $found;
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

?>