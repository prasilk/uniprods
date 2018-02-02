<?php

require "essentials.php";

title("Login");
require "head.php";
require "nav.php";
bodystart();
head("Login");

echo "<div id='loginbox'><center>";
formstart("process.php?node=login");
	general("Shop name");
	echo "<input type='text' id='inputboxlogin' name='sname' autofocus='autofocus' required>";
	
	general("<br>Password");
	echo "<input type='password' id='inputboxlogin' name='password' required>";
	
	echo "<br><br><input type='submit' id='pagebuttonlogin' value='Login'>";
	echo "<div id='loginfooter'>";
		echo "<br><hr style='border:none;height:2px'><a href='forgotpassword.php' id='pagebuttonlogin' style='float:left;margin-left:10px;margin-top:5px;'>Forgot Password</a>";
		echo "<a href='newshop.php' id='pagebuttonlogin' style='float:right;margin-right:10px;margin-top:5px;'>Create new Shop</a>";
formend();
echo "</center></div>";

bodyend();
?>