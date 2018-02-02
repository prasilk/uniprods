<?php

require "essentials.php";

title("New Market");
require "head.php";
require "nav.php";
bodystart();


if(isset($_GET['anc'])) {
	$anc=$_GET['anc'];
}else {
	$anc="/";
}

head("New Market under $anc");

if(isset($_GET['action'])) {
	dbconnect();
	$marketname=filter($_POST['marketname']);
	$marketname=strtolower($marketname);
	$ancestor=filter($_POST['ancestor']);
	$ancestor=strtolower($ancestor);
	$marketdesc=filter($_POST['marketdesc']);
	
	$query1="select links from market where market_name='".$ancestor."';";
	$res1=mysql_query($query1);

	while($row1=mysql_fetch_assoc($res1)) {
		$links=$row1['links'];
	}

	$newlink=$links.",".$marketname;

	$query="insert into market(market_name,market_anc, market_desc,links) values ('$marketname','$ancestor','$marketdesc','$newlink')";
	$res=mysql_query($query);
	
	general("Market Created!");
	pagebutton("Return","explore.php?anc=$ancestor");
	return 1;

}
formstart("newmarket.php?anc=$anc&&action=create");
	general("Market name");
	ftext("marketname","inputbox","no spaces","1","0");
		
	general("<br>Market Description");
	flong("marketdesc");

	echo "<input type='hidden' name='ancestor' value='".$anc."'>";
	
	echo "<br><br><br><input type='submit' id='pagebutton' value='Create'>";
	echo " <a href='explore.php?anc=".$anc."' id='pagebutton'>Cancel</a>";
formend();

bodyend();
require "footer.php";

?>