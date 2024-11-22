<?php

global $wpdb;
$table = $wpdb->prefix . "jacro_films";
$table_performances = $wpdb->prefix . "jacro_performances";
$table_locations = $wpdb->prefix . "jacro_locations";

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

$default_jacro_image = get_option( 'default_jacro_image' );
$default_image = wp_get_attachment_url( $default_jacro_image);
if($default_image == '') :
    $default_image = plugin_dir_url( __FILE__ ).'images/default.png';
endif;
$back_to_prev_page = jacro_get_back_page_link('back_to_live_prev_page');

$live_film_feeds = array();

$strtotimezone = jacro_strtotimezone($cinema);
$today = date("Y-m-d", $strtotimezone);

$result = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table WHERE location = %d", $cinema));

if(!empty($result)){
    foreach($result as $key => $film){
        $query = $wpdb->prepare("SELECT * FROM $table_performances WHERE location = %d AND filmcode = %s AND performdate >= %s AND selloninternet = %s ORDER BY performdate ASC", $cinema, $film->code, $today, 'Y');
        $perf_result = $wpdb->get_results($query);
        $filmtitle = $film->filmtitle;
        $new = 0; $tmp_checkup = array();
        if(!empty($perf_result)){
            foreach($perf_result as $performance){
                $perform_date = strtotime($performance->performdate);
                if(!empty($tmp_checkup) && !in_array($perform_date, $tmp_checkup)) {
                    continue;
                } else {
                    $tmp_checkup[] = $perform_date;
                }
                $chkperformdate = $performance->performdate;
                $chkstarttime = $performance->starttime;
                if(strtotime("$chkperformdate $chkstarttime") > $strtotimezone ) {
                    $live_film_feeds[date("Y-m-d",$perform_date)][$filmtitle]['title'] = $filmtitle;
                    $live_film_feeds[date("Y-m-d",$perform_date)][$filmtitle]['dates'][$perform_date] = $perform_date;
                    $live_film_feeds[date("Y-m-d",$perform_date)][$filmtitle]['f_id'] = $film->id;
                    $new++;
                }
            }
        }
    }
}

$jacroMoreShowtimesLink = get_option('jacroMoreShowtimesLink');
$jacroBookNowOpenLink = get_option('jacroBookNowOpenLink');
$moreShowTimeTarget = ''; 
if($jacroMoreShowtimesLink==true): $moreShowTimeTarget = '_new'; endif;
$jacro_showtime_length = get_option('jacro_showtime_length');
$jacro_showtime_length = (($jacro_showtime_length!='')?$jacro_showtime_length:-1);
$events_films_sorting_title = ((get_option("events-films-sorting-title"))?get_option("events-films-sorting-title"):false);

?>
<div class="row jacro-container">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <a class='text-decoration: none;' style="font-size: 16px;" href="<?php echo home_url();?>"><i class="fas fa-arrow-left"></i> <?php _e("Back to What's On", "jacro"); ?></a>
    </div>
</div>
<div class="row jacro-events">
    <?php 

    if(!empty($live_film_feeds)):
        if(!$events_films_sorting_title){
            ksort($live_film_feeds);
        }
        
        $existing_tmp = array();
        foreach($live_film_feeds as $file_date=>$films_data) :
            foreach($films_data as $file_title=>$films):

                $filmresult = $wpdb->get_row("SELECT * FROM $table WHERE id = " . $films['f_id']);
                if($filmresult) {
                    if (in_array($filmresult->filmtitle, $existing_tmp)) {
                        continue;
                    } else {
                        $existing_tmp[] = $filmresult->filmtitle;
                    }

                    $img_url = $filmresult->img_1s;
                    $film_url = $filmresult->url;
                    $filmtitle = $filmresult->filmtitle;
                    $synopsis = $filmresult->synopsis;
                    $synopsis = balanceTags($synopsis, true);
                    if(empty($img_url) || $img_url == 'None'): $img_url = $default_image; endif;
            ?>
                <div class="jacro-event com-md-12 col-sm-12 col-xs-12 jacro-liveevents">
                    <div class="col-md-3 col-sm-4 col-xs-12 no-padding" style="padding-left: 0px">
                        <div class="film_img">
                            <a href="<?php echo esc_url($film_url); ?>">
                                <img alt="filmimg" src="<?php echo esc_url($img_url); ?>" class="img-responsive" width="150" height="210" onError="this.onerror=null;this.src='<?php echo esc_url($default_image); ?>';">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-8 col-xs-12 no-padding">
                        <div class="row">
                            <div class="col-md-9 col-sm-9 col-xs-12 no-padding">
                                <a class="liveeventtitle" href="<?php echo esc_url($film_url); ?>" target=""><?php echo esc_html($filmtitle); ?></a>
                                <br>
                                <?php $jacroDateFormate = JacroDateFormate($file_date); ?>
                                <p style="font-size: 20px;"><?php echo $jacroDateFormate; ?> </p>
                                <div class="film-info"><?php echo htmlsafe_truncate($synopsis, 180,array('html' => true, 'ending' => ' ...', 'exact' => false)); ?></div>
                                <div style="clear:both;"></div>
                            </div>
                            <!--- mo show time --->
                            <div class="col-md-3 col-sm-3 col-xs-12" style="padding: 0px;">
                                <div class="live-more-show-time">
                                    <center><a href="<?php echo esc_url($film_url); ?>" class="livemoreshow perfbtn" target="<?php echo $moreShowTimeTarget; ?>"><i>find out more  <i class="fas fa-arrow-right"></i></i></a></center>
                                </div>          
                            </div>
                        </div>
                    </div>
                </div>
            <?php } endforeach;
        endforeach;
    else : ?>
        <div class="film-info">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class='jacro-text-center jacro-custom-messages'><?php _e('No films available !', 'jacro'); ?></div>
            </div>
        </div>
    <?php endif; ?> 
</div>