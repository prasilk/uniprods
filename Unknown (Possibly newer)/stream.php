<?php

require "essentials.php";

title("Stream");
require "head.php";
require "nav.php";
bodystart();
dbconnect();

$query="select following from followtable where followedby='".$shopname."';";
$res=mysql_query($query);


$combined="";
while($row=mysql_fetch_assoc($res)) {
	$extracted=$row['following'];
	$combined=$combined."UNION select * from items where item_shop='".$extracted."' ";
}

if(isset($_GET['sorttype'])) {

	$sorttype=$_GET['sorttype'];
	$sorttype=filter($sorttype);
	$sortin=$_GET['sortin'];
	$sortin=filter($sortin);

	if($sorttype=="Date posted") {
		$type="item_id";
	}elseif ($sorttype=="Product Price") {
		$type="item_price";
	}elseif ($sorttype=="Popularity") {
		$type="item_views";
	}

	if($sortin=="Ascending - Low to High") {
		$in="asc";
	}else {
		$in="desc";
	}
}

$combined=substr($combined,6,strlen($combined));

if(isset($type)) {
	$combined=$combined." order by ".$type." ".$in.";";
}else {
	$combined=$combined." order by item_id desc;";
}

$resdisp=mysql_query($combined);

if($resdisp==FALSE) {
	general("Nothing to show.");
	general("Find your favourite shop, and click follow to start following. <br>");
	pagebutton("Explore","explore.php");
	bodyend();
	exit();
}

head("Products from shops you're following");
echo "<div id='streambar'>
		<form action='stream.php' method='GET' enctype='multipart/form-data'>
		Sort by <select name='sorttype' id='sortlist'>";

	if(isset($type)) {
		$show=$sorttype;
	}else{
		$show="Default";
	}

	echo" 
		<option>".$show."</option>
		<option>Date posted</option>
		<option>Product Price</option>
		<option>Popularity</option>
	</select>
	order of <select name='sortin' id='sortlist'>";

	if(isset($type)) {
		$showo=$sortin;
	}else {
		$showo="Default";
	}

	echo "
		<option>".$showo."</option>
		<option>Descending - High to Low</option>
		<option>Ascending - Low to High</option>
	</select>
	| Defaults : Date in Descending
	<input type='submit' id='sortbutton' value='SORT'>
	</div>";
echo "	<div id='streambox'>";
while($row=mysql_fetch_assoc($resdisp)) {
	$item_id=$row['item_id'];
	$imagelink=$row['imagelink'];

	echo "<a href='view.php?id=".$item_id."' style='text-decoration:none;'>";
	echo "<div id='itembox'>";
	echo "<img src='itemspics/thumb/".$imagelink."' id='itemthumb'>";
		echo "<text id='itemprice'>Rs. ".$row['item_price']."</text>";
	echo "<div id='itemnamebox'>".$row['item_name']."</div>";
	echo "</a></div>";
}

echo "<div id='itembox'>";
echo "<img src='itemspics/thumb/endlogo.png' id='itemthumb'>";
echo "</div></div>";

bodyend();
require "footer.php";

?>