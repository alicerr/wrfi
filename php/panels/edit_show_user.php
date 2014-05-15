<!--add or remove a show user affiliation-->
<form method="post">
    <?php
        if (manager())
            {
                draw_show_select();
                draw_user_select();
                echo('<input type = "submit" name = "add_show_user" value = "add privileges" /><br><br>');
                echo('<input type = "submit" name = "remove_show_user" value = "remove privileges" />');
                
            }
    ?>
</form>