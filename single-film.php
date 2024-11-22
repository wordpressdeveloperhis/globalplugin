<title>Film - <?php echo get_bloginfo(); ?></title>
<?php
get_header();

include './showtime_html.php';

global $wpdb;
$table = $wpdb->prefix . "jacro_films";
$table_performances = $wpdb->prefix . "jacro_performances";
$table_locations = $wpdb->prefix . "jacro_locations";
$table_attributes = $wpdb->prefix . "jacro_attributes";

$current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$url_parts = explode("/" , $current_url);
$location_name = str_replace("-", " ", $url_parts[3]);

$location_result = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_locations WHERE name LIKE %s LIMIT 1", $location_name));
if($location_result) {
    $location_id = $location_result[0]->id;
}

if (preg_match('/\/film\/(\d+)\/?/', $current_url, $matches)) {
	$code = $matches[1];
}

if($_COOKIE['cinema_id'] && $_COOKIE['cinema_id'] != 'undefined') {
    $cinema = $_COOKIE['cinema_id'];
} elseif($_COOKIE['visitedcinema_id'] && $_COOKIE['visitedcinema_id'] != 'undefined') {
    $cinema = $_COOKIE['visitedcinema_id'];
} else {
    $cinema = $location_id;
}

$result = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE location = %d AND code = %s", $cinema, $code));

$default_jacro_image=get_option( 'default_jacro_image' );
$default_image= wp_get_attachment_url( $default_jacro_image);
if($default_image=='') :
    $default_image = plugin_dir_url( __FILE__ ).'images/default.png';
endif;

if (function_exists('fw_get_db_settings_option')) {
    $primaryColour = fw_get_db_settings_option('primary_colour');
    $secondaryColour = fw_get_db_settings_option('secondary_colour');
} else {
    $primaryColour = get_option('primary_colour');
    $secondaryColour = get_option('secondary_colour'); 
}

if($result):
    $filmcode = $result->code;
    $img_url = $result->img_1s;
    if(empty($img_url) || $img_url == 'None') {
        $img_url = $default_image;
    } 
    $start_date = $result->startdate;
    $releaseddate = $result->releasedate;
    $genre = $result->genre;
    $directors = $result->directors;
    $actors = $result->actors;
    if(!empty($actors)) {
        $actors_arr = explode("|",$actors);
        $allactors = implode(", ",$actors_arr);
    }
    $synopsis = $result->synopsis;
    $running_time = $result->runningtime;
    $certificate = $result->certificate;
    $id_3d = $result->is3d;
    $youtube = $result->youtube;
    $backdrop = $result->img_bd;
    $filmtitle = $result->filmtitle;
    $film_attributes = $result->film_attributes;
    $ad = $result->ad;
    if (strpos($ad,'Y') !== false) {
        $ad = str_replace('Y', '<i class="fa fa-audio-description" aria-hidden="true"></i>', $ad);
    } else {
        $ad = '';
    }

    $id_3d = filmCheckDimension($id_3d);
    if (strpos($id_3d,'3D') !== false) {
        $id_3d = str_replace('3D', '3D', $id_3d);
    } else {
        $id_3d = '';
    }
        
    $all_perf_flags = array();
    $term_id = $result->location;

    $jacroBookNowOpenLink = get_option('jacroBookNowOpenLink');
    $jacroCountryname = get_option('jacroCountry-'.$term_id);
    $americanlang = get_option( 'americanlang' );
    $australianlang = get_option( 'australianlang' );
    $uktheatre = get_option( 'uktheatre' );
    $groupby_performance_modifiers = get_option("groupby_performance_modifiers");
    $hide_single_film_rating = get_option('hide_single_film_rating');
    $hide_single_film_runningtime = get_option('hide_single_film_runningtime');
    $hide_single_film_releaseddate = get_option('hide_single_film_releaseddate');
    $hide_single_film_genre = get_option('hide_single_film_genre');

