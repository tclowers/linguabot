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
					<h1 class="pagehead">Tips and Features.</h1>
					<div class="helpsection">Intelligent Dictionary Search</div>
					<p>The Linguabot dictionary’s intelligent search feature can receive input as English text,  Chinese characters, or Chinese phonetic pinyin - all in one search box, no extra options required. So, if you’re looking for the Chinese word for “door,” you can enter “<b>door</b>,” or “<b>men</b>,” or “<b>门</b>” and you will find what you’re looking for.</p>
					<div class="helpsection">Multiple Varieties of Pinyin</div>
					<p>Pinyin search terms can be entered in full hanyu pinyin with accented characters (i.e.  <b>zhōngguó</b>), pinyin with simple tone numbers (i.e. <b>zhong1guo2</b>) , or as simple plain text (i.e. <b>zhongguo</b>).  Naturally, pinyin entered with tone values will bring up much more specific search results than without. You can also enter pinyin searches either with or without spaces between syllables (i.e. <b>mao ze dong</b> / <b>Mao Zedong</b> / <b>maozedong</b>) it makes no difference.</p>
					<div class="helpsection">Search Hints</div>
					<p>We’re trying hard, but we’re stupid sometimes. If your search isn’t bringing up the desired results, you might want to try our optional Search Hints feature. With Search Hints, you can refine your search further by adding “<b>en:</b>” for English or “<b>ch:</b>” for Chinese pinyin, to your search. This feature is primarily useful in those instances where its unclear weather your search term is in English or pinyin. For example, the phrase “can” might be either the English term for an aluminium can, or a Chinese word for “food”.</p>
					<p>So, if you want to look up “can” as in “soda can,” you can type the following.</p>
					<div class="example"><b>en: can</b>&nbsp;&nbsp;&nbsp;<span class="graytext">or</span>&nbsp;&nbsp;&nbsp;<b>can en:</b></div>
					<p>Likewise, if you want to look up “càn” as in the Chinese for “gem,” or “cān” as in the Chinese for “food,” you just need to type the following.</p>
					<div class="example"><b>ch: can</b>&nbsp;&nbsp;&nbsp;<span class="graytext">or</span>&nbsp;&nbsp;&nbsp;<b>can ch:</b></div>
					<br />
					<div class="helpsection">HTML5 Audio</div>
					<p>On pages for Chinese word entries, you can click on the large blue characters to hear them pronounced. If you are using a supported browser, the sound will play via HTML5 audio, so you will not need any extra browser plugins. If you are using an unsupported browser (for example earlier versions of Internet Explorer, or Firefox), the audio functions will fall back to your browser’s Adobe Flash plugin. So, anywhere you see the little speaker icon <img src="speaker.png" /> just click the words and listen.</p>
					<!--<p><a href="http://creativecommons.org/licenses/by-sa/3.0/"><img src="by-sa.png" id="cclogo1" /></a></p>-->
					<div class="helpsection">Rendering Issues</div>
					<p>If your browser is not displaying Chinese characters correctly, there are a couple of possibile problems you may need to address. If for example you are using an older version Microsoft Internet Explorer to access the internet, you might really want to consider switching to a modern browser such as <a href="http://www.google.com/chrome">Google Chrome</a> or <a href="http://www.mozilla.com/en-US/firefox/">Mozilla Firefox</a>. Both of those browsers are availible as a free download, and either one can greatly improve the quality of your web browsing experience.</p>  
					<p>If changing your browser does not work, you may need to install East-Asian Language support on your operating system. This may sound complicated, but it's actually much simpler than you would imagine. Please see <a href="http://en.wikipedia.org/wiki/Help:Multilingual_support_%28East_Asian%29">this Wikipedia page</a> for details and instructions.</p>
					<div class="helpsection">Contact Us</div>
					<p>If you have any other questions or comments about this site, please feel free to contact me at: <a href="mailto:linguabot@gmail.com">linguabot@gmail.com</a>.</p>
				</div>
			</div> <!-- end maincol -->

	</div> <!-- end wrapper -->

	<div id="spaceit"> </div>
	<div id="footer">
		<div id="license"><a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/" class="ccsmall" target="_blank"><img alt="Creative Commons License" style="border-width:0" src="cc_round.png" /></a>&nbsp;&nbsp;Dictionary content is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/" class="gray">Creative Commons Attribution-ShareAlike 3.0 Unported License</a>.</div>
	</div>
</div> <!--end pagewidth -->
</body>
</html>
