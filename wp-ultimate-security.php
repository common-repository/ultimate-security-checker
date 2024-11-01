<?php
/*
Plugin Name: Ultimate Security Checker
Plugin URI: http://www.ultimateblogsecurity.com/
Description: Security plugin which performs all set of security checks on your WordPress installation.<br>Please go to <a href="tools.php?page=wp-ultimate-security.php">Tools->Ultimate Security Checker</a> to check your website.
Version: 4.2
Author: Eugene Pyvovarov
Author URI: http://www.ultimateblogsecurity.com/
License: GPL2

Copyright 2013  Eugene Pyvovarov  (email : bsn.dev@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/
global $wp_version;
require_once("securitycheck.class.php");
$security_check_icon = plugins_url( 'img/shield_32.png', __FILE__ ); 
    
function wp_ultimate_security_checker_deactivate() {
  delete_option( 'wp_ultimate_security_checker_color');
  delete_option( 'wp_ultimate_security_checker_score');
  delete_option( 'wp_ultimate_security_checker_issues');
  delete_option( 'wp_ultimate_security_checker_lastcheck');
}
    
register_deactivation_hook( __FILE__, 'wp_ultimate_security_checker_deactivate' );
function wp_ultimate_security_checker_activate() {
  add_option( 'wp_ultimate_security_checker_color', 0 , null , 'yes' );
  add_option( 'wp_ultimate_security_checker_score', 0 , null , 'yes' );
  add_option( 'wp_ultimate_security_checker_issues', '' , null, 'yes' );
  add_option( 'wp_ultimate_security_checker_lastcheck', '' , null , 'yes' );
  add_option( 'wp_ultimate_security_checker_hide_header', 0 , null , 'yes' );
}

register_activation_hook( __FILE__, 'wp_ultimate_security_checker_activate' );
function wp_ultimate_security_checker_admin_init() {
  // wp_enqueue_script('jquery');
  $lang_dir = basename(dirname(__FILE__))."/languages";
  load_plugin_textdomain( 'ultimate-security', false, $lang_dir );
     
}

add_action( 'network_admin_menu', 'wp_ultimate_security_checker_setup_admin' );
function wp_ultimate_security_checker_setup_admin() {
  add_submenu_page(
    $parent_slug = 'settings.php',
    $page_title =  __('Ultimate Security Checker', 'wp_ultimate_security_checker'),
    $menu_title =  __('Ultimate Security Checker', 'wp_ultimate_security_checker'),
    $capability = 'manage_network_options',
    $menu_slug = 'ultimate-security-checker',
    $function = 'wp_ultimate_security_checker_main'
  );
}

function wp_ultimate_security_checker_admin_menu() {
  if (function_exists('is_multisite') && !is_multisite()) {
    $page = add_submenu_page( 'tools.php', 
    __('Ultimate Security Checker', 'wp_ultimate_security_checker'), 
    __('Ultimate Security Checker', 'wp_ultimate_security_checker'), 'manage_options',  'ultimate-security-checker', 
    'wp_ultimate_security_checker_main');
    add_action('admin_print_scripts-' . $page, 'wp_ultimate_security_checker_admin_styles');
  }
}

function wp_ultimate_security_checker_admin_styles() {
  /*
   * It will be called only on your plugin admin page, enqueue our script here
   */
  // wp_enqueue_script('myPluginScript');
}

function wp_ultimate_security_checker_main() {
  $tabs  = array('run-the-tests', 'how-to-fix', 'core-files', 'wp-files',
		   'wp-posts', 'settings', 'pro', 'current-status', 'register');
  $tab = '';
  if(!isset($_GET['tab']) || !in_array($_GET['tab'],$tabs)){
      $tab = 'run-the-tests';
  } else {
      $tab = $_GET['tab'];
  }
  $function_name = 'wp_ultimate_security_checker_' . str_replace('-','_',$tab);
  $function_name();
} 

function wp_ultimate_security_checker_header() {
  include_once(plugin_dir_path( __FILE__ ) . 'view/header.php');
}   
    
function wp_ultimate_security_checker_how_to_fix() {
  include_once(plugin_dir_path( __FILE__ ) . 'view/how_to_fix_tab.php');
}

