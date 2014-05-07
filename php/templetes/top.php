<?php
//bring in the setup functions and the requires
require_once "php/controller/initial_load.php";
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo($pageTitle); ?></title>
    <link href="style/base.css" rel="stylesheet">
    <script src=
    "http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="script/base.js"></script>
    <?php 
        inc_style($styles); //load any page spec styles
        //inc_script($scripts); //load any page spec scripts
        setCSS(); //user state specific css

    ?>
</head>

<body>

    <div id = "left">
        
        <div id = "listener">
            <div class = "cline">

                <!--search bar here-->
                <form id="search_form" action="search.php" method="get"> <!-- FILL IN ACTION="" -->
                    <input type="text" name="search" />
                    Search by: <select name="type" >
                        <option value="all">All</option>
                        <option value="dj">DJs and hosts</option>
                        <option value="artist">Artists</option>
                        <option value="show">Shows</option>
                    </select>
                    <input type="submit" value="Search" name="submit_search" />
    
                </form>
            </div>
            <!-- <a href="" class="button">Artists</a> -->


        </div>
        <div class = "lower">
            <div id = "dj">
                <div class = "cline">
                    <div id ="logged_in_dj" class = "logged_in" >
                        <!--dj in form here-->
                        <!-- display dj's name -->
                                               
                       <form method = "post">
                           <input type = "submit" name="edit_track" value="Add track" />
                       </form>
                        <h3>
                            <?php
                            //prints out selected dj name with a link to the dj page
                            $dj_name = get_session('current_dj_name');
                            $dj_id = get_session('current_dj_id');
                            if ($dj_id) $dj_id = "dj.php?dj_id=".$dj_id;
                            echo(local_link($dj_name, get_link(get_global("base_url"), "dj_id", $dj_id)));
                            echo("DJ Awesome");
                            ?>
                        </h3>
                        <form method = "post">
                       <!-- dropdown to select DJ names for that user -->
                           <select name="dj_id">
                               <option value = "1">DJ Awesome</option>
                               <option value = "2">DJ Amazing</option>
                               <?php
                               //drop menu of users dj names
                                   //$dj_names = get_session("dj_names");
                                   //$dj_ids = get_session("dj_ids");
                                   //for ($i = 0; $i < count($dj_names); $i++)
                                       //echo("<option value =\"".$dj_ids[$i]."\">".$dj_names[$i]."</option>");
                                ?>
                               
                           </select>
                           <input type="submit" name="change_dj_name" value="Select DJ name" />
                       </form>
                        <form method = "post"><!--add dj name-->
                           <input type = "submit" name = "add_dj" value="Add DJ Name" />
                       </form>

                       <!-- <a href="" class="button">Add DJ name</a>
                       <a href="" class="button">Change email</a> -->
                       <form method = "post"><!--edit user details-->
                           <input type = "submit" name = "edit_user" value="User Details" />
                       </form>

                       <form  method="post"> 
                           <input type="submit" value="Log out" name="logout" />
                       </form>
    
                
                    </div>
                    <div id = "logged_out_dj" class = "out">
                        <!--logged out form here-->
                        
                        <!--<form  method="post"> 
                            Email: <input type="email" name="user" required />
                            Password: <input type="password" name="password" />
                            <input type="submit" value="Log in" name="login" />
                            <input type="submit" name = "reset_password" value="Forgot password" /> <!-- LINK -->
                        <!--</form>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id = "middle">
            <div id = "left_hold"></div>
        <div id = "header">
            <!--wrfi image here-->
            <img src="images/wrfi_logo.png" alt="WRFI">
        </div>

        <div id = "content">
            <!--block and line content here-->
            <!---forward/backward results here-->
            
            
            <?php content_function(); //calls gen. content function for each page ?>

        </div>
        <div id = "editing">
            <!--editing panel to hold various things-->
            
            <?php $edit_panel = get_post("edit_panel");
                    if($edit_panel) require_once $edit_panel;
                //this is set during the page load by load_edit_panel();
            ?>
        </div>
    </div>
    <div id = "right">
        <div class = "cline">
            <div id = "streaming">
                <!--streaming console here-->
                    
                <!--test for js?-->
                
                    <div class = "cline">

                       <!-- buttons to parts of the site (all shows, djs, schedules, etc) -->
                       <a href="schedule.php" class="button">Schedule</a>
                       <a href="all_show.php" class="button">Shows</a>
                       <a href="all_dj.php" class="button">DJs</a>
                       <a href="<?php echo(get_last_url()); ?>" class="button">Back</a>
                    </div>   
                
            </div>
        </div>
        <div class = "lower">
            <div id = "manager" class = "manager">
                <div class = "cline">
                <!--manager console here-->
                <form method = "post" action = "schedule.php">
                    <input type= "submit" value = "Add set" name = "edit_set">
                </form>
                <form method = "post" >
                    <input type= "submit" value = "Add show" name = "edit_show" />
                </form>
                <form method = "post" >
                    <input type= "submit" value = "Add user" name = "add_user" />
                </form>
                        
                <form method = "post">
                    <input type= "submit" value = "User-Show" name = "edit_show_user" />
                </form>
                 <a href="all_user.php" class="button">View all users</a>  
                    
                </div>
            </div>
        </div>
        </div>
          <div id = "message_block">
            <!--messages to user drawn here-->
		
                <?php print_message("this is a message"); print_error_message("this is an error message"); draw_message(); ?>
             <div id = "jsmessage"></div>
        </div>  



</body>
</html>