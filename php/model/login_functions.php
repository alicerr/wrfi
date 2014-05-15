<?php
//these functions handle session details for a givin user


    //checks for login and logout events (does not handle reloads)
    function update_user_state(){
        if (get_post('logout')){
            logout();
            unset_post('logout', null);
        }
        elseif (get_post('login')){
            login();
            unset_post('login');
        }
    }
    
    
    //innitiates logout
    function logout(){
        unset($_SESSION);
    }
    //initiates login
    function login(){
        unset($_SESSION);
        $password = get_post("password");
        $email = get_post("email");
        $query = "SELECT * FROM user WHERE email = '$email' && password = '".hash_it($password)."'";
        $res ="";
        
        if (warn($password, "Please enter a password") && warn($email, "Please enter an email address as a user name"))
        {
            global $mysqli;
            $res = $mysqli->query($query);
            if (warn($res, "User not found, or password incorrect!")){
                $r = $res->fetch_assoc();
                if (warn($r["level_id"] > 0, "Disabled Account!")){
                    $user_id = $r["user_id"];
                    set_session("user_level", $r["level_id"]);
                    set_session("user_id", $user_id);
                    $query = "SELECT * FROM dj WHERE user_id = $user_id";
                    $res = $mysqli->query($query);
                    $dj_id = array();
                    $dj_name = array();
                    while ($r= $res->fetch_assoc()){
                        array_push($dj_id, "dj_id");
                        array_push($dj_name, "dj_name");
                    }
                    set_session("dj_ids", $dj_id);
                    set_session("dj_names", $dj_names);
                    
                    $query = "SELECT * FROM show_user WHERE user_id = $user_id";
                    $res = $mysqli->query($query);
                    $shows = array();
                    while($r = $res->fetch_assoc()){
                        array_push($shows, $r["show_name"]);
                    
                    }
                    set_session("shows", $shows);
                    $hold = implode("\" OR show_name LIKE \"", $shows);
                    if ($hold) $hold = " WHERE show_name LIKE \"".$hold."\"";
                    $query = "SELECT set_id FROM SETS ".$hold;
                    $res = "";
                    if ($hold) $res = $mysqli->query($query);
                    $set_id = array();
                    if ($res){
                        while ($r= $res->fetch_assoc())
                            array_push($set_id, $r["set_id"]);
                    }
                    set_session("set_ids", $set_id);
                    
                }
            }
        }
        
        //harvest post data:
        //password (may not be set at all)
        //email
        
        //confirm user status and retrieve user id
        //and level
        //store user id in session var user_id
        //level in user_level
        //IF LEVEL IS 0 DO NOT ALOW USER TO LOGIN
        
    }
    
    //loads user info, and reloads it when a change
    //may have been made during editing
    function reload_user_info(){
        global $mysqli;
        $user_id = get_session("user_id");
        if ($user_id){
         $query = "SELECT * FROM dj WHERE user_id = $user_id";
                    $res = $mysqli->query($query);
                    $dj_id = array();
                    $dj_name = array();
                    while ($r= $res->fetch_assoc()){
                        array_push($dj_id, "dj_id");
                        array_push($dj_name, "dj_name");
                    }
                    set_session("dj_ids", $dj_id);
                    set_session("dj_names", $dj_names);
        }
    }
         //three admin level functions:
    //manager(), aux(), dj() which return true if user is at least tat level
    function aux(){ return get_session("user_level") && get_session("user_level") > 1;}
    function manager(){ return get_session("user_level") && get_session("user_level") > 2;}
    function dj(){ return get_session("user_level") && get_session("user_level") > 0;}
    //is show of user
    function is_show_user(){
       $yes = false;
       $set_id = get_post("set_id");
       $show_name = get_post("show_name");
       
       if (logged_in() && $set_id) $yes = array_search($set_id, get_session($set_ids));
       elseif (logged_in() && $show_name) $yes = array_search ($show_name, get_session($shows));
       
    }
    
    function is_user_dj(){
        
        $dj_id = get_post("dj_id");
        if ($dj_id = false) $dj_id = get_get("dj_id");
        return (logged_in() && array_search($dj_id, get_session("dj_ids")));
    }
    
    function logged_in(){
        return get_session("user_id");
    }
    
?>