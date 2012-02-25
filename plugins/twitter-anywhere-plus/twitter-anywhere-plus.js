jQuery(function ($) {

$(document).ready(function(){
	
	$("#tweetBox").mouseover(function() {
		$("#tweetBox > .twitter-anywhere-tweet-box")[0].contentWindow.document.getElementById("tweet-box").focus();
	});
	
});

});