<?php

require "essentials.php";

title("Advanced Search");
require "head.php";
require "nav.php";
bodystart();
head("Spider Search (Advanced Mode)");
general("Name contains: (use comma ',' to sepearate keywords)");
flong("name");

general("<br>Description Contains: (use comma ',' to seperate keywords)");
flong("desc");

general("<br>Price range: (Rs.)");	
echo "<input type='text' id='inputboxprice' name='minprice' placeholder='Min'> to <input type='text' id='inputboxprice' name='minprice' placeholder='Max'>";

general("<br>Min Karma of shop:");
echo "<input type='text' id='inputboxprice' name='minprice' placeholder='Karma' value='1'>";

echo "<br><br><input type='checkbox' style='margin-left:0;padding-top:10px;float:left'> Limit Search to the markets I'm watching ";

fsubmit("Search");

echo "<br><text style='color:grey'>PowerSearch_v4, FilterText_v1 | Threads : 10 | Max CPU : 20%</text>";

bodyend();
require "footer.php";

?>