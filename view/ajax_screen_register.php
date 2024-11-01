<script type="text/javascript">
    <!--
    var apikey = "<?php echo $apikey;?>";
    $(document).ready(function(){
        //reg window
        $("#ajax-content").delegate("#ajax-register-submit", "click", function(event){
            $("#ajax_loading").css("display", "block");
            $('#ajax-result').text('');
            $(this).attr('disabled', 'disabled');
            var el = $(this);
            var post_data = {
               email: $("#ajax-register-email").val(),
               username: $("#ajax-register-username").val(),
               blogurl: blogurl
           };

            $.post(register_url, post_data , function(data) {
                if(data.state == 'error'){
                    if('data' in data){
                        if('errors' in data.data){
                            if('username' in data.data.errors)
                                $('#ajax-result').text(data.data.errors.username);
                            if('email' in data.data.errors)
                                $('#ajax-result').text(data.data.errors.email);
                            if('blogurl' in data.data.errors)
                                $('#ajax-result').text(data.data.errors.blogurl);
                        }    
                    } else if('message' in data) {
                        $('#ajax-result').text(data.message);
                    }
                    $("#ajax_loading").css("display", "none");
                    el.removeAttr('disabled');
                }
                $('#ubs_regmsg').html('You sucessfully registered account in our service. Please - use this password for authentication in your plugin and our site: </br><strong>'+data.data.password+'</strong></br>We sent account activation details to your email. Please follow these instructions to complete registration.</br><a href="#" id="dashboard-link" class="button-primary">Go to dashboard -></a>');
                if(data.state == 'ok'){
                    ajax_update_apikey(
                        data.data.apikey,
                        data.data.password,
                        1,
                        function(local_resp){
                            if (local_resp.state == 'ok') {
                                $('#pro-reg-form').css('display', 'none');
                                $("ubs_regmsg").append('<p>Apikey sucessfully stored in your wordpress blog</p>');    
                            } else {
                                $('#ubs_regerr').text('Can\'t update your site values'); 
                            }  
                        },
                        function(local_resp){
                            $('#ubs_regerr').text('Can\'t update your site values'); 
                        }
                    );
                    $("#ajax_loading").css("display", "none");
                }
            }, 'json');
                            //console.log(post_data);
        });
    });	
-->
</script>

<h2 style="padding-left:5px;"><?php _e('Register to Ultimate Blog Security service');?></h2>
<div id="ubs_regmsg">
    <?php if ($apikey) { ?>
    <p>Thanks for registering. A confirmation email was sent to your email address.
        Please check your email and click on the link to confirm your account and complete your registration.
    </p>
    <?php } ?>
</div>              
<div id="ubs_regerr"></div>

<div id="pro-reg-form" style="<?php if ($apikey) { ?>display:none<?php }?>">                    
    <p>If you don't want to spend time to deal with manual fixes, want professionals to take care of your website - register your website and get API key, so we can help you get those fixes done. Fill the form below to complete registration
    </p>
    <ul>
        <li><label for="login"><?php _e('Email');?></label><input type="text" id="ajax-register-email" value="<?php echo $current_user->user_email; ?>" name="email" size="40" /></li>
        <li><label for="login"><?php _e('Username');?></label><input type="text" id="ajax-register-username" value="<?php echo $email_name; ?>" name="username" size="40" /></li>
        <li>
            <div class="login-controlls">
                <div class="links-wrapper">
                    <a id="login-link" href="#"><?php _e("login");?></a>
                    <div class="clear"></div>
                </div>
                <div class="button-submit-wrapper">
                    <input type="submit" id="ajax-register-submit" class="button-primary" value="<?php _e('Submit');?>" />
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>  
        </li>
        <li>
            <p id="ajax_loading" style="display: none;"> Communicating with server...
                <img style="margin-left:15px;" src="<?php echo plugins_url( 'ultimate-security-checker/img/ajax-loader.gif' ); ?>" alt="loading" />
            </p>
        </li>
    </ul>
</div>                 