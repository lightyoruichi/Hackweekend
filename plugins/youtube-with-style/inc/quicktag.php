<?php

function youtube_quicktag(){

	echo '<script type="text/javascript">'."\n";
	echo "\t".'function insertyoutubetag( myField ) {'."\n";
	echo "\t\t".'var youtubetag_startPos = myField.selectionStart;'."\n";
	echo "\t\t".'var youtubetag_endPos = myField.selectionEnd;'."\n";
	echo "\t\t".'var youtubetag_selection = myField.value.substring( youtubetag_startPos, youtubetag_endPos );'."\n";
	echo "\t\t".'edInsertContent(myField, "[youtube]" + youtubetag_selection + "[/youtube]");'."\n";
	echo "\t".'}'."\n";
	echo "\t".'if(document.getElementById("ed_toolbar")){'."\n";
	echo "\t\t".'qt_toolbar = document.getElementById("ed_toolbar");'."\n";
	echo "\t\t".'edButtons[edButtons.length] = new edButton("ed_youtubetag","youtubetag","","","");'."\n";
	echo "\t\t".'var qt_button = qt_toolbar.lastChild;'."\n";
	echo "\t\t".'while (qt_button.nodeType != 1){'."\n";
	echo "\t\t"."\t".'qt_button = qt_button.previousSibling;'."\n";
	echo "\t".'}'."\n";
	echo "\t".'qt_button = qt_button.cloneNode(true);'."\n";
	echo "\t".'qt_button.value = "youtube";'."\n";
	echo "\t".'qt_button.title = "Insert Youtube Tag";'."\n";
	echo "\t".'qt_button.onclick = function () { insertyoutubetag( edCanvas); }'."\n";
	echo "\t".'qt_button.id = "ed_youtubetag";'."\n";
	echo "\t".'qt_toolbar.appendChild(qt_button);'."\n";
	echo "\t".'}'."\n";
	echo '</script>'."\n";
}

add_action('admin_footer', 'youtube_quicktag');
