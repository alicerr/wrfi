<?php
//these functions handle session details for a givin user


    //checks for login and logout events (does not handle reloads)
    function update_user_state(){
        if (get_post('logout')){
            logout();
            print_error_message("logged out");
            unset_post('logout');
        }
        elseif (get_post('login')){
            login();
            unset_post('login');
            print_message("logged in");
        }
        elseif(get_post("change_dj_name")){
            change_dj_name();
        }
    }
    
    
    //innitiates logout
    function logout(){
        unset_session("dj_ids");
        unset_session("dj_names");
        unset_session("user_id");
        unset_session("current_dj_name");
        unset_session("current_dj_id");
        unset_session("sets");
        unset_session("shows");
        unset_session("user_level");

        
    }
    //initiates login
    function login(){
        //unset($_SESSION);
        $password = get_post("password");
        $email = get_post("email");
        //print_message($email);
        $query = "SELECT * FROM user WHERE email = '$email' && password = '".hash_it($password)."'";
        //echo($query);
        
        $res ="";
        
        if (warn($password, "Please enter a password") && warn($email, "Please enter an email address as a user name"))
        {
            global $mysqli;
            $res = $mysqli->query($query);
            if (warn($res, "User not found, or password incorrect!")){
                $r = $res->fetch_assoc();
                //echo($r["level_id"]);
                if (warn($r["level_id"] > 0, "Disabled Account!")){
                    $user_id = $r["user_id"];
                    $_SESSION["user_id"] = $user_id;
                    set_session("user_level", $r["level_id"]);
                    set_session("user_id", $user_id);
                    $query = "SELECT * FROM dj WHERE user_id = $user_id";
                    //print_message($query);
                    $res = $mysqli->query($query);
                    $dj_id = array();
                    $dj_name = array();
                    while ($r= $res->fetch_assoc()){
                        
                        array_push($dj_id, $r["dj_id"]);
                        array_push($dj_name, $r["dj_name"]);
                    }
                    set_session("dj_ids", $dj_id);
                    set_session("dj_names", $dj_name);
                    
                    $query = "SELECT * FROM show_user WHERE user_id = $user_id";
                    
                    //print_message($query);
                    $res = $mysqli->query($query);
                    $shows = array();
                    $hold = " WHERE show_name = \"";
                    while($r = $res->fetch_assoc()){
                        array_push($shows, $r["show_name"]);
                        $hold = $hold.trim($r["show_name"])."\" OR ";
                        
                    }
                    set_session("shows", $shows);
                    $hold = substr($hold, 0, strlen($hold) - 4);
                    //print_error_message($hold);
                    //echo($hold);
                    $query = "SELECT set_id FROM sets ".$hold;
                    
                    //print_message($query);
                    $res = "";
                    if (!empty($shows)) $res = $mysqli->query($query);
                    $set_id = array();
                    if ($res){
                        while ($r= $res->fetch_assoc())
                            array_push($set_id, $r["set_id"]);
                    }
                    set_session("set_ids", $set_id);
                    $hold = implode("  OR dj.dj_id =",  $dj_id);
                    if ($hold) $hold = " WHERE dj.dj_id = ".$hold."";
                    $query = "SELECT dj.dj_id, dj.dj_name FROM track_played INNER JOIN dj ON track_played.dj_id = dj.dj_id ".$hold." ORDER BY start ";
                    
                    //print_message($query);
                    if ($hold){
                        $res = $mysqli->query($query);
                        if (mysqli_num_rows($res) > 0){
                            $r = $res->fetch_assoc();
                            set_session("current_dj_name", $r["dj_name"]);
                            set_session("current_dj_id", $r["dj_id"]);
                            
                        }
                        elseif (!empty($dj_id)){
                            set_session("current_dj_name", end($dj_name));
                            set_session("current_dj_id", end($dj_id));
                    }
                        
                    }
                    elseif (!empty($dj_id)){
                            set_session("current_dj_name", end($dj_name));
                            set_session("current_dj_id", end($dj_id));
                    }
                    
                    
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
                        array_push($dj_id, $r["dj_id"]);
                        array_push($dj_name, $r["dj_name"]);
                    }
                    set_session("dj_ids", $dj_id);
                    set_session("dj_names", $dj_name);
        }
        print_message("information reloaded");
    }
    
    function change_dj_name(){
        $dj_id = get_post("dj_id");
        $query = "SELECT * FROM dj WHERE dj_id = $dj_id";
        global $mysqli;
        if ($dj_id){
            $res = $mysqli->query($query);
            if ($res){
                $r= $res->fetch_assoc();
                set_session("current_dj_name", $r["dj_name"]);
                echo($r["dj_id"]);
                set_session("current_dj_id", $dj_id);
            }
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