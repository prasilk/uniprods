<?php

require "essentials.php";

title("Edit Item");
require "head.php";
require "nav.php";
bodystart();
head("Edit");
dbconnect();
$id=$_GET['id'];
$id=filter($id);

$query="select * from items where item_id='$id'";
$res=mysql_query($query);

while($row=mysql_fetch_assoc($res)) {
	$itemid=$row['item_id'];
	$itemname=$row['item_name'];
	$itemprice=$row['item_price'];
	$itemdesc=$row['item_desc'];
	$itemmarket=$row['item_market'];
	$imagelink=$row['imagelink'];
}

formstart("process.php?node=edit&&itemid=$itemid");

general("Name");
echo "<input type='text' name='itemname' id='inputbox' autocomplete='off' value='$itemname'>";

general("<br>Description");
echo "<textarea name='item_description' id='flong'>$itemdesc</textarea>";

general("<br>Price (Rs.)");
echo "<input type='text' name='itemprice' id='inputbox' autocomplete='off' value='$itemprice'>";


general("<br>Market");
echo "<input type='text' name='market' id='inputbox' autocomplete='off' value='$itemmarket'>";

?>

<div id="postrightbox">
	Image
	<input type="file" name="image" id="pagebutton" accept="image/*" onchange="loadFile(event)">
<?php
	echo "<img src='itemspics/thumb/".$imagelink."' style='margin-top:20px' id='disp'/>";
?>
<img id="previewimage"/>
</div>

<script>
  var loadFile = function(event) {
  	var element =  document.getElementById('disp');
if (typeof(element) != 'undefined' && element != null)
{
  var image_x = document.getElementById('disp');
image_x.parentNode.removeChild(disp);
}
  	
    var output = document.getElementById('previewimage');
    output.src = URL.createObjectURL(event.target.files[0]);
  };
</script>
<br><br><br>
<input type="submit" value="Save Changes" id="pagebutton">
<a href='view.php?id=<?php echo $itemid;?>' id='pagebutton'>Cancel</a>
<?php



bodyend();
require "footer.php";

?>