
<div id='console_maindisp'>
	<div id='console_output'>
	<?php formstart("console.php"); ?>
	<?php 
	echo "&nbsp;||&nbsp;   || &nbsp;&nbsp;&nbsp;Spider WebBuilder v1.03<br>";
	echo "&nbsp;\\\()//&nbsp;&nbsp;&nbsp; <text style='color:yellow'>Compiled date:</text> 19/1/2017 20:41 GMT<br>";
	echo "//(__)\\\&nbsp;&nbsp;&nbsp;Developed by Prasil Koirala [prasilkoirala@hotmail.com]<br>";
	echo "||&nbsp;&nbsp;&nbsp;    ||&nbsp;&nbsp;&nbsp;Type <i>help</i> for command list<br>";


	?>
	<br><?php echo $shopname ?>@spider_dev:~ # <input type='text' id='console_input' autofocus='autofocus' name='command' autocomplete='off'>

	<?php 
		echo "////////// NLP MODULE LOADED //////////<br><br>";
		echo "<text id='output_console'>".$show."<br><br>:: END ::</text>"; ?>
	<br><br>
	</div>
</div>

<?php
formend();
bodyend();
require "footer.php";
exit();
?>

?>