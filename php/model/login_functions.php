<?php

    function update_state(){
        if (get_post('logout')){
            logout();
            unset_post('logout', null);
        }
        elseif (get_post('login')){
            login();
            unset_post('login');
        }
    }
    
    
    function logout(){}
    function login(){}
?>