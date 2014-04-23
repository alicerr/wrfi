<?php

    //updates history keeping functions
    //ACCESSES: SESSION: 'this_page', 'this_page_title', 'history', 'title_history'
    //            GLOBALS: 'base_url', 'page_title'
    //Modifies: SESSION: 'this_page', 'this_page_title', 'history', 'title_history'
    function update_history(){
        $last_page = get_session('this_page');
        $last_page_title = get_session('this_page_title');
        
        $this_page = get_global('base_url');
        $this_page_title = get_global('page_title');
        
        $user_went_back = get_post('back');
        $history_stack = get_session('history');
        $history_title_stack = get_session('title_history');
        
        if (!$history_stack && $last_page && $last_page_title){
            
            $history_stack = array($last_page);
            $history_title_stack = array($last_page_title);
            set_session('history', $history_stack);
            set_session('title_history', $history_title_stack);
            
        }
        //save last page if diff. from this page and user did not press back
        elseif ($last_page && $last_page_title && $last_page != $this_page && !$user_went_back)
        {
            array_push($history_stack, $last_page);
            array_push($history_title_stack, $last_page_title);
        }
        elseif($user_went_back){
            array_pop($history_stack);
            array_pop($history_title_stack);
        }
        
        set_session('this_page', $this_page);
        set_session('this_page_title', $this_page_title);
        
    }
    //clears history, for use on logout
    //must be called before update_history() (above) to behave as expected
    //ACCESSES: GLOBALS: 'base_url', 'page_title'
    //Modifies SESSION: 'this_page', 'this_page_title', 'history', 'title_history'
    function clear_history()
    {
        set_session('history', null);
        set_session('title_history', null);
        $this_page = get_global('base_url');
        $this_page_title = get_global('page_title');
        set_session('this_page', $this_page);
        set_session('this_page_title', $this_page_title);
    }
    
    //retrieves the last distinct page change
    //INPUT: none 
    //VISIBLE ACTION: none
    //OUTPUT: url if found, null if not
    function get_last_url()
        {
        $last = "";
        $history = get_session('history');
        if ($history) $last = end($history);
        return $last;
        }
    
    //finds the tile of the last distint page change
    //INPUT: none 
    //VISIBLE ACTION: none
    //OUTPUT: url if found, null if not
    function get_last_title()
        {
        $last = "";
        $history = get_session('title_history');
        if ($history) $last = end($history);
        return $last;
        }
?>