/** Document Ready **/

jQuery(document).ready(function ($) {
    
    $('.venobox').venobox({
        autoplay: true
    });
    
    jQuery(".desktopcinemaselect .cinema_select").click( function(e) {
        e.preventDefault();
        jQuery("#process_running").addClass('loader-action');
        jQuery('.desktopcinemaselect .cinema_select').removeClass("active");
        jQuery(this).addClass("active");
        var cinema_id = jQuery(this).attr("data-cinema_id");
        var cinema_ids = jQuery('#cine_val').attr('selectedcinema');
        var numberofposts = jQuery('.customslider').attr('data-posts');

        if(cinema_ids){
            jQuery("#cinema_id").val(cinema_ids);
        }else{
            jQuery("#cinema_id").val(cinema_id);
        }
        setCookie('cinema_id',cinema_id,'10');
        //fire change event using active date option on page load, so date dropdown gets selected
        jQuery('#mobimdates').val(jQuery('#mobimdates .film_date_value.active').attr('rel')).trigger('change');
        jQuery('#mobimcats').val(jQuery('#mobimcats .category_select.active').val()).trigger('change');
        jQuery("#process_running").removeClass('loader-action');
        show_film();

        jQuery.ajax({
            type: 'POST',
            url: cinema_ajax.ajax_url,
            data: {
                action: 'update_movie_slider',
                cinema_id : cinema_id,
                numberofposts : numberofposts,
            },
            success: function(response) {
                if (response.status == 'success') {
                    $('.customslider').html(response.htm);
                } else {
                    $('.noslide').html(response.htm);
                }
            },
            error: function(error) {
                console.log(error);
            }
        });

    });

    jQuery('#mobcinemaselect').on('change', function() {
        
        jQuery("#process_running").addClass('loader-action');
        var cinema_id = $(this).find(":selected").val();
        var cinema_ids = jQuery('#cine_val').attr('selectedcinema');
        var numberofposts = jQuery('.customslider').attr('data-posts');

        if(cinema_ids){
            jQuery("#cinema_id").val(cinema_ids);
        }else{
            jQuery("#cinema_id").val(cinema_id);
        }
        
        setCookie('cinema_id',cinema_id,'10');
        //fire change event using active date option on page load, so date dropdown gets selected
        jQuery('#mobimdates').val(jQuery('#mobimdates .film_date_value.active').attr('rel')).trigger('change');
        jQuery('#mobimcats').val(jQuery('#mobimcats .category_select.active').val()).trigger('change');
        jQuery("#process_running").removeClass('loader-action');
        show_film();

        jQuery.ajax({
            type: 'POST',
            url: cinema_ajax.ajax_url,
            data: {
                action: 'update_movie_slider',
                cinema_id : cinema_id,
                numberofposts : numberofposts,
            },
            success: function(response) {
                if (response.status == 'success') {
                    $('.customslider').html(response.htm);
                } else {
                    $('.noslide').html(response.htm);
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
        
    });
    
    var cinema_id = jQuery('#cinema_id').val();
    setCookie('cinema_id',cinema_id,'10');
 });

function setCookie(key, value, expiry) {
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
    setCookie(key, keyValue, '-1');
}

var today_date_obj = '';
jQuery(document).ready(function () {
    console.log('TEST 0.1');
    cinema_id = jQuery('#cinema_id').val();
    show_film_performances(cinema_id);
    switch_filter = jQuery('#switch_filter').val();
    if(switch_filter=='cinema-dates-films'){
        get_timing_from_cinema(cinema_id);
        console.log('TEST 2');
    } 
    // else {
    //     get_films(cinema_id);
    // }
    jQuery('.film_date_value').click(function (e) {
        var film_date = jQuery(this).attr('rel');
        if(film_date!='') {
            jQuery("#film_date").val(film_date);
            jQuery(".film_date_value").removeClass("active");
            jQuery(this).addClass("active");
            show_film();
            filter_films(0);
        }
    });
	
	jQuery('#mobimdates').on('change', function (e) {
        var film_date = jQuery(this).val();
        if(film_date!='') {
            jQuery("#film_date").val(film_date);     
            show_film();
            filter_films(0);
        }
    });


    //fire change event using active date option on page load, so date dropdown gets selected
    jQuery('#mobimdates').val(jQuery('#mobimdates .film_date_value.active').attr('rel')).trigger('change');

    //.. same with categories
    jQuery('#mobimcats').val(jQuery('#mobimcats .category_select.active').val()).trigger('change');

    jQuery('.coming_soon').click(function (e) {
        var coming_soon = jQuery(this).attr('rel');
        if (coming_soon == 'Now Showing') {
            jQuery("#date_list").show();
        } else {
            jQuery("#date_list").hide();
        }
        jQuery("#film_tags").val(coming_soon);
        jQuery(".fw-tabs ul li a").removeClass("active");
        jQuery(this).addClass("active");
        show_film();
    });

	jQuery('#mobimcats').on('change', function (e) {
		var coming_soon = jQuery(this).val();
		if (coming_soon == 'Now Showing') {
			jQuery("#mobimdateshow").show();
		} else {
			jQuery("#mobimdateshow").hide();
		}
		jQuery("#film_tags").val(coming_soon);
		show_film();
	});
   
    jQuery(".import_showtimes").bind('click', function () {
        jQuery("#process_running").addClass('loader-action');
        jQuery("#jacro-loader").css('display', 'block');
    });

    jQuery('#btn_cinema').click(function (e) {
        var datetime = jQuery('#datetime').val();
        var book_time_select = jQuery('#book_time_select').val();
        var name = jQuery('#name').val();
        var email = jQuery('#email').val();
        var phone = jQuery('#phone').val();
        var sort_of_beer = jQuery('#sort_of_beer').val();
        var participants = jQuery('#participants').val();
        var questions = jQuery('#phone').val();

        if (datetime == "") {
            jQuery('#datetime').css('border', '1px solid red');
        } else {
            jQuery('#datetime').css('border', 'none');
        }
        if (book_time_select == "") {
            jQuery('#book_time_select').css('border', '1px solid red');
        } else {
            jQuery('#book_time_select').css('border', 'none');
        }
        if (name == "") {
            jQuery('#name').css('border', '1px solid red');
        } else {
            jQuery('#name').css('border', 'none');
        }
        if (email == "") {
            jQuery('#email').css('border', '1px solid red');
        } else {
            var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (!filter.test(email)) {
                jQuery('#email').css('border', '1px solid red');
                return false;
            } else {
                jQuery('#email').css('border', 'none');
            }
        }
        if (phone == "") {
            jQuery('#phone').css('border', '1px solid red');
        } else {
            jQuery('#phone').css('border', 'none');
        }
        if (sort_of_beer == "") {
            jQuery('#sort_of_beer').css('border', '1px solid red');
        } else {
            jQuery('#sort_of_beer').css('border', 'none');
        }
        if (participants == "") {
            jQuery('#participants').css('border', '1px solid red');
        } else {
            jQuery('#participants').css('border', 'none');
        }
        if (questions == "") {
            jQuery('#questions').css('border', '1px solid red');
        } else {
            jQuery('#questions').css('border', 'none');
        }
        if (book_time_select != "" && datetime != "" && name != "" && email != "" && phone != "" && sort_of_beer != "" && participants != "" && questions != "") {
            var pattern = /^\d/;
            if (pattern.test(phone)) {
                jQuery('#phone').css('border', 'none');
            } else {
                jQuery('#phone').css('border', '1px solid red');
                jQuery('#phone').val('');
                return false;
            }
            jQuery.ajax({
                url: cinema_ajax.ajax_url,
                type: 'POST',
                dataType: "json",
                data: {
                    action: 'cinema_save',
                    datetime: datetime,
                    book_time_select: book_time_select,
                    name: name,
                    email: email,
                    phone: phone,
                    sort_of_beer: sort_of_beer,
                    participants: participants,
                    questions: questions,
                },
                success: function (response) {
                    jQuery('#myfrm_book').find("input[type=text], textarea, select").val("");
                    jQuery('#myfrm_book')[0].reset();
                    jQuery('#displaymessage').html(response.message);
                    jQuery('html, body').animate({
                        scrollTop: jQuery('#primary').offset().top
                    }, 'slow');
                }
            });
        }
        return false;
    });


    jQuery(".select_movie").change(function(){  
        var select_movie = jQuery(this).val();
		var selected_option = jQuery(this).find('option:selected');
        var movie_loc = selected_option.attr('attr_loc');
        jQuery.ajax({
            url: cinema_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'display_showtime_byfilmid',
                select_movie: select_movie,
				movie_loc: movie_loc,
            },
            success: function (response) {
                var datas = JSON.parse(response);
                jQuery('.select_showtime').html(datas.html);  
            }
        });
    });

    jQuery('.select_showtime').change(function() {  
        //window.location = jQuery(this).val(); 
        var urlll = jQuery(this).val(); 
        //window.open(urlll, '_blank');
        window.location.href = urlll; 
    }); 

    jQuery("#jacro-table-pricing-cinema").change(function(){
        var jacroCinemaID = jQuery(this).val();
        if(jacroCinemaID!='') {
            jacroGetPricingTable(jacroCinemaID);
        }
    });

    jQuery("#jacro-cinemas-filter").change(function(e){
        jQuery("#process_running").addClass('loader-action');
        var selectedTheatore = jQuery(this).val();
        var filmid = jQuery("#jacro-film-id").val();
        var filmname = jQuery("#jacro-film-name").val();
        var datas = {
            'action':'jacroGetSingleFilmPerformce',
            'cinemaID':selectedTheatore,
            'filmId':filmid,
            'filmName':filmname,
        };
        jQuery.post(cinema_ajax.ajax_url, datas, function(response){
            jQuery("#process_running").removeClass('loader-action');
            var datas = JSON.parse(response);
            jQuery("#single-film-performance-part").html(datas.html);            
        });
    });

    // Search Filter JS
    jQuery(".searchfilms_box").keyup( function() {
        var searchfilter = jQuery(this).val();
        var searchfilms_length = jQuery(this).val().length;
        var film_date = jQuery("input#film_date").val();
        var film_tags = jQuery("input#film_tags").val();
        var cinema_id = jQuery("input#cinema_id").val();
        if(searchfilms_length > 1) {
            jQuery("div#date_list").hide(); 
            search_ajax_function(searchfilter,film_date,film_tags,cinema_id);
        } 
        if(searchfilms_length == '') {
            jQuery("div#date_list").show();
            jQuery('a.film_date_value[rel="moredates"]').trigger('click');
        }
    });

});

/** Search ajax function **/
function search_ajax_function(searchfilter,film_date,film_tags,cinema_id) {
    jQuery.ajax({
        url: cinema_ajax.ajax_url,
        type: 'POST',
        data: {
            action: 'search_filter_results',
            searchfilter: searchfilter,
            film_date: film_date,
            film_tags: film_tags,
            cinema_id: cinema_id,            
        },
        success: function (response) {
            var datas = JSON.parse(response);
            jQuery('div#film_section').html(datas.html);
        }
    });
}

/** Get Pricing Table **/
function jacroGetPricingTable(jacroCinemaID) {
    jQuery("#process_running").addClass('loader-action');
    jQuery.ajax({
        url: cinema_ajax.ajax_url,
        type: 'POST',
        data: {
            action: 'jacroGetTheaterTablePrices',
            theatorID: jacroCinemaID,
        },
        error: function (request, error) {
            jQuery("#process_running").removeClass('loader-action');
        },
        success: function (response) {
            var datas = JSON.parse(response);
            if(datas.errors==false) {
                jQuery('#jacro-table-pricing').html(datas.htmlData);
            }
            jQuery("#process_running").removeClass('loader-action');
        }
    });
}

/** Get Films **/
function get_films(cinema_id) {
    if (cinema_id != undefined && cinema_id != "") {
        jQuery.ajax({
            url: cinema_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'show_film',
                cinema_id: cinema_id,
            },
            success: function (response) {
                var datas = JSON.parse(response);
                jQuery('#film_list').html(datas.html);
                jacro_widget_select();
            }
        });
        show_film_performances(cinema_id);
    }
}

function get_timing_from_cinema(cinema_id){
    if (cinema_id != undefined && cinema_id != "") {
        var settings = {
            'EventTargetWholeDay': false,
            NavShow: true,
            NavVertical: false,
            EventTargetWholeDay: true,
            ModelChange: 'model'
        };
        jQuery.ajax({
            url: cinema_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'get_dates_from_cinema',
                cinema_id: cinema_id,
            },
            success: function (response) {
                var data_response = JSON.parse(response);
                var events = [];
                jQuery.each(data_response.dates, function(key, value){
                    var date_string = value.replace(/,/g, "/");
                    events.push({'Date': new Date(date_string), 'Title': 'NEW', 'Link':'#'});
                });
                jQuery("#jacro-caleandar-section").empty();
                jQuery("#jacro-caleandar-section").append("<div class='jacro-events' id='jacro-date-events'></div>");
                var element = document.getElementById('jacro-date-events');
                if(events.length>=1){
                    jQuery("#jacro-widget-date-movie-section").show();
                    jQuery("#jacro-widget-showtime-section").show();
                    jQuery("#jacro-calender-messages").hide();
                    caleandar(element, events, settings);
                }else{
                    jQuery("#jacro-widget-date-movie-section").hide();
                    jQuery("#jacro-widget-showtime-section").hide();
                    jacro_messages("jacro-calender-messages", "No Films Available.", 'warning');
                }
                jQuery(".cld-day").each(function(key, value){
                    var this_obj = jQuery(value);if(jQuery(this).children('p.eventday').length){this_obj.addClass('jacro-event-cursor-pointer');}
                    if(jQuery(this).hasClass('today')){today_date_obj=this;}
                });

                var date_string = jacro_getdate_calendar(today_date_obj);
                if(date_string){get_movies_from_date(date_string);}
            }
        });
        show_film_performances(cinema_id);
    }
}

function jacro_widget_select(){
    jQuery(function (){
        get_timing(jQuery("#film_list option:selected").val());
    });
}

function jacro_widget_from_date_select(){
    jQuery(function (){
        var film_id = jQuery("#film_list option:selected").val();
        get_performance_from_movie(film_id);
    });
}

/** Get Timing **/
function get_timing(film_id) {
    if (film_id != undefined && film_id != "") {
        jQuery("#process_running").addClass('loader-action');
        jQuery.ajax({
            url: cinema_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'show_timing',
                film_id: film_id,
            },
            error: function (request, error) {
                jQuery("#process_running").removeClass('loader-action');
            },
            success: function (response) {
                var datas = JSON.parse(response);
                jQuery('#timing_list').html(datas.html);
                jQuery("#process_running").removeClass('loader-action');
            }
        });
    }
}

