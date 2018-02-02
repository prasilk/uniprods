<?php
require 'essentials.php';
require 'head.php';
dbconnect();
$value=$_POST['val'];
$value=filter($value);
$sql = "update shops set scratchpad='$value' where shop_name='$shopname'";

$res=mysql_query($sql);

echo "Added.";
?>
