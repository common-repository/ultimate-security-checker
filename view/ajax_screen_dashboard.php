<style type="text/css">
  <!--
  dt{
    font-weight: bold;
  }
  dd{
   margin-left: 50px;
 }	
-->
</style>

<script type="text/javascript">
  var apikey = "<?php echo $apikey;?>";
  var all_issues = {
    5 : '<div>Fix wp-config.php location - Wp-config.php in the document root makes it easier for hackers to access your configuration data.</div>',
    6 : '<div>Fix wp-config.php rights issue - Incorrect rights allows others to edit the wp-config file.</div>',
    8 : '<div>Do not display WordPress version in the code - Showing the version is on by default, and gives hackers clues on the best way to attack your blog.</div>',
    11 : '<div>Remove readme.html file - readme.html exposes Wordpress vesion to hackers, which they can then use to more easily hack into your blog.</div>',
    12 : '<div>Remove installation script - The install script can be used to damage your Wordpress blog.</div>',
    13 : '<div>Fix uploads folder from being accessed from the web - Your uploads should not be able to be accessed from the web.</div>',
    14 : '<div>WordPress displays unnecessary error messages on failed log-ins - With detailed error messages it\'s easy to brute force admin credentials.</div>',
    15 : '<div>WordPress core should be updated. - You should update to latest version of WordPress regularly.</div>',
    16 : '<div>Some of your plugins should be updated. - Outdated version of plugins may have unresolved security issues.</div>',
    17 : '<div>Some of your themes should be updated. - Outdated version of themes may have unresolved security issues.</div>',
    18 : '<div>Secure admin login. - Default admin login is not safe.</div>',
    19 : '<div>Secure database prefix. - Default database prefix is not safe.</div>',
    101 : '<div>Lock wp-config.php. Recommendation: On - <strong>Turn off only if wordpress needs access to this file.</strong> Keeping wp-config.php writeable makes it easier for hackers to access your configuration data.</div>',
    102 : '<div>Lock .htaccess file. Recommendation: On - The reason Wordpress needs to access your .htaccess file is to make your urls more user-friendly. Leave it turned off if you use canonical URLs.</div>',
    103 : '<div>Allow writing to wp-content folder. Recommendation: On - This folder is created to store your media content, like photos, music, etc. Also used by plugins for storing various data. It must be writeable.</div>',
    104 : '<div>Lock themes folder. Recommendation: On - Unlock if you\'re doing any changes to the themes files through wordpress admin or installing new themes.</div>',
    105 : '<div>Lock plugins folder. Recommendation: On - Unlock if you\'re installing or updating plugins.</div>',
    106 : '<div>Lock wordpress core folders. Recommendation: On - Should be always locked. Only turn off when updating your WordPress installation.</div>',
  };

  jQuery(document).ready(function($) {			
    ajax_get_status(
      function(data){
        $("#ajax_loading").css("display", "none"); 
        if(data.state == 'ok') {
          $("#pro-dashboard-content").css("display", "block");
          $("#pro-dashboard-content-uri").text(data.data.uri);
          $("#pro-dashboard-content-ubs_url").html('<a href="'+data.data.ubs_url+'">Manage this blog on UBS site</  a>');
          $("#pro-dashboard-content-latest_check_date").text(data.data.latest_check_date);
          if(data.data.latest_check_result){
            var errors_text = data.data.latest_check_result;
            errors_text = errors_text.replace(/[\[\],]/g, '');
            console.log(errors_text);
            $.each(all_issues, function(index, value) {
              errors_text = errors_text.replace(new RegExp("'"+index+"'",'g'), value);
            }); 
          }
          $("#pro-dashboard-content-latest_check_result").html(errors_text);
        }else{
          if('message' in data){
            if(data.message == 'Invalid API key'){
              $("#pro-dashboard-content").html('<div>You haven\'t activated your account, or your apikey blocked.</div>');
            }
            if(data.message == 'Blog not found'){
              $("#pro-dashboard-content").html('<div>You haven\'t registered this blog in our service. <a href="#" id="ftp-link" class="button-primary">Add this blog to our service!</a></div>');
            }
          }
          if('data' in data){
            $("#pro-dashboard-content").css("display", "block");
            console.log(data);
          }
          $("#pro-dashboard-content").css("display", "block");
          console.log(data);
        }
      },
      function(data){
        $('#ajax-result').text('Ajax error occured. Please try again later.');
      }
    ); 
  });
</script>

<h2><?php _e('Dashboard');?><a id="logout-link" class="button-primary" <?php if($apikey){echo 'style="display: block;"';} ?> href="#">logout</a>
</h2>
<p id="ajax_loading"> Communicating with server...
  <img style="margin-left:15px;" src="<?php echo plugins_url( 'ultimate-security-checker/img/ajax-loader.gif' ); ?>" alt="loading" />
</p>
<div id="pro-dashboard-content" style="display: none;">
  <dl>
    <dt>Blog Url:</dt>
    <dd id="pro-dashboard-content-uri"></dd>
    <dt>Link to our site:</dt>
    <dd id="pro-dashboard-content-ubs_url">Manage this blog on UBS site</dd>
    <dt>Latest check date:</dt>
    <dd id="pro-dashboard-content-latest_check_date"></dd>
    <dt>Latest check result:</dt>
    <dd id="pro-dashboard-content-latest_check_result"></dd>
  </dl>
</div>
<?php
$failed_logins = get_option('wp_ultimate_security_checker_failed_login_attempts_log');
if (is_array($failed_logins)):
  ?>
<h4>List of failed login attempts:</h4>
<table style="text-align: center;">
  <tr>
    <td style="width: 15px;">#</td>
    <td style="width: 150px;">Time</td>
    <td style="width: 200px;">login username</td>
    <td style="width: 120px;">IP address</td>
  </tr>
  <?php
  foreach ($failed_logins as $key => $row) {
    echo "<tr>";
    echo ("<td>$key</td><td>{$row['time']}</td><td>{$row['username']}</td><td>{$row['ip']}</td>");
    echo "</tr>";
  }
  endif;
  ?>
</table>		