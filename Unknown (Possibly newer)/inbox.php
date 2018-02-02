<?php

require "essentials.php";

title("Inbox");
require "head.php";
require "nav.php";
bodystart();
head("Inbox");

dbconnect();

if(isset($_GET['act'])) {
	$id=filter($_GET['id']);
	$query="delete from messages where message_id='".$id."';";
	$res=mysql_query($query);

	if($res==TRUE) {
		general ("Message Deleted!");
		pagebutton("OK","inbox.php");
		exit();
	}else{ 
		general("Could not be deleted.");
		pagebutton("OK","inbox.php");
		exit();
	}
}

pagebutton("New Message","messages.php");
pagebutton("Sent","sent.php");
general("");
$query="select * from messages where messageto='".$shopname."' order by message_id desc;";
$res=mysql_query($query);

echo "<table style='width:100%'>";
echo "<tr><th>From</th><th>Message</th><th>Date</th><th>Action</th></tr>";
while($row=mysql_fetch_assoc($res)) {
	echo "<tr><td>".$row['messagefrom']."</td><td>".$row['message']." </td><td> ".$row['time']."</td>";
	echo "<td><a href='inbox.php?act=del&&id=".$row['message_id']."'>Delete</a> | ";

	echo "<a href='messages.php?rep=".$row['messagefrom']."'>Reply</a></td></tr>";
}
echo "</table>";
general("");
bodyend();
require "footer.php";

?>