jQuery(document).ready(function($){

	var cinema_name = $('#cust_location').val();
	if(!cinema_name){
		var cinema_name = readCookie('selected_cinema_code');
	}

	var baseUrl = 'https://eu.internet-ticketing.com';
	
    var websalesUrl = baseUrl + '/websales';
    var loginUrl = websalesUrl + '/sales/' + cinema_name + '/login';
    var logoutUrl = websalesUrl + '/auth/rest-auth/logout/';
    var memberUrl = websalesUrl + '/sales/api/' + cinema_name + '/memberself/';
	var membershipUrl = websalesUrl + '/sales/' + cinema_name + '/sell_membership/';
	var contactprefUrl = websalesUrl + '/sales/' + cinema_name + '/contact_preferences';

    $(".login-btn").on("click", function () {
		$('.jacro-loader-overlay').show();
		$('.jacro-loader').show(); 	
        $('#login-iframe').attr('src', loginUrl);
        $('#login-iframe').fadeIn();
    });

	$(".inner-detail-btn a, .account-btn a").on("click", function () {
		$('.jacro-loader-overlay').show();
		$('.jacro-loader').show();
		$('.details-form').show();
		$('body').addClass('contactpreferences-iframe-load');
		$('#contact-preferences-iframe').attr('src', contactprefUrl + '?' + sessionStorage.getItem('sessionUrlParameter'));
		$('#contact-preferences-iframe').fadeIn();
	});

    $(".logout-btn a").on("click", function () {
		$(".details-form").hide();
		$('body').removeClass('contactpreferences-iframe-load');
		$('.jacro-loader-overlay').show();
		$('.jacro-loader').show(); 
		erasecookie('user_logined');
        $('#logout-iframe').attr('src', logoutUrl);
        $('#logout-iframe').hide();
		$('#contact-preferences-iframe').hide();
		setTimeout(function() {
			$('.jacro-loader-overlay').hide();
			$('.jacro-loader').hide();
			$('.login-btn').removeClass('hiddenmenu');
        	$('.account-btn').addClass('hiddenmenu');
		}, 2000);
		sessionStorage.setItem('sessionUrlParameter', '');
    });

    $('#logout-iframe').on('load', function(){
		$('.jacro-loader-overlay').hide();
		$('.jacro-loader').hide();
    });
	
	$(".membership-btn").on("click", function () {
		 window.open(membershipUrl + '?' + sessionStorage.getItem('sessionUrlParameter'));
    });

	$(".details-form .closeppbtn").on('click', function(){
		$('body').removeClass('contactpreferences-iframe-load');
		$("#contact-preferences-iframe").attr('src', '');
		$(".details-form").hide();
	});
	
  function message_receiver(event) {
        console.log('event data is : ' + event.data);
        if(event.origin == baseUrl) {
            if (typeof(event.data) === 'string' && event.data.startsWith('iframe_login')) {
                console.log('after login condition');
				$('.jacro-loader-overlay').hide();
				$('.jacro-loader').hide();
				$('.login-btn').addClass('hiddenmenu');
				$('.account-btn').removeClass('hiddenmenu');
				sessionStorage.setItem('sessionUrlParameter', event.data.split(':::')[2]);
				
                $.ajax({
                    type: "GET",
                    url: memberUrl,
					xhrFields: {
                    	withCredentials: true,
                    },
					headers: {
						'Authorization': 'Token ' + event.data.split(':::')[1]
					},
                    success: function(msg) {
						erasecookie('user_logined');
						setcookie('user_logined','1','1');
						$('.jacro-loader-overlay').hide();
						$('.jacro-loader').hide();
                        $('#login-iframe').fadeOut();
                    },
					error: function(xhr, status, err) {
						console.log(err);
						console.log(JSON.stringify(err, undefined, 4));
					}
                });
            } else if (event.data === 'iframe_not_logged') {
				console.log('iframe not logged in condition');
				$('.jacro-loader-overlay').hide();
				$('.jacro-loader').hide();  
            } else if (event.data === 'iframe_close_login') {
                console.log('iframe close condition');
				$('#login-iframe').attr('src', '');
                $('#login-iframe').fadeOut();
                $('.princeloginiframe').show();
            }
        }
    }
    window.addEventListener('message', message_receiver, false);

});


function setcookie(key, value, expiry) {
	var expires = new Date();
	expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
	document.cookie = key + '=' + value + ';path=/' + ';expires=' + expires.toUTCString();
}

function getcookie(key) {
	var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
	return keyValue ? keyValue[2] : null;
}

function erasecookie(key) {
	var keyValue = getcookie(key);
	setcookie(key, keyValue, '-1');
}