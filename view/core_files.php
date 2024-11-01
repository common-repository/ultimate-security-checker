 <div class="wrap">

  <style>
    div.diff-addedline {
      font-family: monospace;
      display: block;
      font-size: 13px;
      font-weight: normal;
      padding: 10px;
      background-color: #DDFFDD;
    }
    div.diff-deletedline {
      font-family: monospace;
      display: block;
      font-size: 13px;
      font-weight: normal;
      padding: 10px;
      background-color: #FBA9A9;
    }
    div.diff-context {
      font-family: monospace;
      display: block;
      font-size: 13px;
      font-weight: normal;
      padding: 10px;
      background-color: #F3F3F3;
    }
  </style>

  <?php wp_ultimate_security_checker_header(); ?>

  <h3 class="nav-tab-wrapper usc-tabs">
    <a href="?page=ultimate-security-checker&tab=run-the-tests" style="text-decoration: none;">&lt;- <?php _e('Back to Test results');?></a>
  </h3>

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
  </style>
  
  <a name="#top"></a>
  <div class="stab">
    <h2><?php _e('Your blog core files check results:');?></h2>
    <?php if ($core_tests_results['diffs']): ?>
      <h3><?php _e('Some files from the core of your blog have been changed. Files and lines different from original WordPress core files:');?></h3>
      <?php
      $i = 1; 
      foreach($core_tests_results['diffs'] as $filename => $lines){
        $li[]  .= "<li><a href=\"#$i\">$filename</a></li>\n";
        $out .= "<h4>$filename<a name=\"$i\"></a><a href=\"#top\" style=\"font-size:13px;margin-left:10px;\">&uarr; ".__('Back')."</a></h4>";
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
      <?php else: _e('<h3>No code changes found in your blog core files!</h3>');?>; ?>
      <?php endif;?>
    </p>
  </div>
  <?php 
  if ($core_tests_results['old_export']) {
    echo _e("<h5>This is old export files. You should delete them.</h5>");
    echo "<ul>";
    foreach($core_tests_results['old_export'] as $export){
      echo "<li>".$static_url."</li>";
    }
    echo "</ul>"; 
  }
  ?>
  <!-- end hashes -->

  <!-- security-check -->
  <h3><?php _e('Keep your blog secure with automated checks.');?><a name="security-check"></a><a href="#top" style="font-size:13px;margin-left:10px;">&uarr; <?php _e('Back');?></a></h3>
  <p>
    <?php _e('A lot of the security vulnerabilities are put back in place when themes and the WordPress core version is updated.  You need to run regular checks using this plugin, or <a href="http://www.ultimateblogsecurity.com/?utm_campaign=plugin">register for our service</a> and we will check your blog for you weekly and email you the results.');?></p>
    <p><?php _e('We also have a paid service which automatically fixes these vulnerabilities. Try it by clicking the button:');?><br><a href="http://www.ultimateblogsecurity.com/?utm_campaign=fix_issues_plugin_button"><img src="<?php echo plugins_url( 'ultimate-security-checker/img/fix_problems_now.png' ); ?>" alt="" /></a>
    </p>
    <!-- end security-check -->
  </div>
  <div class="clear"></div>
</div>