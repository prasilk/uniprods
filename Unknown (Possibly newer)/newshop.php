<?php

require "essentials.php";

title("New Shop");
require "head.php";
require "nav.php";
bodystart();
head("New Shop");

formstart("process.php?node=newshop");

	//shop name
	general("New Shop name (5-50 chars, no spaces)");
	if(isset($_SESSION["tempshopname"])) {
		$tempshopname=$_SESSION["tempshopname"];
		echo "<input type='text' name='shopname' id='inputbox' value='$tempshopname' autofocus='autofocus' >";
	}else{
	ftext("shopname","inputbox","5-25 characters","0","1");
	}
	//about shop
	general("<br>Describe your shop:");
	if(isset($_SESSION["tempshopdesc"])) {
		$tempshopdesc=$_SESSION["tempshopdesc"];
		echo "<textarea name='shopdesc' id='flong'>".$tempshopdesc."</textarea>";
	}else {
	flong("shopdesc");
}
	//password
	general("<br>Give a password: ");
	if(isset($_SESSION["tempshoppass"])) {
		$tempshoppass=$_SESSION["tempshoppass"];
		echo "<input type='password' name='signuppass' id='inputbox' value='$tempshoppass' >";
	}else{
	fpass("signuppass");
}

	//re-enter password
	general("<br>Re-enter the password: ");
	if(isset($_SESSION["tempshoppass"])) {
		$tempshoppass=$_SESSION["tempshoppass"];
		echo "<input type='password' name='signuppassv' id='inputbox' value='$tempshoppass' >";
	}else{
	fpass("signuppassv");
}

	fsubmit("Create");
	
formend();

bodyend();
require "footer.php";

?>