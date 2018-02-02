<?php

require "essentials.php";
require "head.php";
require "nav.php";
dbconnect();

if(isset($_POST['text'])) {
	$text=$_POST['text'];
	$link=$_POST['link'];
	$date=date("Y-m-d H:i:s");

	$query="insert into notifications (noti_text,noti_link,shop,date) values ('$text','$link','$shopname','$date')";
	$res=mysql_query($query);

	echo "<br>Done!</br>";
	pagebutton("Again","ntest.php");
	exit();
}

title("Notification  gmp_testbit(a, index)");

bodystart();
head("Notification Test");

formstart("ntest.php?a=add");
general("Notification text");
ftext("text","inputbox","","1","0");

general("<br>Link it to page");
ftext("link","inputbox","","1","0");

fsubmit("Send");

bodyend();
require "footer.php";

?>