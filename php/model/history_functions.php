<?php
//FINISHED
/*functions that handle keeping track of user history
 */

 /*
Purpose:updates the history stack after a navigation event
Input:none
Output:none
Accesses:history stacks
Modifies:history stacks
Visual effects:none
Database effects:none
Other:will not update the stack if the url is unmodified. will pull the last url off the history stack if POST[back] is set
*/
    function update_history(){
        $last_page = get_session('this_pagewrfi');
        //$last_page_title = get_session('this_page_title');
        global $base_url;
        global $pageTitle;
        $this_page = $base_url;
        $this_page_title = $pageTitle;
        
        $user_went_back = get_post('back');
        $history_stack = get_session('historywrfi');
        //$t= get_session('t');
        //print_message(is_array($t));

        if (!$history_stack && $last_page ){
            
            $history_stack = array($last_page);
            //echo("last_page");
            //$t = array($last_page_title);
            //set_session('t', $t);
            set_session('historywrf1', $history_stack);
            //set_session('title_history', $t);
            
        }
        //save last page if diff. from this page and user did not press back
        elseif ($last_page  && $last_page != $this_page && !$user_went_back)
        {
            array_push($history_stack, $last_page);
            //echo("last_page");
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
/*
Purpose: clear user history
Input: none
Output: none
Accesses:  story stacke
Modifies:   deletes history stack
Visual  effects:none
Database    effects:none
Other:  none
*/
    function clear_history()
    {
        set_session('history', null);
        set_session('title_history', null);
        $this_page = get_global('base_url');
        $this_page_title = get_global('page_title');
        set_session('this_page', $this_page);
        set_session('this_page_title', $this_page_title);
    }
/*
Purpose: retrives url of last page visited for back button
Input: none
Output: none
Accesses:  history stack
Modifies:   deletes history stack
Visual  effects:none
Database    effects:none
Other:  none
*/
    function get_last_url()
        {
        $last = "";
        $history = get_session('historywrf1');
        
        if ($history){ $last = end($history);}
                //print_message("Last".$last."\n");
        return $last;
        }
    
/*
Purpose: clear user history
Input: none
Output: none
Accesses:  story stacke
Modifies:   deletes history stack
Visual  effects:none
Database    effects:none
Other:  none

    function get_last_title()
        {
        $last = "";
        $history = get_session('title_history');
        if ($history) $last = end($history);

        return $last;
    
        }*/
?>