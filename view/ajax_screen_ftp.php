 <script type="text/javascript">
            <!--
            var apikey = "<?php echo $apikey;?>";
            $(document).ready(function(){
                $("#ajax-content").delegate("#pro-ftp-submit", "click", function(event){
                    $("#ajax_loading").css("display", "block");
                    $('#ajax-result').text('');
                    $(this).attr('disabled', 'disabled');
                    var el = $(this);
                    var post_data = {
                                     apikey:apikey,
                                     uri:$("#pro-ftp-web_link").val(),
                                     ftphost:$("#pro-ftp-ftp_host").val(),
                                     ftppath:$("#pro-ftp-ftp_path").val(),
                                     ftpuser:$("#pro-ftp-ftp_user").val(),
                                     ftppass:$("#pro-ftp-ftp_pwd").val()
                                     };
                    $.post(add_website_url, post_data , function(data) {
                          if(data.state == 'error'){
                            if('data' in data){
                                if('errors' in data.data){
                                    if('uri' in data.data.errors)
                                        $('#ajax-result').text(data.data.errors.uri);
                                    if('ftphost' in data.data.email)
                                        $('#ajax-result').text(data.data.errors.ftphost);
                                    if('ftppath' in data.data.email)
                                        $('#ajax-result').text(data.data.errors.ftppath);
                                    if('ftpuser' in data.data.email)
                                        $('#ajax-result').text(data.data.errors.ftpuser);
                                    if('ftppass' in data.data.email)
                                        $('#ajax-result').text(data.data.errors.ftppass);
                                }    
                            }else if('message' in data){
                                $('#ajax-result').text(data.message);
                            }
                            $("#ajax_loading").css("display", "none");
                            el.removeAttr('disabled');
                          }
                          if(data.state == 'ok'){
                            ajax_get_screen('dashboard');
                            $('#ajax-result').text('Your blog has been sucessfully added to our system');
                          }
                    }, 'json');
                });    
            });	
            -->
            </script>
            <h2><?php _e('FTP Information');?></h2>
            <p>If you don't want to spend time to deal with manual fixes, want professionals to take care of your website - register your website and get API key, so we can help you get those fixes done. Fill the form below to complete registration</p>
            <h4><?php _e('Website details');?></h4>
            <ul>
            <li><label for="web_link"><?php _e('Website link');?></label><input id="pro-ftp-web_link" type="text" value="<?php echo $url; ?>" name="web_link" size="40" /></li>
            <li><label for="ftp_host"><?php _e('FTP Host');?></label><input id="pro-ftp-ftp_host" type="text" name="ftp_host" size="40" /></li>
            <li><label for="ftp_user"><?php _e('FTP User');?></label><input id="pro-ftp-ftp_user" type="text" name="ftp_user" size="40" /></li>
            <li><label for="ftp_pwd"><?php _e('FTP Password');?></label><input id="pro-ftp-ftp_pwd" type="password" name="ftp_pwd" size="40" /></li>
            <li><label for="ftp_path"><?php _e('Path to directory on your server (optional)');?></label><input id="pro-ftp-ftp_path" type="text" name="ftp_path" size="40" /></li>
            <li>
                <input type="submit" id="pro-ftp-submit" class="button-primary" value="<?php _e('Submit');?>" />
            </li>
            <li>
                <p id="ajax_loading" style="display: none;"> Communicating with server...
                <img style="margin-left:15px;" src="<?php echo plugins_url( 'ultimate-security-checker/img/ajax-loader.gif' ); ?>" alt="loading" />
                </p>
            </li>
            </ul>