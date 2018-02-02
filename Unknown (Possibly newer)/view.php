<?php

require "essentials.php";

title("View");
require "head.php";
require "nav.php";
bodystart();

$item_id=$_GET['id'];
dbconnect();

//delete
if(isset($_GET['action'])) {
	$id=$_GET['id'];
	$query="delete from items where item_id='".$id."';";
	$res=mysql_query($query);
	general ("Deleted Successfully!");
	pagebutton ("OK","shop.php");
	exit();
}

dbconnect();

//main left window
echo "<div id='viewleft'>";

	$query="select * from items where item_id='".$item_id."';";
	$res=mysql_query($query);
	while($row=mysql_fetch_assoc($res)) {
		$itemid=$row['item_id'];
		$itemshop=$row['item_shop'];
		$itemname=$row['item_name'];
		$itemdesc=$row['item_desc'];
		$itemprice=$row['item_price'];
		$market=$row['item_market'];
		$date=$row['item_date'];
		$imagelink=$row['imagelink'];

		echo "<text id='viewname'>".$itemname."</text>";

		$pricewords=convert_number_to_words($itemprice);
		$pricewords=$pricewords." rupees";
		$itemprice=number_format($itemprice);
		echo "<br><text id='viewprice' title='".$pricewords."'>Rs. ".$itemprice."</text>";
		$date=date("F jS, h:m a", strtotime($date));
		echo "<text id='viewdate'>Added on ".$date."</text>";
	
		if(strlen($itemdesc)<400) {
			echo "<div id='viewdescshort'>";
		}else {
			echo "<div id='viewdesclong'>";
		}
			echo $itemdesc;
			echo "</div>"; //viewdesc
	
		echo "<div id='buyrow'>";
			echo "<a href='messages.php?rep=$itemshop&&act=buy%%item=$itemid' id='buybutton'>Request Buy</a>";
			
		echo "</div>";

		echo "<div id='morebox'>";

			pagebuttonview ("Back","shop.php");
			$long="view.php?action=delete&&id=".$item_id;
			?>
			<a href="view.php?action=delete&&id=<?php echo $item_id ?>" id="pagebuttonview" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
			<?php
			pagebuttonview ("Edit","edit.php?id=$itemid");
			echo "<a href='market.php?market=".$market."' id='pagebuttonview' style='float:right;margin-right:0px'>Market : ".$market."</a>";
	echo "</div>";
		
	echo "</div>";

	echo "<div id='imageviewdiv'><img src='itemspics/thumb/".$imagelink."' id='imageview'>
			<a href='itemspics/".$imagelink."' target='_blank' style='text-decoration:none;margin-top:5px;float:left;margin-left:60px'>view full-size</a>
		</div>";
	
	echo "</div>";
}


bodyend();
require "footer.php";

?>