function get_movies_from_date(timing_id){
    if (timing_id != "") {
        jQuery("#process_running").addClass('loader-action');
        var cinema_id = jQuery("select#widgets_cinema_id option:selected").val();
        jQuery.ajax({
            url: cinema_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'get_films_from_date',
                timing_id: timing_id,
                cinemaid: cinema_id,
            },
            error: function (request, error) {
                jQuery("#process_running").removeClass('loader-action');
            },
            success: function (response) {
                response.replace(/^0+|0+$/g, "");
                var datas = JSON.parse(response);
                jQuery('#film_list').html(datas.html);
                jQuery("#film_list option:first").attr('selected','selected');
                jacro_widget_from_date_select();
            }
        });
    }
}

function get_performance_from_movie(film_id){
    if (film_id != "") {
        jQuery("#process_running").addClass('loader-action');
        var cinema_id = jQuery("select#widgets_cinema_id option:selected").val(),
        timing_id = jacro_getdate_calendar(today_date_obj);
        jQuery.ajax({
            url: cinema_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'get_performances_from_date',
                timing_id: timing_id,
                cinemaid: cinema_id,
                film_id: film_id,
            },
            error: function (request, error) {
                jQuery("#process_running").removeClass('loader-action');
            },
            success: function (response) {
                response.replace(/^0+|0+$/g, "");
                var datas = JSON.parse(response);
                jQuery('#performance_list').html(datas.html);
                jQuery("#process_running").removeClass('loader-action');
            }
        });
    }
}

