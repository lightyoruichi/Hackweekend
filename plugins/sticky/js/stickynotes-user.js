// JavaScript Document
jQuery(document).ready(function(){
	 jQuery('#stickynote-main').wpStickyNotes();
});

(function($){
 	$.fn.extend({ 
 		//plugin name - animatemenu
 		wpStickyNotes: function(options) {

			/*var defaults = {
			    animatePadding: 60,
           		defaultPadding: 10,
           		evenColor: '#ccc',
           		oddColor: '#eee',
			};*/
			
			$.zIndex = 0;
			$.ctlimit = 128;
			$.tilimit = 40;
			/* Finding the biggest z-index value of the notes */
			return this.each(function() {
				//var options = $.extend(defaults, options);
				/*$.o = options,*/ $.m = $(this);
								
				var stickynote = $(".stickynote", $.m);
				var addform = $("#add_sticky_note", $.m);
				
				$(".stickynote").live("mouseover", function(ev) {
					if($(this).find('.identify').is(":not(:hidden)")){
						$(this).find('.stickynote-rightarrow').show();
						$(this).find('.stickynote-leftarrow').show();
					}
				});
				$(".stickynote").live("mouseout",function(ev){
						$(this).find('.stickynote-rightarrow').hide();
						$(this).find('.stickynote-leftarrow').hide();
				});
				
				/* START STICKY NOTE EACH */
				stickynote.livequery(function(){
					
					/* Setup Vars */
					var comments = $(this).find('ul.stickynote-body');
					var leftarrow = $(this).find('.stickynote-leftarrow');
					var rightarrow = $(this).find('.stickynote-rightarrow');
					var toggle = $(this).find('.identify');
					
					var comment_text = $(this).find('.stickynote_comment-comment'), comment_text_c = $(this).find('.stickynote-count');
					
					/* Setup Stickynote */
					leftarrow.hide();
					rightarrow.hide();
					
					tmp = $(this).css('z-index');
					if(tmp>$.zIndex) $.zIndex = tmp;
					
					make_draggable($(this));
					
					/* Bind Elements */
					$(this).find('.stickynote-commentsbutton').live('click', togglestickynote);
					comment_text.bind("keyup", {element: comment_text, count: comment_text_c, li:$.ctlimit}, calculatetext);
					$(this).find(".stickynote_comments_form").live("submit", submitcomment);
					
					//if (comments.children("li").length > 1) {
						$('li',comments).hide().eq(0).show();
						leftarrow.live("click", function() {
							$('li:visible',comments).hide().prev('li').fadeIn(100);
							if ($('li:visible',comments).length < 1) {
								$('li:last',comments).fadeIn(100);
							}
						});
						// add the forward button behavior
						rightarrow.live("click", function() {
							$('li:visible',comments).hide().next('li').fadeIn(100);
							if ($('li:visible',comments).length < 1) {
								$('li:first',comments).fadeIn(100);
							}
						});
					//}
					
				});
				/* END STICKY NOTE EACH */
				
				/* START TABBED FORM */
				var notepreview = addform.find('#sticknote-preview');
				var toggle = addform.find('.identify');
				var button = addform.find('#stickynote-toggle');
				
				var new_title = addform.find("#stickynote-title"), new_title_c = addform.find(".stickynote-title-count")
				var new_content = addform.find("#stickynote-content"), new_content_c = addform.find(".stickynote-content-count");
				
				/* Setting up */
				notepreview.hide();
				new_content.css({top:"-"+new_content.outerHeight()+"px", zIndex: 0});
				
				/* Bind Elements */
				button.live("click.toggleformbox", toggleformbox);
				new_title.bind("keyup", {element: new_title, count: new_title_c, li:$.tilimit}, calculatetext);
				new_content.bind("keyup", {element: new_content, count: new_content_c, li:$.ctlimit}, calculatetext);
				addform.find(".sticknote_createnote-form").live("submit", submitstickynote);
				
				addform.find('.pr-stickynote-content,.pr-stickynote-title').bind('keyup',function(e)
				{
					if(!this.preview)
					{
						this.preview = addform.find('.stickynote');
					}
					
					this.preview.find($(this).attr('class').replace('pr-','.'))
						.html($(this).val().replace(/<[^>]+>/ig,''));
				});
				
				addform.find('.color-box-box').live('click',function(){
					notepreview.find('.stickynote').removeClass('_sticky_note_01 _sticky_note_02 _sticky_note_03 _sticky_note_04 _sticky_note_05 _sticky_note_06').addClass($(this).attr('rel'));
				});
				
				//addform.find('#stickynote-comments').removeAttr("checked");
				addform.find('#stickynote-comments').bind('click',function(e)
				{
					if($(this).attr('checked'))
					{
						addform.find('.pr-stickynote-commentsbutton').fadeIn();
					} else {
						addform.find('.pr-stickynote-commentsbutton').fadeOut();
					}
				});
			});
			
			function togglestickynote()
			{
				element = $(this).parent();
				if (element.find('.identify').is(":hidden")) {
					element.find('.stickynote_comments_data').fadeIn(400); 
					element.find('.stickynote_comments_form').fadeOut(400);
					element.find('.identify').show();
					element.find('a.stickynote-leftarrow').show(); element.find('a.stickynote-rightarrow').show();
				} else {
					element.find('.stickynote_comments_data').fadeOut(400); 
					element.find('.stickynote_comments_form').fadeIn(400);
					element.find('.identify').hide();
					element.find('a.stickynote-leftarrow').hide(); element.find('a.stickynote-rightarrow').hide();
				}
			}
						
			function toggleformbox()
			{
				var element = $(this).parent().parent().parent();
				
				if (element.find('.main_identify').is(":hidden")) {
					element.find('#sticknote-preview').fadeOut();
					element.find('#add_sticky_note-content').animate({ 
						top: "-"+element.find("#add_sticky_note-content").outerHeight()+"px"
						}, 400, function(){element.css({zIndex: 0});});
					
					element.find('#stickynote-toggle').html('+ Create Sticky Note');
					element.find('.main_identify').show();
				} else {
					element.find('#sticknote-preview').delay(400).fadeIn(600);
					element.find('#add_sticky_note-content').animate({ 
						top: "0px"
						}, 400 );
					//alert($.zIndex);
					element.css({zIndex: parseInt($.zIndex) + 1});
					element.find('#stickynote-toggle').html('- Create Sticky Note');
					element.find('.main_identify').hide();
				}
			}
			
			function make_draggable(elements)
			{
				/* Elements is a jquery object: */
				elements.draggable({
				containment:'parent',
				start:function(e,ui){ ui.helper.css('z-index',++$.zIndex); },
				stop:function(e,ui){
						$.post(ajax_url, {
							'action'  : 'stickynote_updateposition',
							'x'		: ui.position.left,
							'y'		: ui.position.top,
							'z'		: $.zIndex,
							'id'	: parseInt(ui.helper.find('span.stickynote-id').html())
						});
					}
				});
			}
			
			function calculatetext(e)
			{
				var textlength = e.data.element.val().length;
				var element = e.data.element;
				var limit = e.data.li;
				var count = e.data.count;
				if(textlength > limit){
					count.text("0 remain").css('color','#CB0000');
					element.val(element.val().substr(0,limit));
					return true;
				}else{
					count.text((limit - textlength) + " remain");
				}
			}
			
			function submitcomment()
			{
				var the_form = $(this);
				var stickynote = the_form.parent();
				var content = the_form.find('.stickynote_comment-comment'); 
				var author = the_form.find('.stickynote_comment-author').val();
				var id = the_form.find('.stickynote_comment-ID').val();
				var submitbtn = the_form.find('.stickynote_comment-submit');
				var tempsubmit = submitbtn;
				
				if(content.val().length < 4)
				{
					alert("Your comments is too short!")
					return false;
				}
				
				submitbtn.replaceWith('<img src="'+stickynotes_pluginurl+'/images/ajax-loader.gif" style="margin:3px 2px; display:block; float:right;" class="stickynote-loading" />');
				
				/*var data = new Array();
				data = {
					'action' : "stickynote_post_comment",
					'body' : content.val(),
					'stickynote_ID' : id,
					'author' : author,
				}*/
				/*data['action'] = "stickynote_post_comment";
				data['body'] = content.val();
				data['stickynote_ID'] = id;
				data['author'] = author;*/
					
				/* Sending an AJAX POST request: */
				$.post(ajax_url, {'action' : "stickynote_post_comment",'body' : content.val(),'stickynote_ID' : id,'author' : author}, function(msg){ 
					if(msg)
					{
						/* msg contains the ID of the note, assigned by MySQL's auto increment: */
						stickynote.find('.stickynote_comments_data .stickynote-body').append(msg);
						the_form.find('.stickynote-loading').replaceWith(tempsubmit);
						content.val("");
						stickynote.find('.stickynote-commentsbutton').trigger("click");
					}
					
				});
				
				return false;
			}
			
			function submitstickynote(element)
			{
				var the_form = $(this);
				var addnote = $(this).parent().parent().parent();
				
				var new_title = the_form.find("#stickynote-title");
				var new_content = the_form.find("#stickynote-content");
				var author = the_form.find('.stickynote_comment-author').val();
				var comments_box = the_form.find("#stickynote-comments");
				var submitbtn = the_form.find("#stickynote-submit");
				var tempsubmit = submitbtn.clone();

				if(new_content.val().length < 4)
				{
					alert("The note text is too short!")
					return false;
				}
				
				if(new_content.val().length > 128)
				{
					alert("The note text is too long!")
					return false;
				}
				
				submitbtn = submitbtn.replaceWith('<img src="'+stickynotes_pluginurl+'/images/ajax-loader.gif" style="margin-right:30px; display:block; float:right;" id="stickynote-loading" />');
				submitbtn = $("#stickynote-loading");
				
				if(comments_box.attr('checked'))
				{
					var comments = 'open';
				} else {
					var comments = 'closed';
				}
				
				var data = {
					'action'	: "stickynote_create",
					'zindex'	: ++$.zIndex,
					'title'		: new_title.val(),
					'body'		: new_content.val(),
					'author'	: author,
					'comments'  : comments,
					'style'		: jQuery.trim(addnote.find('.stickynote').attr('class').replace('stickynote','').replace('box-shadow','').replace('ui-draggable',''))
				};		
				/* Sending an AJAX POST request: */
				$.post(ajax_url, data, function(msg){ 
					if(parseInt(msg))
					{
						var orig = addnote.find('.stickynote');
						var tmp = orig.clone();
						
						orig.find('.stickynote-content').text(""); orig.find('.stickynote-title').text("");
						orig.find('.pr-stickynote-commentsbutton').hide();
						
						tmp.find('.pr-stickynote-commentsbutton').removeClass('pr-stickynote-commentsbutton').addClass('stickynote-commentsbutton').parent().find('span.stickynote-id').text(msg).end().css({zIndex:$.zIndex,top:0,left:0});
						tmp.hide().appendTo($.m).fadeIn(1200);
						
						if(comments == 'open'){
						$.post(ajax_url, {'action': 'get_comments_form','id' : msg}, function(get_comments_form){
							tmp.append(get_comments_form);
							//alert(get_comments_form);
						});
							tmp.find('.stickynote-body').append('<a class="stickynote-leftarrow"></a><a class="stickynote-rightarrow"></a>');
						}else{
							tmp.find('.stickynote-commentsbutton').remove();
						}
						make_draggable(tmp);
						//submitbtn.replaceWith('<a id="stickynote-submit" tabindex="4" onclick="jQuery(this).closest("form").submit();">Stick It!</a>');
						submitbtn.css({'width':"100px"});
						submitbtn.replaceWith(tempsubmit);
						addnote.find('#stickynote-toggle').trigger("click.toggleformbox");
						addnote.find('.identify').css({display: 'none'});
						$(".stickynote-content-count").text(" ");
						$(".stickynote-title-count").text(" ");
						new_content.val("");
						new_title.val("");
						comments_box.removeAttr("checked");
					}
					
				});
				
				return false
			}
    	}
	});
})(jQuery);