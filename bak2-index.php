<?php
/* Trying to make Internet Explorer suck less */
header('Content-Type:text/html; charset=UTF-8');
?>
<html>
<head>
<title>LinguaBot Chinese-English Dictionary</title>
<meta name="description" content="Chinese-English dictionary. Lists over 253,000 Mandarin Chinese terms with multiple English definitions. Streaming HTML5 Chinese pronunciation audio included." />
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
	<div id="header">
		<div id="logo">
			<img src="logo.png" alt="site logo" /></span>
		</div> <!--end logo -->
		<?php
			require("navBar.php");
			navBar("index");
		?>
	</div> <!-- end header -->
	<div id="wrapper" class="clearfix">
			<div id="maincol">
				<hi id="dictionary"><a href="http://www.linguabot.com" class="headimage"><img src="chinese_english_dictionary.png" alt="Chinese-English Dictionary" /></a></h1>
				<div id="entryform">
					<!--<p>Dictionary Lookup:</p>-->
					<form action="dictLookup.php" method="get">
					<input type="text" name="word" value="Enter text in English, Chinese, or Pīnyīn here" id="qbox"/>
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
