<style type="text/css">
   .inm{
       padding-left: 10px;
       color: #008000;
       font-weight: bold;
   }
   </style>
   <div class="wrap">
   <div class="icon32" id="icon-tools"><br></div>
   <h2>Quick Notice Settgins</h2> <br>
   <form action="" method="post" id="wpqn">
    <input type="hidden" name="action" value="wpqn_save_notice_settings">
    <table cellpadding="4">
    <tr><td>Twitter Profile URL:<br/><input type="text" size="80" name="twitter" value="<?php echo get_option('_wpqn_twitter'); ?>"></td></tr>
    <tr><td>Facebook page URL:<br/><input type="text" size="80" name="facebook" value="<?php echo get_option('_wpqn_facebook'); ?>"></td></tr>
    <tr><td valign="top">Custom Code:<br/><textarea rows="4" cols="63" name="custom_code"><?php echo get_option('_wpqn_custom_code'); ?></textarea></td></tr>
    </table>
    <br clear="all" />
    <br clear="all" />
    <input type="submit" id="btn" class="button-primary" value="Save Settgins"> 
    <span id="loading" style="display: none;"><img src="images/loading.gif" alt=""> saving...</span>
    </form>
    </div>
    <script language="JavaScript">
    <!--
      jQuery('#wpqn').submit(function(){
           jQuery(this).ajaxSubmit({
               'url': ajaxurl,
               'beforeSubmit':function(){
                   jQuery('#loading').fadeIn();
               },
               'success':function(res){
                   jQuery('#loading').fadeOut();
               }
           });
      return false;
      });
    //-->
    </script>