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
    <script src="script/base.js"></script>
    <?php 
        inc_style($styles); //load any page spec styles
        inc_script($scripts); //load any page spec scripts
        setCSS(); //user state specific css

    ?>
</head>

<body>
    <div id = "left">
        <div id = "listener">


            <!--search bar here-->
            <form id="search_form" action="search.php" method="get"> <!-- FILL IN ACTION="" -->
                Keyword: <input type="text" size="50" name="keyword" id="search_key" />
                Search by: <select name="criteria" id="search_criteria">
                    <option value="all">All</option>
                    <option value="dj">DJs and hosts</option>
                    <option value="artist">Artists</option>
                    <option value="show">Shows</option>
                </select>
                <input type="submit" value="Search" name="search_button" />

            </form>
            <!-- buttons to parts of the site (all shows, djs, schedules, etc) -->
            <a href="php/panels/all_show.php" class="button">All shows</a><br>
            <a href="php/panels/all_dj.php" class="button">DJs</a><br>
            <a href="" class="button">Schedule</a><br>
            <!-- <a href="" class="button">Artists</a> -->
            <!--back button here-->
            <a href="<?php get_last_url(); ?>" class="button">Back</a>

        </div>
        <div id = "dj">
            <div id ="logged_in_dj" class = "logged_in" >
                <!--dj in form here-->
                <!-- display dj's name -->
                <h3>
                    <?php
                    //prints out selected dj name with a link to the dj page
                    $dj_name = get_session('current_dj_name');
                    $dj_id = get_session('current_dj_id');
                    if ($dj_id) $dj_id = "dj.php?dj_id=".$dj_id;
                    echo(make_link($dj_name, $dj_id));
                    echo("DJ name here");
                    ?>
                </h3>
     
                <form method = "post">
                    <input type = "submit" name="add_track" value="Add track" />
                </form>
                <!-- <a href="" class="button">Add DJ name</a>
                <a href="" class="button">Change email</a> -->
                <form method = "post">
                    <input type = "submit" name = "user_settings" value="User settings" />
                </form>
                <form method = "post">
                    <input type = "submit" name = "add_dj" value="Add DJ" />
                </form>
                <form method = "post">
                <!-- dropdown to select DJ names for that user -->
                    <select name="dj_id">
                        <?php
                            $dj_names = get_session("dj_names");
                            $dj_ids = get_session("dj_ids");
                            for ($i = 0; $i < count($dj_names); $i++)
                                echo("<option value =\"".$dj_ids[$i]."\">".$dj_names[$i]."</option>");
                         ?>
                        <!-- FUNCTION with array of dj's names stored in session -->
                    </select>
                    <input type="submit" name="change_dj_name" value="Select DJ name" />
                </form>
                <form  method="post"> 
                    <input type="submit" value="Log out" name="logout" />
                </form>

            </div>
            <div id = "logged_out_dj" class = "out">
                <!--logged out form here-->
                <form  method="post"> 
                    Email: <input type="email" name="user" id="email" required /><br>
                    Password: <input type="password" name="password" id="pass" /><br>
                    <input type="submit" value="Log in" name="login" />
                    <input type="submit" name = "reset_password" value="Forgot password" /> <!-- LINK -->
                </form>
            </div>
        </div>
    </div>
    <div id = "middle">
        <div id = "header">
            <!--wrfi image here-->
            <img src="images/wrfi_logo.png" alt="WRFI">
        </div>
        <div id = "message">
            <!--messages to user drawn here-->
		user messages will be displayed here
            <?php draw_message(); ?>
             <div id = "jsmessage"></div>
        </div>
        <div id = "content">
            <!--block and line content here-->
            <!---forward/backward results here-->
	Tables and block content go here
            <?php content_function(); ?>
            <h2 id="page_title">Page title</h2>
            <h3 id="sub_heading">Sub heading</h3>
        </div>
        <div id = "editing">
            <!--editing panel to hold various things-->
            <!-- FUNCTION to handle which form to display -->
        </div>
    </div>
    <div id = "right">
        <div id = "streaming">
            <!--streaming console here-->
		Streaming content here
            <!--test for js?-->
            <a href="<?php get_last_url(); ?>" class="button">Back</a>
        </div>
        <div id = "manager" class = "manager">
            <!--manager console here-->
            <form method = "post" action = "schedule.php">
                <input type= "submit" value = "Add set" name = "add set">
            </form>
            <form method = "post" >
                <input type= "submit" value = "add show" name = "add_show"></input>
            </form>
                <a href="all_user.php" class="button">View all users</a>          
            <form method = "post">
                <input type= "submit" value = "Add user to show" name = "add_user_show"></input>
            </form>
            <form method = "post">
                <input type= "submit" value = "Remove user from show" name = "remove_user_show"></input>
            </form>              
                
   
        </div>
    </div>
    



</body>
</html>
