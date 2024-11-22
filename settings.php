<?php start_session(); ?>
<div>
<h2>Plugin Settings</h2>
<?php
global $wpdb;
$settingsOption = 'jacroColorSettings';
$jacroColorsSettings = JacroGetSettigns($settingsOption);
$google_analytics_code = stripslashes(get_option('google_analytics_code'));
$jacroLoader = get_option('jacro-loader-image');
$jacroShowTimePerPage = get_option('jacroShowTimePerPage');
$defaultJacroCurrencyPosition = get_option('jacroCurrencyPossion');
$jacroShowCinemaCategoryFilters = get_option('jacroShowCinemaCategoryFilters');
$jacroShowPerformanceCategoryFilters = get_option('jacroShowPerformanceCategoryFilters');
$custom_filter_option = get_option("jacro_csutom_filter_options");
$all_genre_codes = jacro_get_live_event('genrecode');

$jacroMoreShowtimesLink = get_option('jacroMoreShowtimesLink');
$jacroBookNowOpenLink = get_option('jacroBookNowOpenLink');
$jacro_showtime_length = get_option('jacro_showtime_length');
$jacro_auto_clean_performace = ((get_option('jacro_auto_clean_performace')!='')?get_option('jacro_auto_clean_performace'):7);
$showtime_import_interval = get_option('showtime_import_interval')? get_option('showtime_import_interval'):72000;
$cinema_model_show = (get_option("cinema-modal-popup-show")?get_option("cinema-modal-popup-show"):false);
$booking_header_loc = (get_option("booking-header-loc")?get_option("booking-header-loc"):false);
$date_sort_recent = (get_option("date-sort-recent")?get_option("date-sort-recent"):false);
$date_filter_format = get_option( 'date_filter_format', "jS M");
if ($date_filter_format == "") {
    $date_filter_format = "jS M";
}
$date_formats = [['jS M','15th Mar',false],['j M', '15 Mar',false],['M jS', 'Mar 15th',false],['M j', 'Mar 15',false]];
$i = 0;
foreach ($date_formats as $f) {
    if ($date_filter_format == $f[0]) {
        $date_formats[$i][2] = true;
    }
    $i++;
}

$homepage_layout = get_option( 'homepage_layout', "posters");
if ($homepage_layout == "") {
    $homepage_layout = "posters";
}
$homepage_formats = [['detail','Detailed Listings',false], ['posters','Poster Layout',false], ['both','Both Poster and Detailed Listings',false]];
$i = 0;
foreach ($homepage_formats as $f) {
    if ($homepage_layout == $f[0]) {
        $homepage_formats[$i][2] = true;
    }
    $i++;
}

# Poster widths 
$homepage_poster_width = get_option( 'homepage_poster_width', 'w220');
$homepage_poster_widths = [['w180','180px',false], ['w220','220px',false], ['w270','270px',false]];
$i = 0;
foreach ($homepage_poster_widths as $f) {
    if ($homepage_poster_width == $f[0]) {
        $homepage_poster_widths[$i][2] = true;
    }
    $i++;
}

$show_time_header = get_option( 'show_time_header', "Show Times");
if ($show_time_header == "") {
    $show_time_header = "Show Times";
}

$showtime_button_text = (get_option( 'showtime_button_text')?get_option("showtime_button_text"):false); 

$tab_hide_now_showing = (get_option( 'tab_hide_now_showing')?get_option("tab_hide_now_showing"):false);
// $tab_hide_advance_bookings = (get_option( 'tab_hide_advance_bookings')?get_option("tab_hide_advance_bookings"):false);
$tab_hide_advance_sales = (get_option( 'tab_hide_advance_sales')?get_option("tab_hide_advance_sales"):false);
$tab_hide_new_releases = (get_option( 'tab_hide_new_releases')?get_option("tab_hide_new_releases"):false);
$tab_hide_all_performances = (get_option( 'tab_hide_all_performances')?get_option("tab_hide_all_performances"):false);
//$tab_header_advance_sales = (get_option( 'tab_header_advance_sales')?get_option("tab_header_advance_sales"):false);
$tab_header_all_performances = (get_option( 'tab_header_all_performances')?get_option("tab_header_all_performances"):false);
$now_showing_days = (get_option( 'now_showing_days')?get_option("now_showing_days"):false); 
$advance_booking_days = (get_option( 'advance_booking_days')?get_option("advance_booking_days"):false); 

$tab_header_now_showing = get_option( 'tab_header_now_showing', "Now Playing");

// $tab_header_advance_bookings = get_option( 'tab_header_advance_bookings', "Advance Bookings");
// if ($tab_header_advance_bookings == "") {
//     $tab_header_advance_bookings = "Coming Soon";
// }       

$tab_header_advance_sales = get_option( 'tab_header_advance_sales', 'Advance Sales');

$tab_header_new_releases = get_option( 'tab_header_new_releases', "New Releases");

$theatre_section_override = (get_option("theatre_section_override")?get_option("theatre_section_override"):false);
$theatre_screen_genre_exclude = (get_option("theatre_screen_genre_exclude")?get_option("theatre_screen_genre_exclude"):false);
$theatre_screen_genre_exclude_array = explode(',', $theatre_screen_genre_exclude);

$groupby_performance_modifiers = (get_option("groupby_performance_modifiers")?get_option("groupby_performance_modifiers"):false);

$cinema_auto_select_nearest = (get_option("cinema-auto-select-nearest")?get_option("cinema-auto-select-nearest"):false);
$date_filter_select_today = (get_option("date-filter-select-today")?get_option("date-filter-select-today"):false);
$events_films_sorting_title = (get_option("events-films-sorting-title")?get_option("events-films-sorting-title"):false);
$includevenue = (get_option("includevenue")?get_option("includevenue"):false);
$hideallshows = (get_option("hideallshows")?get_option("hideallshows"):false);

$uktheatre = (get_option("uktheatre")?get_option("uktheatre"):false);
$americanlang = (get_option("americanlang")?get_option("americanlang"):false);
$australianlang = (get_option("australianlang")?get_option("australianlang"):false);
$menuorder = (get_option("menuorder")?get_option("menuorder"):false);
$defaultheadermenu = (get_option("defaultheadermenu")?get_option("defaultheadermenu"):false);
$posterlayoutopt = (get_option("posterlayoutopt")?get_option("posterlayoutopt"):false);
$jacrologinmenu = (get_option("jacrologinmenu")?get_option("jacrologinmenu"):false);
$jacro_log_email = (get_option("jacro_log_email")?get_option("jacro_log_email"):false);

$hide_single_film_rating = (get_option("hide_single_film_rating")?get_option("hide_single_film_rating"):false);
$hide_single_film_runningtime = (get_option("hide_single_film_runningtime")?get_option("hide_single_film_runningtime"):false);
$hide_single_film_releaseddate = (get_option("hide_single_film_releaseddate")?get_option("hide_single_film_releaseddate"):false);
$hide_single_film_genre = (get_option("hide_single_film_genre")?get_option("hide_single_film_genre"):false);

$perfcat_section_override = (get_option("perfcat_section_override")?get_option("perfcat_section_override"):false);
$perfcat_category_message = (get_option("perfcat_category_message")?get_option("perfcat_category_message"):false);

$movieslideroption = (get_option("movieslideroption")?get_option("movieslideroption"):false);
$movieslider = (get_option("movieslider")?get_option("movieslider"):false);
$adsslider = (get_option("adsslider")?get_option("adsslider"):false);

?>
<?php if(isset($_SESSION['s_message'])) {?><div class="success"><?php echo $_SESSION['s_message'];?></div><?php unset($_SESSION['s_message']);}?>
<ul class="tabs nav-tab-wrapper">
    <li data-tab="jacro-filter-settings" id="jacro-filter" class="nav-tab current"><?php _e('Content Settings', 'jacro'); ?></li>
    
    <li data-tab="jacro-other-settings" id="jacro-other" class="nav-tab"><?php _e('Other Settings', 'jacro'); ?></li>
<ul>

