<style type="text/css">
   .inm{
       padding-left: 10px;
       color: #008000;
       font-weight: bold;
   }
   </style>
   <div class="wrap">
   <div class="icon32" id="icon-plugins"><br></div>
   <h2>Setup a Quick Notice</h2> <br>
   <form action="" method="post" id="wpqn">
    <input type="hidden" name="action" value="wpqn_save_notice">
    <label>Message:</label>
    <input type="text" name="notice[message]" value="<?php echo htmlspecialchars(stripcslashes($notice['message'])); ?>" style="font-size: 14pt;padding:3px 10px;width:100%;">
    <br clear="all" />
    <br clear="all" />
    <div style="width: 30%;float:left;margin-right: 25px;">
    <label>Link URL:</label><br/>
    <input type="text" name="notice[url]" value="<?php echo $notice['url']; ?>" style="padding:3px 10px;width:100%;">
    <br clear="all" />
    <br clear="all" />    
    <label>Link Label:</label><br/>
    <input type="text" name="notice[link_label]" value="<?php echo $notice['link_label']?$notice['link_label']:'Read More &#187;'; ?>" style="padding:3px 10px;width:100%;">
    </div>
    <div style="width: 50%;float:left;">
    <label>Background CSS Style: <em>( you can copy exclusive css styles from <a href='http://www.colorzilla.com/gradient-editor/' target="_blank" style="font-weight:bold">here</a> )</em></label><br/>
    <input type="text" name="notice[bg_css]" value="<?php echo $notice['bg_css']?$notice['bg_css']:"background: #6d0019;background: -moz-linear-gradient(top, #6d0019 0%, #a90329 74%);background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#6d0019), color-stop(74%,#a90329));background: -webkit-linear-gradient(top, #6d0019 0%,#a90329 74%);background: -o-linear-gradient(top, #6d0019 0%,#a90329 74%);background: -ms-linear-gradient(top, #6d0019 0%,#a90329 74%);filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#6d0019', endColorstr='#a90329',GradientType=0 );background: linear-gradient(top, #6d0019 0%,#a90329 74%);"; ?>" style="padding:3px 10px;width:100%;">
    <br clear="all" />
    <br clear="all" />
    <table width="100%">
    <tr><td>
    <label>Text Color:</label><br/>
    <input type="text" name="notice[text_color]" value="<?php echo $notice['text_color']?$notice['text_color']:'#ffffff'; ?>" style="padding:3px 10px;width:120px;">
    </td>
    <td>
    <label>Font:</label><br/>
    <select name="notice[font]">
    <option value="Michroma" <?php echo $notice['font']=='Michroma'?'selected=selected':''; ?> >Michroma</option>
    <option value="Oswald" <?php echo $notice['font']=='Oswald'?'selected=selected':''; ?>>Oswald</option>
    <option value="Lobster+Two" <?php echo $notice['font']=='Lobster+Two'?'selected=selected':''; ?> >Lobster Two</option>
    <option value="Nixie+One" <?php echo $notice['font']=='Nixie+One'?'selected=selected':''; ?> >Nixie One</option>
    <option value="Kameron" <?php echo $notice['font']=='Kameron'?'selected=selected':''; ?> >Kameron</option>    
    <option value="Shadows+Into+Light" <?php echo $notice['font']=='Shadows+Into+Light'?'selected=selected':''; ?> >Shadows Into Light</option>    
    <option value="Special+Elite" <?php echo $notice['font']=='Special+Elite'?'selected=selected':''; ?> >Special Elite</option>
    <option value="Jura" <?php echo $notice['font']=='Jura'?'selected=selected':''; ?> >Jura</option>
    <option value="Artifika" <?php echo $notice['font']=='Artifika'?'selected=selected':''; ?> >Artifika</option>
    <option value="Bevan" <?php echo $notice['font']=='Bevan'?'selected=selected':''; ?> >Bevan</option>
    <option value="Maven+Pro" <?php echo $notice['font']=='Maven+Pro'?'selected=selected':''; ?> >Maven Pro</option>
    <option value="Tenor+Sans" <?php echo $notice['font']=='Tenor+Sans'?'selected=selected':''; ?> >Tenor Sans</option>
    <option value="Metrophobic" <?php echo $notice['font']=='Metrophobic'?'selected=selected':''; ?> >Metrophobic</option>
    <option value="Ultra" <?php echo $notice['font']=='Ultra'?'selected=selected':''; ?> >Ultra</option>
    <option value="Muli" <?php echo $notice['font']=='Muli'?'selected=selected':''; ?> >Muli</option>
    <option value="Anonymous+Pro" <?php echo $notice['font']=='Anonymous Pro'?'selected=selected':''; ?> >Anonymous Pro</option>
    <option value="Paytone+One" <?php echo $notice['font']=='Paytone+One'?'selected=selected':''; ?> >Paytone One</option>
    <option value="Francois+One" <?php echo $notice['font']=='Francois+One'?'selected=selected':''; ?> >Francois One</option>
    <option value="Verdana" <?php echo $notice['font']=='Verdana'?'selected=selected':''; ?> >Verdana</option>
    <option value="Tahoma" <?php echo $notice['font']=='Tahoma'?'selected=selected':''; ?> >Tahoma</option>
    </select>
    </td>
    <td>
    <label>Font Size:</label><br/>
    <input type="text" name="notice[font_size]" value="<?php echo $notice['font_size']?$notice['font_size']:'12'; ?>" style="padding:3px 10px;width:50px;"> pt
    </td>
    <td>
    <label>Font Weight:</label><br/>
    <select name="notice[font_weight]">
    <option value="normal">Normal</option>
    <option value="bold" <?php echo $notice['font_weight']=='bold'?'selected=selected':''; ?>>Bold</option>
    </select>
    </td>
    </tr>
    </table>    
    
    </div>
    <br>
    
    <br clear="all" />
    <br clear="all" />
    <input type="checkbox" name="_wpqn_disabled" value="1"> Hide Notice Bar from site 
    <br clear="all" />
    <br clear="all" />
    <!--<input type="submit" name="do" id="btn" class="button-secondary" value="Archive this notice"> -->
    <input type="submit" name="do" id="btn" class="button-primary" value="Save Changes"> 
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