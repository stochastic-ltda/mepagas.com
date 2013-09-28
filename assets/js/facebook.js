window.fbAsyncInit = function() {
    FB.init({
        appId   : '589467211096552',
        oauth   : true,
        status  : true, // check login status
        cookie  : true, // enable cookies to allow the server to access the session
        xfbml   : true // parse XFBML
    });

  };

function fb_login(){
    FB.login(function(response) {

        if (response.authResponse) {
            //console.log(response); // dump complete info
            access_token = response.authResponse.accessToken; //get access token
            user_id = response.authResponse.userID; //get FB UID

            FB.api('/me', function(userinfo) {
                var request = $.ajax({
                    type: "POST",
                    url: '/includes/phpscripts/user_create_facebook.php', 
                    data: userinfo, 
                    dataType: "json", 
                    success: function(data) {

                        if(typeof data.userid != "undefined") {

                            // inicio sesion
                            setCookie('email', userinfo.email,7);
                            setCookie('nombre', userinfo.name,7);
                            setCookie('userid', data.userid,7);
                            setCookie('avatar', "http://graph.facebook.com/" + userinfo.id + "/picture",7);

                            $.post('/includes/phpscripts/user_login_str.php', {id:data.userid}, function(str){
                                setCookie('mutm_gif', str, 7);                                
                            });             

                            changeloginfo(userinfo.name, data.userid, "http://graph.facebook.com/" + userinfo.id + "/picture"); 
                            $('.close-reveal-modal').click();
                        }

                    }
                });        
            });

        } else {
            //user hit cancel button
            console.log('User cancelled login or did not fully authorize.');

        }
    }, {
        scope: 'offline_access,user_birthday,user_likes,email'
    });
}