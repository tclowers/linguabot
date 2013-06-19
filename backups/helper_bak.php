<?php
//defined('_JEXEC') or die('Direct Access to this location is not allowed.');



function checkLang($wordText) {

	// check the word to see which language it's in
	if (preg_match("/[a-zA-Z]/", $wordText)) { //latin chars so it's probably english or pinyin
		//if there's spaces we're dealing with multiple words in the string
		if (preg_match('/\s/', $wordText)) {
			$pieces = explode(" ", $wordText);

		//no spaces, just one word
		} else {
			//first check for numbered pinyin
			if (checkNumPin($wordText)) {

				return "np";

			//next check word length
			} else {


			//next check with regular expressions
		

				return "en";

			}//if checkNumPin

		}//if spaces


		// old default
	//	return "en";


	} else { // it's chinese
		return "zh";
	} //end if

	// I really like this but I can't get it to work, investigate later
	//if (preg_match('/[\x{4e00}-\x{9fa5}]+.*\-/u', $wordText)) {

} // end checkLang

function checkNumPin($wordText) {
	if (preg_match("/[a-zA-Z][1-4]$/", $wordText)) {
		return 1;
	}
} //end checkNumPin

//check for consonant clusters
function checkCons($wordText) {
	if (preg_match("/[a-zA-Z]/", $wordText)) {
		return 1;
	} else {
		return 0;
	}
} //end checkCons

function printLang($lang) {
	if ($lang == "en") {
		return "English";
	} elseif ($lang =="zh") {
		return "Chinese";
	}
} //end printLang

function oppositeLang($lang) {
	if ($lang == "en") {
		return "Chinese";
	} elseif ($lang =="zh") {
		return "English";
	}
} //end oppositeLang

function oppositeShort($lang) {
	if ($lang == "en") {
		return "zh";
	} elseif ($lang =="np") {
		return "en";
	} elseif ($lang =="zh") {
		return "en";
	}
} //end oppositeShort

