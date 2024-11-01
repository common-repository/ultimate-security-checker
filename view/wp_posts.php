<div class="wrap">

  <?php wp_ultimate_security_checker_header(); ?>

  <h3 class="nav-tab-wrapper usc-tabs">
    <a href="?page=ultimate-security-checker&tab=run-the-tests" style="text-decoration: none;">&lt;- <?php _e('Back to Tests results');?></a>
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
    <h2><?php _e('Your blog records scan results:');?></h2>

    <?php if ($posts_tests_results['posts_found']){
      $postsHdr = __("<h3>Some posts in your blog contains suspicious code:</h3>\n");
      $i = 1; 
      foreach($posts_tests_results['posts_found'] as $postId => $postData){
        $postsList[] = "<li><a href=\"#p$i\">{$postData['post-title']}($postId)</a></li>\n";
        $pout .= "<h4>{$postData['post-title']}($postId) - <a href=\"".get_edit_post_link($postId)."\" title=\"".__("Edit")."\">".__("Edit")."</a><a name=\"p$i\"></a><a href=\"#top\" style=\"font-size:13px;margin-left:10px;\">&uarr; ".__('Back').";?></a></h4>";
        $pout .= implode("\n", $postData['content']);
        $i++;
      }

      $postsOut .= "<div class=\"clear\"></div>\n<div class=\"errors-found\">\n<p>";
      $postsOut .= $pout;
      $postsOut .= "</p>\n</div>\n";

    }else{
      $postsHdr = __("<h3>No potential code vulnerabilities foud in your posts!</h3>\n");
    }
    ?>

    <?php if ($posts_tests_results['comments_found']){
      $commentsHdr = __("<h3>Some comments in your blog contains suspicious code:</h3>\n");
      $i = 1; 
      foreach($posts_tests_results['comments_found'] as $commentId => $commentData){
        $commentsList[] = "<li><a href=\"#c$i\">{$commentData['comment-autor']}($commentId)</a></li>\n";
        $cout .= "<h4>{$commentData['comment-autor']}($commentId) - <a href=\"".get_edit_comment_link($commentId)."\" title=\"".__("Edit")."\">".__("Edit")."</a><a name=\"c$i\"></a><a href=\"#top\" style=\"font-size:13px;margin-left:10px;\">&uarr; ".__('Back').";?></a></h4>";
        $cout .= implode("\n", $commentData['content']);
        $i++;
      }
      $commentsOut .= "<div class=\"clear\"></div>\n<div class=\"errors-found\">\n<p>";
      $commentsOut .= $cout;
      $commentsOut .= "</p>\n</div>\n";

    }else{
      $commentsHdr = __("<h3>No potential code vulnerabilities foud in your comments!</h3>\n");
    }
    ?>
    <?php echo $postsHdr; ?>
    <?php if(sizeof($postsList) > 4) echo "<ul>\n".implode("\n", $postsList)."</ul>\n"; ?>
    <?php echo $postsOut; ?>

    <?php echo $commentsHdr; ?>
    <?php if(sizeof($commentsList) > 4) echo "<ul>\n".implode("\n", $commentsList)."</ul>\n"; ?>
    <?php echo $commentsOut; ?>

    <!-- security-check -->
    <h3><?php _e('Keep your blog secure with automated checks.');?><a name="security-check"></a><a href="#top" style="font-size:13px;margin-left:10px;">&uarr; <?php _e('Back');?></a></h3>
    <p>
      <?php _e('A lot of the security vulnerabilities are put back in place when themes and the WordPress core version is updated.  You need to run regular checks using this plugin, or <a href="http://www.ultimateblogsecurity.com/?utm_campaign=plugin">register for our service</a> and we will check your blog for you weekly and email you the results.');?></p>
      <p><?php _e('We also have a paid service which automatically fixes these vulnerabilities. Try it by clicking the button:');?><br><a href="http://www.ultimateblogsecurity.com/?utm_campaign=fix_issues_plugin_button"><img src="<?php echo plugins_url( 'ultimate-security-checker/img/fix_problems_now.png'); ?>" alt="" /></a>
    </p>
  </div>                
  <!-- end security-check -->
</div>