function wp_ultimate_security_checker_settings() {
  if (isset($_GET['flike']) || isset($_GET['rescan'])) {
    switch ($_GET['flike']) {
      case 'k' :
        update_option('wp_ultimate_security_checker_flike_deactivated', false);
        break;
      case 'n' :
        update_option('wp_ultimate_security_checker_flike_deactivated', true);
        break;
    }
    switch ($_GET['rescan']) {
      case 'w' :
        update_option('wp_ultimate_security_checker_rescan_period', 14);
        break;
      case 'm' :
        update_option('wp_ultimate_security_checker_rescan_period', 30);
        break;
      case 'n' :
        update_option('wp_ultimate_security_checker_rescan_period', 0);
        break;
    }
  }
	// hide_header
	if (isset($_GET['hide_header'])) {
		update_option('wp_ultimate_security_checker_hide_header', 1);
	} elseif (isset($_GET['flike']) || isset($_GET['rescan'])) {
		update_option('wp_ultimate_security_checker_hide_header', 0);
	}
  /*if (isset($_GET['apikey'])) {
		update_option('wp_ultimate_security_checker_apikey', $_GET['apikey']);
		?><div id="message" class="updated"><p>API key is updated</p></div><?php
	}*/
	$apikey = get_option('wp_ultimate_security_checker_apikey');
	$params['apikey'] = $apikey;
	$params['blog_url'] = get_option('siteurl');
	$status_url = sprintf("http://beta.ultimateblogsecurity.com/api/%s/?%s", "get_status", http_build_query($params));
  include_once(plugin_dir_path( __FILE__ ) . 'view/settings.php');
}
    
function wp_ultimate_security_checker_pro(){
  include_once(plugin_dir_path( __FILE__ ) . 'view/pro_page.php');
}
    
function wp_ultimate_security_checker_ajaxscreen_loader(){
  check_admin_referer('ultimate-security-checker-ajaxrequest', 'csrfmiddlewaretoken');
  $apikey = get_option('wp_ultimate_security_checker_apikey');
  if (isset($_POST['screen'])){
    switch ($_POST['screen']) {
      case 'register' :
        return wp_ultimate_security_checker_ajaxscreen_register();
    		break;
      case 'ftp' :
        if (!$apikey) {
            return wp_ultimate_security_checker_ajaxscreen_login();
        }
        return wp_ultimate_security_checker_ajaxscreen_ftp();
    	  break;
      case 'dashboard' :
        if (!$apikey) {
          return wp_ultimate_security_checker_ajaxscreen_login();
        }
        return wp_ultimate_security_checker_ajaxscreen_dashboard();
    		break;
      default:
        return wp_ultimate_security_checker_ajaxscreen_login();
        break;
    }
  } else {
    if (!$apikey) {
      return wp_ultimate_security_checker_ajaxscreen_login();
    } else {
      return wp_ultimate_security_checker_ajaxscreen_dashboard();
    }
  }
  exit;
}
    
function wp_ultimate_security_checker_ajaxscreen_login(){
  $current_user = wp_get_current_user();
  preg_match_all("/([\._a-zA-Z0-9-]+)@[\._a-zA-Z0-9-]+/i", $current_user->user_email, $matches);
	$email_name = $matches[1][0];	
  $apikey = get_option('wp_ultimate_security_checker_apikey');        
  include_once(plugin_dir_path( __FILE__ ) . 'view/ajax_screen_login.php');
  exit;
}
    
function wp_ultimate_security_checker_ajaxscreen_register(){
  $current_user = wp_get_current_user();
  preg_match_all("/([\._a-zA-Z0-9-]+)@[\._a-zA-Z0-9-]+/i", $current_user->user_email, $matches);
	$email_name = $matches[1][0];					
  $url = home_url();
  if (is_multisite()) {
      $url = network_home_url();
  }
  $apikey = get_option('wp_ultimate_security_checker_apikey');        
  include_once(plugin_dir_path( __FILE__ ) . 'view/ajax_screen_register.php');
  exit;
}
    
function wp_ultimate_security_checker_ajaxscreen_ftp(){
  $url = home_url();
  if (is_multisite()) {
    $url = network_home_url();
  }
  $apikey = get_option('wp_ultimate_security_checker_apikey');        
  include_once(plugin_dir_path( __FILE__ ) . 'view/ajax_screen_ftp.php');
  exit;
}
    
