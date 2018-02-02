<?php

require "essentials.php";

title("Settings");
require "head.php";
require "nav.php";
bodystart();	
head("Shop Settings");
general("<br><hr><center>General</center><hr>");
general("Shop Description");
flong("Desc");
fsubmit("Update Description");

general("<br><hr><center>Privacy</center><hr>");

general("Old password");
fpass("oldpass");
general("<br>New password");
fpass("newpass");
general("<br>Re-enter new password");
fpass("newpassconf");
fsubmit("Change Password");

general("<br><hr><center>Shop</center><hr>");

pagebutton("Delete Shop Permanently","delshop.php");

bodyend();
require "footer.php";

?>