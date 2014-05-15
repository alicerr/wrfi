<?php
function  remove_show_user($show_name, $user_id){
    $query = "DELETE FROM show_user WHERE show_name = '$show_name' && user_id =$user_id ";
    feedback_op(query($query, false), "user removed from show", "user not removed from show");
}
function disable_user($user_id){
    $query = "UPDATE user SET level_id = 0 WHERE user_id =$user_id ";
    feedback_op(query($query, false), "user disabled", "user not disabled");
}
function enable_user($user_id){
    $query = "UPDATE user SET level_id = 1 WHERE user_id =$user_id ";
    feedback_op(query($query, false), "user enabled", "user not enabled");
}
function delete_set($set_id){
    $query = "DELETE FROM sets WHERE set_id = $set_id ";
    feedback_op(query($query, false), "set deleted", "set not deleted");
}
function delete_track($start){
    $query = "DELETE FROM track_played WHERE start = '$start' ";
    feedback_op(query($query, false), "track deleted", "track not deleted");
}
?>