/** Get Performance **/
function get_performance(timing_id) {
    if (timing_id != "") {
        jQuery("#process_running").addClass('loader-action');
        var film_id = jQuery("#film_list").val();
        var cinema_id = jQuery("select#widgets_cinema_id option:selected").val();
        jQuery.ajax({
            url: cinema_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'show_performances',
                timing_id: timing_id,
                cinemaid: cinema_id,
                film_id: film_id,
            },
            error: function (request, error) {
                jQuery("#process_running").removeClass('loader-action');
            },
            success: function (response) {
                response.replace(/^0+|0+$/g, "");
                var datas = JSON.parse(response);
                jQuery('#performance_list').html(datas.html);
                jQuery("#process_running").removeClass('loader-action');
            }
        });
    }
}

/** Show Film **/
function show_film() {
    var cinema_id = jQuery("#cinema_id").val();
	 if (jQuery(window).width() <= 767) {
        var film_date = jQuery('#film_date').val();
    } else {
        var film_date = jQuery('.film_date_value.active').attr('rel');
    }
    var film_tags = jQuery('#film_tags').val();
    if(film_date == 'moredates'){
        jQuery('a.film_date_value[rel="moredates"]').addClass('active');
    }
    if ((cinema_id) && cinema_id != "") {
        jQuery("#process_running").addClass('loader-action');
        jQuery.ajax({
            url: cinema_ajax.ajax_url,
            type: 'POST',
            async: false,
            data: {
                action: 'jacro_filter_result',
                film_date: film_date,
                film_type: film_tags,
                cinema_id: cinema_id,
            },
            error: function (request, error) {
                jQuery("#process_running").removeClass('loader-action');
            },
            success: function (response) {
                var datas = JSON.parse(response);
                jQuery('#film_section').html(datas.html);
                jQuery("#process_running").removeClass('loader-action');
                filter_films();
            }
        });
    }
}

