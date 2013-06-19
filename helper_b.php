<?php
//defined('_JEXEC') or die('Direct Access to this location is not allowed.');

function checkLang($wordText) {

	// check the word to see which language it's in
	if (preg_match("/[a-zA-Z]/", $wordText)) { //latin chars so it's probably english or pinyin

		//first check for numbered pinyin
		if (checkNumPin($wordText)) {

			return "np"; //numbered pinyin

		//next check for english-only consonant usage
		} elseif (checkCons($wordText)) {

			return "en"; //english

		//next check for pinyin-only accent characters
		} elseif (checkAccChars($wordText)) {

			return "tpy"; //tone-marked pinyin

		//after all that check to see if there's any chinese-only clusters "kuai" and so on
		} elseif (checkPinCluster($wordText)) {

			return "ppy"; //plain pinyin

		// all else fails, check both, like a mixed type string
		} else {
	
			return "mx";

			//until finished use below:
			//return "en";

		}//if checkNumPin


		// old default
	//	return "en";


	} else { // it's chinese
		return "zh";
	} //end if

	// I really like this but I can't get it to work, investigate later
	//if (preg_match('/[\x{4e00}-\x{9fa5}]+.*\-/u', $wordText)) {

} // end checkLang


//check for the numbers 1-4 at the very end of a word, this will probably be numbered pinyin
function checkNumPin($wordText) {
	if (preg_match("/[a-zA-Z][1-4]$/", $wordText)) {
		return 1;
	}
} //end checkNumPin

//check for english-only consonant usage
function checkCons($wordText) {

	//first check for ending consonants besides 'n', 'ng', and 'r'
	if (preg_match("/[bcdfghjklmpqstwxyz]$/i", $wordText)) {
		//'bang' is possibly mandarin, but 'bag' is not
		if (!preg_match("/ng$/i", $wordText)) { //notice this is a negative preg_match
			return 1;
		}

	// also check for consonant clusters
	} else {
		//ch,zh,sh are allowed,but we don't want to lose track of consonant placement
		//this replacement is fine because we won't be using this string for it's phonetic value
		$modWord = mb_strtolower($wordText);
		$modWord = str_replace("ch","c",$modWord);
		$modWord = str_replace("sh","s",$modWord);
		$modWord = str_replace("zh","z",$modWord);

		//note that 'n', 'g' and 'r' aren't in the first brackets because they can end syllables
		//nor is 'v' used in case it is meant as a vowel
		if (preg_match("/[bcdfhjklmpqstwxyz][bcdfghjklmnpqrstwxyz]/i", $modWord)) {
			return 1;
		}

	}

} //end checkCons


//check for letter clusters that do not start english words
function checkPinCluster($wordText) {

	if (preg_match("/^(hua|qi|kuai|luo|xi|xu)/i", $wordText)) {
		return 1;
	}
} //end checkPinCluster


// check for pinyin with tone marks
function checkAccChars($wordText) {
	// make sure the check the english-only consonant clusters first
	// that way we avoid matching english loan-words from spanish or whatever

	if (preg_match("/(ā|á|ă|à|ē|é|ĕ|è|ī|í|ĭ|ì|ō|ó|ŏ|ò|ü|ǘ|ǚ|ǜ|ū|ú|ŭ|ù)/i", $wordText)) {
		return 1;
	}
} //end checkAccChars

//add spaces to run-together pinyin (e.g. 'hui2lai4')
//
//something is breaking here
//
function breakNumPY($word) {

	$word = preg_replace('/1/', '1 ', $word);
	$word = preg_replace('/2/', '2 ', $word);
	$word = preg_replace('/3/', '3 ', $word);
	$word = preg_replace('/4/', '4 ', $word);
	$word = preg_replace('/5/', '5 ', $word);
	$word = trim($word);

	return $word;

} // end breakNumPY

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

// function for splitting multi-byte characters
// such as unicode Chinese
function mb_str_split( $string ) {
    # Split at all position not after the start: ^
    # and not before the end: $
    return preg_split('/(?<!^)(?!$)/u', $string );
} //end mb_str_split