function wp_ultimate_security_checker_ajaxscreen_dashboard(){
  $apikey = get_option('wp_ultimate_security_checker_apikey');        
  include_once(plugin_dir_path( __FILE__ ) . 'view/ajax_screen_dashboard.php');
  exit; 
}
    
function wp_ultimate_security_checker_core_files(){
  $core_tests_results = get_option('wp_ultimate_security_checker_hashes_issues');
  include_once(plugin_dir_path( __FILE__ ) . 'view/core_files.php');
}

add_action( 'wp_ajax_ultimate_security_checker_ajax_handler', 'wp_ultimate_security_checker_ajax_handler' );
function wp_ultimate_security_checker_ajax_handler(){
	check_ajax_referer( 'ultimate-security-checker_scan' );
  $security_check = new SecurityCheck();
  $responce = $security_check->run_heuristic_check(); 
  echo json_encode($responce);
	exit;
}

function wp_ultimate_security_checker_wp_files(){
  $files_tests_results = get_option('wp_ultimate_security_checker_files_issues');
  include_once(plugin_dir_path( __FILE__ ) . 'view/wp_files.php');  
}

function wp_ultimate_security_checker_wp_posts(){
  $posts_tests_results = get_option('wp_ultimate_security_checker_posts_issues');
  include_once(plugin_dir_path( __FILE__ ) . 'view/wp_posts.php'); 
}
	
add_action('admin_head', 'wp_ultimate_security_checker_load_common_js');
add_action('wp_ajax_link_blog', 'wp_ultimate_security_checker_link_blog');
add_action('wp_ajax_unlink_blog', 'wp_ultimate_security_checker_unlink_blog');
add_action('wp_ajax_set_apikey', 'wp_ultimate_security_checker_set_apikey');
add_action('wp_ajax_pro_logout', 'wp_ultimate_security_checker_pro_logout');
add_action('wp_ajax_ajaxscreen_loader', 'wp_ultimate_security_checker_ajaxscreen_loader');
    
function wp_ultimate_security_checker_link_blog() {
	check_admin_referer('ultimate-security-checker-ajaxrequest', 'csrfmiddlewaretoken');		 
	update_option('wp_ultimate_security_checker_linkedto', intval($_POST['blogid']));
	update_option('wp_ultimate_security_checker_linked_data', $_POST['blogdata']);
	exit;
}
	
function wp_ultimate_security_checker_unlink_blog() {
	check_admin_referer('ultimate-security-checker-ajaxrequest', 'csrfmiddlewaretoken');		 
	delete_option('wp_ultimate_security_checker_linkedto');
	delete_option('wp_ultimate_security_checker_linked_data');
	exit;
}
	
function wp_ultimate_security_checker_set_apikey(){
	check_admin_referer('ultimate-security-checker-ajaxrequest', 'csrfmiddlewaretoken');	
	if (isset($_POST['apikey'])) 	 
		$ret = update_site_option('wp_ultimate_security_checker_apikey', htmlspecialchars($_POST['apikey'])) ? 'ok': 'error';
	else
		$ret = 'error';
      if (isset($_POST['registered'])) 	 
		    update_site_option('wp_ultimate_security_checker_registered', (bool)$_POST['registered']) ? 'ok': 'error';
      if (isset($_POST['password']))
        set_site_transient('wp_ultimate_security_checker_password', $_POST['password'], 60*60*24 ); 	 

		echo json_encode(Array('state' => $ret));
		exit;
	}
	
function wp_ultimate_security_checker_pro_logout() {
	check_admin_referer('ultimate-security-checker-ajaxrequest', 'csrfmiddlewaretoken');
	$ret = delete_site_option('wp_ultimate_security_checker_apikey') ? 'ok': 'error';
	echo json_encode(Array('state' => $ret));
	exit;
}		
	
