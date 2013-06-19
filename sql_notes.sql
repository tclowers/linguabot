select e.definition, z.pinyin_tone, z.simpHan FROM enText e, zhText z where (e.definition like '%pin%' or z.pinyin_plain like '%pin%') and e.zh_id=z.zh_id and e.definition is not null order by length(e.definition), e.frequency desc limit 10;


/*


characters used in pinyin: (ā|á|ă|à|ē|é|ĕ|è|ī|í|ĭ|ì|ō|ó|ŏ|ò|ü|ǘ|ǚ|ǜ|ū|ú|ŭ|ù)

####################
TODO>>

	** the pronunciation ipa data needs fixing, right now "the wind"="to wind"
	see: http://en.wikipedia.org/wiki/List_of_English_homographs
		--to use this data we need a better grasp on the part of speech data
		-- also drop pronunciation data that is incomplete or mangled, and anything over something like 5 words

	** the word-display page needs a few more features, like being able to click on each hanzi character and see its meaning and details

	

	


Post-Completion Improvements>>

	** add OpenSearch data so you can search the dictionary from chrome or firefox's search bar


Completed>>

	--DONE-- ** add search tags feature, like in opera's search bar: en - english only, py - pinyin only, or mx - mixed

	--DONE -- ** Integrate wikipedia entry data, but first rebuild with that ruby script the original author used, there's
		a lot more data now.
				Note: the scripts I used for this are kind of hacky, and I never got the ruby script completely working, I tried to re-do it in perl, but the source file is too huge for my laptop to handle so right now I'm just proccessing the output of the broken ruby script.

	--DONE -- ** add a superscript note feature that explains tone sandhi

	--DONE-- (mostly done, probably could use some more testing)** add html5 sound player to chinese words of two syllables or less and those english words we have mp3s of
		--just split the chinese characters and the numbered pinyin string, then use the numbered pinyin syllable text as part of
			the soundmanager link for each character in order
		--I wanted to have something like this, but my javascript is weak right now, maybe look into this later:
			<!-- script to play the individual files -->
			<script type="text/javascript">
			function playVoice(filep)
			{
				var mySound = soundManager.createSound({
				  id: 'hanSound',
				  url: filep,
				  volume: 50,
				  onload: soundLoadedFunction
				});
				mySound.play();
			}
			</script>

		---that way we could use this to call the script:
			echo "<a href=\"#\" onClick=\"javascript:playVoice('./mandarin_sounds/" . $sounds[$pinIndex] . ".mp3');\" class=\"bighan\">" . $simpHan . "</a>\n";




##########################

*/


/* had to do this so the frequency data would be any good */
mysql> select max(frequency) from zhText;
+----------------+
| max(frequency) |
+----------------+
|           5000 |
+----------------+
1 row in set (0.23 sec)


update zhText set frequency='5001' where frequency is null;

mysql> select max(frequency) from enText;
+----------------+
| max(frequency) |
+----------------+
|          20000 |
+----------------+
1 row in set (0.29 sec)

mysql> update enText set frequency='20001' where frequency is null;

Query OK, 124861 rows affected (1.57 sec)
Rows matched: 124861  Changed: 124861  Warnings: 0

