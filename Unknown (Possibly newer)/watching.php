<?php

require "essentials.php";

title("Watching");
require "head.php";
require "nav.php";
bodystart();
head("Market Watchlist");
dbconnect();
$query="select distinct watchwho from watchlist where watchby='".$shopname."';";
$res=mysql_query($query);

while($row=mysql_fetch_assoc($res)) {
	pagebutton($row['watchwho'],"market.php?market=".$row['watchwho']);
}

bodyend();
require "footer.php";

?>