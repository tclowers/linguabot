<html>
<head>
<meta http-equiv="Content-type" value="text/html; charset=utf-8">
<link rel="shortcut icon" href="favicon.ico">
<title> LinguaBot C-E Dictionary Lookup </title>
<link rel="stylesheet" type="text/css" href="lbot.css" />
<link rel="stylesheet" type="text/css" href="layout.css" />

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
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
<script type="text/javascript" src="./sm2/script/soundmanager2.js"></script>
<script type="text/javascript" src="./sm2/script/inlineplayer.js"></script>
<link rel="stylesheet" type="text/css" href="./sm2/css/inlineplayer.css" />


<script>
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
		<div id="twocols">
			<div id="logo">
				<img src="logo.png"/>
			</div> <!--end logo -->
			<div id="nav">
				<ul>
					<li><a href="this.html" class="selected">Dictionary</a></li>
					<li>|</li>
					<li><a href="credits.php" class="option">Trainer</a></li>
					<li>|</li>
					<li><a href="credits.php" class="option">Games</a></li>
					<li>|</li>
					<li><a href="credits.php" class="option">About</a></li>
					<li>|</li>
					<li><a href="that.html" class="option">Help</a></li>
				</ul>
			</div> <!-- end nav -->


			<div id="entryform">
				<form action="dictLookup.php" method="get">
				<span id="searchlabel">Dictionary Lookup:</span>
				<input type="text" name="word" value="Enter English, Chinese, or Pinyin here" id="qbox"/>
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
	getEnWordDat($wId);
} elseif ($lang == "zh") {
	getZhWordDat($wId);
}

?>

				</div> <!-- end entrydat -->

			</div> <!-- end maincol -->

			<div id="rightcol">
				<div id="boxes">
					<img src="gads.gif" id="gads" />
				</div>
			</div> <!-- end rightcol -->
			

		</div> <!-- end twocols -->
	</div> <!-- end wrapper -->

	<div id="spaceit"> </div>
	<div id="footer"><h2>Footer</h2></div>
</div> <!--end pagewidth -->

</body>
</html>
