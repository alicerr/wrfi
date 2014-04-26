<?php
    update_user_state();
    update_history(); 

   ?>
     
<!DOCTYPE html>

<html>
<head>
    <title><?php echo($pageTitle); ?></title>
    <link href="../style/base.css" rel="stylesheet">
    <script src="script/base.js"></script>
    <?php 
        inc_style($styles);
        inc_script($scripts);
        setCSS(); //user state specific css
        
        require_once("../php/model/history_functions.php"); //to be able to use get_last_url()
    ?>
</head>

<body>
    <div id = "left">
        <div id = "listener">
            <!-- buttons to parts of the site (all shows, djs, schedules, etc) -->
            <a href="" class="button">All shows</a><br>
            <a href="" class="button">DJs</a><br>
            <a href="" class="button">Schedule</a><br>
            <!-- <a href="" class="button">Artists</a> -->

            <!--search bar here-->
            <form id="search_form" action="search_results.php" method="get"> <!-- FILL IN ACTION="" -->
                Keyword: <input type="text" size="50" name="keyword" id="search_key" />
                Search by: <select name="criteria" id="search_criteria">
                    <option value="all">All</option>
                    <option value="dj">DJs and hosts</option>
                    <option value="artist">Artists</option>
                    <option value="show">Shows</options>
                </select>
                <input type="submit" class="button" value="Search" name="search_button" />
            </form>

            <!--back button here-->
            <a href="<?php get_last_url(); ?>" class="button">Back</a>

        </div>
        <div id = "dj">
            <div id ="logged_in_dj" class = "in">
                <!--dj in form here-->
                <!-- display dj's name -->
                <h3><?php get_session('use_dj_name'); ?></h3>
                <form id="dj_control" action="" method="post"> <!-- FILL IN ACTION="" -->
                    <!-- <a href="" class="button">Add track</a> LINK TO APPROPRIATE PAGE -->
                    <!-- <a href="" class="button">Add DJ name</a>
                    <a href="" class="button">Change email</a> -->
                    <a href="" class="button">Change password</a><br>
                    <a href="" class="button">Add set</a><br>
                    <!-- dropdown to select DJ names for that user -->
                    <select name="dj_name" id="djs_names">
                        <!-- FUNCTION with array of dj's names stored in session -->
                    </select>
                    <input type="submit" name="select_dj_name_button" value="Select DJ name" />

                </form>

                <form id="dj_logout" action="" method="post"> <!-- FILL IN ACTION="" -->
                    <input type="submit" class="button" value="Log out" name="logout_button" />
                </form>

            </div>
            <div id = "logged_out_dj" class = "out">
                <!--logged out form here-->
                <form id="dj_login" action="" method="post"> <!-- FILL IN ACTION="" -->
                    Email: <input type="text" size="10" name="user" id="username" required /><br>
                    Password: <input type="password" name="password" id="pass" /><br>
                    <input type="submit" class="button" value="Log in" name="login_button" />
                    <a href="" class="button">Forgot password</a> <!-- LINK -->
                </form>
            </div>
        </div>
    </div>
    <div id = "middle">
        <div id = "header">
            <!--wrfi image here-->
            <img src="../images/wrfi_logo.png" alt="WRFI">
        </div>
        <div id = "message">
            <!--messages to user drawn here-->
            <?php draw_message(); ?>
             <div id = "jsmessage"></div>
        </div>
        <div id = "content">
            <!--block and line content here-->
            <!---forward/backward results here-->\
            <h2 id="page_title">Page title</h2>
            <h3 id="sub_heading">Sub heading</h3>
        </div>
        <div id = "editing">
            <!--editing panel to hold various things-->
        </div>
    </div>
    <div id = "right">
        <div id = "streaming">
            <!--streaming console here-->
            <!--test for js?-->
            <a href="<?php get_last_url(); ?>" class="button">Back</a>
        </div>
        <div id = "manager">
            <!--manager console here-->
            <form id="manager_control" action="" method="post">  <!-- FILL IN ACTION="" -->
                <a href="" class="button">Audit view</a><br> <!-- LINK TO APPROPRIATE PAGE -->
                <a href="" class="button">Add show</a><br>
                <a href="" class="button">Delete show</a><br>
                <a href="" class="button">View all users</a><br>
                <a href="" class="button">Add user</a><br>
                <a href="" class="button">Add to show</a><br>
                <a href="" class="button">Remove from show</a><br>
                
            </form>
        </div>
    </div>
    



</body>
</html>