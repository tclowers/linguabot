<?php
//here's the html to open the page and header section along with the general header stuff
require("htmlHeaders.html");

//and the jQuery stuff for the lookup bar
require("lookupScript.html");

//and the sound manager 2 stuff
require("sm2.html");

//here's the html to close the headers, open the body and layout the top half of the page
require("layoutTop.html");

require("helper.php");

// Grab Post data
$wId = $_GET["wId"];
$lang = $_GET["targetLang"];

if ($lang == "en") {
	getEnWordDat($wId);
} elseif ($lang == "zh") {
	getZhWordDat($wId);
}

//here's the html for the bottom half of the layout and to close the body and the html
require("layoutBottom.html");

?>