function getEntries($word,$language) {

	//how many results do we want each time?
	$dbLimit = 100;

	// Connect to Database
	$con = mysql_connect("localhost","cedicU","letter");
	if (!$con)
	  {
	  die('Could not connect: ' . mysql_error());
	  }

	mysql_select_db("ceDic", $con);

	//make sure we're using unicode
	$unicode_query1 = mysql_query("set names utf8");
	$unicode_query2 = mysql_query("SET CHARACTER SET utf8");


	if ($language == "en") { //if it's english
		//$queryStr = "SELECT z.simpHan, z.zh_id, z.pinyin_tone FROM zhText z, enText e WHERE e.zh_id=z.zh_id AND e.definition='" . $word . "' ORDER BY z.frequency";

		if (preg_match('/\s/', $word)) {
			//for strings that have spaces in them use this
			$queryLogic = "e.definition LIKE '%" . $word . "%' ORDER BY LENGTH(e.definition), z.frequency DESC";


			//$queryStr = "SELECT z.simpHan, z.zh_id, z.pinyin_tone, e.definition FROM zhText z, enText e, enPronun p WHERE e.zh_id=z.zh_id AND e.en_id=p.en_id AND e.definition LIKE '%" . $word . "%' ORDER BY LENGTH(e.definition), z.frequency DESC limit " . $dbLimit;
		} else {
			// use this query for single words
			$queryLogic = "e.definition REGEXP '[[:<:]]" . $word . "[[:>:]]' ORDER BY LENGTH(e.definition), z.frequency DESC";

			//$queryStr = "SELECT z.simpHan, z.zh_id, z.pinyin_tone, e.definition FROM zhText z, enText e, enPronun p WHERE e.zh_id=z.zh_id AND e.en_id=p.en_id AND e.definition REGEXP '[[:<:]]" . $word . "[[:>:]]' ORDER BY LENGTH(e.definition), z.frequency DESC limit " . $dbLimit;
		}

		/*
		$transLang = "Chinese";
		//variables for the database return vals
		$row1 = "simpHan";
		$row2 = "pinyin_tone";
		$row3 = "definition";
		$rowID = "zh_id";
		*/

	} elseif ($language == "np") { //if it's numbered pinyin

		$queryLogic = "z.pinyin_num LIKE '%" . $word . "%' ORDER BY LENGTH(z.simpHan), e.frequency DESC";

		/*
		$queryStr = "SELECT e.definition, e.en_id, p.pronunIPA, z.zh_id, z.pinyin_tone, z.simpHan FROM zhText z, enText e, enPronun p WHERE e.zh_id=z.zh_id AND p.en_id=e.en_id AND z.pinyin_num LIKE '%" . $word . "%' ORDER BY LENGTH(z.simpHan), e.frequency DESC limit " . $dbLimit;

		$transLang = "English";
		//variables for the database return vals
		$row1 = "definition";
		$row2 = "pronunIPA";
		$row3 = "simpHan";
		$rowID = "en_id";
		*/
		
	} elseif ($language == "zh") { //if it's chinese
		//$queryStr = "SELECT e.definition, e.en_id, p.pronunIPA FROM zhText z, enText e, enPronun p WHERE e.zh_id=z.zh_id AND p.en_id=e.en_id AND z.simpHan='" . $word . "' ORDER BY e.frequency";

		$queryLogic = "z.simpHan LIKE '%" . $word . "%' ORDER BY LENGTH(z.simpHan), e.frequency DESC";

		/*
		$queryStr = "SELECT e.definition, e.en_id, p.pronunIPA, z.simpHan FROM zhText z, enText e, enPronun p WHERE e.zh_id=z.zh_id AND p.en_id=e.en_id AND z.simpHan LIKE '%" . $word . "%' ORDER BY LENGTH(z.simpHan), e.frequency DESC";

		$transLang = "English";
		//variables for the database return vals
		$row1 = "definition";
		$row2 = "pronunIPA";
		$row3 = "simpHan";
		$rowID = "en_id";
		*/
	} //end if

	// logic: e.definition LIKE '%" . $word . "%' ORDER BY LENGTH(e.definition), z.frequency DESC


	///// Build Query String //////
	//always grab the same values, but use different logic depending on the language entered into search
	$queryStr = "SELECT z.simpHan, z.zh_id, z.pinyin_tone, e.definition, e.en_id, p.pronunIPA FROM zhText z, enText e, enPronun p WHERE e.zh_id=z.zh_id AND e.en_id=p.en_id AND " . $queryLogic . " LIMIT " . $dbLimit;

	//debug
	echo "queryStr: " . $queryStr . "<br />\n";

	$targetLang = oppositeShort($language);

	//query DB with pre-generated string
	$result = mysql_query($queryStr);

	//later use this w/ joomla's database classes
	// --this way we can do all the html in the other php file and only do data access here
	//$con->setQuery($queryStr);
	//$items = ($items = $con->loadObjectList())?$items:array();

	$countRows = 0; //nothing to see here

	while ($row = mysql_fetch_array($result)) {

		$countRows++; //just changing the colors of the rows

		if ($odd = $countRows%2) {
			echo "<table bgcolor='#eeeeee'>\n";
		} else {
			echo "<table bgcolor='#ffffff'>\n";
		}

		echo "<tr>\n";

		echo "<td width=175><a href=\"wordDisplay.php?wId=" . $row['zh_id'] . "&targetLang=zh\">" . $row['simpHan'] . "</a></td>\n";
		echo "<td width=175>[" . $row['pinyin_tone'] . "]</td>\n";
		echo "<td width=175><a href=\"wordDisplay.php?wId=" . $row['en_id'] . "&targetLang=en\">" . $row['definition'] . "</a></td>\n";
		echo "<td width=175>" . $row['pronunIPA'] . "</td>\n";
		
		/* old:
		echo "<td width=175><a href=\"wordDisplay.php?wId=" . $row[$rowID] . "&targetLang=" . $targetLang . "\">" . $row[$row1] . "</a></td>\n";
		echo "<td width=175>[" . $row[$row2] . "]</td>\n";
		echo "<td width=300>" . $row[$row3] . "</td>\n";
		*/

		echo "</tr>\n";
		echo "</table>\n";

		//echo "<a href=\"wordDisplay.php?wId=" . $row[$rowID] . "&targetLang=" . $targetLang . "\">" . $row[$row1] . "</a>		[" . $row[$row2] . "]		" . $row[$row3] . "<br />";

	  //echo "English: " . $row['definition'] . "  [" . $row['pronunIPA'] . "]<br />";
	  //echo "  Chinese: " . $row['simpHan'] . " " . $row['pinyin_tone'];
	  //echo "<br /><br />";

	} // end while row=

	mysql_close($con);


} //end getEntries


