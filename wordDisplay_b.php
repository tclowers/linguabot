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
<div id="pagewidth">
	<div id="topline"> </div>
	<div id="wrapper" class="clearfix">

			<div id="entryform">
				<form action="dictLookup_b.php" method="get">
				<span id="searchlabel">Dictionary Lookup:</span>
				<input type="text" name="word" value="Enter text in English, 中文, or Pīnyīn here" id="qbox"/>
				<input type="submit" id="lookup" value="Go" />
				</form>
			</div> <!--end entryform -->

			<div id="spaceit"> </div>

			<div id="maincol">
				<div id="entrydat">
<?php
require("helper.php");

// Grab Post data
$wId = $_GET["wId"];
$lang = $_GET["targetLang"];

if ($lang == "en") {
	getEnWordDat($wId, "b");
} elseif ($lang == "zh") {
	getZhWordDat($wId, "b");
}

?>

				</div> <!-- end entrydat -->

			</div> <!-- end maincol -->
			
	</div> <!-- end wrapper -->

	<div id="spaceit"> </div>
	<div id="footer">
		<div id="license"><a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/" class="ccsmall"  target="_blank"><img alt="Creative Commons License" style="border-width:0" src="cc_round.png" /></a>&nbsp;&nbsp;Dictionary content is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/" class="gray">Creative Commons Attribution-ShareAlike 3.0 Unported License</a>.</div>
	</div>
</div> <!--end pagewidth -->
</body>
</html>
