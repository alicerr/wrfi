<?php
    //this page records pages the user visted, to help site nav

    //updates history keeping functions
    //ACCESSES: SESSION: 'this_page', 'this_page_title', 'history', 'title_history'
    //            GLOBALS: 'base_url', 'page_title'
    //Modifies: SESSION: 'this_page', 'this_page_title', 'history', 'title_history' (title history is not in use yet)
    function update_history(){
        $last_page = get_session('this_pagewrfi');
        $last_page_title = get_session('this_page_title');
        global $base_url;
        global $pageTitle;
        $this_page = $base_url;
        $this_page_title = $pageTitle;
        
        $user_went_back = get_post('back');
        $history_stack = get_session('historywrfi');
        //$t= get_session('t');
        //print_message(is_array($t));

        if (!$history_stack && $last_page && $last_page_title){
            
            $history_stack = array($last_page);
            //$t = array($last_page_title);
            //set_session('t', $t);
            set_session('historywrf1', $history_stack);
            //set_session('title_history', $t);
            
        }
        //save last page if diff. from this page and user did not press back
        elseif ($last_page && $last_page_title && $last_page != $this_page && !$user_went_back)
        {
            array_push($history_stack, $last_page);
            //array_push($t, $last_page_title);
        }
        elseif($user_went_back){
            array_pop($history_stack);
            array_pop($t);
        }
        
        set_session('this_pagewrfi', $this_page);
        //set_session('this_page_title', $this_page_title);
        //print_message(get_session('this_page')."title");
        //print_message(get_session('this_page_title')."page");
        //print_message($this_page."title");
        //print_message($this_page_title."page");
        
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
        $history = get_session('historywrf1');
        if ($history) $last = end($history);
                //print_message("Last".$last."\n");
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