//function to get the unicode code point of a utf8 char
// comes from: http://efreedom.com/Question/1-395832/Get-Code-Point-Number-Given-Character-Utf-String
// will need this to grab stroke-order gifs from ocrat
function utf8_to_unicode( $str ) {

    $unicode = array();        
    $values = array();
    $lookingFor = 1;

    for ($i = 0; $i < strlen( $str ); $i++ ) {
        $thisValue = ord( $str[ $i ] );
    if ( $thisValue < ord('A') ) {
        // exclude 0-9
        if ($thisValue >= ord('0') && $thisValue <= ord('9')) {
             // number
             $unicode[] = chr($thisValue);
        }
        else {
             $unicode[] = '%'.dechex($thisValue);
        }
    } else {
          if ( $thisValue < 128) 
        $unicode[] = $str[ $i ];
          else {
                if ( count( $values ) == 0 ) $lookingFor = ( $thisValue < 224 ) ? 2 : 3;                
                $values[] = $thisValue;                
                if ( count( $values ) == $lookingFor ) {
                    $number = ( $lookingFor == 3 ) ?
                        ( ( $values[0] % 16 ) * 4096 ) + ( ( $values[1] % 64 ) * 64 ) + ( $values[2] % 64 ):
                        ( ( $values[0] % 32 ) * 64 ) + ( $values[1] % 64 );
            $number = dechex($number);
            $unicode[] = (strlen($number)==3)?"%u0".$number:"%u".$number;
                    $values = array();
                    $lookingFor = 1;
          } // if
        } // if
    }
    } // for

	 // sleight modification here
    //return implode("",$unicode);

	$uval = implode("",$unicode);

	return preg_replace("/^\%u/", "", $uval);
	
		

} // utf8_to_unicode


function getSingleLookQuery($word, $language, $dbLimit) {

	if ($language == "en") { //if it's english

		//$queryLogic = "e.definition REGEXP '[[:<:]]" . $word . "[[:>:]]' ORDER BY LENGTH(e.definition), z.frequency DESC";

		$queryLogic = "e.definition REGEXP '[[:<:]]" . $word . "[[:>:]]'";

		$queryOrder = "LENGTH(e.definition), z.frequency ASC";

	} elseif ($language == "np") { //if it's numbered pinyin

		//check for run-together pinyin (e.g. 'hui2lai4') and add spaces
		if (preg_match("/\D\d\D/", $word)) { //checking for a digit between two non-digits
			$word = breakNumPY($word);
		}

		//$queryLogic = "z.pinyin_num LIKE '%" . $word . "%' ORDER BY LENGTH(z.pinyin_tone), e.frequency DESC";

		$queryLogic = "z.pinyin_num LIKE '%" . $word . "%'";

		$queryOrder = "LENGTH(z.pinyin_tone), z.frequency ASC";

	} elseif ($language == "tpy") { //if it's pinyin with tone-marks

		//$queryLogic = "z.pinyin_tone LIKE '%" . $word . "%' ORDER BY LENGTH(z.pinyin_tone), e.frequency DESC";

		//I'd like the put something here where I can take non-numbers pinyin and break it apart if it's run-together (ex. 'zedong')

		$queryLogic = "z.pinyin_tone_nospace LIKE '%" . $word . "%'";

		$queryOrder = "LENGTH(z.pinyin_tone), z.frequency ASC";

	} elseif ($language == "ppy") { //if it's plain pinyin without tone indication

		//queryLogic = "z.pinyin_plain LIKE '%" . $word . "%' ORDER BY LENGTH(z.pinyin_tone), e.frequency DESC";

		//I'd like the put something here where I can take non-numbers pinyin and break it apart if it's run-together (ex. 'zedong')

		$queryLogic = "z.pinyin_plain LIKE '%" . $word . "%'";

		$queryOrder = "LENGTH(z.pinyin_tone), z.frequency ASC";

	} elseif ($language == "mx") { //all else fails, we'll search both pinyin and english

		//$queryLogic = "z.pinyin_plain LIKE '%" . $word . "%' ORDER BY LENGTH(z.pinyin_tone), e.frequency DESC";

		//$queryLogic = "(e.definition LIKE '%" . $word . "%' OR z.pinyin_plain LIKE '%" . $word . "%') AND e.definition IS NOT NULL";

		$queryLogic = "(z.pinyin_plain = '" . $word . "' OR z.pinyin_plain LIKE '%" . $word . "%' OR e.definition = '" . $word . "' OR e.definition LIKE '" . $word . "%') AND e.definition IS NOT NULL";

		$queryOrder = "z.frequency ASC, e.frequency ASC, LENGTH(e.definition), LENGTH(z.pinyin_tone)";
		
	} elseif ($language == "zh") { //if it's chinese

		//$queryLogic = "z.simpHan LIKE '%" . $word . "%' ORDER BY LENGTH(z.simpHan), e.frequency DESC";

		$queryLogic = "z.simpHan LIKE '%" . $word . "%'";

		$queryOrder = "LENGTH(z.simpHan), e.frequency ASC";

	} //end if

	///// Build Query String //////
	$queryStr = "SELECT z.simpHan, z.zh_id, z.pinyin_tone, e.definition, e.backNote, p.pronunIPA FROM zhText z, enText e, enPronun p WHERE " . $queryLogic . " AND e.zh_id=z.zh_id AND e.en_id=p.en_id ORDER BY " . $queryOrder . " LIMIT " . $dbLimit;

	// send the completed query string back out
	return $queryStr;

} //end getSingleLookQuery


