
<div class="wrap">
    <style>
        #logout-link {
            float: right;
            display: none;
        }
    </style>
    

    <?php wp_ultimate_security_checker_header(); ?>
    

    <h3 class="nav-tab-wrapper usc-tabs">
        <a href="?page=ultimate-security-checker&tab=run-the-tests" class="nav-tab"><?php _e('Run the Tests');?></a>                    
        <a href="?page=ultimate-security-checker&tab=wp-files" class="nav-tab"><?php _e('Files Analysis');?></a>
        <a href="?page=ultimate-security-checker&tab=how-to-fix" class="nav-tab"><?php _e('How to Fix');?></a>
        <a href="?page=ultimate-security-checker&tab=settings" class="nav-tab"><?php _e('Settings');?></a>
        <!--<a href="?page=ultimate-security-checker&tab=pro" class="nav-tab nav-tab-active"><?php _e('PRO Checks');?></a>-->
    </h3>

    <!--  <p style="border:2px solid #eee;margin-left:3px;background:#f5f5f5;padding:10px;width:706px;font-size:14px;color:green;font-family:helvetica;"> Please check out our new idea: <strong>WP AppStore</strong>. 1-click install best plugins and themes. <a style="color:#e05b3c;text-decoration:underline;" href="http://wordpress.org/extend/plugins/wp-appstore/" target="_blank">Check it out!</a>
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
        .button-submit-wrapper{
            float: right;
        }
        .links-wrapper{
            float: left;
            width: 100px;
        }
        .login-controlls{
            width: 230px;
        }
        label{
            display: block;
        }
    </style>
    <div class="wrap">
        <div class="stab">
          <div id="ajax-content"></div>
          <div id="ajax-result"></div>
      </div>
      <div class="clear"></div>
  </div>
</div>