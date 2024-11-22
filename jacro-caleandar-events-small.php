<?php
/**
* Template Name: Jacro Live Events
*
* @package Jacro
* @subpackage Jacro
*/

global $wpdb;
$table = $wpdb->prefix . "jacro_films";
$table_performances = $wpdb->prefix . "jacro_performances";
$table_locations = $wpdb->prefix . "jacro_locations";
$table_modifiers = $wpdb->prefix . "jacro_modifiers";

$location_result = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_locations LIMIT 1"));
if($location_result) {
    $location_id = $location_result[0]->id;
}

if($_COOKIE['cinema_id'] && $_COOKIE['cinema_id'] != 'undefined') {
    $cinema = $_COOKIE['cinema_id'];
} elseif($_COOKIE['visitedcinema_id'] && $_COOKIE['visitedcinema_id'] != 'undefined') {
    $cinema = $_COOKIE['visitedcinema_id'];
} else {
    $cinema = $location_id;
}

$strtotimezone = jacro_strtotimezone($cinema);
$today = date("Y-m-d", $strtotimezone);

$genre_code = (isset($_GET['code'])?$_GET['code']:'');

$check_today_evets = jacro_check_calender_events($today);
$evetn_filmes = jacro_get_live_event('film', '', $today);

$default_image= plugin_dir_url( __FILE__ ).'images/default.png';
$back_to_prev_page = jacro_get_back_page_link('back_to_live_prev_page');

wp_enqueue_style('jacro-caleandar-css');

$data_exist = false;

if (function_exists('fw_get_db_settings_option')) {
    $primaryColour = fw_get_db_settings_option('primary_colour');
    $secondaryColour = fw_get_db_settings_option('secondary_colour');
} else {
    $primaryColour = get_option('primary_colour');
    $secondaryColour = get_option('secondary_colour'); 
}

$post_parent = array();
foreach($evetn_filmes as $film) {
    $post_arr = jacro_get_live_event_performance($film->code, $today);
    $filmdtprformance = array();
    foreach($post_arr as $key=>$val) {
        $per_date = $val->performdate;
        $start_time = date('H:i', strtotime($val->starttime));
        if (array_search(date('Y, m, d', strtotime($per_date)), array_column($filmdtprformance, 'date')) !== FALSE) {
            continue;
        } else {
            if(strtotime(date('Y-m-d H:i', strtotime("$per_date $start_time"))) > $strtotimezone) { 
                $filmdtprformance[$counter]['date'] = date('Y, m, d', strtotime($per_date));         
                $film->time = $val->starttime;
                $post_parent[] = (array)$film;
            }
        }
    }
}
usort($post_parent, 'my_sort');

?>
<script src="//code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    jQuery(document).ready(function(){
        var events = [];
        var genre_code = '<?php echo $genre_code; ?>';
        var cinemaid = '<?php echo $cinema; ?>';
        //console.log(genre_code);
        var settings = {
            'EventTargetWholeDay': false,
            NavShow: true,
            NavVertical: false,
            EventTargetWholeDay: true,
            ModelChange: 'model'
        };
        jQuery.post(cinema_ajax.ajax_url, {'action':'jacro_action_call','jacro_call':'get_live_event_dates','cinemaid':cinemaid,'data':{'code':genre_code}}, function(response){
            var data_response = JSON.parse(response);
            //console.log('Calendor Resopnse ',data_response);
            jQuery.each(data_response.dates, function(key, value){
            
                jQuery.each(value, function(keyin, valuein){
                    jQuery.each(valuein, function(keytr, valuetr){
                        
                        if(valuetr.date){
                        var date_string = valuetr.date.replace(/,/g, "/");
                        events.push({'Date': new Date(date_string), 'Title': valuetr.title, 'Link':valuetr.url});
                    }
                    }); 
                    
                });
            });
            var element = document.getElementById('jacro-event-caleandar');
            caleandar(element, events, settings);
            jQuery(".cld-day").each(function(key, value){
                var this_obj = jQuery(value);
                if(jQuery(this).children('p.eventday').length){
                    this_obj.addClass('jacro-event-cursor-pointer');
                }
            });
        });
        jQuery('body').on('click', '.cld-day', function() {
            var this_obj = jQuery(this).children('p.eventday');
            console.log('this_obj', this_obj);
            var current_m_y = jQuery(".cld-datetime").children('div.today');
            console.log('current_m_y', current_m_y);
            if(this_obj.length){
                var now_date = jQuery(this).children('p.eventday').attr('data-dnumber'),
                date_string = ((now_date+","+current_m_y.html()).replace(/,/g, "/"));
                jacro_fetch_calendar_events(date_string);
                jQuery(this).addClass('today').siblings().removeClass('today');
            }
        });
    });
