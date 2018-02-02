<?php

require "essentials.php";

title("Messages");
require "head.php";
require "nav.php";
bodystart();
head("Messages");

if(isset($_POST['messageto'])) {
	$messageto=filter($_POST['messageto']);
	$messageto=strtolower($messageto);
	$message=filter($_POST['message']);
	$messagefrom=$shopname;
	$messagefrom=strtolower($messagefrom);
	$time=date("Y-m-d h:i:sa");

	dbconnect();

	$query="insert into messages (messageto,message,messagefrom,time) values ('$messageto','$message','$messagefrom','$time')";
	$res=mysql_query($query);

	if($res==TRUE) {
		general("Message Sent!");
		pagebutton("Home","inbox.php");
		exit();
	}else {
		general("Message sending failed!");
		exit();
	}
}

if (isset($_GET['rep'])) {
	$replyto=$_GET['rep'];
}else {
	$replyto="";
}

formstart("messages.php");

general("<b>Request buy from $replyto</b>");
echo "<input type='hidden' name='messageto' id='inputbox' value='".$replyto."''>";

if(isset($_GET['act'])) {
	$id=$_GET['item'];
	dbconnect();
	$querym="select * from items where item_id='".$id."';";
	$resm=mysql_query($querym);
	while($rowm=mysql_fetch_assoc($resm)) {
		$itemname=$rowm['item_name'];
	}
	$buymessage="Hi. I would like to buy '".$itemname."' from your shop. Could you help me with it.";
}else {
	$buymessage="";
}

general("<br>Message");
echo "<textarea name='message' id='flong'>".$buymessage."</textarea>";

fsubmit("Send");
if(isset($id)) {
pagebutton("Cancel","view.php?id=$id");
}
formend();

bodyend();
require "footer.php";

?>