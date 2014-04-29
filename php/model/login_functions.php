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
        //gather from database:
        //dj_names : array
        //dj_ids : array
        //user_shows
        
        //chose:
        //current_dj_name
        //current_dj_id

        
        //store everything in session
        }
    }
?>