/** Show Film & Performance Categories **/
function show_film_performances(cinema_id) {
    jQuery("#cinema_id").val(cinema_id);
    jQuery(".subselect-cinema-theater").val(cinema_id);
    if (jQuery("#widgets_cinema_id").length != 0) {
        if (cinema_id) {
            jQuery("#widgets_cinema_id").val(cinema_id);
        }
    }
    if (cinema_id != undefined && cinema_id != '') {
        jQuery("#process_running").addClass('loader-action');
        // jQuery.ajax({
        //     url: cinema_ajax.ajax_url,
        //     type: 'POST',
        //     async: false,
        //     data: {
        //         action: 'jacroCheckFilmOnDate',
        //         cinema_id: cinema_id,
        //     },
        //     success: function (response) {
        //         var datas = JSON.parse(response);
        //         jQuery.each(datas.jacroCheckFilmOnDate, function(key, value){
        //             jQuery("#date_list a").each(function(){
        //                 if(jQuery.trim(key) == jQuery.trim(jQuery(this).attr('rel'))) {
        //                     if(parseInt(value)<=0) {
        //                         jQuery(this).addClass('filmDateDisable');
        //                     } else {
        //                         jQuery(this).removeClass('filmDateDisable');
        //                     }
        //                 }
        //             });
        //         });
        //     }
        // });
        jQuery.ajax({
            url: cinema_ajax.ajax_url,
            type: 'POST',
            async: false,
            data: {
                action: 'show_film_performances',
                cinema_id: cinema_id,
            },
            error: function (request, error) {
                jQuery("#process_running").removeClass('loader-action');
            },
            success: function (response) {
                var datas = JSON.parse(response);
                jQuery('#performance_category_div').html(datas.performancecatdatas);
                jQuery('#film_category_div').html(datas.filmcategorysdatas);
                jQuery("#process_running").removeClass('loader-action');
            }
        });
    }
}

