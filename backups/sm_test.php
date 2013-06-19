<html>
<head>
<title>LinguaBot Chinese-English Dictionary</title>
<meta http-equiv="Content-type" value="text/html; charset=utf-8">
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" type="text/css" href="lbot.css" />

<link rel="stylesheet" type="text/css" href="./sm2/css/inlineplayer.css" />

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script type="text/javascript" src="./sm2/script/soundmanager2.js"></script>
<script type="text/javascript" src="./sm2/script/inlineplayer.js"></script>


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

<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

</head>
<body>
<?php

function mb_str_split( $string ) {
    # Split at all position not after the start: ^
    # and not before the end: $
    return preg_split('/(?<!^)(?!$)/u', $string );
} 

	$simpHanzi = "猴戏";

	$numPin = "hou2 xi4";

	$sounds = preg_split("/\s/", $numPin);

	$hanChars = mb_str_split($simpHanzi);

	//$snd1 = "hou2";
	//$snd2 = "xi4";

	echo "<a href=\"./mandarin_sounds/" . $sounds[0] . ".mp3\" class=\"bighan\">" . $hanChars[0] . "</a>";
	echo "<a href=\"./mandarin_sounds/" . $sounds[1] . ".mp3\" class=\"bighan\">" . $hanChars[1] . "</a>";
?>
<!--<a href="./mandarin_sounds/hou2.mp3" class="bighan">猴</a> <a href="./mandarin_sounds/xi4.mp3" class="bighan">戏</a>-->
<div id="pinyin">hóu xì</div><br /><br />
</body>
</html>
