<?php
function navBar($selected) {
	if ($selected == "dictionary" || $selected == "index") {
		$dictClass = "selected";
	} else {
		$dictClass = "option";
	}

	if ($selected == "about") {
		$aboutClass = "selected";
	} else {
		$aboutClass = "option";
	}


	if ($selected == "help") {
		$helpClass = "selected";
	} else {
		$helpClass = "option";
	}

	echo "<div id=\"nav\">\n";
	echo "	<ul>\n";
	if ($selected == "index") {
		echo "		<li><span class=\"selected\">Dictionary</span></li>\n";
	} else {
		echo "		<li><a href=\"index.php\" class=\"" . $dictClass . "\">Dictionary</a></li>\n";
	}
	echo "		<li>|</li>\n";
	echo "		<li><a href=\"http://www.mandarintrainer.com\" class=\"option\">Lessons</a><span class=\"newtag\"> NEW</span></li>\n";
	echo "		<li>|</li>\n";
	echo "		<li><a href=\"credits.php\" class=\"" . $aboutClass . "\">About</a></li>\n";
	echo "		<li>|</li>\n";
	echo "		<li><a href=\"help.php\" class=\"" . $helpClass . "\">Help</a></li>\n";
	echo "	</ul>\n";
	echo "</div> <!-- end nav -->\n";
}
?>
