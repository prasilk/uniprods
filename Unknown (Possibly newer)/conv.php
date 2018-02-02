<?php

require "essentials.php";

title("Conversation");
require "head.php";
require "nav.php";
bodystart();
head("Conversation");
dbconnect();

if(isset($_POST['message'])) {
	$messagefrom=$_POST['messagefrom'];
	$messagefrom=filter($messagefrom);
	$message=$_POST['message'];
	$message=filter($message);
	$time=date("Y-m-d h:i:sa");

	$query="insert into messages (messageto,message,messagefrom,time) values ('$messagefrom','$message','$shopname','$time')";
	$res=mysql_query($query);
	echo "Sent!";
	echo "<a href='conv.php?mode=view&&type=selling&&buyer=$messagefrom' id='pagebutton'>Ok</a>";
	exit();
}

if(isset($_GET['mode'])) {
	$buyer=$_GET['buyer'];
	$mode=$_GET['mode'];
	if($mode=="view") {
		$queryshow="(select * from messages where messageto='$shopname' AND messagefrom='$buyer') UNION select * from messages where messagefrom='$shopname' AND messageto='$buyer' order by message_id desc";
		$resshow=mysql_query($queryshow);

		echo "<div id='convwrapper'>";
		formstart('conv.php');
	echo "<div id='replybox'>";
	echo "<input type='text' name='message' autocomplete='off' autofocus='autofocus' id='inputboxsend'>";
	echo "<input type='hidden' name='messagefrom' value='".$buyer."'>";
	echo " <input type='submit' id='pagebutton' value='Send'>";
		echo "<a href='conv.php' id='pagebuttongeneral'><</a></div>";

	formend();

		while($rowshow=mysql_fetch_assoc($resshow)) {
			if ($rowshow['messagefrom']==$shopname) {
				echo "<div id='sentbyme'>You: ".$rowshow['message']."<text id='convtime'>".$rowshow['time']."</text></div><br>";
			}else {
			echo "<div id='sentby'>".$rowshow['messagefrom'].": ".$rowshow['message']."<text id='convtime'>".$rowshow['time']."</text></div>";
		}}
		echo "</div>";
		echo "</div><br>";
		include 'footer.php';
	exit();
}
}

$query="select distinct messagefrom from messages where messageto='$shopname'";
$res=mysql_query($query);

while($row=mysql_fetch_assoc($res)) {
	echo $row['messagefrom'];
	$querytemp="select message,time from messages where messageto='$shopname' and messagefrom='".$row['messagefrom']."' order by message_id desc limit 1";
	
	$restemp=mysql_query($querytemp);
	while($rowtemp=mysql_fetch_assoc($restemp)) {
		echo " >>> ".$rowtemp['message']." | ".$rowtemp['time']." | <a href='conv.php?mode=view&&type=selling&&buyer=".$row['messagefrom']."'>view</a><hr>";
	}
}

bodyend();
require "footer.php";

?>