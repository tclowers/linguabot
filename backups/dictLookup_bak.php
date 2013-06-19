<html>
<head>
<meta http-equiv="Content-type" value="text/html; charset=utf-8">
<title> LinguaBot C-E Dictionary Lookup </title>
</head>
<body>
<?php

//debug
//echo "sql query: select Word.WordText, Pronun.PronunIPA from Word right join Pronun on Word.W_Id = Pronun.W_Id where Word.WordText='" . $_POST["word"] . "';";
//echo "<br />";

// Grab Post data
$word = $_POST["word"];

// Connect to Database
$con = mysql_connect("localhost","cedicU","letter");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("ceDic", $con);

$unicode_query1 = mysql_query("set names utf8");

$unicode_query2 = mysql_query("SET CHARACTER SET utf8");



//check the word entered to see if it's in chinese
// I really like this but I can't get it to work, investigate later
//if (preg_match('/[\x{4e00}-\x{9fa5}]+.*\-/u', $word)) {
//////////////////////

// check the word to see which language it's in
if (preg_match("/[a-zA-Z]/", $word)) { //it's probably english or pinyin
	$queryStr = "SELECT z.simpHan, z.pinyin_tone, e.definition, p.pronunIPA FROM zhText z, enText e, enPronun p WHERE e.zh_id=z.zh_id AND p.en_id=e.en_id AND e.definition='" . $word . "'";
} else { // it's chinese
	$queryStr = "SELECT z.simpHan, z.pinyin_tone, e.definition, p.pronunIPA FROM zhText z, enText e, enPronun p WHERE e.zh_id=z.zh_id AND p.en_id=e.en_id AND z.simpHan='" . $word . "'";
}

//$queryStr = "SELECT z.simpHan, z.pinyin_tone, e.definition, p.pronunIPA FROM zhText z, enText e, enPronun p WHERE e.zh_id=z.zh_id AND p.en_id=e.en_id AND e.definition='" . $word . "'";


//query DB for English word
//$result = mysql_query("SELECT z.simpHan, z.pinyin_tone, e.definition, p.pronunIPA FROM zhText z, enText e, enPronun p WHERE e.zh_id=z.zh_id AND p.en_id=e.en_id AND e.definition='" . $word . "';");

//query DB with pre-generated string
$result = mysql_query($queryStr);


//$result = mysql_query("select Word.WordText, Pronun.PronunIPA from Word right join Pronun on Word.W_Id = Pronun.W_Id where Word.WordText='" . $_POST["word"] . "';");

if (!$result)
  {
  die('query error: ' . mysql_error());
  }


//debug
//echo "queryStr: " . $queryStr . "<br />";


//get data and print
while ($row = mysql_fetch_array($result))
  {
  //echo "doing something"; //debug stuff
  //echo "<br />";

  echo "English: " . $row['definition'] . "  [" . $row['pronunIPA'] . "]<br />";
  echo "  Chinese: " . $row['simpHan'] . " " . $row['pinyin_tone'];
  echo "<br /><br />";
  }

mysql_close($con);

//echo "Also, word postdata: " . $_POST["word"];
?>
<form action="dictLookup.php" method="post">
Word: <input type="text" name="word" />
<input type="submit" />
</form>
</body>
</html>
