

<div class="wrap">

<?php wp_ultimate_security_checker_header(); ?>

  <h3 class="nav-tab-wrapper usc-tabs">
    <a href="?page=ultimate-security-checker&tab=run-the-tests" class="nav-tab"><?php _e('Run the Tests');?></a>
    <a href="?page=ultimate-security-checker&tab=wp-files" class="nav-tab"><?php _e('Files Analysis');?></a>
    <a href="?page=ultimate-security-checker&tab=how-to-fix" class="nav-tab nav-tab-active"><?php _e('How to Fix');?></a>
    <a href="?page=ultimate-security-checker&tab=settings" class="nav-tab"><?php _e('Settings');?></a>
    <!--<a href="?page=ultimate-security-checker&tab=pro" class="nav-tab"><?php _e('PRO Checks');?></a>-->
  </h3>

<!-- <p style="border:2px solid #eee;margin-left:3px;background:#f5f5f5;padding:10px;width:706px;font-size:14px;color:green;font-family:helvetica;"> Please check out our new idea: <strong>WP AppStore</strong>. 1-click install best plugins and themes.
<a style="color:#e05b3c;text-decoration:underline;" href="http://wordpress.org/extend/plugins/wp-appstore/" target="_blank">Check it out!</a>
</p>-->
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
    <ul>
      <li><a href="#upgrades"><?php _e('WordPress/Themes/Plugins Upgrades.');?></a></li>
      <li><a href="#unneeded-files"><?php _e('Removing unneeded files.');?></a></li>
      <li><a href="#config-place"><?php _e('Config file is located in an unsecured place.');?></a></li>
      <li><a href="#config-keys"><?php _e('Editing global variables or keys in config file.');?></a></li>
      <li><a href="#code-edits-login"><?php _e('Removing unnecessary error messages on failed log-ins.');?></a></li>
      <li><a href="#code-edits-version"><?php _e('Removing WordPress version from your website.');?></a></li>
      <li><a href="#code-edits-requests"><?php _e('Securing blog against malicious URL requests.');?></a></li>
      <li><a href="#config-rights"><?php _e('Changing config file rights.');?></a></li>
      <li><a href="#rights-htaccess"><?php _e('Changing .htaccess file rights.');?></a></li>
      <li><a href="#rights-folders"><?php _e('Changing rights on WordPress folders.');?></a></li>
      <li><a href="#db"><?php _e('Database changes.');?></a></li>
      <li><a href="#uploads"><?php _e('Your uploads directory is browsable from the web.');?></a></li>
      <li><a href="#server-config"><?php _e('Your server shows too much information about installed software.');?></a></li>
      <li><a href="#security-check"><?php _e('How to keep everything secured?');?></a></li>
    </ul>
    <div class="clear"></div>
    <div class="answers">

      <!-- upgrades -->
      <h3>WordPress/Themes/Plugins Upgrades.<a name="upgrades"></a><a href="#top" style="font-size:13px;margin-left:10px;">&uarr; <?php _e('Back');?></a>
      </h3>
      <p>
        <?php _e('You should upgrade your software often to keep it secure.');?><br />
        <?php _e("However, you shouldn't upgrade WordPress yourself if you don't know how to fix it if the upgrade process goes wrong.");?>
      </p>
      <p>
        <?php _e("Here's why you should be afraid to upgrade your WordPress:");?>
        <ul>
          <li><?php _e("WordPress might run out of memory or have a network problem during the update");?></li>
          <li><?php _e("There could be a permissions issue which causes problems with folder rights");?></li>
          <li><?php _e("You could cause database problems which could cause you to lose data or take your entire site down");?></li>
        </ul>
      </p>
      <p>
        <a href="http://codex.wordpress.org/Updating_WordPress"><?php _e("Step-by-step explanations</a> are available at WordPress Codex.");?>
      </p>
      <p>
        <?php _e('You can let the professionals do the work for you and upgrade your blog with plugins. <a href="http://ultimateblogsecurity.com/blog-update">See details</a>.');?>
      </p>
      <!-- end upgrades -->

      <!-- config-place -->
      <h3>
        <?php _e('Config file is located in an unsecured place.');?><a name="config-place"></a><a href="#top" style="font-size:13px;margin-left:10px;">&uarr; <?php _e('Back');?></a>
      </h3>
      <p>
        <?php _e("The most important information in your blog files is located in wp-config.php. It's good practice to keep it in the folder above your WordPress root.");?>
      </p>
      <p>
        <?php _e("Sometimes this is impossible to do because:");?>
        <ul>
          <li><?php _e("you don't have access to folder above your WordPress root");?></li>
          <li><?php _e("some plugins were developed incorrectly and look for the config file in your WordPress root");?></li>
          <li><?php _e("there is another WordPress installation in the folder above");?></li>
        </ul>
      </p>
      <!-- end config-place -->

      <!-- config-keys -->
      <h3><?php _e("Editing global variables or keys in config file.");?><a name="config-keys"></a><a href="#top" style="font-size:13px;margin-left:10px;">&uarr; <?php _e('Back');?></a>
      </h3>
      <p>
        <b><?php _e("Some of keys AUTH_KEY, SECURE_AUTH_KEY, LOGGED_IN_KEY, NONCE_KEY are not set.");?></b><br />
        <?php _e('Create secret keys from this link <a href="https://api.wordpress.org/secret-key/1.1/">https://api.wordpress.org/secret-key/1.1/</a> and paste them into wp-config.php');?>
      </p>
      <p>
        <b><?php _e("It's better to turn off file editor for plugins and themes in wordpress admin.");?></b><br />
        <?php _e("You're not often editing your theme or plugins source code in WordPress admin? Don't let potential hacker do this for you. Add <em>DISALLOW_FILE_EDIT</em> option to wp-config.php");?>
        <pre><?php echo htmlentities("define('DISALLOW_FILE_EDIT', true);"); ?></pre>
      </p>
      <p>
        <b><?php _e("WP_DEBUG option should be turned off on LIVE website."); ?></b><br />
        <?php _e("Sometimes developers use this option when debugging your blog and keep it after the website is done. It's very unsafe and allow hackers to see debug information and infect your site easily. Should be turned off."); ?>
        <pre><?php echo htmlentities("define('WP_DEBUG', false);"); ?></pre>
      </p>
      <!-- end config-keys -->

      <!-- code-edits-version -->
      <h3><?php _e("Removing the WordPress version from your website."); ?><a name="code-edits-version"></a><a href="#top" style="font-size:13px;margin-left:10px;">&uarr; <?php _e('Back');?></a>
      </h3>
      <p>
        <?php _e("When WordPress version which is used in your blog is known, hacker can find proper exploit for exact version of WordPRess."); ?>
      </p>
      <p>
        <?php _e("To remove WordPress version you should do two things:"); ?>
        <ul>
          <li><?php _e("check if it's not hardcoded in header.php or index.php of your current theme(search for"); ?> <i>'<meta name="generator">'</i>)</li>
          <li>
            <?php _e("add few lines of code to functions.php in your current theme:"); ?>
            <pre><?php echo htmlentities("function no_generator() { return ''; }  
              add_filter( 'the_generator', 'no_generator' );"); ?></pre>
            </li>
          </ul>
        </p>
        <!-- end code-edits-version -->

        <!-- unneeded-files -->
        <h3><?php _e("Removing unneeded files."); ?><a name="unneeded-files"></a><a href="#top" style="font-size:13px;margin-left:10px;">&uarr; <?php _e('Back');?></a></h3>
        <p>
          <b><?php _e("Users can see version of WordPress you are running from readme.html file."); ?></b><br>
        </p>
        <p>
          <?php _e("When WordPress version which is used in your blog is known, hacker can find proper exploit for exact version of WordPRess."); ?>
        </p>
        <p>
          <?php _e("Remove readme.html file which is located in root folder of your blog. <br>
          <em>NOTE:</em> It will appear with next upgrade of WordPress."); ?>
        </p>
        <p>
          <b><?php _e("Installation script is still available in your wordpress files."); ?></b><br>
          <?php _e("Remove /wp-admin/install.php from your WordPress."); ?>
        </p>
        <!-- end unneeded-files -->

        <!-- code-edits-login -->
        <h3><?php _e("Removing unnecessary error messages on failed log-ins."); ?><a name="code-edits-login"></a><a href="#top" style="font-size:13px;margin-left:10px;">&uarr; <?php _e('Back');?></a>
        </h3>

        <p>
          <?php _e("By default WordPress will show you what was wrong with your login credentials - login or password. This will allow hackers to start a brute force attack to get your password once they know the login."); ?>
        </p>
        <p>
          <?php _e("Add few lines of code to functions.php in your current theme:"); ?>
          <pre><?php echo htmlentities("function explain_less_login_issues($data){ return '<strong>ERROR</strong>: Entered credentials are incorrect.';}
            add_filter( 'login_errors', 'explain_less_login_issues' );"); ?></pre>
        </p>
        <!-- end code-edits-login -->

        <!-- code-edits-requests -->
        <h3><?php _e("Securing blog against malicious URL requests."); ?><a name="code-edits-requests"></a><href="#top" style="font-size:13px;margin-left:10px;">&uarr; <?php _e('Back');?></a>
        </h3>
        <p>
          <?php _e("Malicious URL requests are requests which may have SQL Injection inside and will allow hacker to broke your blog."); ?> 
        </p>
        <p>
          <?php _e("Paste the following code into a text file, and save it as blockbadqueries.php. Once done, upload it to your wp-content/plugins directory and activate it like any other plugins."); ?> 
          <pre><?php echo htmlentities('<?php
            /*
            Plugin Name: Block Bad Queries
            Plugin URI: http://perishablepress.com/press/2009/12/22/protect-wordpress-against-malicious-url-requests/
            Description: Protect WordPress Against Malicious URL Requests
            Author URI: http://perishablepress.com/
            Author: Perishable Press
            Version: 1.0
                */
            if (strpos($_SERVER[\'REQUEST_URI\'], "eval(") ||
              strpos($_SERVER[\'REQUEST_URI\'], "CONCAT") ||
            strpos($_SERVER[\'REQUEST_URI\'], "UNION+SELECT") ||
            strpos($_SERVER[\'REQUEST_URI\'], "base64")) 
            {
              @header("HTTP/1.1 400 Bad Request");
              @header("Status: 400 Bad Request");
              @header("Connection: Close");
              @exit;
            }
            ?>'); ?>
          </pre>
        </p>
        <!-- end code-edits-requests -->    

        <!-- config-rights -->
        <h3><?php _e("Changing config file rights."); ?> <a name="config-rights"></a><a href="#top" style="font-size:13px;margin-left:10px;">&uarr; <?php _e('Back');?></a>
        </h3>
        <p>
          <?php _e('According to <a href="http://codex.wordpress.org/Hardening_WordPress#Securing_wp-config.php">WordPress Codex</a> you should change rights to wp-config.php to 400 or 440 to lock it from other users.'); ?> 
        </p>
        <p>
          <?php _e("In real life a lot of hosts won't allow you to set the last digit to 0, because they configured their webservers the wrong way. Be careful hosting on web hostings like this."); ?>
        </p>
        <!-- end config-rights -->

        <!-- rights-htaccess -->
        <h3><?php _e("Changing .htaccess file rights."); ?><a name="rights-htaccess"></a><a href="#top" style="font-size:13px;margin-left:10px;">&uarr; <?php _e('Back');?></a>
        </h3>
        <p>
          <?php _e(".htaccess rights should be set to 644 or 664(depending if you want wordpress to be able to edit .htaccess for you)."); ?>
        </p>
        <!-- end rights-htaccess -->

        <!-- rights-folders -->
        <h3> <?php _e("Changing rights on WordPress folders."); ?><a name="rights-folders"></a><a href="#top" style="font-size:13px;margin-left:10px;">&uarr; <?php _e('Back');?></a>
        </h3>
        <p>
          <?php _e('According to <a href="http://codex.wordpress.org/Hardening_WordPress#File_permissions">WordPress Codex</a> right for next folders should be set like this.');?>
        </p>
        <p><b><?php printf(__('Insufficient rights on %s folder!'),'wp-content');?></b><br>
          <?php _e('<i>/wp-content/</i> should be writeable for all(777) - according to WordPress Codex. But better to set it 755 and change to 777(temporary) if some plugins asks you to do that.');?><br>
        </p>
        <p>
          <b><?php printf(__('Insufficient rights on %s folder!'),'wp-content/themes');?></b><br>
          <i>/wp-content/themes/</i> <?php _e('should have rights 755.');?> <br>
        </p>
        <p>
          <b><?php printf(__('Insufficient rights on %s folder!'),'wp-content/plugins');?></b><br>
          <i>/wp-content/plugins/</i> <?php _e('should have rights 755.');?><br>
        </p>
        <p>
          <b>Insufficient rights on core wordpress folders!</b><br>
          <i>/wp-admin/</i> <?php _e('should have rights 755.');?><br>
          <i>/wp-includes/</i> <?php _e('should have rights 755.');?>
        </p>
        <!-- end rights-folders -->

        <!-- db -->
        <h3><?php _e('Changes in database.');?><a name="db"></a><a href="#top" style="font-size:13px;margin-left:10px;">&uarr; <?php _e('Back');?></a>
        </h3>
        <p>
          <b><?php _e('Default admin login is not safe.');?></b><br>
          <?php _e('Using MySQL frontend program(like phpmyadmin) change administrator username with command like this:');?>
          <pre><?php echo htmlentities("update tableprefix_users set user_login='newuser' where user_login='admin';"); ?></pre>
        </p>
        <p>
          <b><?php _e('Default database prefix is not safe.');?></b><br>
          <?php _e('Using MySQL frontend program(like phpmyadmin) change all tables prefixes from <i>wp_</i> to something different. And put the same into wp-confg.php');?>
          <pre><?php echo htmlentities('$table_prefix  = \'tableprefix_\';'); ?></pre>
        </p>
        <!-- end db -->

        <!-- uploads -->
        <h3><?php _e('Your uploads directory is browsable from the web.');?><a name="uploads"></a><a href="#top" style="font-size:13px;margin-left:10px;">&uarr; <?php _e('Back');?></a>
        </h3>
        <p>
          <?php _e('Put an empty index.php to your uploads folder.');?>
        </p>
        <!-- end uploads -->

        <!-- server-config -->
        <h3><?php _e('Your server shows too much information about installed software.');?><a name="server-config"></a><a href="#top" style="font-size:13px;margin-left:10px;">&uarr; <?php _e('Back');?></a>
        </h3>
        <p>
          <?php _e('If you\'re using Apache web server and have root access(or can edit httpd.conf) - you can define <i>ServerTokens</i> directive with preffered options(less info - better). <a href="http://httpd.apache.org/docs/2.0/mod/core.html#servertokens">See details</a>.');?>
        </p>
        <!-- end server-config -->

        <!-- security-check -->
        <h3><?php _e('Keep your blog secure with automated checks.');?><a name="security-check"></a><a href="#top" style="font-size:13px;margin-left:10px;">&uarr; <?php _e('Back');?></a>
        </h3>
        <p>
        <?php _e('A lot of the security vulnerabilities are put back in place when themes and the WordPress core version is updated.  You need to run regular checks using this plugin, or <a href="http://www.ultimateblogsecurity.com/?utm_campaign=plugin">register for our service</a> and we will check your blog for you weekly and email you the results.');?>
        </p>
        <p><?php _e('We also have a paid service which automatically fixes these vulnerabilities. Try it by clicking the button:');?><br><a href="http://www.ultimateblogsecurity.com/?utm_campaign=fix_issues_plugin_button"><img src="<?php echo plugins_url( 'ultimate-security-checker/img/fix_problems_now.png' ); ?>" alt="" /></a>
        </p>
        <!-- end security-check -->
    </div>
  </div>
</div>