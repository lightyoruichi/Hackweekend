jQuery(function ($) {

$(document).ready(function(){
 
	$("body").append('\
	<div id="lightdiv-overlay"></div>\
	<div id="lightdiv">\
	<div class="twitter-bird"></div>\
	  <table id="tabla">\
		<tbody>\
		  <tr>\
			<td class="tl"/><td class="b"/><td class="tr"/>\
		  </tr>\
		  <tr>\
			<td class="b"/>\
			<td class="body">\
			  <div id="tap-rt-tweetbox"></div>\
			  <!-- <div class="footer"><a href="#retweet" class="close"><img src="close.gif" title="Close" border="0" /></a></div> -->\
			</td>\
			<td class="b"/>\
		  </tr>\
		  <tr>\
			<td class="bl"/><td class="b"/><td class="br"/>\
		  </tr>\
		</tbody>\
	  </table>\
	</div>\
	');
	
	var rtLabel = TwitterAnywherePlus.rtLabel;
	var rtContent = TwitterAnywherePlus.rtContent;
	
	twttr.anywhere(function (T) {
	T("#tap-rt-tweetbox").tweetBox({
	label: rtLabel,
	defaultContent: rtContent
	});
	});
	
	setTimeout(function() {
		$("#lightdiv-overlay").append('<div class="plugin">Twitter @Anywhere Plus v2.0</div>');
	}, 8000);
	
	$("#tap-rt-tweetbox").mouseover(function() {
		$("#tap-rt-tweetbox > .twitter-anywhere-tweet-box")[0].contentWindow.document.getElementById("tweet-box").focus();
	});
	
	$("#lightdiv-overlay").css("opacity","0.0");
	//$("#lightdiv").css("opacity","0.0");

    $(document).click(function(e){
        if(e.target.id != 'lightdiv-overlay') {
			if(e.target.id == 'lightdiv-button') {
				$("#lightdiv-overlay").css("visibility","visible");
				$("#lightdiv").css("visibility","visible");
				//$("#lightdiv").stop().animate({opacity: 1.0}, "slow"); // PNGs are not transparent in IE8
				$("#lightdiv-overlay").stop().animate({opacity: 0.6}, "slow");
			}
		} else {
			$("#lightdiv-overlay").stop().animate({opacity: 0.0}, "slow", function() { $("#lightdiv-overlay").css("visibility","hidden"); });
			//$("#lightdiv").stop().animate({opacity: 0.0}, "slow", function() { $("#lightdiv").css("visibility","hidden"); });
			$("#lightdiv").css("visibility","hidden");
		}
	});
 
});

});