<html>
<head>
<title>LinguaBot Chinese-English Dictionary</title>
<meta http-equiv="Content-type" value="text/html; charset=utf-8">
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" type="text/css" href="lbot.css" />

<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

</head>
<body>
<div id="pagewidth">
	<div id="topline"> </div>
	<div id="header">
		<div id="logo">
			<img src="logo.png"/></span>
		</div> <!--end logo -->
		<div id="nav">
			<ul>
				<li><a href="this.html" class="option">Dictionary</a></li>
				<li>|</li>
				<li><a href="credits.php" class="option">About</a></li>
				<li>|</li>
				<li><a href="that.html" class="option">Help</a></li>
			</ul>
		</div> <!-- end nav -->
	</div> <!-- end header -->
	<?php
	//logo and nav bar
	//require($DOCUMENT_ROOT . "navHeader.html");
	?>
	<div id="wrapper" class="clearfix">
		<div id="twocols"> 
			<div id="maincol">
				<div id="entryform">
					Dictionary Lookup:
					<form action="dictLookup.php" method="get">
					<input type="text" name="word" value="enter English, Chinese, or Pinyin here" id="qbox"/>
					<input type="submit" />
					</form>
				</div> <!--end entryform -->

				<div id="radiustest">This is the radius test</div>

			</div> <!-- end maincol -->

			<div id="rightcol">
				Right Col
			</div> <!-- end rightcol -->
			

		</div> <!-- end twocols -->
	</div> <!-- end wrapper -->

	<div id="footer"><h2>Footer</h2></div>
</div> <!--end pagewidth -->
</body>
</html>
