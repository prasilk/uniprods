<script src='jquery.js'></script>

<?php
date_default_timezone_set('Asia/Calcutta');
require 'essentials.php';
if (isset($_SESSION["shopname"])) {
				$shopname=$_SESSION["shopname"];
}
dbconnect();

		$querynotify="select * from notifications where shop='$shopname' order by notification_id desc";
		$resnotify=mysql_query($querynotify);

		while($rownotify=mysql_fetch_assoc($resnotify)) {
			$daten=$rownotify['date'];
			echo "<a href='".$rownotify['noti_link']."' style='color:black;text-decoration:none;' id='linknoti'>";
			if($rownotify['read_status']==0) {
				echo "<div class='notibox_unread'>";
			}
			else {
			echo "<div class='notibox'>";
		}
			echo $rownotify['noti_text']."<br><div id='noticontrols'><text id='notitime'>".time_elapsed_string($daten)."</text>";

			$notificationid=$rownotify['notification_id'];	
			echo "</div></div></a>";
		}
?>