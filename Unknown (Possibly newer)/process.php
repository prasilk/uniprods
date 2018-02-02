<?php

require "essentials.php";

title("Process");
require "head.php";
require "nav.php";
bodystart();
head(":: Process ::");

$node=$_GET['node'];

if($node=='edit') {
	$itemid=$_GET['itemid'];
	//check if the item belongs to the user
	dbconnect();
	$querycheck="select * from items where item_id='$itemid'";
	$rescheck=mysql_query($querycheck);
	while($rowcheck=mysql_fetch_assoc($rescheck)) {
		$itemshop=$rowcheck['item_shop'];
		if($shopname!=$itemshop) {
			echo "<br><br>The item you're trying to edit does not belong to you.<br><br>";
			pagebutton("Back","view.php?id=$itemid");
			exit();
		}
	}

	$itemname=$_POST['itemname'];
	$itemname=filter($itemname);

	$itemdesc=$_POST['item_description'];
	$itemdesc=filter($itemdesc);

	$itemprice=$_POST['itemprice'];
	$itemprice=filter($itemprice);

	$market=$_POST['market'];
	$market=filter($market);

	$image_name=$_FILES['image']['name'];

	///////////////////////////////////////////////

	$location='itemspics/';
		$location_thumb='itemspics/thumb/';

		if ($image_name!=NULL) {

			//delete old image
			$querydel="select * from items where item_id='$itemid'";
			$resdel=mysql_query($querydel);

			while($rowdel=mysql_fetch_assoc($resdel)) {
				$imagelinkori=$rowdel['imagelink'];
			}
			$unlk1="itemspics/".$imagelinkori;
			$unlk2="itemspics/thumb/".$imagelinkori;
			unlink($unlk1);
			unlink($unlk2);


			$extension= strtolower(substr($image_name,strpos($image_name,'.')+1));
			$tmp_name=$_FILES['image']['tmp_name'];
			$rand_name=(rand(1000,9999999999999)).".".$extension;

			$ok=move_uploaded_file($tmp_name,$location.$rand_name);
	
			$file = "itemspics/".$rand_name;
			$newfile = "itemspics/thumb/".$rand_name;
			copy($file, $newfile);
	
			function resize_crop_image($max_width, $max_height, $source_file, $dst_dir, $quality = 80)  {
	                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     
				$imgsize = getimagesize( $source_file);
				$width = $imgsize[0];
				$height = $imgsize[1];
				$mime = $imgsize['mime'];

				switch($mime) {
					case 'image/gif':
						$image_create = "imagecreatefromgif";
						$image = "imagegif";
					break;

					case 'image/png':
						$image_create = "imagecreatefrompng";
						$image = "imagepng";
						$quality = 7;
					break;

					case 'image/jpeg':
						$image_create = "imagecreatefromjpeg";
						$image = "imagejpeg";
						$quality = 80;
					break;

					default:
						return false;
					break;
				}
	
			$dst_img = imagecreatetruecolor($max_width, $max_height);
			$src_img = $image_create($source_file);
	
			$width_new = $height * $max_width / $max_height;
			$height_new = $width * $max_height / $max_width;
			//if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
			if($width_new > $width){
				//cut point by height
				$h_point = (($height - $height_new) / 2);
				//copy image
				imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
			}else{
				//cut point by width
				$w_point = (($width - $width_new) / 2);
				imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
			}
	
			$image($dst_img, $dst_dir, $quality);

			if($dst_img)imagedestroy($dst_img);
	
			if($src_img)imagedestroy($src_img);
		}
	
	resize_crop_image(200, 200, $newfile, $newfile);


	///////////////////////////////////////////////

	$query="update items set item_name='$itemname', item_price='$itemprice', item_desc='$itemdesc', item_market='$market',imagelink='$rand_name' where item_id='$itemid'";
	$res=mysql_query($query);
}

	if($image_name==NULL) {
		$query="update items set item_name='$itemname', item_price='$itemprice', item_desc='$itemdesc', item_market='$market' where item_id='$itemid'";
	$res=mysql_query($query);
	}
	echo "<br><br>Edited Successfully!<br><br>";
	pagebutton("View","view.php?id=$itemid");
	exit();
}

