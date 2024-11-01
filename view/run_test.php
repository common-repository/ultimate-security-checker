 <div class="wrap">      

  <?php wp_ultimate_security_checker_header(); ?>

  <h3 class="nav-tab-wrapper usc-tabs">
    <a href="?page=ultimate-security-checker&tab=run-the-tests" class="nav-tab nav-tab-active"><?php _e('Run the Tests');?></a>
    <a href="?page=ultimate-security-checker&tab=wp-files" class="nav-tab"><?php _e('Files Analysis');?></a>
    <a href="?page=ultimate-security-checker&tab=how-to-fix" class="nav-tab"><?php _e('How to Fix');?></a>
    <a href="?page=ultimate-security-checker&tab=settings" class="nav-tab"><?php _e('Settings');?></a>
    <!--<a href="?page=ultimate-security-checker&tab=pro" class="nav-tab"><?php _e('PRO Checks');?></a>-->
  </h3>
  
  <!-- <p style="border:2px solid #eee;margin-left:3px;background:#f5f5f5;padding:10px;width:706px;font-size:14px;color:green;font-family:helvetica;">Please check out our new idea: <strong>WP AppStore</strong>. 1-click install best plugins and themes.
	<a style="color:#e05b3c;text-decoration:underline;" href="http://wordpress.org/extend/plugins/wp-appstore/" target="_blank">Check it out!</a>
	</p>-->
  <!-- <p>We are checking your blog for security right now. We won't do anything bad to your blog, relax :)</p> -->

  <div class="stab">
    <div id="test_results">
      <?php 
       $security_check = new SecurityCheck();
      if(isset($_GET['dotest']) || get_option( 'wp_ultimate_security_checker_issues',0) == 0){
        $security_check->run_tests(); 
      } else {
        $security_check->get_cached_test_results(); 
      }
      $security_check->display_global_stats(); 
      $security_check->display_stats_by_categories($security_check->categories); 
      ?>
    </div>
  </div>
  <div style="clear:both;"></div>
</div> 