?>
    <!---START FILM CONTAINER--->
    <?php get_template_part('inc/header', 'nav'); ?>
    <script>
        var filmTitle = "<?php echo isset($filmtitle) ? $filmtitle : ''; ?>";
        if (filmTitle) {
            document.title = filmTitle + " - <?php echo get_bloginfo(); ?>";
        }
    </script>
    <div id="content_hero" class="jacrobookhero" style="background-image: url(<?php echo ($backdrop);?>); background-position: 50% 25%;">
        <img src="<?php echo plugin_dir_url( __FILE__ ); ?>/images/scroll-arrow.svg" alt="<?php echo esc_attr__('Scroll down', 'specto'); ?>" class="scroll" />
        <div style="background: #00000057;">
            <div class="container">
                <div class="row blurb">
                    <div class="col-md-9">
                        <?php if ($genre !== 'None') { ?>
                            <span class="title"><?php echo esc_attr($genre); ?></span>
                        <?php } ?>
                        <header><h1><?php echo $filmtitle; ?></h1></header>
                        <div style="margin:0px 0 30px 0;" class="buttons">
                            <?php if (!empty($certificate)) { ?>
                                <span class="certificate"><?php echo esc_attr($certificate); ?></span>
                            <?php } ?>
                            <?php if ($youtube == 'None') { echo "<style>#trailerbtn{display:none;}</style>"; } ?>
                            <?php if (!empty($youtube)) { ?>
                                <a id="trailerbtn" href="<?php echo esc_url($youtube); ?>" data-vbtype="video" class="venobox btn btn-default vbox-item">
                                    <i class="fa fa-play"></i>
                                    <span><?php echo esc_attr__('Play trailer', 'specto'); ?></span>
                                </a>
                            </br>
                            </br>
                            <?php } ?>
                            <div class="star-rating">
                                <?php if($page['rating'] == 1) { ?>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star grey"></i>
                                    <i class="fa fa-star grey"></i>
                                    <i class="fa fa-star grey"></i>
                                    <i class="fa fa-star grey"></i>
                                <?php } elseif ($page['rating'] == 2) { ?>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star grey"></i>
                                    <i class="fa fa-star grey"></i>
                                    <i class="fa fa-star grey"></i>
                                <?php } elseif ($page['rating'] == 3) { ?>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star grey"></i>
                                    <i class="fa fa-star grey"></i>
                                <?php } elseif ($page['rating'] == 4) { ?>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star grey"></i>
                                <?php } elseif ($page['rating'] == 5) { ?>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                <?php } ?>
                            </div>
                        </div>
                        </br><a class="backtohome" href="<?php echo home_url();?>" style="text-decoration: none;"><i class="fas fa-arrow-left"></i> Back To What's On</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .perfbtn{color: #fff; background-color: <?php echo $primaryColour ?> !important;}
        .perfbtn:hover{color:#fff !important; background-color:<?php echo $secondaryColour ?> !important;} 
        .moreshowtimes {background-image: linear-gradient(to right, <?php echo $primaryColour; ?>, <?php echo $secondaryColour; ?>) !important;}
        .moreshowtimes:hover {color: #fff !important;}
    </style>
    <section style=" padding-top: 75px; padding-bottom: 75px; border-width: 0px 0px 0px 0px" id="section_dc19ad1544710c9472766cab95d19904" class="fw-main-row">
        <div class="container">                                       
            <div class="row">
                <!----- info col ---->
                <div style="padding: 0 15px 0 15px;" class="col-xs-12 col-sm-8">
                    <header><h2 class="left" style="color: #101010;"><?php echo $filmtitle; ?></h2></header>
                    <div class="row">
                        <div class="col-sm-5">
                            <center><img style="border-radius: 3px; margin-bottom: 3em;height: 350px;max-height: 100%;" src="<?php echo $img_url;?>" alt="<?php echo $filmtitle; ?>" onError="this.onerror=null;this.src='/wp-content/plugins/jacro-plugin/images/default.png';" class="poster"></center>
                        </div>
                        <div class="col-sm-7 plot">
                            <p><?php echo balanceTags($synopsis, true); ?></p><!---Synopsis--->
                            <ul class="movie-info"><!---Bonus Intel--->
                                <?php if(!$hide_single_film_rating){
                                    echo '<li><i>Rating</i> '.esc_attr($certificate).'</li>';
                                }
                                if(!$hide_single_film_runningtime){
                                    echo '<li><i>Running time</i> '.esc_attr($running_time).'</li>';
                                }
                                if(!$hide_single_film_releaseddate && $releaseddate != '0000-00-00'){
                                    echo '<li><i>Released</i> '.esc_attr($releaseddate).'</li>';
                                }
                                if(!$hide_single_film_genre){
                                    echo '<li><i>Genre</i> '.esc_attr($genre).'</li>';
                                } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div style="padding: 0 15px 0 15px;" class="col-sm-4 col-xs-12">
                    <?php
                    if ($americanlang) {?>
                        <header><h2 class="left" style="color: #101010;">Movie Times</h2></header>
                    <?php } elseif ($australianlang) {?>
                        <header><h2 class="left" style="color: #101010;">Session Times</h2></header>
                    <?php } elseif ($uktheatre) {?>
                        <header><h2 class="left" style="color: #101010;">Showtimes</h2></header>
                    <?php }else { ?>
                        <header><h2 class="left" style="color: #101010;">Show Times</h2></header>
                    <?php }
                   
                    // Get Date and Time based on Timezone
                    $strtotimezone = jacro_strtotimezone($cinema);
                    $today = date("Y-m-d", $strtotimezone);

                    ?>
                    <!------ PERFORMANCE TIME LOGIC ------------>
                    <div class="film_showtime" id="film_showtime" style="margin-bottom: 2em;">
                        <?php
                        $query = $wpdb->prepare("SELECT * FROM $table_performances WHERE location = %d AND filmcode = %s AND performdate >= %s AND selloninternet = %s ORDER BY performdate ASC", $cinema, $code, $today, 'Y');
                        $perf_result = $wpdb->get_results($query);

                        $tmp_start_time = ''; $tmparray = array(); $new=0;
                        if(!empty($perf_result)) : ?>
                            <div class="single-showtime"></div>
                                <?php 
                                $loc_result = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_locations"));
                                if($loc_result && count($loc_result)>1) :
                                    echo '<span>Select a Cinema</span>' ?>
                                    <select id="jacro-cinemas-filter" class="moviepotato" name="jacro-cinemas-filter">
                                        <?php foreach($loc_result as $theatre) : ?>
                                            <option <?php if($cinema == $theatre->id): echo 'selected="selected"'; endif; ?> value="<?php echo esc_attr($theatre->id); ?>"><?php echo esc_html($theatre->name); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="hidden" name="jacro-film-id" id="jacro-film-id" value="<?php echo $filmcode; ?>" />
                                    <input type="hidden" name="jacro-film-name" id="jacro-film-name" value="<?php echo $filmtitle; ?>" />
                                <?php else : echo '' ?>
                                <?php endif; ?>
                                <!--- Ends --->
                                <div class="single-film-performance-part" id="single-film-performance-part">
                                    <?php
                                    $start_date_arr ='';
                                    foreach($perf_result as $key=>$performance) {
                                        $perform_date = strtotime($performance->performdate);
                                        $start_time = $performance->starttime;
                                        $press_report = $performance->pressreport;
                                        $trailer_time = $performance->trailertime;
                                        $screen = $performance->screen;
                                        $soldoutlevel = $performance->soldoutlevel;
                                        $ad = $performance->ad;
                                        $start_time = date('H:i', strtotime($start_time));
                                        $approx_end_time = JacroCountApproxEndTime($start_time, $running_time, $trailer_time);
                                        $approxEndTimeFormate = JacroTimeFormate($approx_end_time, $jacroCountryname);
                                        $access = $performance->wheelchairaccessible;
                                        if (strpos($access,'Y') !== false) {
                                            $access = str_replace('Y', '<i class="fa fa-wheelchair" aria-hidden="true"></i>', $access);
                                        }
                                        else {
                                            $access = '';
                                        }

                                        $termsID = $performance->location;
                                        $termname = jacro_theatre_name($termsID);
                                        $theatre_name = strtolower(preg_replace('/[^\\pL\d]+/u', '-', $termname));

                                        $perf_cat_class_val = $performance->perfcat;
                                        $pf_filmclass = preg_replace('/[^A-Za-z0-9\-]/', '', $perf_cat_class_val);
                                        $pfclass = mb_strtolower($pf_filmclass);
                                        $subs = $performance->subs;
                                            if (strpos($subs,'Y') !== false) {
                                                $subs = str_replace('Y', '<i class="fa fa-cc" aria-hidden="true"></i>', $subs);
                                            }
                                            else {
                                                $subs = '';
                                            }
                                        $perf_flags = $performance->perfflags;
                                        if(!empty($perf_flags)) {
                                            $perf_flag_arr = explode("|",$perf_flags);
                                            $perf_flags = implode(",",$perf_flag_arr);
                                        }
                                        if($start_date_arr == '')
                                            $start_date_arr = $perform_date;
                                        if($key == 0)
                                            $new = 0;
                                        if($start_date_arr != $perform_date) {
                                            $new = 0;
                                            $start_date_arr = $perform_date;
                                        }

                                        $chk_perform_date = $performance->performdate;
                                        $chk_start_time = $performance->starttime;

                                        if(strtotime("$chk_perform_date $chk_start_time") > $strtotimezone) { 
                                            $tmparray[date("Y-m-d",$perform_date)][$new]['id'] = $performance->id;
                                            $tmparray[date("Y-m-d",$perform_date)][$new]['cinema_name'] = $termname;
                                            $tmparray[date("Y-m-d",$perform_date)][$new]['screen'] = $screen;
                                            $tmparray[date("Y-m-d",$perform_date)][$new]['start_time'] = $start_time;
                                            $tmparray[date("Y-m-d",$perform_date)][$new]['press_report'] =  $press_report;
                                            $tmparray[date("Y-m-d",$perform_date)][$new]['title'] =  $filmtitle;
                                            $tmparray[date("Y-m-d",$perform_date)][$new]['date'] = $perform_date;
                                            $tmparray[date("Y-m-d",$perform_date)][$new]['certificate'] = $certificate;
                                            $tmparray[date("Y-m-d",$perform_date)][$new]['running_time'] = $running_time;
                                            $tmparray[date("Y-m-d",$perform_date)][$new]['approx_end_time'] = $approxEndTimeFormate;
                                            $tmparray[date("Y-m-d",$perform_date)][$new]['is_3d'] =  $id_3d;
                                            $tmparray[date("Y-m-d",$perform_date)][$new]['perf_cat_class_val'] = $perf_cat_class_val; 
                                            $tmparray[date("Y-m-d",$perform_date)][$new]['perf_cat_class'] = 'percate'.$pfclass;
                                            $tmparray[date("Y-m-d",$perform_date)][$new]['ad'] = $ad;
                                            $tmparray[date("Y-m-d",$perform_date)][$new]['soldoutlevel'] = $soldoutlevel;
                                            $tmparray[date("Y-m-d",$perform_date)][$new]['sub_title'] = $subs;
                                            $tmparray[date("Y-m-d",$perform_date)][$new]['access'] = $access;
                                            $tmparray[date("Y-m-d",$perform_date)][$new]['special_fea'] = (!empty($perf_flags))?$perf_flags:'';
                                            $tmparray[date("Y-m-d",$perform_date)][$new]['book_now_url'] = home_url()."/".$theatre_name."/booknow/".$performance->code;
                                            $new++;
                                        }
                                    }

                                    foreach($tmparray as $date=>$datefilms) :
                                        
                                        $filmstimearray = array();
                                        $arct = array();
                                        $fmct = array();
                                        $showtime_html = '';
                                        $filmstimearray = sorting_time($datefilms);

                                        foreach($filmstimearray as $key=>$val) {
                                            $fmct[$val['id']] = $val;
                                            $arct[$val['perf_cat_class']][$val['id']] = $val['perf_cat_class'];
                                        }
                                        
                                        $tmp = ''; $is_show_date = 0;
                                                                        
                                        if ($groupby_performance_modifiers) {
                                            $showtime_html = generate_showtime_html($fmct,$arct);
                                        }
                                                                                
                                        $key_array = array();
                                        $picount = 0;
                                        foreach($filmstimearray as $k=>$films) :
                                            if (in_array($films['start_time'], $key_array)) {
                                                continue;
                                            }
                                            $key_array[$picount] = $films['start_time'];
                                            $picount++;

                                            $per_date = date("Y-m-d",$films['date']);
                                            $start_time = $films['start_time'];
                                            $startTimeHourFormat = JacroTimeFormate($start_time, $jacroCountryname);
                                            if(strtolower($jacroCountryname)=='us') {
                                                $showTimeClass = 'show-time-12-hours';
                                            } elseif(strtolower($jacroCountryname)=='uk') {
                                                $showTimeClass = '';
                                            } else {
                                                $jacroShowTimeHour  =   get_option('jacroShowTimeHour');
                                                if($jacroShowTimeHour==true) {
                                                    $showTimeClass = 'show-time-12-hours';
                                                } else {
                                                    $showTimeClass = '';
                                                }
                                            }

                                            if(strtotime(date('Y-m-d H:i', strtotime("$per_date $start_time"))) > strtotime(current_time('Y-m-d H:i'))) {
                                                if($tmp=='') { $show_date = true; $tmp = $date; } elseif($tmp==$date){ $show_date = false; }
                                                $jacroDateFormate = JacroDateFormate($date);
                                                if($show_date==true) { $is_show_date=1;
                                                /*** FRAME ***/
                                                    echo '<div class="date-row col-md-12 col-sm-12 col-xs-12"><span>'.$jacroDateFormate.'</span>';
                                                    echo "<div class='show-time'>";
                                                /*** FRAME END ***/
                                                } 
                                            ?>
                                            <div class="singlefilmperfs <?php echo $showTimeClass; ?>">
                                                <div class="perfmods">
                                                <?php
                                                if ($groupby_performance_modifiers) {
                                                   
                                                } else {
                                                    
                                                    $jacroShowTimeHour  =   get_option('jacroShowTimeHour');
                                                    if($jacroShowTimeHour == true) {
                                                        $jacrobookTimeFormat  = date("g:i a", strtotime($startTimeHourFormat));
                                                    } else {
                                                        $jacrobookTimeFormat  = date("H:i", strtotime($startTimeHourFormat));
                                                    }
                                                    
                                                    if ($films['press_report']== 'N') {
                                                        echo '<a class="perfbtn disabled" title="Please contact the Box Office to book">'.$jacrobookTimeFormat.'</a>';
                                                    } else {
                                                        $perfcat_category_message = get_option('perfcat_category_message');
                                                        $pfbtntxt = '';$pfbtnmsg = '';$alertinfo = '';
                                                        if($perfcat_category_message){
                                                            if($films['perf_cat_class_val'] == $perfcat_category_message[$films['perf_cat_class_val']]['name']){
                                                                $pfbtntxt = $perfcat_category_message[$films['perf_cat_class_val']]['name'];
                                                                if($perfcat_category_message[$films['perf_cat_class_val']]['message']){
                                                                    $alertinfo = 'onclick="showperfinfo(this, event)"';
                                                                    $pfbtnmsg  = $perfcat_category_message[$films['perf_cat_class_val']]['message'];
                                                                }else{
                                                                    $pfbtnmsg = '';$alertinfo = '';
                                                                }

                                                            }else{
                                                                $pfbtntxt = '';$pfbtnmsg = '';$alertinfo = '';
                                                            }
                                                        }else{
                                                            $pfbtntxt = '';$pfbtnmsg = '';$alertinfo = '';
                                                        }

                                                        if(get_option('showtime_button_text')){
                                                            if($films['soldoutlevel'] && $films['soldoutlevel'] == 'Y') {
                                                                echo '<a class="perfbtn disabled">Sold Out</a>';
                                                            }else{
                                                                echo '<a class="perfbtn" '.$alertinfo.' target="'; 
                                                                if($jacroBookNowOpenLink==true):  echo '_blank'; endif;
                                                                echo '" href="'.$films['book_now_url'].'">'.get_option('showtime_button_text').' '.$jacrobookTimeFormat.' '.$pfbtntxt.'</a>';
                                                            }
                                                        }else{
                                                            if($films['soldoutlevel'] && $films['soldoutlevel'] == 'Y') {
                                                                echo '<a class="perfbtn disabled">Sold Out</a>';
                                                            }else{
                                                                echo '<a class="perfbtn" '.$alertinfo.' target="'; 
                                                                if($jacroBookNowOpenLink==true):  echo '_blank'; endif;
                                                                echo '" href="'.$films['book_now_url'].'">'.$jacrobookTimeFormat.' '.$pfbtntxt.'</a>';
                                                            }
                                                        }
                                                        echo '<input type="hidden" class="perfcat_message" value="'.$pfbtnmsg.'">';
                                                    }
                                                    ?>
                                                <br>
                                                <?php } ?>
                                                <span><?php echo $films['sub_title']; ?></span>
                                                <span><?php echo $films['is_3d']; ?></span>
                                                <span><?php echo $films['perf_flags']; ?></span>
                                                <!-- <span></?php echo $films['access']; ?></span> -->
                                            </div> 
                                            <div class="modal fade" id="jacroPopup<?php echo $films['id']; ?>" role="dialog">
                                                <div class="modal-content">
                                                    <div class="popup-inner">
                                                        <span class="close" data-dismiss="modal"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>images/close-icon.png" width="16" height="16"></span>
                                                        <h4 class="jacro_popup_title">PERFORMANCE DETAILS</h4>
                                                        <div class="popup-details">
                                                            <p><span class="PopupDate"><?php echo JacroDateFormate(date("Y-m-d",$films['date'])); ?></span></p>
                                                            <p> <span>Cinema Name:</span><span><?php echo $films['cinema_name']; ?></span></p>
                                                            <p><span>Screen:</span><span><?php echo $films['screen']; ?></span></p>
                                                            <p><span>Certificate:</span><span><?php echo $films['certificate']; ?></span></p>
                                                            <p><span>Start Time:</span><span><?php echo $startTimeHourFormat; ?></span></p>
                                                            <p><span>Running Time:</span><span><?php echo $films['running_time']; ?> mins.</span></p>
                                                            <p><span>Approx End Time:</span><span><?php echo $films['approx_end_time']; ?></span></p>
                                                            <p class="hr"></p>
                                                            <p><span>2D / 3D:</span><span><?php echo $films['is_3d']; ?></span></p>
                                                            <p><span>Subtitled:</span><span><?php echo $films['sub_title']; ?></span></p>
                                                            <p><span>Wheelchair Access:</span><span><?php echo $films['access']; ?></span></p>
                                                            <?php if(!empty($films['perf_flags'])) { ?>
                                                                <p class="heading"><span>Special Features:</span><span><?php echo $films['perf_flags']; ?></span></p>
                                                            <?php } ?>
                                                            <div class="book">
                                                                <a href="<?php echo $films['book_now_url']; ?>" target="<?php if($jacroBookNowOpenLink==true): echo '_blank'; endif; ?>">BOOK NOW</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php }
                                    endforeach;
                                    echo $showtime_html;
                                    if($is_show_date):echo "</div></div>";endif;
                                endforeach; ?>
                            </div><?php
                                endif;
                                $all_perf_flags_imp=implode('<li><span>',$all_perf_flags); ?>
                        </div>
                        <!------ PERFORMANCES END ------------------>

                    </div> 
                    <!------ PERFORMANCES END ------------------>
                </div> 
                <!---showtime col--->           
        </div>
    </section>

<?php endif; ?>

<script>
    jQuery(document).ready(function(){
        if (jQuery("#film_showtime").height() > 650) { var total_height = 0;
            var file_showtime = jQuery("#single-film-performance-part .date-row"); var jacro_date_expand=false;
            jQuery("#single-film-performance-part .date-row").each(function(){
                total_height = (parseInt(total_height)+parseInt(jQuery(this).height()));
                if(total_height>500) {
                    jQuery(this).hide();
                    jQuery(this).addClass('jacro-date-expand'); jacro_date_expand=true;
                }
            });
            if(jacro_date_expand){
                var expand_button = '<input type="button" id="jacro-more-showtime-expand" class="moreshowtimes" value="More Showtimes" data-switch="off" />';
                jQuery("#single-film-performance-part").append(expand_button);
            }
            jQuery("#jacro-more-showtime-expand").click(function(e){
                var check_expand = jQuery(this).data('switch');
                if(check_expand=='on') {
                    jQuery(".jacro-date-expand").hide(500); jQuery(this).data('switch','off'); jQuery(this).val('More Showtimes');
                } else {
                    jQuery(".jacro-date-expand").show(500); jQuery(this).data('switch','on'); jQuery(this).val('Collapse Showtimes');
                }
            });
        }
    });
    jQuery(function() {
        if (jQuery("#widgets_cinema_id").length != 0) {
            var cinema_val = '<?php echo $term_id;?>';
            jQuery("#widgets_cinema_id").val(cinema_val);
        }
        jQuery(".legend").html("<?php echo $all_perf_flags_imp;?>");
        //----- CHECK
        jQuery('[data-popup-open]').on('click', function(e) {
            var targeted_popup_class = jQuery(this).attr('data-popup-open');
            jQuery('[data-popup=\"' + targeted_popup_class + '\"]').fadeIn(350);

            e.preventDefault();
        });
        //----- CLOSE
        jQuery('[data-popup-close]').on('click', function(e) {
            var targeted_popup_class = jQuery(this).attr('data-popup-close');
            jQuery('[data-popup=\"' + targeted_popup_class + '\"]').fadeOut(350);

            e.preventDefault();
        });
    });
</script>

<?php get_footer(); ?>