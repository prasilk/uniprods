
<script>
function autoRefresh_div()
{
      $("#user_notifications").load("notifs.php");// a function which will load data from other file after x seconds
  }
 
  setInterval('autoRefresh_div()', 5000); // refresh div after 5 secs
 </script>

<?php

require "essentials.php";
if (isset($_GET['action'])) {
	$action=$_GET['action'];
	if($action=="logout") {
		session_unset();
		session_destroy();
		?>
		<script type="text/javascript">
					alert('You have been logged out successfully.');
		</script>
		<?php
	}
}
title("Universal Products - Home");
require "head.php";
require "nav.php";
bodystart();
$logged=0;
if (isset($_SESSION["shopname"])) {
	$logged=1;
}

if ($logged==0) {
	head("Welcome");
}else {
	$shopname=$_SESSION["shopname"];
}

if ($logged==0) {
general("
Universal Products is a crowd sourced marketplace where you can buy stuffs from the people around you. Start by creating an account.
");
	pagebutton("Create a new shop","newshop.php");
	general("Or,");
}

echo "	<div id='homeiconswrapper'>";
echo "<a href='conv.php'id='pagebutton'>Conversations</a>";

echo "<a href='explore.php' id='pagebutton'>Explore</a>";

echo "<a href='stream.php' id='pagebutton'>Stream</a>";

echo "<a href='watching.php' id='pagebutton'>Watching</a>";

echo "</div>";

bodyend();
?>