if($node=='login') {
	general("Log for Login:");
	
	$shopname=filter($_POST['sname']);
	$password=filter($_POST['password']);
	$shopname=strtolower($shopname);
	
	dbconnect();
	$skip=0;
	
	if(($shopname=="")||($password=="")) {
		general("Error - One or more fields left empty");
		$skip=1;
	}
	
	$query="select * from shops where shop_name='".$shopname."'";
	$res=mysql_query($query);
	
	if(($res==FALSE)&&($skip==0)) {
		general("Shop does not exist");
		$skip=1;
	}
	
	$success=0;
	
	if($skip==0) {
		while ($row=mysql_fetch_assoc($res)) {
			$passwordact=$row['shop_password'];
	
				if($password==$passwordact) {
				$success=1;
			}
		}
	}
	
	if($success==1) {
		general("Logged in successfully.");
		$_SESSION["shopname"]=$shopname;
		?>
		<script>
		window.setTimeout(function(){ window.location = "index.php"; },1000);
		</script>
		<?php
	}elseif($skip==0) {
		general("Wrong Password!");
		pagebutton("Try again","login.php");
	}else {
		pagebutton("Try again","login.php");
	}
}

if($node=='newshop') {
	general("Log for New Shop : ");
	

	$shopname=filter($_POST['shopname']);
	$shopname=strtolower($shopname);
	$shopdesc=filter($_POST['shopdesc']);
	$signuppass=filter($_POST['signuppass']);
	$signuppassv=filter($_POST['signuppassv']);
	
	dbconnect();
	
	$flag=iserrornewshop($shopname,$shopdesc,$signuppass,$signuppassv);
	
	if($flag==0) {
		$query="insert into shops(shop_name,shop_desc,shop_password) values ('$shopname','$shopdesc','$signuppass')";
		$res=mysql_query($query);
	
		general("Shop Created!");
		pagebutton("View","#");
		
		$_SESSION["shopname"]=$shopname;
		?>
		<script>
		window.setTimeout(function(){ window.location = "index.php"; },1000);
		</script>
		<?php
	}else {
		$_SESSION["tempshopdesc"]=$shopdesc;
		
		$_SESSION["tempshopname"]=$shopname;
		
		pagebutton("Retry","newshop.php");
	}	
}	
	
if($node=='additem') {

		general("Log for Add : ");
		$image_name=$_FILES['image']['name'];
		$itemname=filter($_POST['itemname']);
		$itemdesc=filter($_POST['item_description']);
		$itemprice=filter($_POST['itemprice']);
		$market=filter($_POST['market']);
		$market=strtolower($market);
		$date=date("Y-m-d h:i:sa");
		$shopadding=$shopname;
		
		dbconnect();
		
		$location='itemspics/';
		$location_thumb='itemspics/thumb/';

		if ($image_name!=NULL) {
			$extension= strtolower(substr($image_name,strpos($image_name,'.')+1));
			$tmp_name=$_FILES['image']['tmp_name'];
			$rand_name=(rand(1000,9999999999999)).".".$extension;

			$ok=move_uploaded_file($tmp_name,$location.$rand_name);
	
			$file = "itemspics/".$rand_name;
			$newfile = "itemspics/thumb/".$rand_name;
			copy($file, $newfile);
	
			function resize_crop_image($max_width, $max_height, $source_file, $dst_dir, $quality = 80)  {
	                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     
				$imgsize = getimagesize( $source_file);
				$width = $imgsize[0];
				$height = $imgsize[1];
				$mime = $imgsize['mime'];

				switch($mime) {
					case 'image/gif':
						$image_create = "imagecreatefromgif";
						$image = "imagegif";
					break;

					case 'image/png':
						$image_create = "imagecreatefrompng";
						$image = "imagepng";
						$quality = 7;
					break;

					case 'image/jpeg':
						$image_create = "imagecreatefromjpeg";
						$image = "imagejpeg";
						$quality = 80;
					break;

					default:
						return false;
					break;
				}
	
			$dst_img = imagecreatetruecolor($max_width, $max_height);
			$src_img = $image_create($source_file);
	
			$width_new = $height * $max_width / $max_height;
			$height_new = $width * $max_height / $max_width;
			//if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
			if($width_new > $width){
				//cut point by height
				$h_point = (($height - $height_new) / 2);
				//copy image
				imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
			}else{
				//cut point by width
				$w_point = (($width - $width_new) / 2);
				imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
			}
	
			$image($dst_img, $dst_dir, $quality);

			if($dst_img)imagedestroy($dst_img);
	
			if($src_img)imagedestroy($src_img);
		}
	
	resize_crop_image(200, 200, $newfile, $newfile);

	$query="insert into items(item_name,item_price,item_desc,item_date, item_market, item_shop,imagelink) values ('$itemname','$itemprice','$itemdesc','$date','$market','$shopadding','$rand_name')";

}//end if iamge size is not null

if ($image_name==NULL) {
	$query="insert into items(item_name,item_price,item_desc,item_date, item_market, item_shop) values ('$itemname','$itemprice','$itemdesc','$date','$market','$shopadding')";	
}		
		
		$res=mysql_query($query);
		
		general("Item Added!");
		
		pagebutton("OK", "shop.php");
}

bodyend();
require "footer.php";
