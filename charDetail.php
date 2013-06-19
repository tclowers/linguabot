<?php
/* Trying to make Internet Explorer suck less */
header('Content-Type:text/html; charset=UTF-8');
?>
<html>
<head>
<title>LinguaBot Chinese Dictionary - character: <?php echo $_GET["hanChar"]; ?></title>
<meta name="description" content="LinguaBot Chinese Dictionary - details and related words for <?php echo $_GET["hanChar"]; ?>" />
<?php
	//common header data
	include "headers.html";
?>
<link rel="stylesheet" type="text/css" href="layout.css" />
<link rel="stylesheet" type="text/css" href="tabber.css" />

<!-- Javascript Tabifier -->
<script type="text/javascript" src="scripts/tabber-minimized.js"></script>

<!-- search entryform auto-clear on click -->
<script type="text/javascript" src="scripts/jquery-1.5.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('input[type="text"]').focus(function() {
        if (this.value == this.defaultValue) this.value = '';
    });
    $('input[type="text"]').blur(function() {
        if (this.value == '') this.value = (this.defaultValue ? this.defaultValue : '');
    });
});
</script>

<!-- Sound Manager 2 Stuff  -->
<script type="text/javascript" src="./sm2/script/soundmanager2-nodebug-jsmin.js"></script>
<!-- Or, with debug: -->
<!--<script type="text/javascript" src="./sm2/script/soundmanager2.js"></script>-->
<script type="text/javascript">
soundManager.url = './sm2/swf/';
soundManager.flashVersion = 9; // optional: shiny features (default = 8)
soundManager.useFlashBlock = false; // optionally, enable when you're ready to dive in
// enable HTML5 audio support, if you're feeling adventurous. iPad/iPhone will always get this.
// soundManager.useHTML5Audio = true;
soundManager.onready(function() {
  // Ready to use; soundManager.createSound() etc. can now be called.
});
</script>

<!-- end Sound Manager 2 -->

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
				<input type="text" name="word" value="Enter text in English, Chinese, or Pīnyīn here" id="qbox"/>
				<input type="submit" id="lookup" value="Go" />
				</form>
			</div> <!--end entryform -->

			<div id="spaceit"> </div>

			<div id="maincol">
			<?php
			require("helper.php");

			// Grab Post data
			$hanChar = $_GET["hanChar"];

			//$readingQueryStr = "SELECT tradHan, pinyin_tone, pinyin_num FROM zhText WHERE simpHan='" . $hanChar . "' ORDER BY frequency";

			//debug
			//echo "<div>hanchar: " . $hanChar . "</div>\n";
			//echo "<div>query: " . $readingQueryStr . "</div>\n";

			$entryCount = getCharDetail($hanChar);

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