/* iframe listen */
jQuery(document).ready(function($){
    window.addEventListener( "message", CallJacroIframeListener, false );
});

/** Film Categories Filters **/
function filter_films(obj) {
    var checkedparameter = 0;
    var arraytmp = [];
    var i = 0;
    jQuery('input[type=checkbox].performance_checkbox').each(function () {
        perclass = 'percate_' + jQuery(this).val().toLowerCase().replace(/\s/g, "_");
        perclassfor = perclass.replace(/[^a-z0-9\s]/gi, '');    
        if (this.checked) {
            arraytmp[i] = perclassfor;
            i++;
        }
    });
    
    jQuery('input[type=checkbox].film_checkbox').each(function () {
        filmclass = 'filmecat_' + jQuery(this).val().toLowerCase().replace(/\s/g, "_");
        filmclassfor = filmclass.replace(/[^a-z0-9\s]/gi, '');
        //console.log('filmclassfor', i + filmclassfor);
        if (this.checked) {
            arraytmp[i] = filmclassfor;
            i++;
        }
    });

    jQuery('input[type=checkbox].modifier_checkbox').each(function () {
        filmclass = jQuery(this).val();
        if (this.checked) {
            arraytmp[i] = filmclass;
            i++;
        }
    });

    //console.log('arraytmp', 'arraytmp');
    jQuery(".neworderpf").hide();
    jQuery(".innercatdived").show();
    jQuery(".movie-tabs").hide();
    jQuery(".singlefilmperfs").hide();
    jQuery(".poster-case").hide(); 
    jQuery(".filter_percat").hide();
    jQuery('.innercatdived').removeClass('active');
    jQuery.each(arraytmp, function (key, value) {
        jQuery("." + value).show();
        jQuery(".filter_percat").show();
        jQuery("." + value).parent('.innercatdived').addClass('active');
    });
    if (arraytmp.length == 0) {
        jQuery(".movie-tabs").show();
        jQuery(".singlefilmperfs").show();
        jQuery(".poster-case").show();  
        
        jQuery(".neworderpf").show();
        jQuery(".innercatdived").hide(); 
    }
}

