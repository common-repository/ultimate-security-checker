<div id="images"></div>
<div class="wrap">      
	<script type="text/javascript">
		jQuery(document).ready(function($) {			
			$('#select_website').submit(submit_selected_site);
			// auto start of info request
			$('#ajax_loading').fadeIn();
			// TODO: if linked and response is not found - reset state.
			$.ajax({
				url: "<?php echo $status_url;?>&callback=?",
				dataType: "jsonp",
				complete: function (){
					$('#ajax_loading').fadeOut();
				},
				success: function(response) {
					if (response && response.state == 'ok') {
						$('#ajax_status').show();
						var path_status = $('#path_status');
						var login_status = $('#login_status');
						if (response.data.path && response.data.verified) {
							path_status.text(response.data.path +" was successfully verified").css('color', 'green');
						} else if (!response.data.path) {	
							path_status.html('<span> was not providen yet - <a id="verify_path" href="#"> click to find</a></span>').css('color', 'red');
						} else {
							var span = document.createElement('span');
							$(span).text(response.data.path +" is not verified yet").css('color', 'orangered');
							path_status.append(span);
							path_status.append('<span> - <a id="verify_path" href="#"> verify</a></span>');
						}
						if (response.data.last_login) {	
							var status = response.data.last_login_status;
							var msg = status ? 'successful' : 'failed';
							var color = status ? 'green' : 'orangered';
							var d = new Date(response.data.last_login*1000);								
							login_status.text(msg + ' at ' + d.toLocaleString()).css('color', color);
						}						
					} else {
						var message;
						if (response.state == 'error')  {
							switch (response.errno) {
								case -2: // Blog not found
								add_website();
								return;
								case -3: // Multiple blogs found
								select_website(response.data);
								return;
								case -1: // Invalid API key									
								case -4: // Bad request
								message = response.message;
								break;
								default:
								message = 'unknown error occured';
								break;
							}
						} else {
							message = "can't connect to UBS server";
						}
						var err_message = '<p>Error: '+ message + '</p>';															
						var ajax_error = $('#ajax_error');
						if (!ajax_error.length) {
							$('#ajax_status').before('<div id="ajax_error" style="color:orangered">'+ err_message +'</div>');
							var ajax_error = $('#ajax_error');
						} else {
							ajax_error.text(err_message);
						}
						if (response.data) {
							for (item in response.data) {
								ajax_error.append('<p>' + item + ': ' + response.data[item] + '</p>');
							}		
						}
						$('#ajax_status').hide();
					}
				}
			});
			$("#verify_path").live("click", function(e){
				e.preventDefault();
				$('#ajax_loading').fadeIn();
				$.ajax({
					url: "<?php echo $find_url;?>&callback=?&path=<?php echo ABSPATH;?>",
					dataType: "jsonp",
					complete: function (){
						$('#ajax_loading').fadeOut();
					},						
					success: function(response) {
						if (response && response.state == 'ok') {
							$('#ajax_status').show();
							var path_status = $('#path_status');
							var login_status = $('#login_status');
							if (response.data.path && response.data.verified) {
								path_status.text(response.data.path +" was successfully verified").css('color', 'green');
							} else if (!response.data.path) {	
								path_status.text(' was not providen yet').css('color', 'red');
							} else {
								var span = document.createElement('span');
								$(span).text(response.data.path +" is not verified yet").css('color', 'orangered');
								path_status.append(span);
								path_status.append('<span> - <a id="verify_path" href="#"> verify</a></span>');
							}													
						} else {
							var msg = (response.state == 'error') ? response.message : "can't connect to UBS server";
							var err_message = '<p>Error: '+ msg + ' (<a id="verify_path" href="#">retry</a>) </p>';															
							var ajax_error = $('#ajax_error');
							if (!ajax_error.length) {
								$('#ajax_status').before('<div id="ajax_error" style="color:orangered">'+ err_message +'</div>');
								var ajax_error = $('#ajax_error');
							} else {
								ajax_error.text(err_message);
							}
							if (response.data) {
								for (item in response.data) {
									ajax_error.append('<p>' + item + ': ' + response.data[item] + '</p>');
								}		
							}
							$('#ajax_status').hide();
						}
					}	
				});				
			});
		});
	</script>

	<?php wp_ultimate_security_checker_header(); ?>

	<h3 class="nav-tab-wrapper usc-tabs">
		<a href="?page=ultimate-security-checker&tab=run-the-tests" class="nav-tab">Run the Tests</a>
		<a href="?page=ultimate-security-checker&tab=wp-files" class="nav-tab">Files Analysis</a>
		<a href="?page=ultimate-security-checker&tab=how-to-fix" class="nav-tab">How to Fix</a>
		<a href="?page=ultimate-security-checker&tab=settings" class="nav-tab">Settings</a>
	</h3>

	<h4>Current status </h4>
	<form id="add_website" style="display: none;" action="." method="GET">
		<?php
		$apikey = get_option('wp_ultimate_security_checker_apikey');
		if ($apikey) { ?>
		<p>Seems like you didn't added your blog at ultimateblogsecurity.com so far, you can do it right now: </p>
		<input type="hidden" name="apikey" value="<?php echo htmlspecialchars($apikey);?>"/>
		<input type="hidden" name="uri" value="<?php echo get_option('siteurl');?>"/>
		<table>
			<tr>
				<td><label>What's the FTP address of your blog (example: ftp://myblog.com)?</label></td>
				<td><input type="text" name="ftphost"/></td>
			</tr>
			<tr>
				<td><label>WordPress location (see settings tab in plugin)</label></td>
				<td><input type="text" name="ftppath" value="<?php echo ABSPATH;?>"/></td>
			</tr>
			<tr>
				<td><label>What's the FTP username for your blog's FTP account?</label></td>
				<td><input type="text" name="ftpuser"/></td>
			</tr>
			<tr>
				<td><label>What's the password for your blog's FTP account?</label></td>
				<td><input type="password" name="ftppass"/></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="Submit" style="float:right"/></td>
			</tr>
		</table>
		<?php } else { ?>
		<p>If you already have account at ultimateblogsecurity.com - update APIKEY field in
			plugin's settings with key displayed at account info page. Otherwise, create new account first.</p>
			<?php } ?>
	</form>
	<form id="select_website" style="display:none">
		<p>
			You have multiple records in UBS dashboard for this blog.
			Please choose one, guided by it's FTP info.
		</p>
	</form>
	<table id="ajax_status">
		<tr>
			<td>Path</td><td id="path_status"></td>
		</tr>
		<tr>
			<td>Last login</td><td id="login_status"></td>
		</tr>
	</table>	
</div>