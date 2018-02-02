<?php
error_reporting(E_ALL ^ E_DEPRECATED); ini_set('display_errors', '1');
date_default_timezone_set('Asia/Calcutta');
?>
<!--
script to hide the get parameters in url

<script>    
    if(typeof window.history.pushState == 'function') {
        window.history.pushState({}, "Hide", '<?php echo $_SERVER['PHP_SELF'];?>');
    }
</script>
-->	
<?php
 //stuffs for search only

$urlsearch =$_SERVER['PHP_SELF']."?".$_SERVER["QUERY_STRING"];
$valuesearch=substr($urlsearch,10,strlen($urlsearch));
$dotpossearch=strpos($valuesearch,".");
$dispsearch=substr($valuesearch,0,$dotpossearch);

?>
<script>
function autoRefresh_div()
{
      $("#user_notifications").load("notifs.php");// a function which will load data from other file after x seconds
  }
 
  setInterval('autoRefresh_div()', 5000); // refresh div after 5 secs
 </script>
<script src='jquery.js'></script>
<div id="headlong"><div id="main">
	<div id="headwrapper"> 
		<a href="index.php" style="text-decoration:none;"><div id="leftbox">
			<text id="mainlogo" title="Universal Products Home"><center>UniProds</center></text>
		</div></a>
		<div id="centerbox">
			<form action="search.php" method='POST' enctype='multipart/form-data'>
			<input type="text" name="search_keyword" id="searchbox" placeholder="Search for Products, Markets and Shops"<?php if($dispsearch=='search'){echo " autofocus='autofocus'";}?> autocomplete="off" spellcheck=false>
			</form>
		</div>
		<div id="rightbox">
			<?php 
			if (isset($_SESSION["shopname"])) {
				$shopname=$_SESSION["shopname"];
				echo "<div id='notification_toggle'><img src='icons/notifications.png' id='notifications' style='height:20px;cursor: pointer' title='Notifications'>";
								dbconnect();
					$querynotify="select * from notifications where shop='$shopname' order by notification_id desc";
		$resnotify=mysql_query($querynotify);
		$noti_num=mysql_num_rows($resnotify);

		echo "<div id='notification_numbers'>".$noti_num."</div>";



				echo "</div><a href='shop.php'><div id='yourshop'>".$shopname."</div></a>";


				echo "<div id='notifications_panel'>";
		echo "<div id='user_notifications'>";


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
			?>
			
			<?php
			echo "</div></div></a>";
		}

	  echo "</div></div>";
			}else { ?>
			<a href="login.php" id="mainlogoright">Login</a>
		</div>
			<?php } ?>
		</div>
		
	</div>
</div>
<?php
dbconnect();

?>

<script>
$(document).ready(function() {
    $('#notification_toggle').click(function() {
		$("#notification_toggle").toggleClass("active");
  $('#notifications_panel').fadeToggle(0,function() {
  	
  });
});
})

$(document).click(function(){
  $("#notification_toggle").removeClass("active");
  $("#notifications_panel").hide();
});

$("#notification_toggle,#notifications_panel").click(function(e){
  e.stopPropagation();
});

</script>