</script>
<style>
    li.cld-day.currMonth {
        cursor: pointer;
    }
    .advance_cal #jacro-event-caleandar ul.cld-days a {
        padding: 5px !important;
        margin: 0px 0px 3px 0px !important;
        line-height: 16px;
        font-size: 12px !important;
        text-decoration: none;
        color: #fff;
        border-radius: 4px;
    }
    .advance_cal #jacro-event-caleandar ul.cld-days .today a {
        border-bottom: 2px solid #fff;
        border-radius: 0;
        color: #fff;
        display: block;
    }
    .basic_cal #jacro-event-caleandar ul.cld-days a {
        padding: 0px !important;
        border-radius: 50%;
        margin: 0px !important;
        font-size: 0;
        position: absolute;
        height: 14px;
        width: 15px;
        top: 28px;
    }
    ul.cld-days li.cld-day::-webkit-scrollbar {
      width: 0.4em;
    }
    ul.cld-days li.cld-day::-webkit-scrollbar-track {
      box-shadow: inset 0 0 3px rgba(0, 0, 0, 0.4);
    }
    ul.cld-days li.cld-day::-webkit-scrollbar-thumb {
      background-color: darkgrey;
      outline: 1px solid slategrey;
    }
    #jacro-event-caleandar .cld-main {width: auto;}
    #jacro-event-caleandar ul.cld-days a { background: <?php echo $primaryColour ?>; padding: 5px; border-radius: 50%; }
    #jacro-event-caleandar ul.cld-days li.cld-day.currMonth.today { color:#fff; background: <?php echo $primaryColour ?>; border-color: <?php echo $primaryColour ?>;}
    #jacro-event-caleandar ul.cld-days li.cld-day.currMonth.today:hover { background: <?php echo $primaryColour ?>; border-color: <?php echo $primaryColour ?>;}
    #jacro-event-caleandar ul.cld-days li.cld-day.currMonth.today p:hover { background: <?php echo $primaryColour ?>; border-color: <?php echo $primaryColour ?>;}
    #jacro-event-caleandar ul.cld-days span.cld-title {overflow: hidden;padding: 0px;}
    #jacro-event-caleandar ul.cld-days a{padding: 5px !important;border-radius: 50%;margin: 0px !important;}
    #jacro-event-caleandar .cld-main ul.cld-labels {margin-bottom:0px; padding: 5px; color:#fff; background: <?php echo $primaryColour ?>;
        background: -moz-linear-gradient(left, <?php echo $primaryColour ?> 0%, <?php echo $secondaryColour ?> 100%);
        background: -webkit-linear-gradient(left, <?php echo $primaryColour ?> 0%,<?php echo $secondaryColour ?> 100%);
        background: linear-gradient(to right, <?php echo $primaryColour ?> 0%,<?php echo $secondaryColour ?> 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="<?php echo $primaryColour ?>", endColorstr="<?php echo $secondaryColour ?>",GradientType=1 );}
    #jacro-event-caleandar .cld-main .cld-datetime {padding: 5px;font-size: 20px;}
    #jacro-event-caleandar .cld-main ul.cld-days li.cld-day {height:50px;}
    .advance_cal #jacro-event-caleandar .cld-main ul.cld-days li.cld-day {min-height: 100px; height: auto;border: 1px solid #ddd !important;margin-top: 0;}
    .advance_cal span.cld-title a:hover {color: #adadad !important;}
    .advance_cal ul.cld-days {display: flex;flex-wrap: wrap;}
    #jacro-event-caleandar li.cld-day {border:none !important; border-top: 1px solid #ddd !important; border-bottom: 1px solid #ddd !important;}
    .jacro-event-cursor-pointer {cursor: pointer !important;}
    #jacro-event-caleandar .cld-day.nextMonth, #jacro-event-caleandar .cld-day.prevMonth {opacity: 1 !important;}
    #jacro-event-caleandar .cld-day.nextMonth, #jacro-event-caleandar .cld-day.prevMonth{background: #eee !important;}
    #jacro-event-caleandar .cld-day.nextMonth p, #jacro-event-caleandar .cld-day.prevMonth p{opacity: 0.2 !important;}
    .jacro-loader-overlay {display:none !important;}
    .perfbtn{color: #fff; background-color: <?php echo $primaryColour ?> !important;}
    .perfbtn:hover{color:#fff !important; background-color:<?php echo $secondaryColour ?> !important;}
    .moreshowtimes {background-image: linear-gradient(to right, <?php echo $primaryColour; ?>, <?php echo $secondaryColour; ?>) !important;}
    .moreshowtimes:hover {color: #fff !important;}
</style>
<div class="row jacro-container">
    <div class="row jacro-events">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-4 .col-md-push-8 basic_cal col-sm-12 col-xs-12 film_single">
                <div id="jacro-event-caleandar" class="caltypesmall"></div>
            </div>
            <div class="col-md-8 .col-md-pull-4 col-sm-12 col-xs-12 jacro-events calendartypesmall" id="jacro-calender-events">
                <div id="jacro-calender-events">
                    <?php
                    if(!empty($check_today_evets)){
                        foreach($post_parent as $film){
                            if(in_array($film['code'], $check_today_evets['ids'])){
                                $data_exist=true; 
                                $img_url = $film['img_1s'];
                                $url = $film['url'];
                                $certificate = $film['certificate'];
                                $running_time = $film['runningtime'];
                                $synopsis = $film['synopsis'];
                                $synopsis = balanceTags($synopsis, true);
                                if($img_url == "" || $img_url == "None"){ $img_url=$default_image; } ?>
                                <div class="jacro-event">
                                    <div class="col-md-12 col-sm-12 col-xs-12 no-padding">
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                             <div class="film_img">
                                                <a href="<?php echo esc_url($url); ?>" target="">
                                                   <img alt="" style="border-radius: 4px;" src="<?php echo esc_url($img_url); ?>" class="img-responsive" width="150" height="210">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-9 col-sm-6 col-xs-12" style="height: auto; margin-bottom: 2em;">
                                            <div class="film-title jacro-text-left" style="margin: 0px !important;">
                                                <h3>
                                                    <strong><a style="color: #101010;" href="<?php echo esc_url($url); ?>" target=""><?php echo esc_html($film['filmtitle']); ?></a></strong>
                                                    <span style="float: right; font-size: 13px; font-weight: bold; line-height: 33px; display: inline-block; width: 33px; height: 33px; margin-left: 5px; text-align: center; letter-spacing: 0; color: #fff; border-radius: 50%; background: #4a4a4a;"><?php echo $certificate; ?></span>
                                                </h3>
                                            </div>
                                            <div class="film-info"><?php echo htmlsafe_truncate($synopsis, 180, array('html' => true, 'ending' => ' ...', 'exact' => false)); ?></div>
                                            <a href="<?php echo esc_url($url); ?>" class="arrow-button">Full synopsis</a>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-12 no-padding" style="padding: 0px;"></div>
                                         <div class="col-md-9 col-sm-6 col-xs-12 no-padding" style="padding: 0px;">
                                            <?php
                                            $performance_date = date("Y-m-d", strtotime($today));
                                            $post_arr = jacro_get_live_event_performance($film['code'], $performance_date);
                                            $id_3d = filmCheckDimension($film['is3d']);
                                            $all_perf_flags = array();
                                            $jacroCountryname = get_option('jacroCountry-' . $term_id); 
                                            $filter = array(); 
                                            $tmparray = array();

                                            if (!empty($post_arr)) { 
                                            ?>
                                            <div class="jacro-events">
                                                <?php
                                                $start_date_arr = '';
                                                foreach ($post_arr as $key => $val) {
                                                    $perform_date = strtotime($val->performdate);
                                                    $start_time = date('H:i', strtotime($val->starttime));
                                                    $trailer_time = $val->trailertime;
                                                    $screen = $val->screen;
                                                    $approx_end_time = JacroCountApproxEndTime($start_time, $running_time, $trailer_time);
                                                    $approxEndTimeFormate = JacroTimeFormate($approx_end_time, $jacroCountryname);
                                                    $wheelchair_accessible = $val->wheelchairaccessible;
                                                    $soldoutlevel = $val->soldoutlevel;
                                                    $ad = $val->ad;

                                                    if (strpos($ad, 'Y') !== false) {
                                                        $ad = str_replace('Y', '<i class="fa fa-audio-description" aria-hidden="true"></i>', $ad);
                                                    } else { 
                                                        $ad = '';
                                                    }

                                                    $termsID = $val->location;
                                                    $termname = jacro_theatre_name($termsID);
                                                    $theatre_name = strtolower(preg_replace('/[^\\pL\d]+/u', '-', $termname));

                                                    $subs = $val->subs;
                                                    $perf_cat_class_val = $val->perfcat;
                                                    $perf_flags = $val->perfflags;

                                                    if (strpos($perf_flags, 'AUT') !== false) {
                                                        $perf_flags = str_replace('AUT', 'Autism Friendly', $perf_flags); 
                                                    }
                                                    if (!empty($perf_flags)) {
                                                        $perf_flags .= '</br>';
                                                    } else {
                                                        $perf_flags = ''; 
                                                    }

                                                    if ($start_date_arr == '') {
                                                        $start_date_arr = $perform_date;
                                                    }

                                                    if ($key == 0) {
                                                        $new = 0;
                                                    }

                                                    if ($start_date_arr != $perform_date) {
                                                        $new = 0;
                                                        $start_date_arr = $perform_date;
                                                    }

                                                    $tmparray[date("Y-m-d", $perform_date)][$new] = array(
                                                        'id' => $val->id,
                                                        'screen' => $screen,
                                                        'start_time' => $start_time,
                                                        'title' => $film['filmtitle'],
                                                        'date' => $perform_date,
                                                        'certificate' => $certificate,
                                                        'running_time' => $running_time,
                                                        'approx_end_time' => $approxEndTimeFormate,
                                                        'is_3d' => $id_3d,
                                                        'soldoutlevel' => $soldoutlevel,
                                                        'perf_cat_class_val' => $perf_cat_class_val,
                                                        'sub_title' => $subs,
                                                        'wheelchair_accessible' => $wheelchair_accessible,
                                                        'special_fea' => $perf_flags,
                                                        'booknow_url' => home_url() . "/" . $theatre_name . "/booknow/" . $val->code,
                                                    );
                                                    $new++;
                                                }

                                                foreach ($tmparray as $date => $datefilms) {
                                                    $filmstimearray = sorting_time($datefilms);
                                                    $tmp = ''; 
                                                    $is_show_date = 0;
                                                    $key_array = array();
                                                    $picount = 0;

                                                    foreach ($filmstimearray as $k => $films) { 
                                                        if (in_array($films['start_time'], $key_array)) {
                                                            continue;
                                                        }

                                                        $key_array[$picount] = $films['start_time'];
                                                        $picount++;
                                                        $per_date = date("Y-m-d", $films['date']);
                                                        $start_time = $films['start_time'];
                                                        $startTimeHourFormat = JacroTimeFormate($films['start_time'], $jacroCountryname);
                                                        $showTimeClass = strtolower($jacroCountryname) == 'us' ? 'show-time-12-hours' : (strtolower($jacroCountryname) == 'uk' ? '' : (get_option('jacroShowTimeHour') ? 'show-time-12-hours' : ''));

                                                        if(strtotime(date('Y-m-d H:i', strtotime("$per_date $start_time"))) > $strtotimezone) { 

                                                            if ($tmp == '') {
                                                                $show_date = true;
                                                                $tmp = $date;
                                                            } elseif ($tmp == $date) {
                                                                $show_date = false;
                                                            }

                                                            $jacroDateFormate = JacroDateFormate($date);

                                                            if ($show_date == true) {
                                                                $is_show_date = 1;
                                                                $date_year = date('Y', strtotime($jacroDateFormate));
                                                                $date_month = (date('m', strtotime($jacroDateFormate)) - 1);
                                                                $date_day = date('d', strtotime($jacroDateFormate));
                                                                echo '<div class="show-time" style="display: inline-block; padding-left: 15px;" >';
                                                            }

                                                            echo '<div class="perfmods" style="display: inline-block;">';
                                                            $jacrobookTimeFormat = get_option('jacroShowTimeHour') ? date("g:i a", strtotime($startTimeHourFormat)) : date("H:i", strtotime($startTimeHourFormat));
                                                            $perfcat_category_message = get_option('perfcat_category_message');
                                                            $pfbtntxt = '';
                                                            $pfbtnmsg = '';
                                                            $alertinfo = '';

                                                            if ($perfcat_category_message) { 
                                                                if ($films['perf_cat_class_val'] == $perfcat_category_message[$films['perf_cat_class_val']]['name']) {
                                                                    $pfbtntxt = $perfcat_category_message[$films['perf_cat_class_val']]['name'];
                                                                    if ($perfcat_category_message[$films['perf_cat_class_val']]['message']) {
                                                                        $alertinfo = 'onclick="showperfinfo(this, event)"';
                                                                        $pfbtnmsg = $perfcat_category_message[$films['perf_cat_class_val']]['message'];
                                                                    }
                                                                }
                                                            }

                                                            $buttonText = get_option('showtime_button_text') ?: '';
                                                            if($films['soldoutlevel'] && $films['soldoutlevel']=='Y') {
                                                            	echo '<a class="perfbtn disabled">Sold Out</a>';
                                                            }else{
                                                            	echo '<a class="perfbtn" ' . $alertinfo . ' href="' . $films['booknow_url'] . '">' . $buttonText . ' ' . $jacrobookTimeFormat . ' ' . $pfbtntxt . '</a>';
                                                            }
                                                            echo '<input type="hidden" class="perfcat_message" value="' . $pfbtnmsg . '">';
                                                            echo '</div>';
                                                            
                                                            if ($show_date == true) {
                                                                echo '</div>';
                                                            }
                                                        }
                                                    }
                                                }
                                                ?>
                                                <a style="margin-left: 5px; color: #ffffff" href="<?php echo esc_url($url); ?>" class="moreshowtimes" target="">More</a>
                                            </div>
                                            <?php 
                                            } 
                                            $all_perf_flags_imp = implode('<li><span>', $all_perf_flags); 
                                            ?>
                                        </div>
                                    </div>
                                </div>

                        <?php }
                        }
                    } 
                    if(!$data_exist){ ?>
                    <div class="film-info">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class='jacro-text-center jacro-custom-messages'><?php _e('We have no more performances today!</br>Please select another date from the calendar.', 'jacro'); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php wp_enqueue_script('jacro-caleandar-js'); ?>