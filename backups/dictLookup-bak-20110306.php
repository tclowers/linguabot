<?php
/* Trying to make Internet Explorer suck less */
header('Content-Type:text/html; charset=UTF-8');
?>
<html>
<head>
<meta http-equiv="Content-type" value="text/html; charset=utf-8">
<meta name="keywords" content="english,chinese,dictionary,hanyu,pinyin,translation,zhongwen,mandarin,yingwen,putonghua,cidian,cishu" />
<meta name="description" content="Chinese-English dictionary. Lists over 253,000 Mandarin Chinese terms with multiple English definitions. Streaming HTML5 Chinese pronunciation audio included." />
<link rel="shortcut icon" href="favicon.ico">
<title> LinguaBot Chinese-English Dictionary</title>
<link rel="stylesheet" type="text/css" href="lbot.css" />
<link rel="stylesheet" type="text/css" href="layout.css" />

<!-- Google Analytics -->
<script type="text/javascript" src="scripts/analytics.js"></script>

<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

</head>
<body>
<?php include_once("analyticstracking.php") ?>
<!-- ^ Google Analytics ^ -->
<div id="pagewidth">
	<div id="topline"> </div>
	<div id="wrapper" class="clearfix">
		<div id="twocols">
			<div id="logo">
				<img src="logo.png"/>
			</div> <!--end logo -->
			<?php
				require("navBar.php");
				navBar("dictionary");
			?>
			<div id="entryform">
				<form action="dictLookup.php" method="get">
				<span id="searchlabel">Dictionary Lookup:</span>
				<input type="text" name="word" value="<?php echo $_GET["word"]; ?>" id="qbox"/>
				<input type="submit" id="lookup" value="Go" />
				</form>
			</div> <!--end entryform -->

			<div id="spaceit"> </div>

			<div id="maincol">
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


			</div> <!-- end maincol -->

			<div id="rightcol">
				<div id="boxes">
					<img src="gads.gif" id="gads" />
				</div>
			</div> <!-- end rightcol -->
			

		</div> <!-- end twocols -->
	</div> <!-- end wrapper -->

	<div id="spaceit"> </div>
	<div id="footer">
	<div id="license"><a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/" class="ccsmall"><img alt="Creative Commons License" style="border-width:0" src="cc_round.png" /></a>&nbsp;&nbsp;This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/" class="gray">Creative Commons Attribution-ShareAlike 3.0 Unported License</a>.</div>
	</div>
</div> <!--end pagewidth -->

</body>
</html>