// build a special set of queries based on how the words in the string look
// for example, if all of the words in the string are definitely 'en' and not 'mx' then we can
// narrow down the query
function getMultiLookQuery($word, $dbLimit) {

	//$word = preg_replace("/\s\s+/", " ", $word);

	//clean out the spaces for pinyin searches
	$noSpace = preg_replace('/\s*/m', '', $word);

	$pieces = explode(" ", $word);

	$countTotal = 0;
	$countEN = 0;
	$countNPY = 0;
	$countTPY = 0;
	$countPPY = 0;
	$countMX = 0;
	$countZH = 0;

	foreach ($pieces as $onePiece) {
		// check the piece to see which language it's in
		if (preg_match("/[a-zA-Z]/", $onePiece)) { //latin chars so it's probably english or pinyin

			//first check for numbered pinyin
			if (checkNumPin($onePiece)) {

				$countNPY++; //increment number of numbered pinyin

			//next check for english-only consonant usage
			} elseif (checkCons($onePiece)) {

				$countEN++; //increment definite english

			//next check for pinyin-only accent characters
			} elseif (checkAccChars($onePiece)) {

				$countTPY++; //increment tone-marked pinyin

			//after all that check to see if there's any chinese-only clusters "kuai" and so on
			} elseif (checkPinCluster($onePiece)) {

				$countPPY++; //increment plain pinyin

			// all else fails, check both, like a mixed type string
			} else {
	
				$countMX++; //increment mixed

			}//if checkNumPin

		} else { // it's chinese
			$countZH++; //increment hanzi chinese
		} //end if

		//keep track of the number of pieces
		$countTotal++;

	} //end foreach


	//is everythign some type of pinyin? check below
	$allPY = ($countNPY + $countPPY + $countTPY);

	//Next, check the values of the different counters against the total counter
	if ($countTotal == $countEN) {
		//yay! everything is undoubtably english words (e.g. "spooner street", but not "song street")
		$queryLogic = "e.definition LIKE '%" . $word . "%'";
		$queryOrder = "LENGTH(e.definition), z.frequency ASC";

	} elseif ($countTotal == $countNPY) {
		// looking good, everything is numbered pinyin
/*
		//check for run-together pinyin (e.g. 'hui2lai4') and add spaces
		if (preg_match("/\D\d\D/", $word)) { //checking for a digit between two non-digits
			$word = breakNumPY($word);
		}
*/
		$queryLogic = "z.pinyin_num LIKE '%" . $word . "%'";
		$queryOrder = "LENGTH(z.pinyin_tone), z.frequency ASC";

	} elseif ($countTotal == $countTPY) {
		//okay, everything is tone-marked pinyin
		$queryLogic = "z.pinyin_tone_nospace LIKE '%" . $noSpace . "%'";
		$queryOrder = "LENGTH(z.pinyin_tone), z.frequency ASC";

	} elseif ($countTotal == $countPPY) {
		//everything is plain pinyin
		$queryLogic = "z.pinyin_plain LIKE '%" . $noSpace . "%'";
		$queryOrder = "LENGTH(z.pinyin_tone), z.frequency ASC";

	} elseif ($countTotal == $allPY) {
		// if it's mixed types of pinyin, strip the tone numbers from the word string and query plain pinyin
		// it looks like this should be fine because MySQL seems to match accent characters against regular letters

		// drop the numbers
		$word = preg_replace('/\d/', ' ', $word);
		// then deal with any extra whitespace caused by above
		$word = preg_replace("/\s\s+/", " ", $word);

		//I'd like the put something here where I can take non-numbers pinyin and break it apart if it's run-together (ex. 'zedong')

		$queryLogic = "(z.pinyin_plain LIKE '" . $noSpace . "%' OR z.pinyin_plain LIKE '%" . $noSpace . "%')";
		$queryOrder = "LENGTH(z.pinyin_tone), z.frequency ASC";

	} elseif ($countTotal == $countZH) {
	// if everything is hanzi, but there's spaces, do an OR query, one with, one without spaces

		//then drop the numbers
		//$noSpaceHan = preg_replace('/\s/', '', $word);

		//I'd like the put something here where I can take non-numbers pinyin and break it apart if it's run-together (ex. 'zedong')

		$queryLogic = "(z.simpHan LIKE '%" . $word . "%' OR z.simpHan LIKE '%" . $noSpace . "%')";
		$queryOrder = "LENGTH(z.pinyin_tone), z.frequency ASC";

	//if it's none of these things, run it like an mx query
	} else {
		$queryLogic = "(z.pinyin_plain = '" . $noSpace . "' OR z.pinyin_plain LIKE '%" . $noSpace . "%' OR e.definition = '" . $word . "' OR e.definition LIKE '% " . $word . "%') AND e.definition IS NOT NULL";

		$queryOrder = "z.frequency ASC, e.frequency ASC, LENGTH(e.definition), LENGTH(z.pinyin_tone)";

	} //end if countTotal


	// Build the string
	$queryStr = "SELECT z.simpHan, z.zh_id, z.pinyin_tone, e.definition, e.backNote, p.pronunIPA FROM zhText z, enText e, enPronun p WHERE " . $queryLogic . " AND e.zh_id=z.zh_id AND e.en_id=p.en_id ORDER BY " . $queryOrder . " LIMIT " . $dbLimit;

	//send completed query string back out
	return $queryStr;

} //end getMultiLookQuery

