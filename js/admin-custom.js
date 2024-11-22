/** Document Ready **/
jQuery(document).ready(function () {
	/** Tabs **/
	jQuery('ul.tabs li').click(function(){
		var tab_id = jQuery(this).attr('data-tab');
		jQuery('ul.tabs li').removeClass('current');
		jQuery('.tab-content').removeClass('current');
		jQuery(this).addClass('current');
		jQuery("#"+tab_id).addClass('current');
	});

	/*** Import Customer Feeds, Locations, Films and Performance **/
	jQuery(".import_customer").click(function(e) {
		e.preventDefault();
		var total_film=0,total_performance=0,total_modifier=0,count_location=0; 
		jacro_loader('show');
		var customer_id = jQuery(this).data('id');
		jQuery.post(ajaxurl,{'customer_id':customer_id,'action':'jacro_import_feeds'},function(response){
			var response_data = JSON.parse(response);var array_counter = 0;
			if((!response_data.errors)&&(response_data[array_counter])&&(response_data.total_location_counter>0)){
				jacro_call_import_ajax(response_data, response_data.total_location_counter, 0, total_film, total_performance, total_modifier);
			} else {
				jQuery("#jacro-messages").show();
				jQuery("#jacro-messages").addClass('error');
				jQuery("#jacro-messages").html("Sorry, somthing went wrong. Please try again.");
				jacro_loader('hide');
			}
		});
	});

	/*** Import Films and Performance **/
	jQuery(".import_all_films_performaces").click(function(e){
		e.preventDefault();
		var total_film=0,total_performance=0,total_modifier=0,count_location=0;
		jacro_loader('show');
		jQuery.post(ajaxurl,{'all':true,'action':'jacro_get_all_theatre'},function(response){ 
			var response_data = JSON.parse(response);var array_counter = 0;
			if((!response_data.errors)&&(response_data[array_counter])){
				jacro_call_import_ajax(response_data, response_data.total_location_counter, 0, total_film, total_performance, total_modifier);
			} else {
				jQuery("#jacro-messages").show();
				jQuery("#jacro-messages").addClass('error');
				jQuery("#jacro-messages").html("Sorry, somthing went wrong. Please try again.");
				jacro_loader('hide');
			}
		});
	});

	jQuery(".import_films_performaces").click(function(e){
		e.preventDefault(); 
        var total_film=0,total_performance=0,total_modifier=0;
		jacro_loader('show');
		var term_id = jQuery(this).data('id');
		setTimeout(function(){
			jQuery.ajax({url: ajaxurl,method:"POST",async:false,data:{'action':'jacro_import_films_performance','term_id':term_id},
				success: function(feed_response){
					var feed_response_data = JSON.parse(feed_response);
					if(feed_response_data)
					total_film = parseInt(total_film+(parseInt(feed_response_data.totalNewFilm)));
					total_performance = parseInt(total_performance+(parseInt(feed_response_data.totalNewPerformance)));
					total_modifier = parseInt(total_modifier+(parseInt(feed_response_data.totalNewModifier)));
					jQuery("#jacro-messages").show();
					jQuery("#jacro-messages").addClass('updated');
					jQuery("#jacro-messages").html("Total <b>"+total_film+"</b> films, <b>"+total_performance+"</b> performances and <b>"+total_modifier+"</b> modifiers imported.");
					jacro_loader('hide');
				}
		}, 2000);
		jacro_loader('hide');
	});
	});
});

jQuery(document).ready(function ($) {
    $('.jacro_log_reset').on('click', function(e){
        e.preventDefault();
        $('.jacro_log_reset').html('<span class="progress_delete">deleting in progress...</span>');
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
                'action':'delete_log_record'
            },
            success: function(response) {
                $('.jacro_log_reset').html('Reset Log Database');
            }
        });
    });
});

function jacro_call_import_ajax(response_data, total_counter, array_counter, total_film, total_performance, total_modifier){
	if(total_counter>=array_counter){
		if(response_data[array_counter]){
			jQuery.ajax({url: ajaxurl,method:"POST",async:false,data:{'action':'jacro_import_films_performance','term_id':response_data[array_counter].term_id,'cinema_name':response_data[array_counter].name},
				success: function(feed_response){
					var feed_response_data = JSON.parse(feed_response);
					total_film = parseInt(total_film+(parseInt(feed_response_data.totalNewFilm)));
					total_performance = parseInt(total_performance+(parseInt(feed_response_data.totalNewPerformance)));
					total_modifier = parseInt(total_modifier+(parseInt(feed_response_data.totalNewModifier)));
					jQuery("#jacro-loader .imported-message").html("importing <b>"+total_film+"</b> films, <b>"+total_performance+"</b> performances and <b>"+total_modifier+"</b> modifiers.");
				}
			});
		}
		array_counter++;
		setTimeout(function(){
			jacro_call_import_ajax(response_data, total_counter, array_counter, total_film, total_performance, total_modifier);
		}, 1000);
	} else {
		jQuery("#jacro-messages").show();
		jQuery("#jacro-messages").addClass('updated');
		jQuery("#jacro-messages").html("Total <b>"+total_film+"</b> films, <b>"+total_performance+"</b> performances and <b>"+total_modifier+"</b> modifiers imported.");
		jacro_loader('hide');
	}
}

function jacro_loader(action){
	if(action=='show'){
		jQuery("#jacro-loader .imported-message").html('');
		jQuery("#jacro-loader").css('display', 'block');
	} else if(action=='hide'){
		jQuery("#jacro-loader .imported-message").html('');
		jQuery("#jacro-loader").css('display', 'none');
	}
}

function is_number(evt) {
	evt=((evt)?evt:window.event);
	var charCode=((evt.which)?evt.which:evt.keyCode);
	if(charCode>31&&(charCode<48||charCode>57)){return false;}
	return true;
}