function wp_ultimate_security_checker_load_common_js(){
  $current_user = wp_get_current_user();
  preg_match_all("/([\._a-zA-Z0-9-]+)@[\._a-zA-Z0-9-]+/i", $current_user->user_email, $matches);
  $email_name = $matches[1][0];					
  $url = home_url();
  if (is_multisite()) {
      $url = network_home_url();
  }
  $apikey = get_option('wp_ultimate_security_checker_apikey');
  $linkedto = get_option('wp_ultimate_security_checker_linkedto', '');
  $params['apikey'] = $apikey;
  $params['blog_url'] = get_option('siteurl');
  if ($linkedto) {
  	$params['blog_id'] = $linkedto;
  }
  $register_url = "http://beta.ultimateblogsecurity.com/api/register/";
  $get_apikey_url = "http://beta.ultimateblogsecurity.com/api/get_apikey/";
  $add_website_url = "http://beta.ultimateblogsecurity.com/api/add_website/";
  $status_url = "http://beta.ultimateblogsecurity.com/api/get_status/";
	?>
	<!--<script>
		var ajax_token = "<?php echo wp_create_nonce('ultimate-security-checker-ajaxrequest'); ?>";
		var linked = "<?php echo $linkedto;?>";
              var apikey = "<?php echo $apikey;?>";
              var blogurl = "<?php echo $url;?>";
              
              var register_url = "<?php echo $register_url;?>";
              var get_apikey_url = "<?php echo $get_apikey_url;?>";
              var add_website_url = "<?php echo $add_website_url;?>";
              var status_url = "<?php echo $status_url;?>";
              
		var $ = jQuery;
		
              
              function ajax_get_screen(screen_name)
              {
		    $.ajax({
				url: ajaxurl,
				type: "POST",
				data: {csrfmiddlewaretoken: ajax_token, action:'ajaxscreen_loader', screen:screen_name},
				dataType: "html",
				success: function(data){
				  $("#ajax-content").html(data);
				},
				error: function(data){
				  $("#ajax-content").html("Error occured while ajax processing");
				}
			});
              }
              
              function ajax_get_status(success_cb, error_cb)
              {
			$.ajax({
				url: status_url,
				type: "POST",
				data: {apikey:apikey, blog_url:blogurl},
				dataType: "json",
				success: success_cb,
				error: error_cb
			});
              }
              
		function ajax_pro_logout(success_cb, error_cb) 
		{
			$.ajax({
				url: ajaxurl,
				type: "POST",
				data: {csrfmiddlewaretoken: ajax_token, action:'pro_logout'},
				dataType: "json",
				success: success_cb,
				error: error_cb
			});
		}
              
		function ajax_update_apikey(apikey, password, registered, success_cb, error_cb) 
		{
			$.ajax({
				url: ajaxurl,
				type: "POST",
				data: {csrfmiddlewaretoken: ajax_token, action:'set_apikey', apikey:apikey, password:password, registered:registered },
				dataType: "json",
				success: success_cb,
				error: error_cb
			});
		}
              
              $(document).ready(function(){
                  ajax_get_screen();
                  $("#ajax-content").delegate("#register-link", "click", function(event){
                      event.preventDefault();
                      ajax_get_screen('register');
                  });
                  $("#ajax-content").delegate("#dashboard-link", "click", function(event){
                      event.preventDefault();
                      ajax_get_screen('dashboard');
                  });
                  $("#ajax-content").delegate("#login-link", "click", function(event){
                      event.preventDefault();
                      ajax_get_screen('login');
                  });
                  $("#ajax-content").delegate("#ftp-link", "click", function(event){
                      event.preventDefault();
                      ajax_get_screen('ftp');
                  });
                  $("#ajax-content").delegate("#logout-link", "click", function(event){
                      event.preventDefault();
                      ajax_pro_logout(function(){
                          window.location.reload( true );
                      });
                  });
              });
	</script>-->
  <?php
}
	
function wp_ultimate_security_checker_current_status() {
	$apikey = get_option('wp_ultimate_security_checker_apikey');
	$linkedto = get_option('wp_ultimate_security_checker_linkedto', '');
	$params['apikey'] = $apikey;
	$params['blog_url'] = get_option('siteurl');		
	if ($linkedto) {
		$params['blog_id'] = $linkedto;
	}
	$status_url = sprintf("http://beta.ultimateblogsecurity.com/api/%s/?%s", "get_status", http_build_query($params));
	$find_url = sprintf("http://beta.ultimateblogsecurity.com/api/%s/?%s", "find_ftppath", http_build_query($params));
  include_once(plugin_dir_path( __FILE__ ) . 'view/current_status.php'); 
}
	
function wp_ultimate_security_checker_run_the_tests() {
  include_once(plugin_dir_path( __FILE__ ) . 'view/run_test.php'); 
}

