<?php
//prints css to hide various page elements if the user is a gues, admin, or non-admin user
//INPUT: none
//VISIBLE ACTION: various elements are hiddin or uncovered
//OUTPUT: none
function setCSS()
    {
    echo ("<style>");
    if (!logged_in()){}
    else{

        if (aux()) {
            if(manager())
                {}
        }
    }

    echo ("
        </style>");
    }
//prints include javascript statements
//INPUT: js urls
//VISIBLE ACTION: links the script
//OUTPUT: none
function inc_script($urls)
    {
    foreach($urls as $url) echo ("<script src=\"$url\"></script>");
    }
    
//prints include stylesheet statements
//INPUT: sheet urls
//VISIBLE ACTION: links the stylesheet
//OUTPUT: none
function inc_style($urls)
    {
    //print_message("here");
    //foreach($urls as $url) print_message($url);
    foreach($urls as $url) echo ("<link rel=\"stylesheet\" href=\"$url\">");
    }

?>