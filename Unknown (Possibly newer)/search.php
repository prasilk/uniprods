<?php

require "essentials.php";

title("Search Results");
require "head.php";
require "nav.php";
bodystart();
dbconnect();
if((isset($_POST['search_keyword']))||(isset($_SESSION["keyword"]))) {
	if(isset($_POST['search_keyword'])) {
	$keyword=$_POST['search_keyword'];
	$keyword=filter($keyword);
	$keyword=preg_replace('/[^ A-Za-z0-9\-]/', '', $keyword);
	}else {
		$keyword=$_SESSION["keyword"];
	}
	if(strlen($keyword)<1) {
		general("Type the keyword and press enter to search.");
		exit();
	}
	$_SESSION["keyword"]=$keyword;
}else{
	general("TType the keyword and press enter to search.");
	exit();
}

if(isset($keyword)) {
	head("Showing results for '$keyword'");
	echo "<br>";
}else {
	head("Search Results");
}

$query="select * from items where item_name like '%".$keyword."%';";
$res=mysql_query($query);

	if(mysql_num_rows($res)<1) { ?>
	<?php
	general("No results found.");
	exit();
}

while($row=mysql_fetch_assoc($res)) {
	$item_id=$row['item_id'];
	$imagelink=$row['imagelink'];

	echo "<a href='view.php?id=".$item_id."'>";
	echo "<div id='itembox'>";
	echo "<img src='itemspics/thumb/".$imagelink."' id='itemthumb'>";
		echo "<text id='itemprice'>".$row['item_price']."</text>";
	echo "<div id='itemnamebox'>".$row['item_name']."</div>";
	echo "</a></div>";
}

bodyend();


require "footer.php";

?>