function wp_ultimate_security_checker_add_menu_admin_bar() {
  global $wp_admin_bar;
  if (function_exists('is_multisite') && is_multisite() && current_user_can('manage_network_options')) {
  	// Many sites, check settings to hide bar
  	if (get_option('wp_ultimate_security_checker_hide_header') == 1) {
  		// Have multisite and setting hide_header checked
	     $wp_admin_bar->add_menu( array( 'id' => 'ubs_header', 'title' =>__( 'Secured by Ultimate Blog Security'), 'href' => FALSE ));
    } else {
      // Have multisite and setting hide_header not checked
	    if(get_option('wp_ultimate_security_checker_score') != 0){
	      $wp_admin_bar->add_menu( array( 'id' => 'theme_options', 'title' =>__( 'Security points <b style="color:'.get_option('wp_ultimate_security_checker_color').';">'.get_option('wp_ultimate_security_checker_score').'</b>', 'wp-ultimate-security-checker' ), 'href' => network_admin_url('settings.php')."?page=ultimate-security-checker" ) );
	    } else {
	      $wp_admin_bar->add_menu( array( 'id' => 'theme_options', 'title' =>__( '<span style="color:#fadd3d;">Check your blog\'s security</span>', 'wp-ultimate-security-checker' ), 'href' => network_admin_url('settings.php')."?page=ultimate-security-checker" ) );
	    }
    }
  } elseif(function_exists('is_multisite') && !is_multisite() && current_user_can('administrator')) {
    if (get_option('wp_ultimate_security_checker_hide_header') == 1) {
      // Have multisite and setting hide_header checked
			$wp_admin_bar->add_menu( array( 'id' => 'ubs_header', 'title' =>__( 'Secured by Ultimate Blog Security'), 'href' => FALSE ));
    } else {
	    // Not multisite and user is admin
	    if(get_option('wp_ultimate_security_checker_score') != 0){
	     $wp_admin_bar->add_menu( array( 'id' => 'theme_options', 'title' =>__( 'Security points <b style="color:'.get_option('wp_ultimate_security_checker_color').';">'.get_option('wp_ultimate_security_checker_score').'</b>', 'wp-ultimate-security-checker' ), 'href' => admin_url('tools.php')."?page=ultimate-security-checker" ) );
	    } else {
	      $wp_admin_bar->add_menu( array( 'id' => 'theme_options', 'title' =>__( '<span style="color:#fadd3d;">Check your blog\'s security</span>', 'wp-ultimate-security-checker' ), 'href' => admin_url('tools.php')."?page=ultimate-security-checker" ) );
	    }
	  }
  } else {
    // We display the 'Secured by Ultimate Blog Security' header
    $wp_admin_bar->add_menu( array( 'id' => 'ubs_header', 'title' =>__( 'Secured by Ultimate Blog Security'), 'href' => FALSE ));
  }
}

function wp_ultimate_security_checker_old_check(){

  /*if(isset($_GET['page'])){
    $res = explode('/',$_GET['page']);
    if($res[0] == 'ultimate-security-checker'): ?>
    <div class='update-nag'>Scared to upgrade to the most recent version of WordPress? Use our <b>Blog Update Service</b> for just $25. <a href="#">See details</a></div>
    <?php endif;
  }*/

  $period = get_option('wp_ultimate_security_checker_rescan_period');
  if ($period) {
    if((time() - get_option( 'wp_ultimate_security_checker_lastcheck',time())) > $period * 24 * 3600 ){
      switch ($period) {
        case '14' :
          $out = '2 weeks';
          break;
        case '30' :
          $out = 'a month';
          break;
      }
      ?>
      <div class='update-nag'><?php printf(__("It's been more than %s since you last scanned your blog for security issues."),$out);?> <a href="<?php echo admin_url('tools.php') ?>?page=ultimate-security-checker"><?php _e('Do it now.');?></a></div>
      <?php
    }
  }           
}

function wp_ultimate_security_checker_failed_login_logger($username){
  $ip = wp_ultimate_security_checker_get_address();
  if (!$failed_attepts_log = get_option('wp_ultimate_security_checker_failed_login_attempts_log'))
      $failed_attepts_log = array();
  $failed_attepts_log[] = array(
    'ip' => $ip,
    'username' => $username,
    'time' => date('Y-m-d H:i:s'),
  );
  update_option('wp_ultimate_security_checker_failed_login_attempts_log', $failed_attepts_log);  
}

