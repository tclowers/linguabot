<?php
/* Trying to make Internet Explorer suck less */
header('Content-Type:text/html; charset=UTF-8');
?>
<html>
<head>
<?php
	//common header data
	include "headers_b.html";
?>
<link rel="stylesheet" type="text/css" href="layout_b.css" />

</head>
<body>
<div id="pagewidth">
	<div id="topline"> </div>
	<div id="wrapper" class="clearfix">
		<div id="maincol">
			<div id="entryform">
				<form action="dictLookup_b.php" method="get">
				<span id="searchlabel">Dictionary Lookup:</span>
				<input type="text" name="word" value="<?php echo $_GET["word"]; ?>" id="qbox"/>
				<input type="submit" id="lookup" value="Go" />
				</form>
			</div> <!--end entryform -->
			<div id="spaceit"> </div>

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

				$entryCount = getEntries($word, "b");


				//echo "Also, word postdata: " . $_POST["word"];
			?>


		</div> <!-- end maincol -->

	</div> <!-- end wrapper -->

	<div id="spaceit"> </div>
	<div id="footer">
	<div id="license"><a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/" class="ccsmall" target="_blank"><img alt="Creative Commons License" style="border-width:0" src="cc_round.png" /></a>&nbsp;&nbsp;Dictionary content is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/" class="gray">Creative Commons Attribution-ShareAlike 3.0 Unported License</a>.</div>
	</div>
</div> <!--end pagewidth -->
</body>
</html>