/** Show Time **/
function show_time() {
    var datetime = jQuery('#datetime').val();
    if (datetime != "") {
        jQuery.ajax({
            url: cinema_ajax.ajax_url,
            type: 'POST',
            dataType: "json",
            data: {
                action: 'show_time',
                datetime: datetime,
            },
            success: function (response) {
                jQuery('#book_time_select').html(response.return_val);
            }
        });
    }
}

/** Show Time Edit **/
function show_time_edit() {
    var datetime = jQuery('#datetime').val();
    var id = jQuery('#id').val();
    if (datetime != "") {
        jQuery.ajax({
            url: cinema_ajax.ajax_url,
            type: 'POST',
            dataType: "json",
            data: {
                action: 'show_time_edit',
                datetime: datetime,
                id: id,
            },
            success: function (response) {
                jQuery('#book_time_select').html(response.return_val);
            }
        });
    }
}

/* Loader **/
function JacroLoader(action) {
    if(action=='show') {
        jQuery(".jacro-loader-overlay").show(); jQuery(".jacro-loader").show();
    } else {
        jQuery(".jacro-loader-overlay").hide(); jQuery(".jacro-loader").hide();
    }
}

/** Iframe Listener **/
function CallJacroIframeListener(event) {
  /** Request Datas **/
    if (event.data == 'iframe_requesting_data') {
        jQuery("body").addClass('scrollstop');
        JacroLoader('show'); 
    }
    /** Received Page **/
    if (event.data == 'iframe_data_received') {
        jQuery("body").removeClass('scrollstop');
        JacroLoader('hide');
        call_jacro_evert_buynow_request();
        window.scrollTo(0,0);
    }
	/** Scroll Top **/
    if (event.data == 'iframe_scroll_to_top_of_page') {
        window.scrollTo(0,0);
    }
    /** Stripe **/
    if (typeof event.data === 'string' && event.data.startsWith('stripe_redirect')) {
        console.log('iframe has received stripe_redirect ' + event.data);
        var url = event.data.substring(16);
        window.location.href = url;
    }
}

/** Read Cookie **/
function readCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for(var i=0;i < ca.length;i++) { 
      var c = ca[i];
      while (c.charAt(0)==' ') c = c.substring(1,c.length);
      if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
  }
  return null;
}

