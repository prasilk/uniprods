<?php

require "essentials.php";

title("Market");
require "head.php";
require "nav.php";
bodystart();

dbconnect();

$market=$_GET['market'];

?>

<div id='marketlabeldiv'><a href='explore.php?anc=<?php echo $market ?>' id='pagebutton' style='padding:17px 10px;margin-top:0px;float:left;'>< back</a><text id='marketname'><?php echo $market ?></text></div>

<div id="shopleftboxmarket"><center><br>
	<a href="post.php" id="pagebutton">Follow</a> <br><br>
	<a href="post.php" id="pagebutton">Information</a> <br>

<?php
dbconnect();
?>
</center>
</div>
<div id="itemsgrid">
<?php

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

//pagination
if(isset($_GET['page'])) {
	$page=$_GET['page'];
	$page=filter($page);
}else{
	$page=1;
}

$show=20; $recpos=($page-1)*$show;

extractall($marketlist);
$combined=substr($combined,6,strlen($combined));
$tempcomb=$combined;
$combined=$combined." order by item_id desc limit $recpos,$show";
$res=mysql_query($combined);

while($row=mysql_fetch_assoc($res)) {
	$item_id=$row['item_id'];
	$imagelink=$row['imagelink'];

	echo "<a href='view.php?id=".$item_id."' style='text-decoration:none;'>";
	echo "<div id='itembox'>";
	echo "<img src='itemspics/thumb/".$imagelink."' id='itemthumb'>";
		echo "<text id='itemprice'>Rs. ".$row['item_price']."</text>";
	echo "<div id='itemnamebox'>".$row['item_name']."</div>";
	echo "</a></div>";
}


echo "<div id='pagination'>";
$rescomb=mysql_query($tempcomb);
$totalrowscomb=mysql_num_rows($rescomb);
$totalrows=mysql_num_rows($res);
if($recpos<=$totalrowscomb+$show) {
	$linkpage=$page+1;
echo "<a href='market.php?market=$market&&nav=1&&page=$linkpage' id='pagebuttongeneral'>Next Page</a> ";
}else{
	echo "<text id='pagebuttoninactive'>Next Page</text>";
}

$temppage=0;
if($page!='1') {
$temppage=$page-1;
echo " <a href='market.php?market=$market&&nav=1&&page=$temppage' id='pagebuttongeneral'>Previous Page</a>";
}else {
	echo "<text id='pagebuttoninactive'>Previous Page</text>";
}

$pages=$totalrowscomb/$show;
if (strpos($pages,".")!==false) {
        $pages=$pages+1;
    }
$pages=intval($pages);

if($page!='1') {
	echo " <a href='market.php?market=$market&&nav=1&&page=1' id='pagebuttongeneral'>First Page</a>";
} else {
	echo "<text id='pagebuttoninactive'>First Page</text>";
}
echo "<text style='float:right'>Page $page of ".$pages."</text></div></div>";
bodyend();
require "footer.php";

?>