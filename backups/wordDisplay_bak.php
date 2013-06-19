<html>
<head>
<meta http-equiv="Content-type" value="text/html; charset=utf-8">
<link rel="shortcut icon" href="favicon.ico">
<title> LinguaBot C-E Dictionary Lookup </title>
<link rel="stylesheet" type="text/css" href="lbot.css" />
</head>
<body>
<div id="lpad"> </div>
<?php
//logo and nav bar
require($DOCUMENT_ROOT . "navHeader.html");
?>
<div id="content">
<form action="dictLookup.php" method="get">
Word: <input type="text" name="word" />
<input type="submit" />
</form>
<?php
require("helper.php");

// Grab Post data
$wId = $_GET["wId"];
$lang = $_GET["targetLang"];

if ($lang == "en") {
	getEnWordDat($wId);
} elseif ($lang == "zh") {
	getZhWordDat($wId);
}

?>
</div>
<div id="rpad"> </div>
</body>
</html>
