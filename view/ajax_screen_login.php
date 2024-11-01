<script type="text/javascript">
    <!--
    var apikey = "<?php echo $apikey;?>";
    $(document).ready(function(){
        //login window
        $("#ajax-content").delegate("#pro-login-submit", "click", function(event){
            $("#ajax_loading").css("display", "block");
            $('#ajax-result').text('');
            $(this).attr('disabled', 'disabled');
            var el = $(this);
            var post_data = {
               username: $("#pro-login-email").val(),
               password: $("#pro-login-password").val(),
            };

            $.post(get_apikey_url, post_data , function(data) {
                if(data.state == 'error'){
                    if('data' in data){
                        if('errors' in data.data){
                            if('username' in data.data.errors)
                                $('#ajax-result').text(data.data.errors.username);
                            if('password' in data.data.errors)
                                $('#ajax-result').text(data.data.errors.password);
                        }    
                    } else if('message' in data) {
                     $('#ajax-result').text(data.message);
                    }
                    $("#ajax_loading").css("display", "none");
                    el.removeAttr('disabled');
                }
                if(data.state == 'ok'){
                    ajax_update_apikey(
                        data.data.apikey,
                        false,
                        false,
                        function(local_resp){
                            ajax_get_screen('dashboard');
                            console.log(local_resp);  
                        },
                        function(local_resp){
                            $("#ajax_loading").css("display", "none");
                            $('#ajax-result').text('Can\'t update your site values');
                            console.log(local_resp);  
                        }
                    );
                }
            }, 'json');
        });
    });	
-->
</script>  

<p>If you don't want to spend time to deal with manual fixes, want professionals to take care of your website - register your website and get API key, so we can help you get those fixes done. Fill the form below to complete registration
</p>
<h4><?php _e('Login to Ultimate Blog Security service');?></h4>
<ul>
    <li><label for="login"><?php _e('Username or Email');?></label><input id="pro-login-email" type="text" name="login" size="40" value="<?php echo $email_name; ?>" />
    </li>
    <li><label for="pwd"><?php _e('Password');?></label><input id="pro-login-password" type="password" name="pwd" size="40" />
    </li>
    <li>
        <div class="login-controlls">
            <div class="links-wrapper">
                <a id="register-link" href="#"><?php _e("I don't have account");?></a>
                <div class="clear"></div>
            </div>
            <div class="button-submit-wrapper">
                <input type="submit" id="pro-login-submit" class="button-primary" value="<?php _e('Submit');?>" />
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
    </li>
    <li>
        <p id="ajax_loading" style="display: none;"><?php _e('Communicating with server...');?>
            <img style="margin-left:15px;" src="<?php echo plugins_url( 'ultimate-security-checker/img/ajax-loader.gif' ); ?>" alt="loading" />
        </p>
    </li>
</ul>