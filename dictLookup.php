<?php
/* Trying to make Internet Explorer suck less */
header('Content-Type:text/html; charset=UTF-8');
?>
<html>
<head>
<title>LinguaBot Chinese Dictionary - searching: <?php echo $_GET["word"]; ?></title>
<meta name="description" content="LinguaBot Chinese Dictionary - Search Results for <?php echo $_GET["word"]; ?>" />
<?php
	//common header data
	include "headers.html";
?>
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

					$entryCount = getEntries($word);


					//echo "Also, word postdata: " . $_POST["word"];
				?>


			</div> <!-- end maincol -->

			<div id="rightcol">
				<div id="box1">
					<script type="text/javascript"><!--
					google_ad_client = "ca-pub-1281597467757401";
					/* gads1 */
					google_ad_slot = "6960209497";
					google_ad_width = 160;
					google_ad_height = 600;
					//-->
					</script>
					<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
				</div> <!-- end box1 -->
				<?php
					if ($entryCount > 40) {
						include "gads2.html";
					}

					if ($entryCount > 60) {
						include "gads3.html";
					}
				?>
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