function  wp_ultimate_security_checker_get_address($type = '') {
	if (empty($type)) {
		$type = 'REMOTE_ADDR';
	}
	if (isset($_SERVER[$type])) {
		return $_SERVER[$type];
	}
  $type = 'HTTP_X_FORWARDED_FOR';
  if (isset($_SERVER[$type])) {
		return $_SERVER[$type];
	}
	return '';
}

// JSON functions    
if ( !function_exists('json_decode') ){
  function json_decode($json) {
    $comment = false;
    $out = '$x=';
    for ($i=0; $i<strlen($json); $i++) {
      if (!$comment) {
        if (($json[$i] == '{') || ($json[$i] == '['))       $out .= ' array(';
        else if (($json[$i] == '}') || ($json[$i] == ']'))   $out .= ')';
        else if ($json[$i] == ':')    $out .= '=>';
        else                         $out .= $json[$i];          
      }
      else $out .= $json[$i];
      if ($json[$i] == '"' && $json[($i-1)]!="\\") $comment = !$comment;
    }
    eval($out . ';');
    return $x;
  }
}

if ( !function_exists('json_encode') ){
  function json_encode( $data ) {            
    if( is_array($data) || is_object($data) ) { 
      $islist = is_array($data) && ( empty($data) || array_keys($data) === range(0,count($data)-1) ); 
      if( $islist ) { 
        $json = '[' . implode(',', array_map('__json_encode', $data) ) . ']'; 
      } else { 
        $items = Array(); 
        foreach( $data as $key => $value ) { 
            $items[] = __json_encode("$key") . ':' . __json_encode($value); 
        } 
        $json = '{' . implode(',', $items) . '}'; 
      } 
    } elseif( is_string($data) ) { 
      # Escape non-printable or Non-ASCII characters. 
      # I also put the \\ character first, as suggested in comments on the 'addclashes' page. 
      $string = '"' . addcslashes($data, "\\\"\n\r\t/" . chr(8) . chr(12)) . '"'; 
      $json    = ''; 
      $len    = strlen($string); 
      # Convert UTF-8 to Hexadecimal Codepoints. 
      for( $i = 0; $i < $len; $i++ ) { 
        $char = $string[$i]; 
        $c1 = ord($char); 
        # Single byte; 
        if( $c1 <128 ) { 
          $json .= ($c1 > 31) ? $char : sprintf("\\u%04x", $c1); 
          continue; 
        } 
        # Double byte 
        $c2 = ord($string[++$i]); 
        if ( ($c1 & 32) === 0 ) { 
          $json .= sprintf("\\u%04x", ($c1 - 192) * 64 + $c2 - 128); 
          continue; 
        } 
        # Triple 
        $c3 = ord($string[++$i]); 
        if( ($c1 & 16) === 0 ) { 
          $json .= sprintf("\\u%04x", (($c1 - 224) <<12) + (($c2 - 128) << 6) + ($c3 - 128)); 
          continue; 
        }    
        # Quadruple 
        $c4 = ord($string[++$i]); 
        if( ($c1 & 8 ) === 0 ) { 
          $u = (($c1 & 15) << 2) + (($c2>>4) & 3) - 1; 
          $w1 = (54<<10) + ($u<<6) + (($c2 & 15) << 2) + (($c3>>4) & 3); 
          $w2 = (55<<10) + (($c3 & 15)<<6) + ($c4-128); 
          $json .= sprintf("\\u%04x\\u%04x", $w1, $w2); 
        } 
      } 
    } else { 
      # int, floats, bools, null 
      $json = strtolower(var_export( $data, true )); 
    } 
    return $json; 
  }
}

add_action( 'admin_notices', 'wp_ultimate_security_checker_old_check' );
// add_action('all_admin_notices','wp_ultimate_security_checker_upgrade_notice');
add_action('admin_bar_menu', 'wp_ultimate_security_checker_add_menu_admin_bar' ,  70);
add_action('admin_init', 'wp_ultimate_security_checker_admin_init');
add_action('admin_menu', 'wp_ultimate_security_checker_admin_menu');
add_action('wp_login_failed', 'wp_ultimate_security_checker_failed_login_logger');
    
function load_usc_style() {
  wp_register_style( 'usc_css', plugin_dir_url( __FILE__ ). 'assets/css/usc-style.css', false, '1.0.0' );
  wp_enqueue_style( 'usc_css' );
}
add_action( 'admin_enqueue_scripts', 'load_usc_style' );  
