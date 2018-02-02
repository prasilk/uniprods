<?php

require "essentials.php";

title("Explore");
require "head.php";
require "nav.php";
bodystart();
dbconnect();

echo "<div id='marketcontainer'>";

//check if default or tailed
if(isset($_GET['anc'])) {
	$anc=$_GET['anc'];
}else{
	$anc="/";
}

//action for watchlist
if(isset($_GET['act'])) {
	$action=$_GET['act'];
	if ($action=="watch") {
		$querycheck="select * from watchlist where watchwho='$anc' and watchby='$shopname'";
		$rescheck=mysql_query($querycheck);
		$skip=0;
		if(mysql_num_rows($rescheck)>0) {
			$skip=1;
		}

		if($skip==0) {
			$querywatch="insert into watchlist  (watchwho,watchby) values ('$anc','$shopname');";
			$res=mysql_query($querywatch);
			$querykarma="update market set karma=karma+1 where market_name='$anc'";
			$reskarma=mysql_query($querykarma);
		}
	}
	else {
		$querywatch="delete from watchlist where watchwho='".$anc."' AND watchby='".$shopname."';";
		$res=mysql_query($querywatch);
		$querykarma="update market set karma=karma-1 where market_name='$anc'";
		$reskarma=mysql_query($querykarma);
	}
}

//check watch
	$querywatch="select * from watchlist where watchby='".$shopname."' AND watchwho='".$anc."';";
	$reswatch=mysql_query($querywatch);
	$rows=mysql_num_rows($reswatch);

	if ($rows>0) {
		$watching=1;   //logged shop is foll curr shop
	}else {
		$watching=0; //not following
	}

echo "<text id='exploretitle'><center>".$anc."</center></text><br>";

echo " <a href='newmarket.php?anc=".$anc."' id='pagebutton' style='float:right;margin-right:-20px;'>New Market</a>";

//get the ancestor of current;
$queryback="select * from market where market_name='".$anc."';";
$resback=mysql_query($queryback);

while($rowback=mysql_fetch_assoc($resback)) {
	$ancforback=$rowback['market_anc'];
}
echo "<a href='explore.php?anc=".$ancforback."' id='pagebutton' style='margin-left:-7px'>< Back</a> ";

if ($watching==0) {
echo "<a href='explore.php?anc=".$anc."&&act=watch'id='pagebutton' style='margin-left:5px'>Add ".$anc." to watchlist</a>";
}else {
	echo"<a href='explore.php?anc=".$anc."&&act=unwatch' id='pagebuttondamped'>Watching ".$anc."</a>";
}

echo "<a href='market.php?market=".$anc."' id='pagebutton' style='float:right;margin-right:5px;'> View All </a></text><br><br>";

/////////////////////////////////////////////////// MARKET PREVIEW
echo "<div id='sneakpreview'>";
$market=$_GET['anc'];
$query1="select market_name,links from market";
$res1=mysql_query($query1);

$marketlist="";

while($row1=mysql_fetch_assoc($res1)) {
	$curr=$row1['links'];
	$find=",".$market;
	if (stripos($curr,$find) !== false) {
    	$marketlist=$marketlist.$row1['market_name'].",";
	}
}

$toextract="";

//tree transversal to retrieve all nodes from the current market
function getnextmarket($current) {
	
	global $marketlist;
	global $toextract;
	global $combined;

	$pos=strpos($current,",");
	if ($pos==FALSE) {
		return 1;
	}
	$toextract=substr($current,0,$pos);

	$marketlist=substr($current,$pos+1,strlen($current));
	return $toextract;
}

$combined="";

function extractall($current) {
	global $marketlist;
	global $toextract;
	global $combined;

	$toextractnew=getnextmarket($marketlist);

	if(strlen($toextractnew)>3) {
		//echo $toextractnew;
		$combined=$combined."UNION select * from items where item_market='".$toextractnew."' ";
		extractall($marketlist);
	}
}

extractall($marketlist);
$combined=substr($combined,6,strlen($combined));
$combined=$combined." order by item_id desc LIMIT 9;";

$res=mysql_query($combined);
if (mysql_num_rows($res)==0) {
	?><script>
	var elem = document.getElementById("sneakpreview");
elem.parentNode.removeChild(elem);
	</script>
	<?php
}else {
while($row=mysql_fetch_assoc($res)) {
	$item_id=$row['item_id'];
	$imagelink=$row['imagelink'];
	echo "<div id='itemboxpreview'>";
	echo "<img src='itemspics/thumb/".$imagelink."' id='itemthumbpreview'>";
	echo "</div>";
}
}

////////////////////////////////////////////////
echo "</div>"; //sneak preview
echo "<div id='belowpreview'><br>";
echo "<div id='marketinfo'>";	
$querymarket="select * from market where market_name='$anc'";
$resmarket=mysql_query($querymarket);
while($rowmarket=mysql_fetch_assoc($resmarket)) {
	$marketdesc=$rowmarket['market_desc'];
	$karma=$rowmarket['karma'];
}

echo "Market Description : ".$marketdesc;
echo "Karma : ".$karma;

echo "</div>";
echo "<br><center style='margin-left:-600px'>Popular Child-Markets : </center>";
echo "<div id='submarket'>";
$query="select * from market where market_anc='".$anc."' order by karma desc;";
$res=mysql_query($query);

if($res==FALSE) {
	exit("Empty");
}
	general("");

	$count=2;
while($row=mysql_fetch_assoc($res)) {
	if($count%2 == 0) {
	echo "<div id='marketlisteven'>";
	$marketname=$row['market_name'];
	$explorelink="explore.php?anc=".$marketname;
	echo "<img src='icons/dna.png' width=5%>";
	marketbutton($marketname,$explorelink);
	echo "<text id='marketdesc'>".$row['market_desc']." | ".$row['karma']."</text>";
	$count++;
	general("");
	echo "</div>";
	}else {
		echo "<div id='marketlistodd'>";
	$marketname=$row['market_name'];
	$explorelink="explore.php?anc=".$marketname;
	marketbutton($marketname,$explorelink);
	echo "<text id='marketdesc'>".$row['market_desc']." | ".$row['karma']."</text>";
	$count++;
	general("");
	echo "</div>";
	}
}

echo "</div></div>";

general("");
echo "</div></div>";
include 'footer.php';
?>
