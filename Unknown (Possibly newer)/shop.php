<?php

require "essentials.php";

title("Your Shop");
require "head.php";
require "nav.php";
bodystart();

?>

<?php
dbconnect();

	if(isset($_GET['shopname'])) {
		$shopnamecurrent=$_GET['shopname'];
	}else {
		$shopnamecurrent=$shopname;
	}

	if(isset($_GET['act'])) {
		$action=$_GET['act'];
		if($action=="follow") {
			$querycheck="select * from followtable where followedby='$shopname' and following='$shopnamecurrent'";
			$rescheck=mysql_query($querycheck);
			$skip=0;
			if(mysql_num_rows($rescheck)>0) {
				$skip=1;
			}

			if($skip==0) {
				$query2="insert into followtable (followedby,following) values ('$shopname','$shopnamecurrent')";
				$res2=mysql_query($query2);
			}
		}
		if($action=="unfollow") {
			$query2="delete from followtable where followedby='".$shopname."' AND following='".$shopnamecurrent."';";
			$res2=mysql_query($query2);
		}
	}

	//check follow
	$queryfollow="select * from followtable where followedby='".$shopname."' AND following='".$shopnamecurrent."';";
	$resfollow=mysql_query($queryfollow);
	$rows=mysql_num_rows($resfollow);

	if ($rows>0) {
		$follows=1;   //logged shop is foll curr shop
	}else {
		$follows=0; //not following
	}

	$query1="select * from shops where shop_name='".$shopnamecurrent."';";
	$res1=mysql_query($query1);

	while($row1=mysql_fetch_assoc($res1)) {
		$shopdesc=$row1['shop_desc'];
	}

?>
<div id="shopleftbox"><center>
	<?php if($shopname==$shopnamecurrent) { ?><br>
	<a href="add.php" id="pagebuttonlogin">Add</a> <br><br>
	<a href="settings.php" id="pagebuttonlogin">Settings</a> <br><br> 
	<a href="index.php?action=logout" id="pagebuttonlogin">Logout</a> <br>


	<?php
	}
	echo "<br>"; 
	if($shopname!=$shopnamecurrent) {
	if ($follows==0) {
	echo "<a href='shop.php?shopname=".$shopnamecurrent."&&act=follow' id='pagebutton'>Follow</a><br><br>";
	 }
	 else {
	 	echo "<a href='shop.php?shopname=".$shopnamecurrent."&&act=unfollow' id='pagebuttondamped'>Following</a><br><br>";
	 }
?>
	<a href="messages.php?rep=<?php echo $shopnamecurrent ?>" id="pagebutton">Message</a> <br><br>
	<a href="post.php" id="pagebutton">Information</a> <br><br><?php } ?><hr>	<?php echo $shopdesc ?>

</center>
</div>
<div id="itemsgrid">
<?php
dbconnect();

$query="select * from items where item_shop='".$shopnamecurrent."' order by item_id desc;";
$res=mysql_query($query);

while($row=mysql_fetch_assoc($res)) {
	$item_id=$row['item_id'];
	$imagelink=$row['imagelink'];
	echo "<a href='view.php?id=".$item_id."' style='text-decoration:none'>";
	echo "<div id='itembox'>";
	echo "<img src='itemspics/thumb/".$imagelink."' id='itemthumb'>";
	echo "<text id='itemprice'>Rs. ".$row['item_price']."</text>";
	echo "<div id='itemnamebox'>".$row['item_name']."</div>";
	echo "</a></div>";
}

echo "</div>";

bodyend();
require "footer.php";

?>