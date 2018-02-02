<?php

require "essentials.php";

title("Sent");
require "head.php";
require "nav.php";
bodystart();
head("Sent");

dbconnect();

if(isset($_GET['act'])) {
	$id=filter($_GET['id']);
	$query="delete from messages where message_id='".$id."';";
	$res=mysql_query($query);

	if($res==TRUE) {
		general ("Message Deleted!");
		pagebutton("OK","sent.php");
		exit();
	}else{ 
		general("Could not be deleted.");
		pagebutton("OK","sent.php");
		exit();
	}
}

pagebutton("New Message","messages.php");
pagebutton("inbox","inbox.php");
general("");
$query="select * from messages where messagefrom='".$shopname."' order by message_id desc;";
$res=mysql_query($query);

echo "<table style='width:100%'>";
echo "<tr><th>To</th><th>Message</th><th>Date</th><th>Action</th></tr>";
while($row=mysql_fetch_assoc($res)) {
	echo "<tr><td>".$row['messageto']."</td><td>".$row['message']." </td><td> ".$row['time']."</td>";
	echo "<td><a href='inbox.php?act=del&&id=".$row['message_id']."'>Delete</a> | ";

	echo "<a href='messages.php?rep=".$row['messagefrom']."'>Resend</a></td></tr>";
}
echo "</table>";
general("");
bodyend();
require "footer.php";

?>