// generate a query for searches
// using an "en:" search hint
function getEnQuery($word, $dbLimit) {

	// Build the string
	$queryStr = "SELECT z.simpHan, z.zh_id, z.pinyin_tone, e.definition, e.backNote, p.pronunIPA FROM zhText z, enText e, enPronun p WHERE e.definition LIKE '%" . $word . "%' AND e.zh_id=z.zh_id AND e.en_id=p.en_id ORDER BY LENGTH(e.definition), z.frequency ASC LIMIT " . $dbLimit;

	//send completed query string back out
	return $queryStr;

} //end getEnQuery

// generate a query for searches
// using a "py:" search hint
function getPyQuery($word, $dbLimit) {

	//clean out the spaces for pinyin searches
	$noSpace = preg_replace('/\s*/m', '', $word);

	//first check to see if we're dealing with different kinds of pinyin
	////////////////////////////////////////////////////////////////////

	// break the string up into pieces
	$pieces = explode(" ", $word);

	$countTotal = 0;
	$countNPY = 0;
	$countTPY = 0;
	$countPPY = 0;

	foreach ($pieces as $onePiece) {

			//first check for numbered pinyin
			if (checkNumPin($onePiece)) {

				$countNPY++; //increment number of numbered pinyin

			//next check for pinyin-only accent characters
			} elseif (checkAccChars($onePiece)) {

				$countTPY++; //increment tone-marked pinyin

			//after all that check to see if there's any chinese-only clusters "kuai" and so on
			} else {

				$countPPY++; //increment plain pinyin

			}//if checkNumPin

		//keep track of the number of pieces
		$countTotal++;

	} //end foreach


	/// Now check the totals and see what kind of search logic we need to use

	//Next, check the values of the different counters against the total counter
	if ($countTotal == $countNPY) {
		// looking good, everything is numbered pinyin
/*
		//check for run-together pinyin (e.g. 'hui2lai4') and add spaces
		if (preg_match("/\D\d\D/", $word)) { //checking for a digit between two non-digits
			$word = breakNumPY($word);
		}
*/
		$queryLogic = "z.pinyin_num LIKE '%" . $word . "%'";
		$queryOrder = "LENGTH(z.pinyin_tone), z.frequency ASC";

	} elseif ($countTotal == $countTPY) {
		//okay, everything is tone-marked pinyin
		$queryLogic = "z.pinyin_tone_nospace LIKE '%" . $noSpace . "%'";
		$queryOrder = "LENGTH(z.pinyin_tone), z.frequency ASC";

	} elseif ($countTotal == $countPPY) {
		//everything is plain pinyin
		$queryLogic = "z.pinyin_plain LIKE '%" . $noSpace . "%'";
		$queryOrder = "LENGTH(z.pinyin_tone), z.frequency ASC";

	} else {
		// if it's mixed types of pinyin, strip the tone numbers from the word string and query plain pinyin
		// it looks like this should be fine because MySQL seems to match accent characters against regular letters

		// drop the numbers
		$word = preg_replace('/\d/', ' ', $word);
		// then deal with any extra whitespace caused by above
		$word = preg_replace("/\s\s+/", " ", $word);

		//I'd like the put something here where I can take non-numbers pinyin and break it apart if it's run-together (ex. 'zedong')

		$queryLogic = "(z.pinyin_plain='" . $noSpace . "' OR z.pinyin_plain LIKE '%" . $noSpace . "%')";
		$queryOrder = "LENGTH(z.pinyin_tone), z.frequency ASC";

	} // end if countTotal



	// Build the string
	$queryStr = "SELECT z.simpHan, z.zh_id, z.pinyin_tone, e.definition, e.backNote, p.pronunIPA FROM zhText z, enText e, enPronun p WHERE " . $queryLogic . " AND e.zh_id=z.zh_id AND e.en_id=p.en_id ORDER BY " . $queryOrder . " LIMIT " . $dbLimit;

	//send completed query string back out
	return $queryStr;

} // end getPyQuery