<div class="content-wrap">
    <!-- Filter Settings -->
    <div id="jacro-filter-settings" class="tab-content current">
        <div class="row ad">
            <form id="frm_lable" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" enctype="multipart/form-data">
                <input type="hidden" name="jacro-setting-action" id="jacro-filter-setting-action" value="jacro-filter-settings" />
        
                <table cellspacing="0" class="wp-list-table widefat fixed appearance_page_machine-list">

                <tr>
                    <td>
                        <b><label style="line-height:30px;" data-tooltip="fronend films layout"><?php _e('Homepage Layout :', 'jacro'); ?></label></b>
                        <select class="homepage_layout" name="homepage_layout">
                        <?php foreach($homepage_formats as $f):
                            if ($f[2] == true) {
                                $selected = 'selected="selected"';
                            } else {
                                $selected = '';
                            }
                        ?>
                        <option value="<?php echo $f[0] ?>" <?php echo $selected; ?> > <?php echo $f[1]?></option>
                        <?php endforeach; ?>
                    </select>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class = 'homepage_poster_display'>
                            <legend class="form-check-label"> Poster Image Width (height will depend on image ratio) </legend>
                            <?php foreach($homepage_poster_widths as $f):
                                if ($f[2] == true) {
                                    $checked = 'checked';
                                } else {
                                    $checked = '';
                                }
                            ?>
                            <div class = 'form-check'>
                                    <input class="form-check-input" type="radio" name="homepage_poster_width" value="<?php echo $f[0]; ?>" id="<?php echo $f[0]; ?>"   <?php echo $checked; ?> >
                            <label class="form-check-label" for="<?php echo $f[0]; ?>"> <?php echo $f[1]; ?> </label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </td>
                </tr>

                    <!--Main Filters -->        
                <tr>
                    <td>
                       <b><label style="line-height:30px;"><?php _e('Main Filter Tabs :', 'jacro'); ?></label></b>
                    </td>
                </tr>       
                <tr>           
                    <td colspan="3">     
                        <table cellspacing="0" class="wp-list-table widefat fixed appearance_page_machine-list">    
                        <tr>
                            <td>
                                <label style="line-height:30px;" data-tooltip="now showing tab hide"><?php _e('Hide Now Showing Tab:', 'jacro'); ?>
                                <input type="checkbox" value="true" name="tab_hide_now_showing" class="tab_hide_now_showing" <?php echo ($tab_hide_now_showing?'checked="checked"':''); ?> /></label>               
                            </td>
                            <td>
                                <div class='tab_now_showing_display'>   
                                    <label style="line-height:30px;" data-tooltip="change now showing tab text"><?php _e('Header text on Now Showing tab:', 'jacro'); ?>
                                    <input type="text" value="<?php echo $tab_header_now_showing; ?>" name="tab_header_now_showing" class="tab_header_now_showing"/></label>
                                </div>
                            </td>
                            <td>
                                <div class='tab_now_showing_display'>   
                                    <label style="line-height:30px;" data-tooltip="now showing tab order set"><?php _e('Front End Tabs Order:', 'jacro'); ?>
                                    <input type="number" min="1" value="<?php echo $menuorder['now_showing']; ?>" name="menuorder[now_showing]" class="now_showing_tabs_order"/></label>
                                </div>
                            </td>
                            <td>
                                <div class='tab_now_showing_display'>   
                                    <label style="line-height:30px;" data-tooltip="after days interval movies show"><?php _e('Number of days:', 'jacro'); ?>
                                    <input type="number" value="<?php echo $now_showing_days; ?>" name="now_showing_days" class="now_showing_days"/></label>
                                </div>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td>
                                <label style="line-height:30px;"></?php _e('Hide Advance Booking Tab:', 'jacro'); ?>
                                <input type="checkbox" value="true" name="tab_hide_advance_bookings" class="tab_hide_advance_bookings" </?php echo ($tab_hide_advance_bookings?'checked="checked"':''); ?> /></label>
                            </td>
                            <td>
                                <div class='tab_advance_bookings_display'>
                                    <label style="line-height:30px;"></?php _e('Header text on Advance Bookings tab:', 'jacro'); ?>
                                    <input type="text" value="</?php echo $tab_header_advance_bookings; ?>" name="tab_header_advance_bookings" class="tab_header_advance_bookings"/></label>
                                </div>
                            </td>
                            <td>
                                <div class='tab_advance_bookings_display'>  
                                    <label style="line-height:30px;"></?php _e('Front End Tabs Order:', 'jacro'); ?>
                                    <input type="number" min="1" value="</?php echo $menuorder['advance']; ?>" name="menuorder[advance]" class="advance_tabs_order"/></label>
                                </div>
                            </td>
                        </tr> -->
                        <tr>
                            <td>
                                <label style="line-height:30px;" data-tooltip="new release tab hide"><?php _e('Hide New Releases Tab:', 'jacro'); ?>
                                <input type="checkbox" value="true" name="tab_hide_new_releases" class="tab_hide_new_releases" <?php echo ($tab_hide_new_releases?'checked="checked"':''); ?> /></label>
                            </td>
                            <td>
                                <div class='tab_new_releases_display'>
                                        <label style="line-height:30px;" data-tooltip="change new release tab text"><?php _e('Header text on New Releases tab:', 'jacro'); ?>
                                        <input type="text" value="<?php echo $tab_header_new_releases; ?>" name="tab_header_new_releases" class="tab_header_new_releases"/></label>
                                </div>
                            </td>
                            <td>
                                <div class='tab_new_releases_display'>  
                                    <label style="line-height:30px;" data-tooltip="new release tab order set"><?php _e('Front End Tabs Order:', 'jacro'); ?>
                                    <input type="number" min="1" value="<?php echo $menuorder['new_releases']; ?>" name="menuorder[new_releases]" class="new_releases_tabs_order"/></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label style="line-height:30px;" data-tooltip="coming soon and advance sales tab hide"><?php _e('Hide Coming Soon And Advance Sales Tab:', 'jacro'); ?>
                                <input type="checkbox" value="true" name="tab_hide_advance_sales" class="tab_hide_advance_sales" <?php echo ($tab_hide_advance_sales?'checked="checked"':''); ?> /></label>
                            </td>
                            <td>
                                <div class='tab_advance_sales_display'>
                                        <label style="line-height:30px;" data-tooltip="change coming soon and advance sales tab text"><?php _e('Header text on Advance Sales tab:', 'jacro'); ?>
                                        <input type="text" value="<?php echo $tab_header_advance_sales; ?>" name="tab_header_advance_sales" class="tab_header_advance_sales"/></label>
                                </div>
                            </td>
                            <td>
                                <div class='tab_advance_sales_display'> 
                                    <label style="line-height:30px;" data-tooltip="coming soon and advance sales tab order set"><?php _e('Front End Tabs Order:', 'jacro'); ?>
                                    <input type="number" min="1" value="<?php echo $menuorder['advance_sales']; ?>" name="menuorder[advance_sales]" class="advance_sales_tabs_order"/></label>
                                </div>
                            </td>
                            <td>
                                <div class='tab_advance_sales_display'>
                                    <label style="line-height:30px;" data-tooltip="after days interval movies show"><?php _e('Number of days:', 'jacro'); ?>
                                    <input type="number" value="<?php echo $advance_booking_days; ?>" name="advance_booking_days" class="advance_booking_days"/></label>    
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label style="line-height:30px;" data-tooltip="all performances tab hide"><?php _e('Hide All Performances Tab:', 'jacro'); ?>
                                <input type="checkbox" value="true" name="tab_hide_all_performances" class="tab_hide_all_performances" <?php echo ($tab_hide_all_performances?'checked="checked"':''); ?> /></label>
                            </td>
                            <td>
                                <div class='tab_all_performances_display'>
                                        <label style="line-height:30px;" data-tooltip="change all performances tab text"><?php _e('Header text on All Performances tab:', 'jacro'); ?>
                                        <input type="text" value="<?php echo $tab_header_all_performances; ?>" name="tab_header_all_performances" class="tab_header_all_performances"/></label>
                                </div>
                            </td>
                            <td>
                                <div class='tab_all_performances_display'>  
                                    <label style="line-height:30px;" data-tooltip="all performances tab order set"><?php _e('Front End Tabs Order:', 'jacro'); ?>
                                    <input type="number" min="1" value="<?php echo $menuorder['all_performances']; ?>" name="menuorder[all_performances]" class="all_performances_tabs_order"/></label>
                                </div>
                            </td>
                        </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <b><label style="line-height:30px;"><?php _e('General :', 'jacro'); ?></label></b>
            </td>
        </tr>       
        <tr>
            <td colspan="3">    
                <table cellspacing="0" class="wp-list-table widefat fixed appearance_page_machine-list">    
                    <tr>
                        <td>
                            <label style="line-height:30px;" data-tooltip="cinema modal popup onpage load"><?php _e('Cinema modal popup show on page load :', 'jacro'); ?>
                            <input type="checkbox" value="true" name="cinema-modal-popup-show" class="cinema-modal-popup-show" <?php echo ($cinema_model_show?'checked="checked"':''); ?> /></label>
                        </td>
                        <td>
                            <label style="line-height:30px;" data-tooltip="sort films by title"><?php _e('Events films sorting by title:', 'jacro'); ?>
                            <input type="checkbox" value="true" name="events-films-sorting-title" class="events-films-sorting-title" <?php echo ($events_films_sorting_title?'checked="checked"':''); ?> /></label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label style="line-height:30px;" data-tooltip="location show on booking page"><?php _e('Include location on Booking Page header :', 'jacro'); ?>
                            <input type="checkbox" value="true" name="booking-header-loc" class="booking-header-loc" <?php echo ($booking_header_loc?'checked="checked"':''); ?> /></label>
                        </td>
                        <td>
                            <label style="line-height:30px;" data-tooltip="sort datefilter most recent"><?php _e('Date filter sort by most recent: ', 'jacro'); ?>
                            <input type="checkbox" value="true" name="date-sort-recent" class="date-sort-recent" <?php echo ($date_sort_recent?'checked="checked"':''); ?> /></label>
                        </td>
                                                            
                    </tr>
                    <tr>
                        <td>
                            <label style="line-height:30px;" data-tooltip="nearby cinema select"><?php _e('Cinema auto select nearby locality :', 'jacro'); ?>
                            <input type="checkbox" value="true" name="cinema-auto-select-nearest" class="cinema-auto-select-nearest" <?php echo ($cinema_auto_select_nearest?'checked="checked"':''); ?> /></label>
                        </td>
                        <td>
                            <label style="line-height:30px;" data-tooltip="venue show in header"><?php _e('Include venue on booking header :', 'jacro'); ?>
                            <input type="checkbox" value="true" name="includevenue" class="includevenue" <?php echo ($includevenue?'checked="checked"':''); ?> /></label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label style="line-height:30px;" data-tooltip="today select in datefilter"><?php _e('Date filter select default as today :', 'jacro'); ?>
                            <input type="checkbox" value="true" name="date-filter-select-today" class="date-filter-select-today" <?php echo ($date_filter_select_today?'checked="checked"':''); ?> /></label>
                        </td>
                        <td>
                            <label style="line-height:30px;" data-tooltip="all shows tab hide in datefilter"><?php _e('Hide ALL SHOWS tab :', 'jacro'); ?>
                            <input type="checkbox" value="true" name="hideallshows" class="hideallshows" <?php echo ($hideallshows?'checked="checked"':''); ?> /></label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label style="line-height:30px;" data-tooltip="film date format"><?php _e('Date filter format :', 'jacro'); ?>
                                <select id="date_filter_format" name="date_filter_format">
                                    <?php foreach($date_formats as $f):
                                            if ($f[2] == true) {
                                                $selected = 'selected="selected"';
                                            } else {
                                                $selected = '';
                                            }
                                             ?>
                                        <option value="<?php echo $f[0] ?>" <?php echo $selected; ?> > <?php echo $f[1]?></option>
                                    <?php endforeach; ?>
                                </select>  
                            </label>
                        </td>
                        <td>
                            <label style="line-height:30px;" data-tooltip="change show time"><?php _e('Show time header text :', 'jacro'); ?>
                                <input type="text" value="<?php echo $show_time_header; ?>" name="show_time_header" class="show_time_header"/>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label style="line-height:30px;" data-tooltip="showtitmes group by performance category"><?php _e('Group show times by performance modifiers:', 'jacro'); ?>
                            <input type="checkbox" value="true" name="groupby_performance_modifiers" class="groupby_performance_modifiers" <?php echo ($groupby_performance_modifiers?'checked="checked"':''); ?> /></label>
                        </td>
                        <td>
                            <label style="line-height:30px;" data-tooltip="text add along with showtime"><?php _e('Showtime Button Text :', 'jacro'); ?>
                                <input type="text" value="<?php echo $showtime_button_text; ?>" name="showtime_button_text" class="showtime_button_text"/>
                            </label>  
                        </td>
                    </tr>           
                    <tr>
                        <td>
                            <label style="line-height:30px;" data-tooltip="main filter tabs override"><?php _e('Theatre section override (replaces NOW SHOWING/ADVANCE BOOKING/NEW RELEASES with STAGE/SCREEN) :', 'jacro'); ?>
                            <input type="checkbox" value="true" name="theatre_section_override" class="theatre_section_override" <?php echo ($theatre_section_override?'checked="checked"':''); ?> /></label>
                        </td>
                        <td>
                            <div class='theatre_section_display'>   
                            <label style="line-height:30px;" data-tooltip="excludes the films genres"><?php _e('Screen Filter : Genres to be excluded', 'jacro'); ?><br />
                                <?php foreach ($all_genre_codes as $val) {
                                        $extra = "";
                                        if (in_array($val, $theatre_screen_genre_exclude_array)) {
                                            $extra = 'checked="checked"';
                                        };
                                ?>
                                <input type="checkbox" name="checkbox-<?php echo $val ?>" class="theatre_screen_genre_exclude_option" <?php echo $extra; ?> value="<?php echo $val ?>"> <?php echo $val ?><br>
                                <?php };?>
                                <!-- easier to store exclude list as comma separated string - created by js as checkboxes are ticked - than work out wp options for arrays!-->
                                <input type="hidden" value="<?php echo $theatre_screen_genre_exclude?>" name="theatre_screen_genre_exclude" class="theatre_screen_genre_exclude"  id="theatre_screen_genre_exclude" />
                            </label>
                            </div>
                        </td>
                    </tr>      
                </table>
            </td>
        </tr>

        <!-- Performance Category name/popup -->
        <tr>
            <td>
                <b><label style="line-height:30px;"><?php _e('Performance Category Name/Popup Alert :', 'jacro'); ?></label></b>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <table cellspacing="0" class="wp-list-table widefat fixed appearance_page_machine-list">
                    <tr>
                        <td>
                            <label style="line-height:30px;" data-tooltip="performance category along with showtime"><?php _e('Book Now Button Override (add performance category with alert information in showtime) :', 'jacro'); ?>
                            <input type="checkbox" value="true" name="perfcat_section_override" class="perfcat_section_override" <?php echo ($perfcat_section_override?'checked="checked"':''); ?> /></label>
                        </td>
                        <td>
                            <div class="perfcat_section_display">   
                            <label style="line-height:30px;" data-tooltip="selected category show along with button showtime"><?php _e('Perfcat or alert information to be included :', 'jacro'); ?><br />
                                <?php         
                                foreach (show_perfcat_films() as $val) {
                                if(isset($perfcat_category_message[$val])){
                                    $checkis = 'checked="checked"';
                                }else{
                                    $checkis = '';
                                }
                                if($perfcat_category_message[$val]['message']){
                                    $checkstyle = "";
                                }else{
                                    $checkstyle = "display:none;";
                                }
                                ?>
                                <input type="checkbox" name="perfcat_category[<?php echo $val ?>][name]" class="perfcat_category" <?php echo $checkis; ?> value="<?php echo $val ?>"> <?php echo $val ?>
                                <textarea rows='2' data-min-rows='2' name="perfcat_category[<?php echo $val ?>][message]" class="perfcat_message" placeholder="Add popup info" style="<?php echo $checkstyle;?>" autofocus><?php echo $perfcat_category_message[$val]['message']; ?></textarea>
                                <br>
                                <?php };?>
                                <input type="hidden" value="" name="included_perfcat" class="included_perfcat"  id="included_perfcat" />
                            </label>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- movie slider -->
        <tr>
            <td>
                <b><label style="line-height:30px;" data-tooltip="movie slider display options"><?php _e('Movie Slider :', 'jacro'); ?></label></b>
            </td>
        </tr>
        <tr>
        <tr>
             <td colspan="3">
                <table cellspacing="0" class="wp-list-table widefat fixed appearance_page_machine-list">
                    <tr>
                        <td>
                            <div class="displayslideroption">
                                <label class="head" for="automatic"><?php _e('Automatic Slides', 'jacro'); ?></label><input type='radio' name="movieslideroption" class="movieslideroption" id="automatic" value="automatic" <?php if(($movieslideroption == 'automatic' || $movieslideroption == '')): echo 'checked="checked"'; endif; ?>/>
                                <label class="head" for="manual"><?php _e('Manual Slides', 'jacro'); ?></label><input type='radio' name="movieslideroption" class="movieslideroption" id="manual" value="manual" <?php if(isset($movieslideroption) && ($movieslideroption == 'manual')): echo 'checked="checked"'; endif; ?>/>
                                <label class="head" for="advertise"><?php _e('Advertise Slides', 'jacro'); ?></label><input type='radio' name="movieslideroption" class="movieslideroption" id="advertise" value="advertise" <?php if(isset($movieslideroption) && ($movieslideroption == 'advertise')): echo 'checked="checked"'; endif; ?>/>
                            </div>
                            <div class="advertisesliderimage">
                                <div class="innersliderimage">
                                    <div class="addslides" onclick="addAdsSlide()">Add New Slide</div>
                                    <div id="adsItemsContainer">
                                        <?php if($adsslider) {
                                            $adsCnt = 1;
                                            foreach ($adsslider as $key => $value) { 
                                                $adsimage = $value['adsimage'];
                                                $file_url = str_replace($_SERVER['DOCUMENT_ROOT'], '', $adsimage);
                                                $uniqueID = "slide".$adsCnt; ?>
                                                <div class="<?php echo $uniqueID; ?>">
                                                    <div class="slider-input-fields">
                                                        <div class="slider-input-file">
                                                            <input type="file" name="adsslider[<?php echo $adsCnt;?>][adsimage]">
                                                            <?php if ($adsimage) : ?>
                                                                <input type="hidden" name="adsslider[<?php echo $adsCnt;?>][old_sliderimage]" value="<?php echo $adsimage; ?>">
                                                                <img src="<?php echo site_url($file_url); ?>" style="max-width:100px;">
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="slider-input-afterfile">
                                                            <input type="number" min="0" name="adsslider[<?php echo $adsCnt;?>][adsposition]" value="<?php echo $value['adsposition']; ?>" placeholder="Position">
                                                            <small style="margin-top: 5px;">( The last position is used as a default if the position is not present )</small>
                                                        </div>
                                                    </div>
                                                    <div class="slider-input-removelocation">
                                                        <div class="slider-input-locations">
                                                            <label>Locations</label>
                                                            <div class="slider-input-locationscheck">
                                                                <?php $cinema_arr = jacroGetCinemas();
                                                                foreach($cinema_arr as $cinema){ 
                                                                    $cinemaId = $cinema->id;
                                                                    $checkslidercinema = isset($value['theatrelocation'][$cinemaId]) ? 'checked="checked"' : ''; ?>
                                                                    <div class="location-checkbox">
                                                                        <input type="checkbox" value="true" name="adsslider[<?php echo $adsCnt;?>][theatrelocation][<?php echo $cinemaId; ?>]" class="theatrelocation" <?php echo $checkslidercinema; ?> />
                                                                        <label><?php echo $cinema->name; ?></label>   
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <div class="slider-input-remove">
                                                            <a onclick="removeAdsSlide(event, '<?php echo $uniqueID; ?>')">Remove</a>
                                                        </div>
                                                    </div>
                                                </div><?php $adsCnt++;
                                            } 
                                        } ?>
                                    </div>
                                    <script>
                                        var adsCounter = <?php echo isset($adsCnt) ? ($adsCnt) : 1; ?>;
                                        function addAdsSlide() {
                                            var newSlide = document.createElement("div");                                            
                                            var uniqueID = "slide" + adsCounter;
                                            newSlide.className = uniqueID;
                                            newSlide.innerHTML = `
                                                <div class="slider-input-fields">
                                                    <div class="slider-input-file">
                                                        <input type="file" name="adsslider[${adsCounter}][adsimage]">
                                                    </div>
                                                    <div class="slider-input-afterfile">
                                                        <input type="number" min="0" name="adsslider[${adsCounter}][adsposition]" placeholder="Position">
                                                        <small style="margin-top: 5px;">( The last position is used as a default if the position is not present )</small>
                                                    </div>
                                                </div>
                                                <div class="slider-input-removelocation">
                                                <div class="slider-input-locations">
                                                    <label>Locations</label>
                                                    <div class="slider-input-locationscheck">
                                                        <?php 
                                                        $cinema_arr = jacroGetCinemas(); 
                                                        foreach($cinema_arr as $cinema){ ?>
                                                            <div class="location-checkbox">
                                                                <input type="checkbox" value="true" name="adsslider[${adsCounter}][theatrelocation][<?php echo $cinema->id ?>]" class="theatrelocation" />
                                                                <label><?php echo $cinema->name ?></label>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="slider-input-remove"><a onclick="removeAdsSlide(event, '${uniqueID}')">Remove</a></div></div>`;

                                            document.getElementById("adsItemsContainer").appendChild(newSlide);
                                            adsCounter++;
                                        }

                                        function removeAdsSlide(event, uniqueClass) {
                                            event.preventDefault();
                                            var removedSlides = document.getElementsByClassName(uniqueClass);
                                            if (removedSlides.length > 0) {
                                                while (removedSlides.length > 0) {
                                                    removedSlides[0].remove();
                                                }
                                            }
                                        } 
                                    </script>
                                </div>
                            </div>
                            <div class="customsliderimage">
                                <div class="innersliderimage">
                                    <div class="addslides" onclick="addSlide()">Add New Slide</div>
                                    <div id="sliderItemsContainer">
                                        <!-- Initially, no slider items are shown -->
                                        <?php if($movieslider) {
                                            $slidercnt = 1;
                                            foreach ($movieslider as $key => $value) { 
                                                $sliderimage = $value['sliderimage'];
                                                $file_url = str_replace($_SERVER['DOCUMENT_ROOT'], '', $sliderimage);
                                                $uniqueID = "slide".$slidercnt; ?>
                                                <div class="<?php echo $uniqueID; ?>">
                                                    <div class="slider-input-fields">
                                                        <div class="slider-input-file">
                                                            <input type="file" name="movieslider[<?php echo $slidercnt;?>][sliderimage]">
                                                            <?php if ($sliderimage) : ?>
                                                                <input type="hidden" name="movieslider[<?php echo $slidercnt;?>][old_sliderimage]" value="<?php echo $sliderimage; ?>">
                                                                <img src="<?php echo site_url($file_url); ?>" style="max-width:100px;">
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="slider-input-afterfile">
                                                            <input type="text" name="movieslider[<?php echo $slidercnt;?>][slidergenre]" value="<?php echo $value['slidergenre']; ?>" placeholder="Genre">
                                                            <input type="text" name="movieslider[<?php echo $slidercnt;?>][slidertitle]" value="<?php echo $value['slidertitle']; ?>" placeholder="Title">
                                                            <input type="text" name="movieslider[<?php echo $slidercnt;?>][slidercertificate]" value="<?php echo $value['slidercertificate']; ?>" placeholder="Certificate">
                                                            <input type="text" name="movieslider[<?php echo $slidercnt;?>][slidertrailer]" value="<?php echo $value['slidertrailer']; ?>" placeholder="Trailer" oninput="validateTrailer(event)">
                                                            <input type="text" name="movieslider[<?php echo $slidercnt;?>][slidersynopsis]" value="<?php echo $value['slidersynopsis']; ?>" placeholder="Link" oninput="validateSynopsis(event)">
                                                        </div>
                                                        <div class="slider-input-content">
                                                            <textarea name="movieslider[<?php echo $slidercnt;?>][slidercontent]" placeholder="Content..."><?php echo $value['slidercontent']; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="slider-input-removelocation">
                                                        <div class="slider-input-locations">
                                                            <label>Locations</label>
                                                            <div class="slider-input-locationscheck">
                                                                <?php  $cinema_arr = jacroGetCinemas(); 
                                                                foreach($cinema_arr as $cinema){ 
                                                                    $cinemaId = $cinema->id;
                                                                    $checkslidercinema = isset($value['theatrelocation'][$cinemaId]) ? 'checked="checked"' : ''; ?>
                                                                    <div class="location-checkbox">
                                                                        <input type="checkbox" value="true" name="movieslider[<?php echo $slidercnt;?>][theatrelocation][<?php echo $cinemaId; ?>]" class="theatrelocation" <?php echo $checkslidercinema; ?> />
                                                                        <label><?php echo $cinema->name; ?></label>   
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <div class="slider-input-remove">
                                                            <a onclick="removeSlide(event, '<?php echo $uniqueID; ?>')">Remove</a>
                                                        </div>
                                                    </div>
                                                </div><?php
                                                $slidercnt++;
                                            } 
                                        } ?>
                                    </div>
                                    <script>
                                        var slideCounter = <?php echo isset($slidercnt) ? ($slidercnt) : 1; ?>;
                                        function addSlide() {
                                            var newSlide = document.createElement("div");                                            
                                            var uniqueID = "slide" + slideCounter;
                                            newSlide.className = uniqueID;
                                            newSlide.innerHTML = `
                                                <div class="slider-input-fields">
                                                    <div class="slider-input-file">
                                                        <input type="file" name="movieslider[${slideCounter}][sliderimage]">
                                                    </div>
                                                    <div class="slider-input-afterfile">
                                                        <input type="text" name="movieslider[${slideCounter}][slidergenre]" placeholder="Genre">
                                                        <input type="text" name="movieslider[${slideCounter}][slidertitle]" placeholder="Title">
                                                        <input type="text" name="movieslider[${slideCounter}][slidercertificate]" placeholder="Certificate">
                                                        <input type="text" name="movieslider[${slideCounter}][slidertrailer]" placeholder="Trailer">
                                                        <input type="text" name="movieslider[${slideCounter}][slidersynopsis]" placeholder="Link">
                                                    </div>
                                                    <div class="slider-input-content">
                                                        <textarea name="movieslider[${slideCounter}][slidercontent]" placeholder="Content..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="slider-input-removelocation">
                                                <div class="slider-input-locations">
                                                    <label>Locations</label>
                                                    <div class="slider-input-locationscheck">
                                                        <?php 
                                                        $cinema_arr = jacroGetCinemas(); 
                                                        foreach($cinema_arr as $cinema){ ?>
                                                            <div class="location-checkbox">
                                                                <input type="checkbox" value="true" name="movieslider[${slideCounter}][theatrelocation][<?php echo $cinema->id ?>]" class="theatrelocation" />
                                                                <label><?php echo $cinema->name ?></label>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="slider-input-remove"><a onclick="removeSlide(event, '${uniqueID}')">Remove</a></div></div>`;

                                            document.getElementById("sliderItemsContainer").appendChild(newSlide);
                                            newSlide.querySelector(`input[name="movieslider[${slideCounter}][slidertrailer]"]`).addEventListener("input", validateTrailer);
                                            newSlide.querySelector(`input[name="movieslider[${slideCounter}][slidersynopsis]"]`).addEventListener("input", validateSynopsis);
                                            slideCounter++;
                                        }

                                        function removeSlide(event, uniqueClass) {
                                            event.preventDefault();
                                            var removedSlides = document.getElementsByClassName(uniqueClass);
                                            if (removedSlides.length > 0) {
                                                while (removedSlides.length > 0) {
                                                    removedSlides[0].remove();
                                                }
                                            }
                                        }
                                        function validateTrailer(event) {
                                            var trailerInput = event.target.value;
                                            var isValid = trailerInput.includes("youtube.com") || trailerInput.includes("vimeo.com");
                                            event.target.style.border = isValid ? "" : "1px solid red";
                                        }

                                        function validateSynopsis(event) {
                                            var synopsisInput = event.target.value;
                                            var urlRegex = /^(ftp|http|https):\/\/[^ "]+$/;
                                            var isValid = urlRegex.test(synopsisInput);
                                            event.target.style.border = isValid ? "" : "1px solid red";
                                        }
                                    </script>  
                                </div>
                            </div>
                        </td>   
                    </tr>
                </table>
            </td>
        </tr>
        <!-- Language Packs -->
        <tr>
            <td>
                <b><label style="line-height:30px;" data-tooltip="country wise language pack"><?php _e('Language Packs :', 'jacro'); ?></label></b>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <table cellspacing="0" class="wp-list-table widefat fixed appearance_page_machine-list">
                    <tr>
                        <td>
                            <label style="line-height:30px;"><?php _e('UK Theatre :', 'jacro'); ?>
                                <input type="checkbox" value="true" name="uktheatre" class="uktheatre" <?php echo ($uktheatre?'checked="checked"':''); ?> />
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label style="line-height:30px;"><?php _e('American  :', 'jacro'); ?>
                                <input type="checkbox" value="true" name="americanlang" class="americanlang" <?php echo ($americanlang?'checked="checked"':''); ?> />
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label style="line-height:30px;"><?php _e('Australian  :', 'jacro'); ?>
                                <input type="checkbox" value="true" name="australianlang" class="australianlang" <?php echo ($australianlang?'checked="checked"':''); ?> />
                            </label>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- LIVE EVENT FILTERS -->
        <tr>
            <td>
                <b><label style="line-height:30px;" data-tooltip="selected category show along with button showtime"><?php _e('Custom Movie Filter Option :', 'jacro'); ?></label></b>
            </td>
        </tr>
        <?php for($filter_option=0;$filter_option<=CUSTOM_FILTER_OPTION;$filter_option++) :
            if($filter_option!=0): ?>
                <tr>
                    <td>
                        <label style="line-height:30px;"><?php _e('Custom Filter '.$filter_option.':', 'jacro'); ?></label>
                    </td>
                </tr>
            <?php endif; ?>
            <tr>
                <td colspan="3">
                    <table cellspacing="0" class="wp-list-table widefat fixed appearance_page_machine-list">
                        <tr>
                            <?php 
                            $filter_name = 'jacro-custom-filter'.$filter_option.'-name';
                            $filter_code_name = 'jacro-custom-filter'.$filter_option.'-code';
                            $filter_show_name = 'jacro-custom-filter'.$filter_option.'-show';
                            $name = (isset($custom_filter_option[$filter_name])?$custom_filter_option[$filter_name]:'');
                            $code = (isset($custom_filter_option[$filter_code_name])?$custom_filter_option[$filter_code_name]:'');
                            $show = ((isset($custom_filter_option[$filter_show_name])&&$custom_filter_option[$filter_show_name]==true)?'checked':'');
                            if($filter_option==0): ?>
                            <th width="20%">
                                <label style="line-height:30px;"><?php _e('Live Event Filter :', 'jacro'); ?></label>
                                <input type="hidden" value="Live Events" name="<?php echo $filter_name; ?>" class="" >
                            </th>
                            <?php else : ?>
                            <td style="width:20%;">
                                <div><label style="line-height:30px;"><?php _e('Filter Name:', 'jacro'); ?></label></div>
                                <input type="text" value="<?php echo $name; ?>" name="<?php echo $filter_name; ?>" class="" >
                            </td>
                            <?php endif; ?>
                            <td style="width:20%;">
                                <div><label style="line-height:30px;"><?php _e('Genre Code :', 'jacro'); ?></label></div>
                                <select id="<?php echo $filter_code_name; ?>" name="<?php echo $filter_code_name; ?>">
                                    <option value=""><?php esc_html_e('Select Code', 'jacro'); ?></option>
                                    <?php foreach($all_genre_codes as $genrecode): ?>
                                        <option value="<?php echo esc_attr($genrecode); ?>" <?php echo (($genrecode==$code)?'selected':''); ?>><?php echo esc_html($genrecode); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <div><label style="line-height:30px;"><?php _e('Show Filter :', 'jacro'); ?></label></div>
                                <input type="checkbox" value="true" name="<?php echo $filter_show_name; ?>" class="" <?php echo $show; ?>>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        <?php endfor; ?>

        <!-- Header loign/membership menu -->
                    <tr>
                        <td>
                            <b><label style="line-height:30px;" data-tooltip="additional menue item add in menu"><?php _e('Header Login/Membership Menu :', 'jacro'); ?></label></b>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <table cellspacing="0" class="wp-list-table widefat fixed appearance_page_machine-list">
                                <tr> 
                                    <td>
                                        <label class="head"><?php _e('Login', 'jacro'); ?></label><input type='radio' name="defaultheadermenu" id="defaultheadermenu" value="h_login" <?php if(isset($defaultheadermenu) && ($defaultheadermenu =='h_login')){ echo 'checked="checked"'; } ?>/>
                                        <label class="head"><?php _e('Membership', 'jacro'); ?></label><input type='radio' name="defaultheadermenu" id="defaultheadermenu" value="h_membership" <?php if(isset($defaultheadermenu) && ($defaultheadermenu =='h_membership')){ echo 'checked="checked"'; } ?>/>
                                        <label class="head"><?php _e('None', 'jacro'); ?></label><input type='radio' name="defaultheadermenu" id="defaultheadermenu" value="h_none" <?php if(isset($defaultheadermenu) && ($defaultheadermenu =='h_none' || $defaultheadermenu =='')){ echo 'checked="checked"'; } ?>/>
                                        <?php if($defaultheadermenu =='h_none'){
                                            $selectclass = 'hideselect';
                                        }else{
                                            $selectclass = '';
                                        }?>
                                        <select name="jacrologinmenu" class="activemenus <?php echo $selectclass; ?>" id="activemenus">
                                            <option value="">Select Menu</option>
                                            <?php 
                                            $menus = get_terms( 'nav_menu' );
                                            $menus = array_combine( wp_list_pluck( $menus, 'term_id' ), wp_list_pluck( $menus, 'name' ) );
                                            foreach($menus as $mid => $mvalue){
                                                if($jacrologinmenu == $mid){
                                                    echo '<option value="'.$mid.'" selected>'.$mvalue.'</option>';
                                                }else{
                                                    echo '<option value="'.$mid.'">'.$mvalue.'</option>';
                                                }   
                                            }
                                         ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Banner options -->
                    <tr>
                        <td>
                            <b><label style="line-height:30px;" data-tooltip="after film box title or button show"><?php _e('Poster layout Button/Title :', 'jacro'); ?></label></b>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <table cellspacing="0" class="wp-list-table widefat fixed appearance_page_machine-list">
                                <tr> 
                                    <?php if(empty($posterlayoutopt)){
                                        $posterlayoutopt = 'poster_titl';
} ?>
                                    <td>
                                        <label class="head"><?php _e('Title', 'jacro'); ?></label><input type='radio' name="posterlayoutopt" id="posterlayoutopt" value="poster_titl" <?php if(isset($posterlayoutopt) && ($posterlayoutopt =='poster_titl')){ echo 'checked="checked"'; } ?>/>
                                        <label class="head"><?php _e('Button', 'jacro'); ?></label><input type='radio' name="posterlayoutopt" id="posterlayoutopt" value="poster_btn" <?php if(isset($posterlayoutopt) && ($posterlayoutopt =='poster_btn')){ echo 'checked="checked"'; } ?>/>
                                       
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Single page movie information -->
                    <tr>
                        <td>
                            <b><label style="line-height:30px;"><?php _e('Single page movie information :', 'jacro'); ?></label></b>
                        </td>   
                    </tr>
                    <tr>
                        <td colspan="3">
                            <table cellspacing="0" class="wp-list-table widefat fixed appearance_page_machine-list">
                                <tr>
                                    <td>
                                        <label style="line-height:30px;" data-tooltip="rating hide from film info"><?php _e('Hide Rating :', 'jacro'); ?>
                                        <input type="checkbox" value="true" name="hide_single_film_rating" class="hide_single_film_rating" <?php echo ($hide_single_film_rating?'checked="checked"':''); ?> /></label>
                                    </td>
                                    <td>
                                        <label style="line-height:30px;" data-tooltip="running time hide from film info"><?php _e('Hide Running Time:', 'jacro'); ?>
                                        <input type="checkbox" value="true" name="hide_single_film_runningtime" class="hide_single_film_runningtime" <?php echo ($hide_single_film_runningtime?'checked="checked"':''); ?> /></label>
                                    </td>
                                    <td>
                                        <label style="line-height:30px;" data-tooltip="release date hide from film info"><?php _e('Hide Released Date :', 'jacro'); ?>
                                        <input type="checkbox" value="true" name="hide_single_film_releaseddate" class="hide_single_film_releaseddate" <?php echo ($hide_single_film_releaseddate?'checked="checked"':''); ?> /></label>
                                    </td>
                                    <td>
                                        <label style="line-height:30px;" data-tooltip="genre hide from film info"><?php _e('Hide Genre:', 'jacro'); ?>
                                        <input type="checkbox" value="true" name="hide_single_film_genre" class="hide_single_film_genre" <?php echo ($hide_single_film_genre?'checked="checked"':''); ?> /></label>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label style="line-height:30px;">&nbsp; </label>
                        </td>
                        <td>
                            <input type="submit" value="Update" class="button button-primary" name="update_lable">
                        </td>
                    </tr>
                </table>

            </form>
        </div>
    </div>

    <!-- Jacro Theme Settings Removed --->
    
    <!-- Jacro Other Settings -->
    <div id="jacro-other-settings" class="tab-content">
        <div class="row ad">
            <form id="frm_lable" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" enctype="multipart/form-data">
                <input type="hidden" name="jacro-setting-action" id="jacro-other-setting-action" value="jacro-other-settings" />
                <table cellspacing="0" class="wp-list-table widefat fixed appearance_page_machine-list">
                    <tr>
                        <td>
                            <label for="jacro-showtime-hour"><strong><?php _e('No Booking Fees text :', 'jacro'); ?></strong></label></br>
                            <label class="jscro-notice-message"><?php _e('(add text for not booking)', 'jacro'); ?></label>
                        </td>
                        <td>
                            <input type="text" name="no_booking_fee_text" value="<?php echo $no_booking_fee_text;?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="jacro-showtime-hour"><strong><?php _e('Google Analytics Tracking Id :', 'jacro'); ?></strong></label></br>
                            <label class="jscro-notice-message"><?php _e('(add tracking id)', 'jacro'); ?></label>
                        </td>
                        <td>
                            <input type="text" name="google_analytics_code" placeholder="<?php _e('UA-XXXXXXXX-Y', 'jacro'); ?>" value="<?php echo $google_analytics_code; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="jacro-showtime-hour"><strong><?php _e('Image :', 'jacro'); ?></strong></label></br>
                            <label class="jscro-notice-message"><?php _e('(size 150px X 210px)', 'jacro'); ?></label>
                        </td>
                        <td>
                            <input type="file" name="image" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label style="line-height:30px;">&nbsp; </label>
                        </td>
                        <td>
                            <?php if(!empty($default_jacro_image)){
                                $img= wp_get_attachment_url( $default_jacro_image);?>
                                <input type="hidden" name="pre_img_id" value="<?php echo $default_jacro_image;?>" />
                                <img src="<?php echo $img;?>" style="max-width:300px;" />
                            <?php }?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="jacro-showtime-hour"><strong><?php _e('Expired performance auto cleaning days :', 'jacro'); ?></strong></label></br>
                            <label class="jscro-notice-message"><?php _e('(default 7 days selected)', 'jacro'); ?></label>
                        </td>
                        <td>
                            <div class="">
                                <input type="text" name="jacro-auto-clean-performace" onkeypress="return is_number(event)" value="<?php echo esc_attr($jacro_auto_clean_performace); ?>" style="margin:0px 7px;" />
                            </div>
                        </td>
                    </tr>
                    <!-- custom showtime cron -->
                    <tr>
                        <td>
                            <label for="jacro-showtime-hour"><strong><?php _e('Cron showtime interval:', 'jacro'); ?></strong></label></br>
                            <label class="jscro-notice-message"><?php _e('(default 20 hours selected)', 'jacro'); ?></label>
                        </td>
                        <td>
                            <div class="">
                                <select id="showtime_import_interval" name="showtime_import_interval">
                                    <?php for ($x = 1; $x <= 24; $x++) {
                                        $opval = $x*60*60;
                                         echo '<option value="'.$opval.'" '.($showtime_import_interval == $opval ? 'selected' : '').'>'.$x.' Hours</option>';
                                    }
                                     ?>  
                                </select>    
                            </div>
                        </td>
                    </tr>
                    <!-- jacro log email alert -->
                    <tr>
                        <td>
                            <label for="jacro-showtime-hour"><strong><?php _e('Log email alert :', 'jacro'); ?></strong></label></br>
                            <label class="jscro-notice-message"><?php _e('(default admin email used)', 'jacro'); ?></label>
                        </td>
                        <td>
                            <div class="">
                                <input type="text" value="<?php echo $jacro_log_email; ?>" name="jacro_log_email" class="jacro_log_email"/>
                            </div>
                        </td>
                    </tr>
                    <!-- jacro log email alert stop -->
                    <tr>
                        <td>
                            <label for="jacro-showtime-hour"><strong><?php _e('Delete log activities:', 'jacro'); ?></strong></label></br>
                            <label class="jscro-notice-message"><?php _e('(Warning: Clicking this will delete all activities from the database.)', 'jacro'); ?></label>
                        </td>
                        <td>
                            <div class="">
                                <a href="javascript:void(0);" class="jacro_log_reset">Reset Log Database</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="jacro-showtime-hour"><strong><?php _e('Currency Position :', 'jacro'); ?></strong></label></br>
                            <label class="jscro-notice-message"><?php _e('(default left selected)', 'jacro'); ?></label>
                        </td>
                        <td class="">
                            <div class="">
                                <label class="head"><?php _e('Left', 'jacro'); ?></label><input type='radio' name="currency-position" id="currency-position" value="left" <?php if(isset($events_films_sorting_title) && ($defaultJacroCurrencyPosition=='left' || $defaultJacroCurrencyPosition=='')): echo 'checked="checked"'; endif; ?>/>
                                <label class="head"><?php _e('Right', 'jacro'); ?></label><input type='radio' name="currency-position" id="currency-position" value="right" <?php if(isset($defaultJacroCurrencyPosition) && ($defaultJacroCurrencyPosition=='right')): echo 'checked="checked"'; endif; ?>/>
                            </div>
                        </td>
                    </tr>
                    <!-- <tr>
                        <td colspan="2"><label style="line-height:30px;"><strong></?php _e('Showtimes Settings :', 'jacro'); ?></strong></label></td>
                    </tr>
                    <tr>
                        <td>
                            <label for="jacro-showtime-hour"></?php _e('Showtime clock setting for 12 hours (default 24 hour) :', 'jacro'); ?></label>
                        </td>
                        <td>
                            <div class="jacro-currency">
                                <input type="checkbox" value="true" </?php if($jacroShowTimeHour==true): echo 'checked="checked"'; endif; ?> name="jacro-showtime-hour" id="jacro-showtime-hour" class="jacro-showtime-hour" />
                            </div>
                        </td>
                    </tr> -->
                     <tr>
                        <td colspan="2"><label style="line-height:30px;"><strong><?php _e('Show Categories Filter Option :', 'jacro'); ?></strong></label></td>
                    </tr>
                    <tr>
                        <td>
                            <label for="jacro-showtime-hour"><strong><?php _e('Show Performance Category :', 'jacro'); ?></strong></label></br>
                            <label class="jscro-notice-message"><?php _e('(film performances category display after tabs)', 'jacro'); ?></label>
                        </td>
                        <td>
                            <div class="jacro-currency">
                                <input type="checkbox" value="true" <?php if($jacroShowPerformanceCategoryFilters==true): echo 'checked="checked"'; endif; ?> name="jacro-show-performance-category-filters" id="jacro-show-performance-category-filters" class="jacro-show-performance-category-filters" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="jacro-showtime-hour"><strong><?php _e('Show Cinema film Category :', 'jacro'); ?></strong></label></br>
                            <label class="jscro-notice-message"><?php _e('(film category display after tabs)', 'jacro'); ?></label>
                        </td>
                        <td>
                            <div class="jacro-currency">
                                <input type="checkbox" value="true" <?php if($jacroShowCinemaCategoryFilters==true): echo 'checked="checked"'; endif; ?> name="jacro-show-cinema-category-filters" id="jacro-show-cinema-category-filters" class="jacro-show-cinema-category-filters" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><label style="line-height:30px;"><strong><?php _e('Open New Tab Settings :', 'jacro'); ?></strong></label></td>
                    </tr>
                    <tr>
                        <td>
                            <label for="jacro-showtime-hour"><strong><?php _e('Book Now :', 'jacro'); ?></strong></label></br>
                            <label class="jscro-notice-message"><?php _e('(open in new tab browser)', 'jacro'); ?></label>
                        </td>
                        <td>
                            <div class="jacro-currency">
                                <input type="checkbox" value="true" <?php if($jacroBookNowOpenLink==true): echo 'checked="checked"'; endif; ?> name="jacro-booknow-open-link" id="jacro-booknow-open-link" class="jacro-booknow-open-link" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="jacro-showtime-hour"><strong><?php _e('More Showtimes &amp; Film Page :', 'jacro'); ?></strong></label></br>
                            <label class="jscro-notice-message"><?php _e('(open in new tab browser)', 'jacro'); ?></label>
                        </td>
                        <td>
                            <div class="jacro-currency">
                                <input type="checkbox" value="true" <?php if($jacroMoreShowtimesLink==true): echo 'checked="checked"'; endif; ?> name="jacro-more-showtimes-link" id="jacro-more-showtimes-link" class="jacro-more-showtimes-link" />
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label for="jacro-showtime-hour"><strong><?php _e('Buttons to show :', 'jacro'); ?></strong></label></br>
                            <label class="jscro-notice-message"><?php _e('(Visible buttons for show timings)', 'jacro'); ?></label>
                        </td>
                        <td>
                            <div class="">
                                <input type="text" name="jacro-showtime-length" value="<?php echo esc_attr($jacro_showtime_length); ?>" onkeypress="return is_number(event)" />
                            </div>
                        </td>
                    </tr>
                    <!-- Spiner Loader -->
                    <tr>
                        <td colspan="2"><label style="line-height:30px;"><strong><?php _e('Loader Settings :', 'jacro'); ?></strong></label></td>
                    </tr>
                    <tr>
                        <td>
                            <label for="jacro-showtime-hour"><?php _e('Spiner Loader Image :', 'jacro'); ?></label></br>
                            <label class="jscro-notice-message"><?php _e('(Recommended Size to 200px X 200px and allow only GIF/SVG)', 'jacro'); ?></label>
                        </td>
                        <td>
                            <div class="">
                                <input type="file" name="loader-image" value="" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label style="line-height:30px;">&nbsp; </label>
                        </td>
                        <td>
                            <?php if(!empty($jacroLoader)){
                                $imgUrl= wp_get_attachment_url( $jacroLoader);                   
                            } else {
                                $imgUrl = CINEMA_URL.'images/jacro-loader.svg';
                                $jacroLoader = '';
                            } ?>
                            <input type="hidden" name="pre_img_id" value="<?php echo $jacroLoader;?>" />
                            <img src="<?php echo $imgUrl; ?>" style="max-width:100px;" />
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <label style="line-height:30px;">&nbsp; </label>
                        </td>
                        <td>
                            <input type="submit" value="Update" class="button button-primary" name="update_lable">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
</div>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    jQuery(document).ready(function(){

        jQuery('.jacro-color-field').wpColorPicker();
        
        jQuery(".homepage_layout").change(function(){
            if (jQuery('.homepage_layout').children('option:selected').val() == "posters") {
                jQuery('.homepage_poster_display').show();
                jQuery('.homepage_detail_display').hide();
            } else {
                jQuery('.homepage_poster_display').hide();
                jQuery('.homepage_detail_display').show();
            }
        }).change();

        if (jQuery('.theatre_section_override').is(":checked")) {
            jQuery('.theatre_section_display').show();
        } else {
            jQuery('.theatre_section_display').hide();
        }
        if (jQuery('.perfcat_section_override').is(":checked")) {
            jQuery('.perfcat_section_display').show();
        } else {
            jQuery('.perfcat_section_display').hide();
        }
        if (jQuery('.perfcat_category').is(":checked")) {
            jQuery(this).next().show();
        } else {
            jQuery(this).next().hide();
        }
        if (jQuery("input[name=movieslideroption]:checked").val() == 'manual') {
            jQuery('.customsliderimage').show();
            jQuery('.advertisesliderimage').hide();
        } else if(jQuery("input[name=movieslideroption]:checked").val() == 'advertise') {
            jQuery('.customsliderimage').hide();
            jQuery('.advertisesliderimage').show();
        } else {
            jQuery('.customsliderimage').hide();
            jQuery('.advertisesliderimage').hide();
        }
        
        if (jQuery('.tab_hide_now_showing').is(":checked")) {
            jQuery('.tab_now_showing_display').hide();
        } else {
            jQuery('.tab_now_showing_display').show();
        }
        // if (jQuery('.tab_hide_advance_bookings').is(":checked")) {
        //     jQuery('.tab_advance_bookings_display').hide();
        // } else {
        //     jQuery('.tab_advance_bookings_display').show();
        // }
        if (jQuery('.tab_hide_new_releases').is(":checked")) {
            jQuery('.tab_new_releases_display').hide();
        } else {
            jQuery('.tab_new_releases_display').show();
        }
        if (jQuery('.tab_hide_advance_sales').is(":checked")) {
            jQuery('.tab_advance_sales_display').hide();
        } else {
            jQuery('.tab_advance_sales_display').show();
        }
        if (jQuery('.tab_hide_all_performances').is(":checked")) {
            jQuery('.tab_all_performances_display').hide();
        } else {
            jQuery('.tab_all_performances_display').show();
        }
        jQuery(".tab_hide_now_showing").on("click", function(){
            if (jQuery('.tab_hide_now_showing').is(":checked")) {
                jQuery('.tab_now_showing_display').hide();
            } else {
                jQuery('.tab_now_showing_display').show();
        }
        });
        // jQuery(".tab_hide_advance_bookings").on("click", function(){
        //     if (jQuery('.tab_hide_advance_bookings').is(":checked")) {
        //         jQuery('.tab_advance_bookings_display').hide();
        //     } else {
        //         jQuery('.tab_advance_bookings_display').show();
        // }
        // });
        jQuery(".tab_hide_new_releases").on("click", function(){
            if (jQuery('.tab_hide_new_releases').is(":checked")) {
                jQuery('.tab_new_releases_display').hide();
            } else {
                jQuery('.tab_new_releases_display').show();
        }
        });
        jQuery(".tab_hide_advance_sales").on("click", function(){
            if (jQuery('.tab_hide_advance_sales').is(":checked")) {
                jQuery('.tab_advance_sales_display').hide();
            } else {
                jQuery('.tab_advance_sales_display').show();
        }
        });
        jQuery(".tab_hide_all_performances").on("click", function(){
            if (jQuery('.tab_hide_all_performances').is(":checked")) {
                jQuery('.tab_all_performances_display').hide();
            } else {
                jQuery('.tab_all_performances_display').show();
        }
        });
        jQuery(".theatre_section_override").on("click", function(){
            if (jQuery('.theatre_section_override').is(":checked")) {
                jQuery('.theatre_section_display').show();
            } else {
                jQuery('.theatre_section_display').hide();
            }
        });
        jQuery(".perfcat_section_override").on("click", function(){
            if (jQuery('.perfcat_section_override').is(":checked")) {
                jQuery('.perfcat_section_display').show();
            } else {
                jQuery('.perfcat_section_display').hide();
            }
        });
        jQuery(".perfcat_category").on("click", function(){
            if (jQuery(this).is(":checked")) {
                jQuery(this).next().show();
            } else {
                jQuery(this).next().hide();
            }
        });
        jQuery("input[name=movieslideroption]:radio").click(function() {
            if(jQuery(this).attr("value")=="manual") {
                jQuery(".customsliderimage").show();
                jQuery('.advertisesliderimage').hide();
            } else if(jQuery(this).attr("value")=="advertise") {
                jQuery('.advertisesliderimage').show();
                jQuery(".customsliderimage").hide();
            } else {
                jQuery(".customsliderimage").hide();
                jQuery('.advertisesliderimage').hide();
            }
        });
    
        var checked_options = jQuery(".theatre_screen_genre_exclude_option:checked");
        //console.log(checked_options);
        set_genre_exclude_string(checked_options);
        
        jQuery(".theatre_screen_genre_exclude_option").on("click", function(){
        // console.log('Click!');
            var checked_options = jQuery(".theatre_screen_genre_exclude_option:checked");
            set_genre_exclude_string(checked_options);
            
        });
    
    });
    function set_genre_exclude_string(checked_options) {
        var gstr = "";
        checked_options.each(function(e){
            gstr += checked_options[e].value+",";
        });
        //console.log(gstr);
        jQuery("#theatre_screen_genre_exclude").val(gstr);
    };
</script>

<?php
if(isset($_POST['update_lable']) && $_POST['update_lable'] ){
    if((isset($_POST['jacro-setting-action']))&&($_POST['jacro-setting-action']!='')) :
        JacroSaveSettings($_POST['jacro-setting-action'], $_POST);

        $upload_overrides = array( 'test_form' => false );
        $movieslideroption = get_option('movieslideroption');
        $image  = isset ( $_FILES[ 'image' ] ) ? $_FILES[ 'image' ] : null; 
        if ( '' != $image[ 'name' ] ) {
            $upload = wp_handle_upload( $image, $upload_overrides );
            $attachment = array(
                'guid'           => $upload[ 'url' ], 
                'post_mime_type' => $upload[ 'type' ],
                'post_title'     => $upload[ 'file' ],
                'post_content'   => '',
                'post_status'    => 'inherit'
            );
            $attach_id = wp_insert_attachment( $attachment, $upload[ 'file' ] );        
            $image=wp_get_attachment_url( $attach_id );
            wp_update_attachment_metadata( 
                $attach_id, 
                wp_generate_attachment_metadata( $attach_id, $upload[ 'file' ] ) 
            );
            update_option( "default_jacro_image",absint( $attach_id ));
        }

        /** Loader Image upload **/
        $loaderImage  = isset ( $_FILES[ 'loader-image' ] ) ? $_FILES[ 'loader-image' ] : null; 
        if ( '' != $loaderImage[ 'name' ] ) {
            $upload = wp_handle_upload( $loaderImage, $upload_overrides );
            $attachment = array(
                'guid'           => $upload[ 'url' ], 
                'post_mime_type' => $upload[ 'type' ],
                'post_title'     => $upload[ 'file' ],
                'post_content'   => '',
                'post_status'    => 'inherit'
            );
            $attach_id = wp_insert_attachment( $attachment, $upload[ 'file' ] );        
            $loaderImage=wp_get_attachment_url( $attach_id );
            wp_update_attachment_metadata( 
                $attach_id, 
                wp_generate_attachment_metadata( $attach_id, $upload[ 'file' ] ) 
            );
            update_option( "jacro-loader-image",absint( $attach_id ));
        }

       /** movie slider images **/
       if ($movieslideroption == 'manual') {
            $moviesdata = array();

            if (isset($_POST['movieslider']) && isset($_FILES['movieslider'])) {
                $moviesdata = $_POST['movieslider'];
                foreach ($_FILES['movieslider']['name'] as $slideCounter => $filename) {
                    $sl_image = $_FILES['movieslider'];
                    if ('' != $filename['sliderimage'] && $sl_image['error'][$slideCounter]['sliderimage'] == 0) {
                        $upload_dir = wp_upload_dir();
                        $file_path = $upload_dir['path'] . '/' . $filename['sliderimage'];
                        if (move_uploaded_file($sl_image['tmp_name'][$slideCounter]['sliderimage'], $file_path)) {
                            $moviesdata[$slideCounter]['sliderimage'] = $file_path;
                        }
                    } 
                } 
                foreach ($moviesdata as $slideCounter => $slideData) {
                    if (empty($slideData['sliderimage']) && isset($slideData['old_sliderimage'])) {
                        $moviesdata[$slideCounter]['sliderimage'] = $slideData['old_sliderimage'];
                    }
                }
            } else if (isset($_POST['movieslider'])) {
                $moviesdata = $_POST['movieslider'];
                foreach ($moviesdata as $slideCounter => $slideData) {
                    if (empty($slideData['sliderimage']) && isset($slideData['old_sliderimage'])) {
                        $moviesdata[$slideCounter]['sliderimage'] = $slideData['old_sliderimage'];
                    }
                }
            }

            $movie_slider_info = array_values($moviesdata);
            update_option("movieslider", $movie_slider_info);
        } else if ($movieslideroption == 'advertise') { 
            $adsslidedata = array();

            if (isset($_POST['adsslider']) && isset($_FILES['adsslider'])) {
                $adsslidedata = $_POST['adsslider'];
                foreach ($_FILES['adsslider']['name'] as $slideCounter => $filename) {
                    $sl_image = $_FILES['adsslider'];
                    if ('' != $filename['adsimage'] && $sl_image['error'][$slideCounter]['adsimage'] == 0) {
                        $upload_dir = wp_upload_dir();
                        $file_path = $upload_dir['path'] . '/' . $filename['adsimage'];
                        if (move_uploaded_file($sl_image['tmp_name'][$slideCounter]['adsimage'], $file_path)) {
                            $adsslidedata[$slideCounter]['adsimage'] = $file_path;
                        }
                    } 
                } 
                foreach ($adsslidedata as $slideCounter => $slideData) {
                    if (empty($slideData['adsimage']) && isset($slideData['old_sliderimage'])) {
                        $adsslidedata[$slideCounter]['adsimage'] = $slideData['old_sliderimage'];
                    }
                }
            } else if (isset($_POST['adsslider'])) {
                $adsslidedata = $_POST['adsslider'];
                foreach ($adsslidedata as $slideCounter => $slideData) {
                    if (empty($slideData['adsimage']) && isset($slideData['old_sliderimage'])) {
                        $adsslidedata[$slideCounter]['adsimage'] = $slideData['old_sliderimage'];
                    }
                }
            }

            $ads_slider_info = array_values($adsslidedata);
            update_option("adsslider", $ads_slider_info);
        }

        $_SESSION['s_message']='Settings has been changed.';
        echo"<script>window.location='?page=jacrosettings';</script>";
    endif;
}
?>