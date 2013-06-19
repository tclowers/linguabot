<html>
<head>
<meta http-equiv="Content-type" value="text/html; charset=utf-8">
<link rel="shortcut icon" href="favicon.ico">
<title> LinguaBot Chinese-English Dictionary</title>
<link rel="stylesheet" type="text/css" href="lbot.css" />
<link rel="stylesheet" type="text/css" href="layout.css" />

<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

</head>
<body>
<div id="lpad"> </div>
<?php
//logo and nav bar
require($DOCUMENT_ROOT . "navHeader.html");
?>
<div id="content">
<form action="dictLookup.php" method="get">
Word: <input type="text" name="word" value="<?php echo $_GET["word"]; ?>" />
<input type="submit" />
</form>
<br />

	<div id="results">

<?php
require("helper.php");


//debug
//echo "sql query: select Word.WordText, Pronun.PronunIPA from Word right join Pronun on Word.W_Id = Pronun.W_Id where Word.WordText='" . $_POST["word"] . "';";
//echo "<br />";

// Grab Post data
$word = trim($_GET["word"]);

//debug
//echo "word: " . $word . "<br />";

//$lang = checkLang($word);

//$opposite = oppositeLang($lang);

//echo $opposite . " entries for \"" . $word . "\"<br /><br />";



//echo "Entries for \"" . $word . "\"<br /><br />\n";

getEntries($word);


//echo "Also, word postdata: " . $_POST["word"];
?>

	</div> 
</div>
<div id="rpad"> </div>
</body>
</html>
