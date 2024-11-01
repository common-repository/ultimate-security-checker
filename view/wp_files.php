<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('#run-scanner').click( function() {
			$.ajaxSetup({
				type: 'POST',
				url: ajaxurl,
				complete: function(xhr,status) {
					if ( status != 'success' ) {
						$('#scan-loader img').hide();
						$('#scan-loader span').html( '<?php _e('An error occurred. Please try again later.');?>' );
					}
				}
			});
			$('#scan-results').hide();
			$('#scan-loader').show();
      $('#run-scanner').hide();
      usc_file_scan();
      return false;
    });
	});
  usc_file_scan = function() {
    jQuery.ajax({
      data: {
        action: 'ultimate_security_checker_ajax_handler',
        _ajax_nonce: '<?php echo wp_create_nonce( 'ultimate-security-checker_scan' ); ?>',
      }, success: function(r) {
        var res = jQuery.parseJSON(r);
        if ( 'processing' == res.status ) {
          jQuery('#scan-loader span').html(res.data);
          usc_file_scan();
        } else if ( 'error' == res.status ) {
	 			// console.log( r );
	 			jQuery('#scan-loader img').hide();
	 			jQuery('#scan-loader span').html(
	 				'<?php _e('An error occurred:');?> <pre style="overflow:auto">' + res.data + '</pre>'
            );
	 		} else {
          jQuery('#scan-loader img').hide();
          jQuery('#scan-loader span').html('<?php _e('Scan complete. Refresh the page to view the results.');?>');
          window.location.reload(false);
        }
      }
    });
  };
</script>

<div class="wrap">
  <style>
    div.danger-found {
      margin-bottom: 25px;
    }
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
    div#scan-loader{
      display: none;
    }
    h3.nav-tab-wrapper .nav-tab {
      padding-top:7px;
    }
  </style>


  <?php wp_ultimate_security_checker_header(); ?>


  <h3 class="nav-tab-wrapper usc-tabs">
    <a href="?page=ultimate-security-checker&tab=run-the-tests" class="nav-tab"><?php _e('Run the Tests');?></a>                    
    <a href="?page=ultimate-security-checker&tab=wp-files" class="nav-tab nav-tab-active"><?php _e('Files Analysis');?></a>
    <a href="?page=ultimate-security-checker&tab=how-to-fix" class="nav-tab"><?php _e('How to Fix');?></a>
    <a href="?page=ultimate-security-checker&tab=settings" class="nav-tab"><?php _e('Settings');?></a>
    <!--<a href="?page=ultimate-security-checker&tab=pro" class="nav-tab"><?php _e('PRO Checks');?></a>-->
  </h3>
  
  <!-- <p style="border:2px solid #eee;margin-left:3px;background:#f5f5f5;padding:10px;width:706px;font-size:14px;color:green;font-family:helvetica;"> Please check out our new idea: <strong>WP AppStore</strong>. 1-click install best plugins and themes.
	<a style="color:#e05b3c;text-decoration:underline;" href="http://wordpress.org/extend/plugins/wp-appstore/" target="_blank">Check it out!</a>
	</p>-->
  <a name="#top"></a>
  <div class="stab">
    <h2><?php _e('Your blog files vulnerability scan results:');?></h2>
    <span style="margin: 15xp; display: inline-block;"><?php _e("This scanner will test your blog on suspicious code patterns. Even if it finds something - it doesn't mean, that code is malicious code actually. Also, this test is in beta, so may stop responding. Results of this test <strong>DO NOT</strong> affect your blog security score. We provide it as additional scanning to find possible danger inclusions in your code.");?>
    </span>

    <a style="float:left;margin-top:20px;font-weight:bold;" href="#" class="button-primary" id="run-scanner">Scan my blog files now!</a>
    <div class="clear"></div>
    <div id="scan-loader">
      <img src="<?php echo plugins_url( 'ultimate-security-checker/img/loader.gif'); ?>" alt="" />
      <span style="color: red;"></span>
    </div>
    <?php if ($files_tests_results): ?>
      <div id="scan-results">
        <h3><?php _e("Some files from themes and plugins may have potential vulnerabilities:");?></h3>
        <?php
        $i = 1; 
        foreach($files_tests_results as $filename => $lines){
          $li[]  .= "<li><a href=\"#$i\">$filename</a></li>\n";
          $out .= "<h3>$filename<a name=\"$i\"></a><a href=\"#top\" style=\"font-size:13px;margin-left:10px;\">&uarr; ".__('Back')."</a></h3>";
          $out .= implode("\n", $lines);
          $i++;
        }
        ?>
        <?php if(sizeof($li) > 4){
         echo "<ul>\n".implode("\n", $li)."</ul>\n"; 
       }
       ?>
       <div class="clear"></div>
       <div class="errors-found">
        <p>
          <?php echo $out; ?>
        <?php elseif($files_tests_results[0]): ?>
          <?php echo $files_tests_results[0];?>
        <?php else: _e('<h3>No code changes found in your blog files!</h3>'); ?>
        <?php endif;?>
      </p>
    </div>
  </div>
  <!-- security-check -->
  <h3><?php _e('Keep your blog secure with automated checks.');?><a name="security-check"></a><a href="#top" style="font-size:13px;margin-left:10px;">&uarr; <?php _e('Back');?></a></h3>
  <p>
    <?php _e('A lot of the security vulnerabilities are put back in place when themes and the WordPress core version is updated.  You need to run regular checks using this plugin, or <a href="http://www.ultimateblogsecurity.com/?utm_campaign=plugin">register for our service</a> and we will check your blog for you weekly and email you the results.');?></p>
    <p><?php _e('We also have a paid service which automatically fixes these vulnerabilities. Try it by clicking the button:');?><br><a href="http://www.ultimateblogsecurity.com/?utm_campaign=fix_issues_plugin_button"><img src="<?php echo plugins_url( 'ultimate-security-checker/img/fix_problems_now.png'); ?>" alt="" /></a>
    </p>
    <!-- end security-check -->
  </div>                
  <div class="clear"></div>
</div>