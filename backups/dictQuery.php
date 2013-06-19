<?php
/* Trying to make Internet Explorer suck less */
header('Content-Type:text/html; charset=UTF-8');
?>
<html>
<head>
<?php
	//common header data
	include "headers.html";
?>
<link rel="stylesheet" type="text/css" href="frontpage.css" />
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

<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

</head>
<body>
<?php include_once("analyticstracking.php") ?>
<!-- ^ Google Analytics ^ -->
<div id="pagewidth">
	<div id="topline"> </div>
	<!--<div id="header">
		<div id="logo">
			<img src="logo.png"/></span>
		</div>
		<div id="nav">
			<ul>
				<li><a href="this.html" class="option">Dictionary</a></li>
				<li>|</li>
				<li><a href="credits.php" class="option">About</a></li>
				<li>|</li>
				<li><a href="that.html" class="option">Help</a></li>
			</ul>
		</div>
	</div>-->
	<div id="header">
		<div id="logo">
			<img src="logo.png"/></span>
		</div> <!--end logo -->
		<?php
			require("navBar.php");
			navBar("dictionary");
		?>
	</div> <!-- end header -->
	<div id="wrapper" class="clearfix">
			<!--<div id="logo">
				<img src="logo.png"/></span>
			</div>
			<div id="nav">
				<ul>
					<li><a href="this.html" class="option">Dictionary</a></li>
					<li>|</li>
					<li><a href="credits.php" class="option">Trainer</a></li>
					<li>|</li>
					<li><a href="credits.php" class="option">Games</a></li>
					<li>|</li>
					<li><a href="credits.php" class="option">About</a></li>
					<li>|</li>
					<li><a href="that.html" class="option">Help</a></li>
				</ul>
			</div> -->
			<div id="maincol">
				<div id="dictionary"><img src="chinese_english_dictionary.png" /></div>
				<div id="entryform">
					<!--<p>Dictionary Lookup:</p>-->
					<form action="dictLookup.php" method="get">
					<input type="text" name="word" value="Enter English, Chinese, or Pinyin here" id="qbox"/>
					<input type="submit" id="lookup" value="Go" />
					</form>
				</div> <!--end frontentryform -->
			</div> <!-- end frontmaincol -->

	</div> <!-- end wrapper -->

	<div id="spaceit"> </div>
	<div id="footer">
		<div id="license"><a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/" class="ccsmall"><img alt="Creative Commons License" style="border-width:0" src="cc_round.png" /></a>&nbsp;&nbsp;This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/" class="gray">Creative Commons Attribution-ShareAlike 3.0 Unported License</a>.</div>
	</div>
</div> <!--end pagewidth -->
</body>
</html>
