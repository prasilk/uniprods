<?php session_start(); ?>
<link rel="stylesheet" type="text/css" href="uniprods.css">
<?php

//page title
function title($title) {
	echo "<title>".$title."</title>";
}

//page head
function head($head) {
	echo "<text id='style_header'>".$head."</text><br>";
}

//start and end body
function bodystart() {
	echo "<div id='mainbody'>";
}

function bodyend() {
	echo "</div>";
}

function pagebutton($name,$link) {
	echo "<br><a href='".$link."' id='pagebutton'>".$name."</a><br>";
}

function pagebuttongeneral($name,$link) {
	echo "<a href='".$link."' id='pagebuttongeneral'>".$name."</a>&nbsp;";
}

function pagebuttonview($name,$link) {
	echo "<a href='".$link."' id='pagebuttonview'>".$name."</a>&nbsp;";
}


function marketbutton($name,$link) {
	echo "<a href='".$link."' id='marketbutton'>".$name."</a>";
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

//form actions
function formstart($target) {
	echo "<form action='".$target."' method='POST' enctype='multipart/form-data'>";
}

function formend() {
	echo "</form>";
}

function ftext($name,$id,$placeholder,$autof,$autoc) {
	if($autof==1) {
		$extra1=" autofocus='autofocus'";
	}else {
		$extra1="";
	}
	if ($autoc==0) {
		$extra2=" autocomplete='off'";
	}else {
		$extra2="";
	}
	echo "<input type='text' name='".$name."' id='".$id."' placeholder='".$placeholder."'".$extra1.$extra2." required>";
}

function fpass($name) {
	echo "<input type='password' name='".$name."' id='inputbox' required>";
}

function flong($text) {
	echo "<textarea name='".$text."' id='flong'></textarea>";
}

function fsubmit($name) {
	echo "<br><br><br><input type='submit' value='".$name."' id='pagebuttonview'><br>";
}

function general($text) {
	echo "<br>".$text."<br>";
}

function filter($text) {
	$text=mysql_real_escape_string($text);
	$text=strip_tags($text);
	return $text;
}

///////////////// DATABASE FUNCTIONS

function dbconnect() {
	$connection=mysql_connect("localhost","root","");
	$selection=mysql_select_db("uniprods");
}

function iserrornewshop($shopname,$shopdesc,$password,$retrypassword) {
	//checking if empty
	if(($shopname=="")||($shopdesc=="")||($password=="")||($retrypassword=="")) {
		general("Error - One or more fields left empty");
		
		return 1;
	}

	if(strlen($shopname<5)) {
		general("Shop name must have at least 5 letters.");
		return 1;
	}

	if(strlen($password<5)) {
		general("Password must be at least 5 characters long.");
		return 1;
	}

	dbconnect();
	$query="select * from shops where shop_name='$shopname'";
	$res=mysql_query($query);

	if(mysql_num_rows($res)>0) {
		general("Shop '$shopname' already exists. Please choose another name.<br>");
		$_SESSION["tempshoppass"]=$password;
		return 1;
	}
	
	//checking if passwords match
	if($password!=$retrypassword) {
		general("Error - Passwords do not match");
		return 1;
	}
	
	//checking if the shop already exists
}

function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}