function getEntries($word, $ver = 'a') {

//	$result_loops = 0;

	//how many results do we want each time?
	$dbLimit = 100;

	// Connect to Database
	//load the values for database connection
	include 'dbconfig.php';

	//$con = mysql_connect("localhost","cedicU","letter");
	$con = mysql_connect($dbHost,$dbUser,$dbPass);
	if (!$con)
	  {
	  die('Could not connect: ' . mysql_error());
	  }

//	mysql_select_db("ceDic", $con);

	//make sure we're using unicode
//	$unicode_query1 = mysql_query("set names utf8");
//	$unicode_query2 = mysql_query("SET CHARACTER SET utf8");



	//escape weird chars for security
	// --remember that you have to use that after there's an open database connection
	$word = mysql_real_escape_string($word);

	//done with the database
	mysql_close($con);

	if (preg_match('/\s/', $word)) {
		//for strings that have spaces in them use this

		//clean out multiple whitespace
		$word = preg_replace("/\s\s+/", " ", $word);

		//debug
		//echo "<span id=\"debug\">word:" . $word . "</span>\n";


		//////////////////////////////////////////////
		///////     UNFINISHED!! 
		//////////////////////////////////////////////

		//check for search hints first, this makes things easier
		if (preg_match("/(^en\:|\sen\:)/", $word)) {
			//if it's an english search

			//strip the hint itself out of the search
			$word = preg_replace("/en\:/", "", $word);

			// then deal with any extra whitespace caused by above
			$word = preg_replace("/\s\s+/", " ", $word);
			$word = preg_replace("/(^\s|\s$)/", "", $word);

			$queryStr = getEnQuery($word, $dbLimit);

		} elseif (preg_match("/(^ch\:|\sch\:)/", $word)) {
			//if it's a pinyin search

			//strip the hint itself out of the search
			$word = preg_replace("/ch\:/", "", $word);

			// then deal with any extra whitespace caused by above
			$word = preg_replace("/\s\s+/", " ", $word);
			$word = preg_replace("/(^\s|\s$)/", "", $word);

			$queryStr = getPyQuery($word, $dbLimit);

		//else there's not hints, so run through the pattern-rec
		} else {
			$queryStr = getMultiLookQuery($word, $dbLimit);
		}

	} else { //get the query for a single word string

		$lang = checkLang($word);
		$queryStr = getSingleLookQuery($word, $lang, $dbLimit);

	} //end if spaces


	// debug
	//echo "language: " . checkLang($word) . "<br />\n";
	//echo "checkCons: " . checkCons($word) . "<br />\n";
	//echo "query: " . $queryStr . "\n";

	//print entries to html - if we're using an alternate version of the interface, specify with $ver
	if ($ver) {
		$entryCount = printEntries($queryStr, $ver);
	} else {
		$entryCount = printEntries($queryStr);
	}
	

	//send number of results back to the display page
	return $entryCount;

} //end getEntries

