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
				<div id="simpletext">
					<h1 class="pagehead">About the Dictionary</h1>
					<p>The Linguabot Chinese-English Dictionary is made with only the freshest ingredients: PHP, MySQL, Javascript, HTML5, and CSS.</p>
					<p>The bulk of the dictionary data comes from the excellent CC-CEDICT project, which can be downloaded <a href="http://www.mdbg.net/chindict/chindict.php?page=cedict">here.</a></p>
					<p>The other major component of the database is generated from the complementary English and Chinese headings of Wikipedia articles, based primarily on the brilliant work of <a href="http://reganmian.net/blog/2009/02/16/release-early-release-often-english-chinese-dictionary-based-on-wikipedia/">Stian Håklev,</a> and of course all of the countless contributors to the English and Chinese versions of Wikipedia.</p>
					<p>In keeping with the <a href="http://creativecommons.org/">Creative Commons</a> license under which both of these data sets are maintained, I intend to release my merged database in a unified format, just as soon as I can get a few more of the kinks worked out (the pronunciation data in particular needs some love). Please stay tuned.</p>
					<p>The audio elements of the site use the awesome <a href="http://www.schillmania.com/projects/soundmanager2/">SoundManager2</a> software, written by Scott Schiller. The sounds files used in this dictionary can be freely downloaded from the wonderful people at <a href="http://www.chinese-lessons.com/download.htm">Chinese-lessons.com.</a></p>
					<p>Additionally, in some of the results, I have also made use of the <a href="http://www.barelyfitz.com/projects/tabber/">Javascript Tabifier</a> by Patrick Fitzgerald. Go check out his site, there's some excellent stuff on there.</p>
					<p><a href="http://creativecommons.org/licenses/by-sa/3.0/"><img src="by-sa.png" id="cclogo1" /></a></p>
					<p>Considering all of the Creative Commons licensed work that has contributed to the creation of this site. I believe that I am legally obliged to release the content of this site under the <a href="http://creativecommons.org/licenses/by-sa/3.0/">Creative Commons Attribution-ShareAlike License</a>.</p>
					<p>If I have forgotten you, or your contribution to this site, please feel free to contact me any time at: <a href="mailto:linguabot@gmail.com">linguabot@gmail.com</a>.</p>
				</div>
			</div> <!-- end maincol -->
	</div> <!-- end wrapper -->

	<div id="spaceit"> </div>
	<div id="footer">
		<div id="license"><a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/" class="ccsmall"  target="_blank"><img alt="Creative Commons License" style="border-width:0" src="cc_round.png" /></a>&nbsp;&nbsp;This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/" class="gray">Creative Commons Attribution-ShareAlike 3.0 Unported License</a>.</div>
	</div>
</div> <!--end pagewidth -->
</body>
</html>
