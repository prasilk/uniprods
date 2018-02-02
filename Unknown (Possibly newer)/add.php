<?php

require "essentials.php";

title("Add item - Universal Products");
require "head.php";
require "nav.php";
bodystart();
head("Add a Product");
dbconnect();

$querywatch="select * from watchlist where watchby='$shopname'";
$reswatch=mysql_query($querywatch);
if(mysql_num_rows($reswatch)==0) {
    echo "<h4>You do not have any market on your watchlist right now. You need to have at least 1 market on your watchlist to link an item to the market and make it visible.<br><br>
	
	To get started, click explore below and add your favourite markets to your watchlist. </h4>"; 
    pagebutton("Explore","explore.php");
    exit();
}

formstart("process.php?node=additem");

general("Name");
echo "<input type='text' name='itemname' id='inputbox' autofocus='autofocus' autocomplete='off' required>";


general("<br>Description");
echo "<textarea name='item_description' id='flong' required></textarea>";

general("<br>Price (Rs.)");
echo "<input type='text' name='itemprice' id='inputboxprice' autocomplete='off' required>";

general("<br>Market");
//ftext("market","inputbox","","0","1");

dbconnect();
$querysel="select * from watchlist where watchby='$shopname'";
$ressel=mysql_query($querysel);
echo "<select name='market' style='margin-top:5px;font-size:16px;width:200px;float:left;margin-left:100px;border:none;padding:4px;border:1px solid grey;border-radius:4px;color:#383838;outline:none;'>";
while($rowsel=mysql_fetch_assoc($ressel)) {
    $op=$rowsel['watchwho'];
    echo "<option value='".$op."'>".$op."</option>";
}
echo "</select>";
?>
<div id="postrightbox">Image (required)<br><br>
	<input type="file" name="image" id="pagebutton" accept="image/*" onchange="loadFile(event)" required>
<img id="previewimage" src='icons/cardboard.jpg'/>
</div>


<script>
  var loadFile = function(event) {
    var output = document.getElementById('previewimage');
    output.src = URL.createObjectURL(event.target.files[0]);
  };
</script>
<?php

fsubmit("Add");

formend();

?>
<br>
<div id='notice_post'>
	<li>Added item will be visible on the selected Market and its parent Markets.
	<li>Once sold, please remove the item from your shop's shelf. All items are only manually deleted. 
	<li>Refain from posting spams, promotions or inappropriate content. Follow community guidelines.
</div>
</body>	
<script>
	
$(document).ready(function(){


    $('#inputboxprice').keyup(function(event){
      // skip for arrow keys
      if(event.which >= 37 && event.which <= 40){
          event.preventDefault();
      }
      var $this = $(this);
      var num = $this.val().replace(/,/gi, "").split("").reverse().join("");

      var num2 = RemoveRougeChar(num.replace(/(.{3})/g,"$1,").split("").reverse().join(""));

      // the following line has been simplified. Revision history contains original.
      $this.val(num2);});});

    function RemoveRougeChar(convertString){


    if(convertString.substring(0,1) == ","){

        return convertString.substring(1, convertString.length)            

    }
    return convertString;

}
</script>
