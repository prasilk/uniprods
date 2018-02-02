<?php
require 'essentials.php';

dbconnect();

if (isset($_POST['action'])) {
    $notification_id=$_POST['action'];
    $query_del_notification="delete from notifications where notification_id='$notification_id';";
    $res_del_notification=mysql_query($query_del_notification) or die(mysql_error());
    exit;
}
?>