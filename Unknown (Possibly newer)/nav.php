<div id='navlong'><div id='main'>
<div id="nav">
<div id="navbuttonholder"><text id='navlogo'>SpiderNav&trade;</text>	
<?php

//create the array if empty
if (empty($_SESSION['pageurls'])) {
    $_SESSION['pageurls'] = array_fill(0,8,'');
}

$url =$_SERVER['PHP_SELF']."?".$_SERVER["QUERY_STRING"] ;

function trackPage($url) {
    array_unshift($_SESSION['pageurls'],$url);
    array_pop($_SESSION['pageurls']);
}

$checkfornav=substr($url,strlen($url)-5,5);

    	  $value1=substr($url,10,strlen($url));
    	  $dotpos1=strpos($value1,".");
    	  $disp1=substr($value1,0,$dotpos1);


foreach( $_SESSION['pageurls'] as $keyx => $valuex) {
          $valuex=substr($valuex,10,strlen($valuex));
          $dotposx=strpos($valuex,".");
          $dispx=substr($valuex,0,$dotposx);
          if (($dispx==$disp1)&&($checkfornav!="nav=1")) {
                $checkfornav="nav=1";
                $_SESSION['pageurls'][$keyx]=$url;
          }
          if ($disp1=="process") {
            $checkfornav="nav=1";
          }

          if ($disp1=="login") {
            $checkfornav="nav=1";
          }

          if ($disp1=="newshop") {
            $checkfornav="nav=1";
          }

          if ($disp1=="advanced_search") {
            $checkfornav="nav=1";
          }
}


 if($checkfornav!="nav=1") {
            trackpage($url);
        }

//print_r(array_values($_SESSION['pageurls']));
foreach( $_SESSION['pageurls'] as $key => $value )
    {	
    	  global $skip;
    	  $value=substr($value,10,strlen($value));
    	  $dotpos=strpos($value,".");
    	  $disp=substr($value,0,$dotpos);
    	  if (($disp==$disp1)AND($disp!="")) {
    	  	echo "<text id='navbuttoncurrent'>".$disp."</text>";
    	  }elseif($disp!=""){
    	  	echo "<a href='".$value."&&nav=1' id='navbutton'>".$disp."</a>";   
    	  }
    }
?>
</div>
</div>