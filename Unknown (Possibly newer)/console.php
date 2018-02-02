<?php

require "essentials.php";

title("Spider Terminal");
require "head.php";
require "nav.php";
bodystart();

$show="";
$found=0;

if(isset($_POST['command'])) {
	$command=$_POST['command'];
	$command=filter($command);
	$command=strtolower($command);
	$pos=stripos($command," ");
	if($pos>3) {
	$cmd=substr($command, 0,$pos);
	$parameter=substr($command,$pos,strlen($command));
	}else {
		$cmd=$command;
		$parameter="";
	}

	if ($cmd=="load") {
		if(strlen($parameter<3)) {
			$show="load: Choose a module to load <br>Or type [<i>load show</i>] to view available modules.";
		}

		if($parameter==" show") {
			$show="Available modules for <i>load</i>: <br><br>nlp - Natural Language Processor [caution : conflicting arguments] <br>dbt - Database Power Toolset <br>efx - User Interface Control Panel [caution : highly unstable] <br><br> * loading multiple modules can slow down the session<br>* close loaded module with <i>unld [module]</i> or <i>unld all</i>";
		}
		$found=1;

		if($parameter==" nlp") {
			$show="loading [100%] <br>Done! <br><br>nlp is loaded into the memory.";
		}
		$found=1;
	}

	if ($cmd=="clrs") {
		$show="";
		$found=1;
	}

	if ($cmd=="help") {
		$show="Available commands: <br><br>load [module] - Load a module | <i>load show</i> to view all available modules <br> unld [module] - Unload a module | <i>unld all</i> to unload all loaded modules <br>lgin [shopname] [password] - to login to your shop <br>lout - logout and exit <br>clrs - clear screen <br>exit - close <br><br>* all commands are case-insensitive";

		$found=1;
	}

	if ($cmd=="") {
		$show="";
		$found=1;
	}

	if ($cmd=="exit") {
		$show="closing Terminal..";
		$found=1;
		?>
		<script>
		window.setTimeout(function(){ window.location = "index.php"; },1000);
		</script>
		<?php
	}

	if($found==0) {
	$show=$cmd.": Command not found.";
	}
}
?>

<div id='console_maindisp'>
	<div id='console_output'>
	<?php formstart("console.php"); ?>
	<?php 
	echo "&nbsp;||&nbsp;   || &nbsp;&nbsp;&nbsp;Spider WebBuilder v1.03<br>";
	echo "&nbsp;\\\()//&nbsp;&nbsp;&nbsp; <text style='color:yellow'>Compiled date:</text> 19/1/2017 20:41 GMT<br>";
	echo "//(__)\\\&nbsp;&nbsp;&nbsp;Developed by Prasil Koirala [prasilkoirala@hotmail.com]<br>";
	echo "||&nbsp;&nbsp;&nbsp;    ||&nbsp;&nbsp;&nbsp;Type <i>help</i> for command list<br>";


	?>
	<br><?php echo $shopname ?>@spider:~ # <input type='text' id='console_input' autofocus='autofocus' name='command' autocomplete='off' spellcheck=false >
	<?php echo "<text id='output_console'>".$show."<br><br>:: END ::</text>"; ?>
	<br><br>
	</div>
</div>

<?php
formend();
bodyend();
require "footer.php";

?>