/** Random TrasposId **/
function randomTaposID(stringLength) {
  var chars = "0123456789abcdefghiklmnopqrstuvwxyz";
  var randomstring = '';
  for (var i=0; i<stringLength; i++) {
    var rnum = Math.floor(Math.random() * chars.length);
    randomstring += chars.substring(rnum,rnum+1);
  }
  return randomstring;
}

function call_jacro_evert_buynow_request(){
    jQuery.post(cinema_ajax.ajax_url, {action: 'jacro_buynow_process_start', 'buynow': true}, function (response) {
        
    });
}

function jacro_fetch_calendar_events(date){
    JacroLoader('show');
    jQuery.post(cinema_ajax.ajax_url, {'action':'get_calender_event', 'date':date}, function(response){
        var data_response = JSON.parse(response);
        jQuery("#jacro-calender-events").html(data_response.events_template);
        JacroLoader('hide');
    });
}

function jacro_getdate_calendar(this_obj){
    this_obj = jQuery(this_obj).children('p.eventday');
    var current_m_y = jQuery(".cld-datetime").children('div.today');
    if(this_obj.length){
        var now_date = (this_obj.html().replace(/(<([^>]+)>)/ig,"")),
        date_string = (now_date+", "+current_m_y.html());
        date_string = ((now_date+","+current_m_y.html()).replace(/,/g, "-"));
        date_string = date_string.replace(/ /g,'');
        return date_string;
    }
    return false;
}

function jacro_reload_page(){
    window.location.reload();
}

function jacro_messages(id, msg, type){
    if(type=='warning'){
        var message = '<i class="fa fa-exclamation-circle"></i>'+msg;
        jQuery("#"+id).addClass("jacro-warning-note").html(message).show();
    } else if(type=='error'){

    }
}

/** Get Pricing Table **/
function changelayout(selectedtype) {   
    jQuery("#layout_changing").addClass('loader-action');
    jQuery.ajax({
        url: cinema_ajax.ajax_url,
        type: 'POST',
        data: {
            action: 'changeLayoutView',
            type: selectedtype,
        },
        error: function (request, error) {
           jQuery("#layout_changing").removeClass('loader-action');
        },
        success: function (response) {
            var datas = JSON.parse(response);
            
            if(datas.status=='success') {
                jacro_reload_page();
            }else{
                alert('Something went wrong please try after some time.');
                jQuery("#layout_changing").removeClass('loader-action');
            }
            
        }
    });
}

/* show information onclick performance category on showtime */
jQuery(document).ready(function($){
    jQuery(".showperfinfo").click( function(e) {
        var bookingurl = jQuery(this).attr('href');
        var message = jQuery(cltag).next().val();
        jQuery('.bkingbtn').attr("href",bookingurl);
        e.preventDefault();
        jQuery('.bkingbtn').prev().text(message);
        jQuery('#showinfo').addClass("active");
        jQuery('body').addClass("noscroll");
    });
    jQuery(".closeppp").click( function(e) {
        jQuery('.bkingbtn').attr("href",'');
        jQuery('#showinfo').removeClass("active");
        jQuery('body').removeClass("noscroll");
    });
	jQuery(".gift-bribie").click( function(e) {
        jQuery('#bribiemovies-giftcard').attr("src", "https://cineticketing.com.au/websales/sales/bribie/sell_giftcard?&nodecorators=true");
		jQuery('.giftcardcontent').hide();
		jQuery('#bribiemovies-giftcard').show();
    });
    iFrameResize({
        autoResize:true, checkOrigin:false, log:false, enablePublicMethods:true, resizedCallback: 
        function(messageData){ }
    });
});
/* show info perfcat function */
function showperfinfo(cltag, e){
    var bookingurl = jQuery(cltag).attr('href');
    var message = jQuery(cltag).next().val();
    jQuery('.bkingbtn').attr("href",bookingurl);
    e.preventDefault();
    jQuery('.bkingbtn').prev().text(message);
    jQuery('#showinfo').addClass("active");
    jQuery('body').addClass("noscroll");
}