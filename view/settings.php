<script>

  jQuery(document).ready(function($) {

    var linked_data_packed = "<?php echo get_option('wp_ultimate_security_checker_linked_data');?>";
    var linked_data = linked_data_packed ? JSON.parse(linked_data_packed) : undefined;

    if (linked_data) {
      var option = $('#blog_linked option:first');
      $(option).attr('id', 'srvid_' + linked_data.id).attr('selected', true);				
      $(option).text('server: ' + linked_data.ftphost +', WP location: ' + linked_data.ftppath).val( linked_data_packed);
      $('#blog_linked').append(option);
    }

    $("#blog_unlink").live("click", function(e){
      if ($('#blog_linked option:first').attr('id') != 'link_unavailable') {
        var data = {action: 'unlink_blog', csrfmiddlewaretoken: ajax_token};
        $('#ajax_loading').fadeIn();
        jQuery.post(ajaxurl, data, function(response) {
          $('#ajax_loading').fadeOut();
          window.location.reload();
        });
      }						
    });

    $("#blog_change_link").live("click", function(e){
      var that = this;
      $('#ajax_loading').fadeIn();
      $.ajax({
        url: "<?php echo $status_url; ?>&callback=?",
        dataType: "jsonp",
        complete: function (){
         $('#ajax_loading').fadeOut();
        },
        success: function(response) {
          if (response && response.state == 'error') {
            switch (response.errno) {
	 			 			case -3: // Multiple blogs found
                $("#blog_link_ops").hide();
                select_website(response.data);
                return;
            }
          }
        }
      });
    });

    $("#website_confirm").live("click", submit_selected_site);

});

</script>

<div class="wrap">    

  <?php wp_ultimate_security_checker_header(); ?>

  <h3 class="nav-tab-wrapper usc-tabs">
    <a href="?page=ultimate-security-checker&tab=run-the-tests" class="nav-tab"><?php _e('Run the Tests');?></a>
    <a href="?page=ultimate-security-checker&tab=wp-files" class="nav-tab"><?php _e('Files Analysis');?></a>
    <a href="?page=ultimate-security-checker&tab=how-to-fix" class="nav-tab"><?php _e('How to Fix');?></a>
    <a href="?page=ultimate-security-checker&tab=settings" class="nav-tab nav-tab-active"><?php _e('Settings');?></a>
    <!--<a href="?page=ultimate-security-checker&tab=pro" class="nav-tab"><?php _e('PRO Checks');?></a>-->
  </h3>
  
  <!-- <p style="border:2px solid #eee;margin-left:3px;background:#f5f5f5;padding:10px;width:706px;font-size:14px;color:green;font-family:helvetica;"> Please check out our new idea: <strong>WP AppStore</strong>. 1-click install best plugins and themes. <a style="color:#e05b3c;text-decoration:underline;" href="http://wordpress.org/extend/plugins/wp-appstore/" target="_blank">Check it out!</a>
	</p> -->

  <style>
    pre {
      padding:10px;
      background:#f3f3f3;
      margin-top:10px;
    }
    .answers p, .answers ul, .answers pre {
      margin-left:10px;
      line-height:19px;
    }
    .answers ul{
      list-style-type:disc !important;
      padding-left:17px !important;
    }
    input[type="radio"] {
      margin-right: 5px;
    }
  </style>

  <a name="#top"></a>

  <div class="stab">
    <h2><?php _e('Plugin options');?></h2>
    <form method="get" action="<?php echo admin_url( 'tools.php' ); ?>" enctype="text/plain" id="wp-ultimate-security-settings">
      <!--<h4>API key from site's settings page:</h4>
      <input type="text" style="width:300px" name="apikey" value="<?php echo htmlspecialchars(get_option('wp_ultimate_security_checker_apikey')); ?>"/>
      <input type="submit" class="button-primary" value="Save"/>-->

      <h4><?php _e('Disable Facebook Like:');?></h4>
      <input type="hidden" value="ultimate-security-checker" name="page" />
      <input type="hidden" value="settings" name="tab" />
      <ul>
        <li><input type="radio" <?php if(! get_option('wp_ultimate_security_checker_flike_deactivated', false)) echo 'checked="checked"';?> value="k" name="flike" /><?php _e('Keep Facebook Like');?></li>
        <li><input type="radio" <?php if(get_option('wp_ultimate_security_checker_flike_deactivated', true)) echo 'checked="checked"';?> value="n" name="flike" /><?php _e('Disable it');?></li>
      </ul>

      <h4>Remind me about re-scan in:</h4>
      <ul>
        <li><input type="radio" <?php if(get_option('wp_ultimate_security_checker_rescan_period') == 14) echo 'checked="checked"';?> value="w" name="rescan" />2 weeks</li>
        <li><input type="radio" <?php if(get_option('wp_ultimate_security_checker_rescan_period') == 30) echo 'checked="checked"';?> value="m" name="rescan" />1 month</li>
        <li><input type="radio" <?php if(get_option('wp_ultimate_security_checker_rescan_period') == 0) echo 'checked="checked"';?> value="n" name="rescan" />Never remind me</li>
      </ul>
      <p>
        <input id="id_hide_header" type="checkbox" name="hide_header" value="1" <?php if(get_option('wp_ultimate_security_checker_hide_header') == 1) echo 'checked="checked"';?> /><label for="id_hide_header">Hide header security points</label> 
      </p>
      <p><input type="submit" class="button-primary" value="<?php _e('Save Settings');?>" /></p>
    </form>

    <div class="clear"></div>
    <h3>System Information.</h3>
    <p>
      WordPress location (copy to <a href="http://www.ultimateblogsecurity.com/?utm_campaign=plugin">add site page</a> for <a href="http://www.ultimateblogsecurity.com/?utm_campaign=plugin">automated security checking service</a>):<br/>
      <pre><?php echo ABSPATH; ?></pre>
    </p>
    <!-- security-check -->
    <h3><?php _e('Keep your blog secure with automated checks.');?><a name="security-check"></a><a href="#top" style="font-size:13px;margin-left:10px;">&uarr; <?php _e('Back');?></a>
    </h3>
    <p>
      <?php _e('A lot of the security vulnerabilities are put back in place when themes and the WordPress core version is updated.  You need to run regular checks using this plugin, or <a href="http://www.ultimateblogsecurity.com/?utm_campaign=plugin">register for our service</a> and we will check your blog for you weekly and email you the results.');?></p>
      <p><?php _e('We also have a paid service which automatically fixes these vulnerabilities. Try it by clicking the button:');?><br> <a href="http://www.ultimateblogsecurity.com/?utm_campaign=fix_issues_plugin_button"><img src="<?php echo plugins_url( 'ultimate-security-checker/img/fix_problems_now.png'); ?>" alt="" /></a>
    </p>
    <!-- end security-check -->
  </div>
  <div class="clear"></div>
</div>
