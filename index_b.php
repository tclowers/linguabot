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
<link rel="stylesheet" type="text/css" href="frontpage_b.css" />
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

</head>
<body>
<div id="pagewidth">
	<div id="topline"> </div>
	<!--<div id="header">
		<div id="logo">
			<img src="logo.png" alt="site logo" /></span>
		</div> <!--end logo -   ->
		<?php
			require("navBar.php");
			navBar("index");
		?>
	</div> <!-- end header -->
	<div id="wrapper" class="clearfix">
			<div id="maincol">
				<hi id="dictionary"><img src="chinese_english_dictionary_orange.png" alt="Chinese-English Dictionary" /><!--<span class="dicheader">CHINESE-ENGLISH STUDY DICTIONARY</span>--></h1>
				<div id="entryform">
					<!--<p>Dictionary Lookup:</p>-->
					<form action="dictLookup_b.php" method="get">
					<input type="text" name="word" value="Enter text in English, 中文, or Pīnyīn here" id="qbox"/>
					<input type="submit" id="lookup" value="Go" />
					</form>
				</div> <!--end frontentryform -->
				<div id="extras">
					<!--<ul>
						<li><a href="credits_b.php" class="option">About</a></li>
						<li>|</li>
						<li><a href="help_b.php" class="option">Help</a></li>
					</ul>-->
					<p><a href="help_b.php" class="option">Help</a></p>
				</div> <!-- end extras -->
			</div> <!-- end frontmaincol -->
	</div> <!-- end wrapper -->

	<div id="spaceit"> </div>
	<div id="footer">
		<div id="license"><a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/" class="ccsmall" target="_blank"><img alt="Creative Commons License" style="border-width:0" src="cc_round.png" /></a>&nbsp;&nbsp;Dictionary content is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/" class="gray">Creative Commons Attribution-ShareAlike 3.0 Unported License</a>.</div>
	</div>
</div> <!--end pagewidth -->
</body>
</html>