function getEnWordDat($idNum) {
	// Connect to Database
	$con = mysql_connect("localhost","cedicU","letter");
	if (!$con)
	  {
	  die('Could not connect: ' . mysql_error());
	  }

	mysql_select_db("ceDic", $con);

	//make sure we're using unicode
	$unicode_query1 = mysql_query("set names utf8");
	$unicode_query2 = mysql_query("SET CHARACTER SET utf8");

	//which kind of word are we looking at?
	//if ($language == "en") { //if it's english
		$queryStr = "SELECT z.simpHan, z.pinyin_tone, e.definition, p.pronunIPA FROM zhText z, enText e, enPronun p WHERE z.zh_id=e.zh_id AND e.en_id=p.en_id AND e.en_id='" . $idNum . "' ORDER BY z.frequency";


	//} elseif ($language == "zh") { //if it's chinese
	//	$queryStr = "SELECT z.simpHan, z.tradHan, z.pinyin_tone, z.hskLevel, e.definition, e.frontNote, e.backNote, e.frequency FROM zhText z, enText e WHERE z.zh_id=e.zh_id AND z.zh_id='" . $idNum . "' ORDER BY e.frequency";

	//} //end if

	//query DB with pre-generated string
	$result = mysql_query($queryStr);

	$firstResult = 0;

	while ($row = mysql_fetch_array($result)) {

		//get some info on the first run through the loop
		if ($firstResult == 0) {
			$enText = $row['definition'];
			$enPro = $row['pronunIPA'];

			echo "<h2>" . $enText . "</h2>  /" . $enPro . "/<br /><br />";
			echo "definitions:<br />";

			$firstResult++;
		}

		echo $row['simpHan'] . " [" . $row['pinyin_tone'] . "]<br />";

	  //echo "English: " . $row['definition'] . "  [" . $row['pronunIPA'] . "]<br />";
	  //echo "  Chinese: " . $row['simpHan'] . " " . $row['pinyin_tone'];
	  //echo "<br /><br />";
	}

	mysql_close($con);

} //end getEnWordDat




function getZhWordDat($idNum) {
	// Connect to Database
	$con = mysql_connect("localhost","cedicU","letter");
	if (!$con)
	  {
	  die('Could not connect: ' . mysql_error());
	  }

	mysql_select_db("ceDic", $con);

	//make sure we're using unicode
	$unicode_query1 = mysql_query("set names utf8");
	$unicode_query2 = mysql_query("SET CHARACTER SET utf8");

	$queryStr = "SELECT z.simpHan, z.tradHan, z.pinyin_tone, z.hskLevel, e.definition, e.frontNote, e.backNote, e.partSpeech FROM zhText z, enText e WHERE z.zh_id=e.zh_id AND z.zh_id='" . $idNum . "' ORDER BY e.frequency";

	//query DB with pre-generated string
	$result = mysql_query($queryStr);

	$firstResult = 0;

	while ($row = mysql_fetch_array($result)) {

		//get some info on the first run through the loop
		if ($firstResult == 0) {

			echo "<h2>" . $row['simpHan'] . "</h2>  [" . $row['pinyin_tone'] . "]<br />";
			echo "(" . $row['tradHan'] . ")<br />";

			if ($row['hskLevel']) {
				echo "HSK Level: " . $row['hskLevel'] . "<br/>";
			}

			echo "<br />";

			echo "definitions:<br />";

			$firstResult++;
		}


		//build a text string combining the notes with the main definition data
		$defString = '';

		if ($row['frontNote']) {
			$defString .= "(" . $row['frontNote'] . ") ";
		}

		//add "to" to the beginning of verbs
		if (($row['partSpeech']) && ($row['partSpeech'] == 1)) {
			$defString .= "to ";
		}

		$defString .= $row['definition'];

		if ($row['backNote']) {
			$defString .= " (" . $row['backNote'] . ")";
		}

		echo $defString . "<br />";

	}



	mysql_close($con);

} //end getZhWordDat

?>

