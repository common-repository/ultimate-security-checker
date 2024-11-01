<?php global $security_check_icon; ?>
  <img src="<?php echo $security_check_icon; ?>">
  <h2 style="padding-left:5px;">Ultimate Security Checker
    <span style="position:absolute;padding-left:25px;">
      <a href="http://www.facebook.com/pages/Ultimate-Blog-Security/141398339213582" target="_blank"><img src="<?php echo plugins_url( 'ultimate-security-checker/img/facebook.png' ); ?>" alt="" /></a>
      <a href="http://twitter.com/BlogSecure" target="_blank"><img src="<?php echo plugins_url( 'ultimate-security-checker/img/twitter.png' ); ?>" alt="" /></a>
    </span>
  </h2>
  <?php if (!get_option('wp_ultimate_security_checker_flike_deactivated')):?>
    <p style="padding-left:5px;"><iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FUltimate-Blog-Security%2F141398339213582&amp;layout=standard&amp;show_faces=false&amp;width=550&amp;action=recommend&amp;font=lucida+grande&amp;colorscheme=light&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:550px; height:35px;" allowTransparency="true"></iframe></p>
  <?php endif; ?>
  <style>
    h3.nav-tab-wrapper .nav-tab {
      padding-top:7px;
    }
  </style>