//unlike get entries, which does some proccessing, this function prints the results of a query to the html
function printEntries($queryStr, $ver = 'a') {

	$result_loops = 0;

	//how many results do we want each time?
	$dbLimit = 100;

	
	//load the values for database connection
	include 'dbconfig.php';

	//get urls  -if we're using an alternate interface, specify with $ver
	if ($ver == 'b') {
		include 'urls_b.php';
	} else {
		include 'urls.php';
	}

	// Connect to Database
	$con = mysql_connect($dbHost,$dbUser,$dbPass);
	if (!$con)
	  {
	  die('Could not connect: ' . mysql_error());
	  }

	//mysql_select_db("ceDic", $con);
	mysql_select_db($dbName, $con);

	//make sure we're using unicode
	$unicode_query1 = mysql_query("set names utf8");
	$unicode_query2 = mysql_query("SET CHARACTER SET utf8");

	//query DB with pre-generated string
	$result = mysql_query($queryStr) or die("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $queryStr . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());

	//$result = mysql_query($queryStr);
	if (!$result)
	  {
	  echo "Could not run query: " . mysql_error() . "<br />\n";
	  }

	$countRows = 0; //nothing to see here

	//start the table
	echo "<table id=\"rlist\">\n";

	while ($row = mysql_fetch_array($result)) {

		$countRows++; //just changing the colors of the rows

		/*if ($odd = $countRows%2) {
			echo "<table class=\"alternate\">\n";
		} else {
			echo "<table>\n";
		}*/

		if ($odd = $countRows%2) {
			echo "<tr class=\"alternate\">\n";
		} else {
			echo "<tr>\n";
		}


		if (preg_match("/\[/", $row['pronunIPA'])) {
			$pronun = ' ';
		} else {
			$pronun = $row['pronunIPA'];
		}

		//echo "<tr>\n";

		//make the pinyin all lowercase
		$lowPin = mb_strtolower($row['pinyin_tone'], "UTF-8");

		echo "<td id=\"rcol\" class=\"hanzi\"><a href=\"". $wordUrl . "?wId=" . $row['zh_id'] . "&targetLang=zh\">" . $row['simpHan'] . "</a></td>\n";
		echo "<td id=\"rcol\">[" . $lowPin . "]</td>\n";
		if ($row['backNote']) {
			echo "<td id=\"rcol\"><a href=\"". $wordUrl . "?wId=" . $row['definition'] . "&targetLang=en\">" . $row['definition'] . " (" . $row['backNote'] . ")</a></td>\n";
		} else {
			echo "<td id=\"rcol\"><a href=\"". $wordUrl . "?wId=" . $row['definition'] . "&targetLang=en\">" . $row['definition'] . "</a></td>\n";
		}
		//echo "<td id=\"rcol\">" . $row['pronunIPA'] . "</td>\n";
		echo "<td id=\"rcol\">" . $pronun . "</td>\n";

		echo "</tr>\n";
		//echo "</table>\n";

		$result_loops++;

	} // end while row=

	//close entries table

	echo "</table>\n";

	if ($result_loops == 0) {
		echo "<div id=\"noresult\">No entries found.</div>\n";
	}

	mysql_close($con);

	//send the number of entries back up the chain
	return $result_loops;
} // end printEntries

function getEnWordDat($enDef, $ver = 'a') {

	//clean up the string a little
	// --sometimes there's weird chars in the definition
	$enDef = preg_replace("/'/","\\\'",$enDef);

	//load the values for database connection
	include 'dbconfig.php';

	//get urls  -if we're using an alternate interface, specify with $ver
	if ($ver == 'b') {
		include 'urls_b.php';
	} else {
		include 'urls.php';
	}

	// Connect to Database
	$con = mysql_connect($dbHost,$dbUser,$dbPass);
	if (!$con)
	  {
	  die('Could not connect: ' . mysql_error());
	  }

	mysql_select_db($dbName, $con);

	//make sure we're using unicode
	$unicode_query1 = mysql_query("set names utf8");
	$unicode_query2 = mysql_query("SET CHARACTER SET utf8");

	//escape weird chars for security
	// --remember that you have to use that after there's an open database connection
	$word = mysql_real_escape_string($enDef);

	$queryStr = "SELECT z.simpHan, z.pinyin_tone, z.zh_id, e.definition, p.pronunIPA FROM zhText z, enText e, enPronun p WHERE z.zh_id=e.zh_id AND e.en_id=p.en_id AND e.definition='" . $enDef . "' ORDER BY z.frequency";

	//query DB with pre-generated string
	$result = mysql_query($queryStr);

	$firstResult = 0;

	while ($row = mysql_fetch_array($result)) {

		//get some info on the first run through the loop
		if ($firstResult == 0) {
			$enText = $row['definition'];
			$enPro = $row['pronunIPA'];

			echo "<div id=\"entryTerm\" class=\"bigText\">" . $enText . "</div>\n";

			
			echo "<div id=\"entryInfo\">\n";
			echo "<div id=\"extraInfo\">\n";
			if (!preg_match("/\[/i", $enPro)){
				echo "<div class=\"grayLabel\">Pronunciation:</div>\n";
				echo "<div class=\"pronunIpa\">/" . $enPro . "/</div>\n";
			} else {
				echo "<div class=\"grayLabel\">No Pronunciation Data</div>\n";
			}
			echo "</div><!--end extraInfo-->\n";
			echo "</div><!--end entryInfo-->\n";

			echo "<div id=\"defs\">\n";
			echo "<div class=\"grayLabel\">Chinese definitions:</div>\n";

			$firstResult++;
		}

		$lowPin = mb_strtolower($row['pinyin_tone'], "UTF-8");

		echo "<div class=\"defString\"><a href=\"" . $wordUrl . "?wId=" . $row['zh_id'] . "&targetLang=zh\">" . $row['simpHan'] . "</a> [" . $lowPin . "]</div>\n";

		

	  //echo "English: " . $row['definition'] . "  [" . $row['pronunIPA'] . "]<br />";
	  //echo "  Chinese: " . $row['simpHan'] . " " . $row['pinyin_tone'];
	  //echo "<br /><br />";
	}

	echo "</div><!--end defs-->\n";

	mysql_close($con);

} //end getEnWordDat




function getZhWordDat($idNum, $ver = 'a') {

	//get urls  -if we're using an alternate interface, specify with $ver
	if ($ver == 'b') {
		include 'urls_b.php';
	} else {
		include 'urls.php';
	}

	//load the values for database connection
	include 'dbconfig.php';

	// Connect to Database
	$con = mysql_connect($dbHost,$dbUser,$dbPass);
	if (!$con)
	  {
	  die('Could not connect: ' . mysql_error());
	  }

	mysql_select_db($dbName, $con);

	//make sure we're using unicode
	$unicode_query1 = mysql_query("set names utf8");
	$unicode_query2 = mysql_query("SET CHARACTER SET utf8");

	//escape weird chars for security
	// --remember that you have to use that after there's an open database connection
	$word = mysql_real_escape_string($idNum);

	$queryStr = "SELECT z.simpHan, z.tradHan, z.pinyin_tone, z.pinyin_num, z.hskLevel, e.definition, e.frontNote, e.backNote, e.partSpeech FROM zhText z, enText e WHERE z.zh_id=e.zh_id AND z.zh_id='" . $idNum . "' ORDER BY e.frequency";

	//query DB with pre-generated string
	$result = mysql_query($queryStr);

	$firstResult = 0;

	while ($row = mysql_fetch_array($result)) {

		//get some info on the first run through the loop
		if ($firstResult == 0) {

			//echo "<h2>" . $row['simpHan'] . "</h2>  [" . $row['pinyin_tone'] . "]<br />";

			echo "<div id=\"entryTerm\">\n";

			///////////////////////////////////
			//generate clickable hanzi w/ sound
			
			$hanziString = $row['simpHan'];
			$numPinyin = $row['pinyin_num'];

			//lowercase the pinyin
			$numPinyin = strtolower($numPinyin);
			

			//split the hanzi and pinyin data for use with soundManager2
			$sounds = preg_split("/\s/", $numPinyin);

			$hanChars = mb_str_split($hanziString);

			// keep track of any neutral-tone syllables displayed
			$superscript = 0;

			$pinIndex = 0; //keep track of our loop

			//loop through and create links
			foreach ($hanChars as $simpHan) {
				if (preg_match("/5/", $sounds[$pinIndex])){
					//echo "<span id=\"bighan\">" . $simpHan . "</span><span class=\"superscr\">*</span>\n";
					echo "<span class=\"bighan-noplay\">" . $simpHan . "</span><span class=\"superscr\">*</span>\n";
					$superscript = 1;
				} else {

					echo "<a onClick=\"soundManager.createSound({id:'my" . $sounds[$pinIndex] . "',url:'./mandarin_sounds/" . $sounds[$pinIndex] . ".mp3',volume: 70}); soundManager.play('my" . $sounds[$pinIndex] . "')\" class=\"bighan-play\">" . $simpHan . "</a>\n";


					//easiest way, but this breaks under chrome when using non-debug version of SM2 --weird
					//echo "<a onClick=\"javascript:soundManager.play('my" . $sounds[$pinIndex] . "','./mandarin_sounds/" . $sounds[$pinIndex] . ".mp3');\" id=\"bighan\" class=\"playme\">" . $simpHan . "</a>\n";

					//old way using the sound manager inline player stuff
					//echo "<a href=\"./mandarin_sounds/" . $sounds[$pinIndex] . ".mp3\" class=\"bighan\">" . $simpHan . "</a>\n";
				} //end if preg_match

				$pinIndex++;
			}


			// end clickable hanzi //////////////
			///////////////////////////////////////

			echo "<img src=\"speaker.png\" id=\"speaker\" /></div> <!-- end div hanziStr -->\n";

			

			//make pinyin all lowercase
			$lowPin = mb_strtolower($row['pinyin_tone'], "UTF-8");

			echo "<div id=\"pinyin\">" . $lowPin . "<span class=\"push\">&nbsp;&nbsp;</span></div>\n";

			if ($superscript == 1) {
				echo "<div id=\"supernote\">* This syllable carries a <a href=\"http://en.wikipedia.org/wiki/Standard_Chinese_phonology#Neutral_tone\" target=\"_blank\">neutral tone</a>, so it is pronunced in a light and short manner, with no change in pitch from end of the previous syllable.</div>\n";
			}

			echo "<div id=\"entryInfo\">\n";

			if ($row['tradHan'] || $row['hskLevel']) {
				echo "<div id=\"extraInfo\">\n";
				if ($row['tradHan']) {
					echo "<div id=\"tradHan\">" . $row['tradHan'] . "</div>\n";
					echo "<div class=\"tradLabel\">Traditional Version</div>\n";
				}

				if ($row['hskLevel']) {
					echo "<br /><div id=\"hsk\">HSK Level " . $row['hskLevel'] . " Word</div>\n";
				}
				echo "</div><!--end extraInfo-->\n";
			} //end tradhan or hsk


			
			///// Individual Character details ///////

			echo "<div id=\"charinfo\">\n";
			echo "<div class=\"grayLabel\">Character Info:</div>\n";
			echo "<div id=\"individualChars\">\n";

			//loop through again and create links
			foreach ($hanChars as $simpHan) {


					//use this later to grab ocrat stuff, but it would be better to get GB codepoints, find out more later
					//$ucode = utf8_to_unicode($simpHan);
					//echo "ucode: " . $ucode . "\n";
	
					echo "<a href=\"" . $charUrl . "?hanChar=" . $simpHan . "\" class=\"onehan\">" . $simpHan . "</a>\n";

			} //end second hanzi loop

			echo "</div><!--end individualChars-->\n";
			echo "</div><!--end charinfo-->\n";



			echo "</div><!--end entryInfo-->\n";
			/////////////////////////////////////////



			echo "<div id=\"defs\">\n";

			echo "<div class=\"grayLabel\">English definitions:</div>";

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

		echo "<div class=\"defString\"><a href=\"" . $wordUrl . "?wId=" . $row['definition'] . "&targetLang=en\">" . $defString . "</a></div>\n";

	}

	echo "</div><!--end defs-->\n";

	mysql_close($con);

} //end getZhWordDat

function getCharDetail($hanZi, $ver = 'a') {

	//load the values for database connection
	include 'dbconfig.php';

	// Connect to Database
	$con = mysql_connect($dbHost,$dbUser,$dbPass);
	if (!$con)
	  {
	  die('Could not connect: ' . mysql_error());
	  }

	mysql_select_db($dbName, $con);

	//make sure we're using unicode
	$unicode_query1 = mysql_query("set names utf8");
	$unicode_query2 = mysql_query("SET CHARACTER SET utf8");

	//display the large version of the character
	echo "<div id=\"charBig\">" . $hanZi;
	$tradQuery = "SELECT tradHan FROM zhText where simpHan='" . $hanZi . "' LIMIT 1";
	$result = mysql_query($tradQuery);
	$tradHan = mysql_fetch_array($result);
	if ($tradHan['tradHan']) {
		echo "&nbsp;&nbsp;&nbsp;<span id=\"traditional\">" . $tradHan['tradHan'] . "</span>\n";
	}
	echo "</div>\n";

	$readingQueryStr = "SELECT DISTINCT pinyin_tone, pinyin_num FROM zhText WHERE simpHan='" . $hanZi . "' ORDER BY frequency";

	//query DB with pre-generated string
	$result = mysql_query($readingQueryStr);

	// keep track of any neutral-tone syllables displayed
	$superscript = 0;
	
	$pinIndex = 0;


	//open the div for the pinyin
	echo "<div id=\"readings\">Reading: \n";

	//check out the various readings of this character, usually only one, but you never know
	while ($row = mysql_fetch_array($result)) {
		
		$numPinyin = $row['pinyin_num'];

		//lowercase the pinyin
		$numPinyin = strtolower($numPinyin);
		

		//split the hanzi and pinyin data for use with soundManager2
		// don't think I'll need this, but hold onto it $sounds = preg_split("/\s/", $numPinyin);

		//lowercase the pinyin
		$lowPin = mb_strtolower($row['pinyin_tone'], "UTF-8");


		if (preg_match("/5/", $numPinyin)){
			echo "<span id=\"blankPin\">" . $lowPin . "</span><span class=\"tinysuperscr\">*</span>\n";
			$superscript = 1;
		} else {

			echo "<a onClick=\"soundManager.createSound({id:'my" . $numPinyin . "',url:'./mandarin_sounds/" . $numPinyin . ".mp3',volume: 70}); soundManager.play('my" . $numPinyin . "')\" class=\"playme\">" . $lowPin . "</a>\n";

			$pinIndex++;
		} //end if preg_match


		// end clickable pinyin //////////////
		///////////////////////////////////////

	} // end while

		echo "<img src=\"speaker.png\" id=\"speaker\" /></div> <!-- end div pinyinStr -->\n";

		//echo "</div> <!-- end div pinyinStr -->\n";


		if ($superscript == 1) {
			echo "<div id=\"supernote\">* This syllable carries a <a href=\"neutral_tone.html\">neutral tone</a>, so it is pronunced in a light and short manner, with no change in pitch from end of the previous syllable.</div>\n";
		}

		echo "<br />";

	// start the tabber section
	echo "<div class=\"tabber\">\n";



	echo "<div class=\"tabbertab\" title=\"Words containing " . $hanZi . "\">\n";
	//echo "<div>Words containing \"" . $hanZi . "\"</div>\n";

	$containQuery = "SELECT z.simpHan, z.zh_id, z.pinyin_tone, e.definition, e.backNote, p.pronunIPA FROM zhText z, enText e, enPronun p WHERE z.zh_id=e.zh_id AND e.en_id=p.en_id AND z.simpHan LIKE '%" . $hanZi . "%' ORDER BY z.frequency LIMIT 200";

	//let's see the output of that query
	$entryCount = printEntries($containQuery, $ver);

	echo "</div> <!-- end words containing -->\n";

	//here is where to put the entries list for words starting with this character, and words containing this character
	echo "<div class=\"tabbertab\" title=\"Words starting with " . $hanZi . "\">\n";

	$firstQuery = "SELECT z.simpHan, z.zh_id, z.pinyin_tone, e.definition, e.backNote, p.pronunIPA FROM zhText z, enText e, enPronun p WHERE z.zh_id=e.zh_id AND e.en_id=p.en_id AND z.simpHan LIKE '" . $hanZi . "%' ORDER BY z.frequency LIMIT 200";

	//let's see the output of that query
	printEntries($firstQuery, $ver);

	echo "</div> <!-- end words starting with -->\n";

	echo "</div> <!-- end the tabber section -->\n";

	//send number of results back to the display page
	return $entryCount;

} //end getCharDetail

?>

