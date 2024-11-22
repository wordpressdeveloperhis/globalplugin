<?php
start_session();
$jacro_theme_color = get_option('jacro_color_theme');
?>
<style>
    .tagcloud1 a:hover, .tagcloud2 a:hover { background: ".$jacro_theme_color." !important; }
    .tagcloud1 a.active, .tagcloud2 a.active { background: ".$jacro_theme_color." !important; }
    .display_cinema { display: none !important; }
</style>

<?php
$americanlang = get_option( 'americanlang' );
$australianlang = get_option( 'australianlang' );
$uktheatre = get_option( 'uktheatre' );
$option_hideallshows = get_option( 'hideallshows' );
$tab_header_now_showing = get_option( 'tab_header_now_showing', "Now Playing" );
$tab_header_advance_bookings = get_option( 'tab_header_advance_bookings', "Advance Booking" );
$tab_header_new_releases = get_option( 'tab_header_new_releases', "New Releases" );
$tab_header_advance_sales = get_option( 'tab_header_advance_sales', "Advance Sales" );
$tab_header_all_performances = get_option( 'tab_header_all_performances', "All Performances" );

$tab_hide_now_showing = get_option( 'tab_hide_now_showing', false );
$tab_hide_new_releases = get_option( 'tab_hide_new_releases',  false  );
$date_filter_select_today = (get_option("date-filter-select-today")?get_option("date-filter-select-today"):false);
$date_format_tabs = get_option( 'date_filter_format','jS M' );

$menuorder = get_option('menuorder');

$ac = array_filter($menuorder, 'strlen');
$menu_filter = array_keys($ac,min($ac));
$s_type = '';
if($menu_filter[0] == 'all_performances'){
    $s_type = 'All Performances';
} elseif($menu_filter[0] == 'now_showing'){
    $s_type = 'Now Showing';
} elseif($menu_filter[0] == 'new_releases'){
    $s_type = 'New Release';
} elseif($menu_filter[0] == 'advance_sales'){
    $s_type = 'Advance Sales';
}

global $wpdb;
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
$strtotimezone = jacro_strtotimezone($cinema);

if(($cinema)&&isset($cinema)):
    $default_selected = $cinema;
    $top_cinema = $cinema;
    delete_transient('back_to_prev_page'); ?> 
    <input type="hidden" name="cinema_id" id="cinema_id" value="<?php echo $default_selected; ?>" />

    <?php
    $cinema_arr = jacroGetCinemas();
    $total_cinema = count((array)$cinema_arr);
    if($single_loctype =='all'){
 
        if(empty($default_selected)){
            $defaultclass = ' active';
        } ?>
        <div class="desktopcinemaselect">
            <?php
            foreach($cinema_arr as $cinema){
                if($cinema->id == $default_selected){
                    $activecnclass = ' active';
                }else{
                    $activecnclass = '';
                } 
            ?> 
                <a class="cinema_select btn btn-default<?php echo $activecnclass; ?>" data-cinema_id="<?php echo $cinema->id;?>"><?php echo $cinema->name;?></a>
            <?php } ?>
        </div>
        <div class="col-lg-4 mobcinemaselect">
            <h5 id="mobcinemaselect" class="jsf">
                <select class="mobcinemaselectinr" name="cinema_select" id="mobcinemaselect">
                <?php
                    foreach($cinema_arr as $cinema){ 
                        if($cinema->id == $default_selected){
                            $activecnclass = 'selected';
                        }else{
                            $activecnclass = '';
                        }
                    ?>  
                    <option value="<?php echo $cinema->id;?>" class="cinema_select btn btn-default" data-cinema_id="<?php echo $cinema->id;?>" <?php echo $activecnclass; ?>>
                        <?php echo $cinema->name;?>
                    </option>
                <?php } ?>
                </select>
            </h5>
        </div>
    <?php } ?>
    <div id="jacroselecto" class="fw-container">
        <div class="cinema-select">
            <input type="hidden" class="form-control subselect-cinema-theater multiselect dropdown-toggle" value="<?php echo $default_selected; ?>" />
            <?php 
            $selectedDate = ''; $selectedType = ''; $jacroToday = $strtotimezone;
            /** Default Film Date **/
            if(isset($_COOKIE['jacroFilmDate']) && $_COOKIE['jacroFilmDate']!='' && ($_COOKIE['jacroFilmDate']>=$jacroToday)) : 
                $selectedDate = ($_COOKIE['jacroFilmDate']=='moredates') ? 'moredates' : $_COOKIE['jacroFilmDate'];
            else :
                if($date_filter_select_today){
                    $selectedDate = date("Y-m-d", $jacroToday);
                } else {
                    $selectedDate = 'moredates';
                }
            endif;

            /** Default Film Type **/

            if(isset($_COOKIE['jacroFilmType']) && $_COOKIE['jacroFilmType']!='') : 
                $selectedType = $_COOKIE['jacroFilmType'];
            elseif($s_type) :
                $selectedType = $s_type;
            else:
                $selectedType = 'All Performances';
            endif; 

            ?>
            <input type="hidden" name="film_date" id="film_date" value="<?php echo $selectedDate; ?>" />
            <input type="hidden" name="film_tags" id="film_tags" data-test="sing" value="<?php echo $selectedType; ?>" />
            
            <div style="clear:both;"></div>
            <!-- Main Movies Type Filter -->
            <div id="full-fat-menu" style="padding: 0 0 15px 0;">
                <div class="moviedetails-widget">
                    <div class="fw-tabs">
                        <ul>
                        <?php if (get_option('theatre_section_override')) {?>
                            <li>
                                <a href="javascript:void(0)" rel="Now Showing" class="<?php if($selectedType=='Now Showing'): echo 'active'; endif; ?> coming_soon now_playing first">Screen</a>
                            </li>
                            <li>
                               <a href="javascript:void(0)" class="<?php if($selectedType=='Coming Soon'): echo 'active'; endif; ?> coming_soon adv-booking" rel="Coming Soon">Stage</a>    
                            </li>
                        <?php } else {  
                            if (!get_option('tab_hide_all_performances')) {?>
                                <li class="<?php if($menuorder['all_performances']){ echo 'order'.$menuorder['all_performances'];}else{ echo 'order0';}?>">
                                    <a href="javascript:void(0)" class="<?php if($selectedType=='All Performances'): echo 'active'; endif; ?> coming_soon all_performances first" rel="All Performances"><?php echo $tab_header_all_performances; ?></a> 
                                </li>
                                <?php }
                                if (!get_option('tab_hide_now_showing')) {?>
                                <li class="<?php if($menuorder['now_showing']){ echo 'order'.$menuorder['now_showing'];}else{ echo 'order0';}?>">
                                    <a href="javascript:void(0)" rel="Now Showing" class="<?php if($selectedType=='Now Showing'): echo 'active'; endif; ?> coming_soon now_playing"><?php echo $tab_header_now_showing; ?></a>
                                </li>
                                <?php }
                                if (!get_option('tab_hide_new_releases')) {?>
                                <li class="<?php if($menuorder['new_releases']){ echo 'order'.$menuorder['new_releases'];}else{ echo 'order0';}?>">
                                    <a href="javascript:void(0)" class="<?php if($selectedType=='New Release'): echo 'active'; endif; ?> coming_soon" rel="New Release"><?php echo $tab_header_new_releases; ?></a> 
                                </li>
                                <?php }
                                if (!get_option('tab_hide_advance_sales')) {?>
                                <li class="<?php if($menuorder['advance_sales']){ echo 'order'.$menuorder['advance_sales'];}else{ echo 'order0';}?>">
                                    <a href="javascript:void(0)" class="<?php if($selectedType=='Advance Sales'): echo 'active'; endif; ?> coming_soon advance_sales" rel="Advance Sales"><?php echo $tab_header_advance_sales; ?></a> 
                                </li>
                                <?php }
                        } ?>

                        <?php echo get_custom_filters(); ?>

                        </ul>
                    </div>
                </div>

                <?php 
                $homepage_layout = get_option('homepage_layout');
                if($homepage_layout == 'both') {
                    if(get_option( 'homepage_layout') == 'posters' || get_option( 'homepage_layout') == 'detail'){
                        $homepage_layout = get_option( 'homepage_layout');
                    }
                    else if(isset($_COOKIE['jacroFilmLayout']) && $_COOKIE['jacroFilmLayout']!='') {
                        $homepage_layout = $_COOKIE['jacroFilmLayout'];
                    }
                    else{
                        $homepage_layout = 'detail';
                    } 
                ?>                          
                <div class="layoutchangeblock">
                    <div class="innerbtnblc">
                        <a href="javascript:;" class="gridlayout <?php if($homepage_layout =='posters'){echo 'active';} ?>" onclick="changelayout('posters');" title="Poster Layout">
                            <i class="dashicons dashicons-screenoptions" aria-hidden="true"></i> 
                        </a>
                        <a href="javascript:;" class="listlayout <?php if($homepage_layout =='detail'){echo 'active';} ?>" onclick="changelayout('detail');" title="Detailed Layout">
                            <i class="dashicons dashicons-menu" aria-hidden="true"></i> 
                        </a>
                    </div>                  
                </div>
            <?php } ?>

                <div class="searchfilms">
                    <div class="searchfilms_inner">
                        <input type="text" value="" name="searchfilms_box" id="searchfilms_box" placeholder="Search" class="searchfilms_box" autocomplete="off">
                    </div>
                </div>
            </div>
            <!-- End Main Movies Type Filter -->

            <!-- Theator Filter -->
            <?php $jacroShowPerformanceCategoryFilters = get_option('jacroShowPerformanceCategoryFilters'); ?>
            <?php $jacroShowCinemaCategoryFilters = get_option('jacroShowCinemaCategoryFilters'); ?>
            <?php if(($jacroShowPerformanceCategoryFilters==true)||($jacroShowCinemaCategoryFilters==true)): ?>
                <div id="performance_film_div">
                    <?php if(($jacroShowPerformanceCategoryFilters==true)): ?>
                        <section class="check_film" id="performance_category_div"></section>
                    <?php endif; ?>
                    <?php if(($jacroShowCinemaCategoryFilters==true)): ?>
                        <section class="check_film" id="film_category_div"> </section>
                    <?php endif; ?>
                </div>
                <script>  
                    var element = document.getElementById("cinema_id").value;
                    show_film_performances(element);
                </script>
            <?php endif; ?>
            <div style="clear:both;"></div>
            <!-- End Theator Filter -->
            <?php

                $date = $strtotimezone;
                $date1 = strtotime(date("Y-m-d H:i:s", $date) . " +1 day");
                $date2 = strtotime(date("Y-m-d H:i:s", $date) . " +2 day");
                $date3 = strtotime(date("Y-m-d H:i:s", $date) . " +3 day");
                $date4 = strtotime(date("Y-m-d H:i:s", $date) . " +4 day");
                $date5 = strtotime(date("Y-m-d H:i:s", $date) . " +5 day");
                $date6 = strtotime(date("Y-m-d H:i:s", $date) . " +6 day");
                $date7 = strtotime(date("Y-m-d H:i:s", $date) . " +7 day");
            
            ?>
            <?php if (!get_option('tab_hide_now_showing')) {?>
            <!-- Show Time Date Filter -->
            <div class="fw-tabs" id="date_list" style="<?php if($selectedType!='Now Showing'): echo 'display:none;'; endif; ?>">
                <div id="full-fat-menu" style="padding: 0 0 15px 0;">
                    <ul>
                        <li>
                            <a href="javascript:void(0)" class="<?php if($selectedDate==date("Y-m-d",$date)) : echo 'active'; endif; ?> film_date_value film-date-first" rel="<?php echo date("Y-m-d",$date); ?>">
                                <div><?php echo date("l",$date);?>&nbsp;</div>
                                <div>Today</div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="<?php if($selectedDate==date("Y-m-d",$date1)) : echo 'active'; endif; ?> film_date_value" rel="<?php echo date("Y-m-d",$date1); ?>">
                                <div><?php echo date("l",$date1);?>&nbsp;</div>
                                <div>Tomorrow</div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="<?php if($selectedDate==date("Y-m-d",$date2)) : echo 'active'; endif; ?> film_date_value" rel="<?php echo date("Y-m-d",$date2); ?>">
                                <div><?php echo date("l",$date2);?>&nbsp;</div>
                                <div><?php echo date($date_format_tabs,$date2);?></div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="<?php if($selectedDate==date("Y-m-d",$date3)) : echo 'active'; endif; ?> film_date_value" rel="<?php echo date("Y-m-d",$date3); ?>">
                                <div><?php echo date("l",$date3);?>&nbsp;</div>
                                <div><?php echo date($date_format_tabs,$date3);?></div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="<?php if($selectedDate==date("Y-m-d",$date4)) : echo 'active'; endif; ?> film_date_value" rel="<?php echo date("Y-m-d",$date4); ?>">
                                <div><?php echo date("l",$date4);?>&nbsp;</div>
                                <div><?php echo date($date_format_tabs,$date4);?></div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="<?php if($selectedDate==date("Y-m-d",$date5)) : echo 'active'; endif; ?> film_date_value" rel="<?php echo date("Y-m-d",$date5); ?>">
                                <div><?php echo date("l",$date5);?>&nbsp;</div>
                                <div><?php echo date($date_format_tabs,$date5);?></div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="<?php if($selectedDate==date("Y-m-d",$date6)) : echo 'active'; endif; ?> film_date_value" rel="<?php echo date("Y-m-d",$date6); ?>">
                                <div><?php echo date("l",$date6);?>&nbsp;</div>
                                <div><?php echo date($date_format_tabs,$date6);?></div>
                            </a>
                        </li>
                        <?php if (!$option_hideallshows) { ?>
                        <li>
                            <a href="javascript:void(0)" class="<?php if($selectedDate=='moredates') : echo 'active'; endif; ?> film_date_value" rel="<?php echo 'moredates'; ?>">
                                <div><?php esc_html_e('All Shows', 'jacro'); ?></div>
                                <div class="jacro-down-arrow">&nbsp;</div>
                            </a> 
                        </li>
                        <?php }; ?>
                    </ul>
                </div>
            </div>
            <?php }?>
            <!--- mobile drop-down menu --->
            <div id="mobile-menu" class="mnm">

                <?php $homepage_layout = get_option("homepage_layout"); 
                if($homepage_layout =='both') { ?>    
                <div class="col-lg-4 mobile-layout">
                    <span style="margin-top: 10px;">Select a Layout</span>                    
                    <div class="layoutchangeblock">
                    <?php 
                    if(isset($_COOKIE['jacroFilmLayout']) && $_COOKIE['jacroFilmLayout']!='') {
                        $jacroFilmLayout = $_COOKIE['jacroFilmLayout'];
                    ?>
                    <div class="innerbtnblc">
                        <a href="javascript:;" class="gridlayout <?php if($jacroFilmLayout=='posters'): echo 'active'; endif; ?>" onclick="changelayout('posters');" title="Poster Layout">
                            <i class="dashicons dashicons-screenoptions" aria-hidden="true"></i> 
                        </a>
                        <a href="javascript:;" class="listlayout <?php if($jacroFilmLayout=='detail'): echo 'active'; endif; ?>" onclick="changelayout('detail');" title="Detailed Layout">
                            <i class="dashicons dashicons-menu" aria-hidden="true"></i> 
                        </a>
                    </div> 
                    <?php } else { ?>  
                    <div class="innerbtnblc">
                        <a href="javascript:;" class="gridlayout" onclick="changelayout('posters');" title="Poster Layout">
                            <i class="dashicons dashicons-screenoptions" aria-hidden="true"></i> 
                        </a>
                        <a href="javascript:;" class="listlayout active" title="Detailed Layout">
                            <i class="dashicons dashicons-menu" aria-hidden="true"></i> 
                        </a>
                    </div> 
                    <?php } ?>
                    </div>          
                </div>
                <?php } ?> 

                <div class="col-lg-4">
                    <span style="margin-top: 10px;">Select a Category</span>
                    <!--- --->
                    <script>
                        function duttyCats(element) {
                            var optvalue = element;
                            var dateshow = document.getElementById("mobimdateshow");
                            if(optvalue == 'Now Showing'){
                                dateshow.style.display = "block";
                            }else{
                                dateshow.style.display = "none";
                            }
                            var isitaURL = optvalue.includes("http");
                            if (isitaURL === true) {
                                window.location.href = optvalue;
                            }
                            // else {
                            //     document.getElementById("film_tags").value = element;
                            //     show_film(element);
                            // }
                        }
                    </script>

                    <h5 id="mobidatesh5">
                        <select class='mobimthing' name="duttyCats" id="mobimcats" onchange="duttyCats(this.value)">
                            <?php 
                            if (get_option('theatre_section_override')) {
                                $section1 = 'Screen';
                                $section2 = 'Stage';
                            ?>
                                <option value="Now Showing" class="<?php if($selectedType=='Now Showing') : echo 'active'; endif; ?> category_select">
                                    <div><?php echo $section1; ?></div>
                                </option>
                                <option value="Coming Soon" class="<?php if($selectedType=='Coming Soon') : echo 'active'; endif; ?> category_select">
                                    <div><?php echo $section2; ?></div>
                                </option>
                            <?php } else {
                            if (!get_option('tab_hide_now_showing')) {?>
                                <option value="Now Showing" class="<?php if($selectedType=='Now Showing') : echo 'active'; endif; ?> category_select">
                                    <div><?php echo $tab_header_now_showing; ?></div>
                                </option>
                            <?php }
                            if (!get_option('tab_hide_new_releases')) {?>
                                <option value="New Release" class="<?php if($selectedType=='New Release'): echo 'active'; endif; ?> category_select">
                                    <div><?php echo $tab_header_new_releases; ?></div>
                                </option>
                            <?php }
                            if (!get_option('tab_hide_advance_sales')) {?>
                                <option value="Advance Sales" class="<?php if($selectedType=='Advance Sales'): echo 'active'; endif; ?> category_select">
                                    <div><?php echo $tab_header_advance_sales; ?></div>
                                </option>
                            <?php }
                            if (!get_option('tab_hide_all_performances')) {?>
                                <option value="All Performances" class="<?php if($selectedType=='All Performances'): echo 'active'; endif; ?> category_select">
                                    <div><?php echo $tab_header_all_performances; ?></div>
                                </option>
                            <?php }
                            }
                            
                        echo get_mobile_custom_filters(); ?>
                        </select>
                    </h5>
                </div>
                <!-- chrome friendly options JS --->
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        document.getElementById('mobimdates').addEventListener('change', function() {
                            duttyDate(this.value);
                        });
                    });
                    function duttyDate(selectedDate) {
                        document.getElementById("film_date").value = selectedDate;
                        //show_film(selectedDate);
                    }
                </script>
               
                <div class="col-lg-4" id="mobimdateshow">
                    <span>Select a Date</span>
                    <h5 id="mobidatesh5" class="jsf">
                        <select class="mobimthing" name="duttyDates" id="mobimdates" onchange="duttyDate(this.value)">
                            <option value="<?php echo date("Y-m-d",$date); ?>" class="<?php if($selectedDate==date("Y-m-d",$date)) : echo 'active'; endif; ?> film_date_value film-date-first" rel="<?php echo date("Y-m-d",$date); ?>">
                                <div><?php echo date("l",$date);?>&nbsp;</div>
                                <div>Today</div>
                            </option>
                            <option value="<?php echo date("Y-m-d",$date1); ?>" class="<?php if($selectedDate==date("Y-m-d",$date1)) : echo 'active'; endif; ?> film_date_value" rel="<?php echo date("Y-m-d",$date1); ?>">
                                <div><?php echo date("l",$date1);?>&nbsp;</div>
                                <div>Tomorrow</div>
                            </option>
                            <option value="<?php echo date("Y-m-d",$date2); ?>" class="<?php if($selectedDate==date("Y-m-d",$date2)) : echo 'active'; endif; ?> film_date_value" rel="<?php echo date("Y-m-d",$date2); ?>">
                                <div><?php echo date("l",$date2);?>&nbsp;</div>
                                <div><?php echo date($date_format_tabs,$date2);?></div>
                            </option>
                            <option value="<?php echo date("Y-m-d",$date3); ?>" class="<?php if($selectedDate==date("Y-m-d",$date3)) : echo 'active'; endif; ?> film_date_value" rel="<?php echo date("Y-m-d",$date3); ?>">
                                <div><?php echo date("l",$date3);?>&nbsp;</div>
                                <div><?php echo date($date_format_tabs,$date3);?></div>
                            </option>
                            <option value="<?php echo date("Y-m-d",$date4); ?>" class="<?php if($selectedDate==date("Y-m-d",$date4)) : echo 'active'; endif; ?> film_date_value" rel="<?php echo date("Y-m-d",$date4); ?>">
                                <div><?php echo date("l",$date4);?>&nbsp;</div>
                                <div><?php echo date($date_format_tabs,$date4);?></div>
                            </option>
                            <option value="<?php echo date("Y-m-d",$date5); ?>" class="<?php if($selectedDate==date("Y-m-d",$date5)) : echo 'active'; endif; ?> film_date_value" rel="<?php echo date("Y-m-d",$date5); ?>">
                                <div><?php echo date("l",$date5);?>&nbsp;</div>
                                <div><?php echo date($date_format_tabs,$date5);?></div>
                            </option>
                            <option value="<?php echo date("Y-m-d",$date6); ?>" class="<?php if($selectedDate==date("Y-m-d",$date6)) : echo 'active'; endif; ?> film_date_value" rel="<?php echo date("Y-m-d",$date6); ?>">
                                <div><?php echo date("l",$date6);?>&nbsp;</div>
                                <div><?php echo date($date_format_tabs,$date6);?></div>
                            </option>
                            <option value="<?php echo 'moredates'; ?>" class="<?php if($selectedDate=='moredates') : echo 'active'; endif; ?> film_date_value more_dates" rel="<?php echo 'moredates'; ?>">
                                <div><?php esc_html_e('All Shows', 'jacro'); ?></div>
                            </option>
                        </select>
                    </h5>
                </div>

            </div>
        </div>
        <!--- mobile ends --->
    </div>
            <!-- End Show Time Date Filter -->
    <!-- Main Film & Show Time Area -->
    <div class="row" id="film_section">
        <?php             
        $show_time_header = get_option("show_time_header");
        $tab_header_now_showing = get_option("tab_header_now_showing");
        $tab_header_advance_bookings = get_option("tab_header_advance_bookings");
        $tab_header_new_releases = get_option("tab_header_new_releases");
        $groupby_performance_modifiers = get_option("groupby_performance_modifiers");
        $date_sort_recent = (get_option("date-sort-recent")?get_option("date-sort-recent"):false);
        $eventlocation = get_option('includevenue');
        $order_by_date=false;
        if( $date_sort_recent && $selectedDate!='moredates' ){
            $order_by_date=true;
        }

        if (function_exists('fw_get_db_settings_option')) {
            $primaryColour = fw_get_db_settings_option('primary_colour');
            $secondaryColour = fw_get_db_settings_option('secondary_colour');
        } else {
            $primaryColour = get_option('primary_colour');
            $secondaryColour = get_option('secondary_colour'); 
        }

        $post_films = get_films( $selectedType, $default_selected, $selectedDate, $order_by_date );

        $fimlPerPage = 10;
        $count_time=0; $count_row=1;$datasarray = array();

        foreach($post_films['post'] as $key=>$film_val) {  

            $post_arr = get_performances( $film_val->code, $selectedDate ,$selectedType, $default_selected);

            $nc_filmclass = '';

            $default_image=$post_films['img'];
            if(!empty($post_arr)) {   
                $img_url=$film_val->img_1s;
                if(empty($img_url)){
                    $img_url=$default_image;
                } elseif (strpos($img_url, 'http') !== false){
                    $img_url=$film_val->img_1s;
                } else {
                    $img_url=$default_image;
                }
                $running_time=$film_val->runningtime;
                $certificate=$film_val->certificate;
                $genre=$film_val->genre;
                $flclass = strtolower(str_replace(' ', '_', $genre));
                $filmclass = ' filmecat'.preg_replace('/[^A-Za-z0-9]/', '', $flclass);

                $synopsis=balanceTags($film_val->synopsis, true);

                $id_3d=$film_val->is3d;
                $id_3d=filmCheckDimension($id_3d);

                $filmtitle = $film_val->filmtitle;
                $filmlink = $film_val->url;

                $perfclass = array(); $perfromanceclass=''; $dateclass = '';$timeclass = '';

                foreach($post_arr as $perfpost) {
                    $pfcatclass = strtolower(str_replace(' ', '_', $perfpost->perfcat));
                    $perfclass[] = ' percate'.preg_replace('/[^A-Za-z0-9]/', '', $pfcatclass);
                }
                $perfclass = array_unique($perfclass);
                $filmperfclass = implode(" ",$perfclass);

                foreach($post_arr as $val) {

                    $perform_date=$val->performdate;
                    $start_time=$val->starttime;             
                    $trailer_time=$val->trailertime;
                    $press_report=$val->pressreport;
                    $perf_cat=$val->perfcat;
                    $film_code=$val->filmcode;
                    $screen=$val->screen;
                    $soldoutlevel=$val->soldoutlevel;
                    $wheelchair_accessible=$val->wheelchairaccessible;
                    $subs=$val->subs;
                    $ad=$val->ad;
                    $perf_flags=$val->perfflags;

                    $ctclass = strtolower(str_replace(' ', '_', $perf_cat));
                    $nc_filmclass .= ' percate'.preg_replace('/[^A-Za-z0-9]/', '', $ctclass);

                    if(!empty($perf_flags)) {
                        $perf_flag_arr=explode("|",$perf_flags);
                        $mod_scores = show_modifiers($cinema);
                        $priority_mod = array_intersect_key($mod_scores,array_flip($perf_flag_arr));
                        $flagsarray = array();
                        foreach($priority_mod as $key=>$array_element) {
                            $flagsarray[] = $key;
                        }
                        $perf_flags=implode(",",$flagsarray);
                    }

                    $start_time=substr($start_time, 0, -3);

                    $termsID = $val->location;
                    $termname = jacro_theatre_name($termsID);
                    $theatre_name = strtolower(preg_replace('/[^\\pL\d]+/u', '-', $termname));

                    $approx_end_time = JacroCountApproxEndTime($start_time, $running_time, $trailer_time);        
                    $jacroCountryname = get_option('jacroCountry-'.$termsID);
                    $startTimeHourFormat = JacroTimeFormate($start_time, $jacroCountryname);
                    $approxEndTimeFormate = JacroTimeFormate($approx_end_time, $jacroCountryname);
                    $jacro_showtime_length = get_option('jacro_showtime_length');
                    $jacro_showtime_length = (($jacro_showtime_length!='')?$jacro_showtime_length:-1);                

                    if(strtotime("$perform_date $start_time") > $strtotimezone) {     

                        $datasarray[$perform_date][$filmtitle]['class'] = $filmclass.$filmperfclass.$dateclass.$timeclass;
                        $datasarray[$perform_date][$filmtitle]['permalink'] = $filmlink;
                        $datasarray[$perform_date][$filmtitle]['showTimeClass'] = $jacro_showtime_length;
                        $datasarray[$perform_date][$filmtitle]['title'] = $filmtitle;
                        $datasarray[$perform_date][$filmtitle]['img_url'] = $img_url;
                        if (!isset($datasarray[$perform_date][$filmtitle]['start_time'])) {
                            $datasarray[$perform_date][$filmtitle]['start_time'] = $start_time;
                        }
                        $datasarray[$perform_date][$filmtitle]['default_img_url'] = $default_image;
                        $datasarray[$perform_date][$filmtitle]['genre'] = $genre;
                        $datasarray[$perform_date][$filmtitle]['synopsis'] = $synopsis;
                        $datasarray[$perform_date][$filmtitle]['certs'] = $certificate;
                        $datasarray[$perform_date][$filmtitle]['runtime'] = $running_time;
                        $datasarray[$perform_date][$filmtitle]['IDs'][$val->id] = $val->id;
                        $datasarray[$perform_date][$filmtitle]['sorting_dates'] = $perform_date;
                        $datasarray[$perform_date][$filmtitle]['dates'][$perform_date] = $perform_date;
                        $datasarray[$perform_date][$filmtitle]['film_type'] = $selectedType;
                        $datasarray[$perform_date][$filmtitle]['film_date'] = $selectedDate;
                        $datasarray[$perform_date][$filmtitle][$val->id]['cinema_name'] = get_option('term_'.$default_selected);
                        $datasarray[$perform_date][$filmtitle][$val->id]['screen'] = $screen;
                        $datasarray[$perform_date][$filmtitle][$val->id]['special_fea'] = $perf_flags;
                        if (strpos($datasarray[$perform_date][$filmtitle][$val->id]['special_fea'],'AUT') !== false) {
                            $datasarray[$perform_date][$filmtitle][$val->id]['special_fea'] = str_replace('AUT', 'Autism Friendly', $datasarray[$perform_date][$filmtitle][$val->id]['special_fea']);
                        }
                        if (!empty($datasarray[$perform_date][$filmtitle][$val->id]['special_fea'])) {
                            $datasarray[$perform_date][$filmtitle][$val->id]['special_fea'] .= '</br>';
                        }else {
                            $datasarray[$perform_date][$filmtitle][$val->id]['special_fea'] = '';
                        }

                        $datasarray[$perform_date][$filmtitle][$val->id]['start_time'] = $startTimeHourFormat;
                        $datasarray[$perform_date][$filmtitle][$val->id]['certificate'] = $certificate;
                        $datasarray[$perform_date][$filmtitle][$val->id]['press_report'] = $press_report;
                        $datasarray[$perform_date][$filmtitle][$val->id]['perf_cat_class'] = $nc_filmclass;
                        $datasarray[$perform_date][$filmtitle][$val->id]['perf_cat_class_val'] = $perf_cat;
                        $datasarray[$perform_date][$filmtitle][$val->id]['approx_end_time'] = $approxEndTimeFormate;
                        $datasarray[$perform_date][$filmtitle][$val->id]['soldoutlevel'] = $soldoutlevel;
                        $datasarray[$perform_date][$filmtitle][$val->id]['ad'] = $ad;
                        if (strpos($datasarray[$perform_date][$filmtitle][$val->id]['ad'],'Y') !== false) {
                            $datasarray[$perform_date][$filmtitle][$val->id]['ad'] = str_replace('Y', '<i class="fa fa-audio-description" aria-hidden="true"></i>', $datasarray[$perform_date][$filmtitle][$val->id]['ad']);
                        } else {
                            $datasarray[$perform_date][$filmtitle][$val->id]['ad'] = '';
                        }
                        $datasarray[$perform_date][$filmtitle][$val->id]['is_3d'] = $id_3d;
                        if (strpos($datasarray[$perform_date][$filmtitle][$val->id]['is_3d'],'3D') !== false) {
                            $datasarray[$perform_date][$filmtitle][$val->id]['is_3d'] = str_replace('3D', '3D', $datasarray[$perform_date][$filmtitle][$val->id]['is_3d']);
                        }
                        else {
                            $datasarray[$perform_date][$filmtitle][$val->id]['is_3d'] = '';
                        }
                        $datasarray[$perform_date][$filmtitle][$val->id]['sub_title'] = $subs;
                        if (strpos($datasarray[$perform_date][$filmtitle][$val->id]['sub_title'],'Y') !== false) {
                            $datasarray[$perform_date][$filmtitle][$val->id]['sub_title'] = str_replace('Y', '<i class="fa fa-cc" aria-hidden="true"></i>', $datasarray[$perform_date][$filmtitle][$val->id]['sub_title']);
                        }
                        else {
                            $datasarray[$perform_date][$filmtitle][$val->id]['sub_title'] = '';
                        }
                        $datasarray[$perform_date][$filmtitle][$val->id]['access'] = $wheelchair_accessible;
                        if (strpos($datasarray[$perform_date][$filmtitle][$val->id]['access'],'Y') !== false) {
                            $datasarray[$perform_date][$filmtitle][$val->id]['access'] = str_replace('Y', '<i class="fa fa-wheelchair" aria-hidden="true"></i>', $datasarray[$perform_date][$filmtitle][$val->id]['access']);
                        }
                        else {
                            $datasarray[$perform_date][$filmtitle][$val->id]['access'] = '';
                        }
                        $datasarray[$perform_date][$filmtitle][$val->id]['book_now_url'] = home_url()."/".$theatre_name."/booknow/".$val->code;
                    }
                }
            }
        }

        $filspostshtml = '';
        if(get_option( 'homepage_layout') == 'posters' || get_option( 'homepage_layout') == 'detail'){
            $homepage_layout = get_option( 'homepage_layout');
        }
        else if(isset($_COOKIE['jacroFilmLayout']) && $_COOKIE['jacroFilmLayout']!='') {
            $homepage_layout = $_COOKIE['jacroFilmLayout'];
        }
        else{
            $homepage_layout = 'detail';
        }
        $poster_width_class = get_option('homepage_poster_width');
        $parent_poster_width_class = "grid".$poster_width_class;
        if($homepage_layout == 'posters') {
            $filspostshtml .= "<div id='PosterLayout' class ='".$parent_poster_width_class."'>";
        }

        $jacroMoreShowtimesLink = get_option('jacroMoreShowtimesLink');
        $jacroBookNowOpenLink = get_option('jacroBookNowOpenLink');

        $filspostshtml .= '<style>.perfbtn{color: #fff; background-color:' . $primaryColour . ' !important;}.perfbtn:hover{color:#fff !important; background-color:' . $secondaryColour . ' !important;} .moreshowtimes {background-image: linear-gradient(to right, ' . $primaryColour. ', ' . $secondaryColour  . ') !important;}.moreshowtimes:hover {color: #fff !important; background-image: linear-gradient(to right, ' . $secondaryColour. ', ' . $secondaryColour  . ') !important;}</style>';

        if(isset($datasarray)&&!empty($datasarray)) { 

            $countFilms=count($datasarray);

            ksort($datasarray);
            $existing_tmp = array();  
            foreach($datasarray as $file_date=>$films_datast) {

                usort($films_datast, 'prformanceSorting');

                $films_data = array();
                foreach($films_datast as $newfdate){
                    $films_data[$newfdate['title']]=$newfdate;
                }

                foreach($films_data as $file_title=>$films){   
                    if($selectedDate=='moredates' || $selectedType!='Now Showing') {
                        if(in_array($file_title, $existing_tmp)){
                            continue;
                        } else {
                            $existing_tmp[]=$file_title;
                        }
                    }

                    $firstShowDate = 0;
                    $bookNowNewTarget=''; if($jacroBookNowOpenLink==true) { $bookNowNewTarget = '_blank'; }
                    $moreShowTimeTarget=''; if($jacroMoreShowtimesLink==true) { $moreShowTimeTarget = '_blank'; }
                    /*** START FILM CONTAINER ***/
                    /*** GRAB SUPER COOL STYLING ***/
                    $class_array = explode(' ', $films['class']);
                    $class_array_unique = array_unique($class_array);
                    $class_string_unique = implode(' ', $class_array_unique);
                    if($homepage_layout == 'detail') {
                        $filspostshtml .= '<div class="row movie-tabs'.$class_string_unique.'">';
                        /*** POSTER ***/

                        $filspostshtml .= '<div class="col-md-2 col-sm-3 col-xs-12"><a href="'.$films['permalink'].'" target="'.$moreShowTimeTarget.'"><img id="jacroappimg" alt="" src="'.$films['img_url'].'" onError="this.onerror=null;this.src=\''.$films['default_img_url'].'\';"</a></div>';
                        /*** INFO SECTION ***/
                        $filspostshtml .= '<div class="col-md-10 col-sm-9 col-xs-12">';
                            /*** TITLE ***/
                        $filspostshtml .= '<header><h3 class="no-underline"><a style="color: #101010;" href="'.$films['permalink'].'" target="'.$moreShowTimeTarget.'">'.$films['title'].'</a></h3>';

                        /*** GENRE INFO
                        $filspostshtml .= '<span class="title">'.$films['genre'].'</span>';***/
                        $filspostshtml .= '<p>'.htmlsafe_truncate($films['synopsis'], 180, array('html' => true, 'ending' => ' ...', 'exact' => false)).'</p><p><a id="tempsynoplink" href="'.$films['permalink'].'" class="arrow-button">Full synopsis</a></p>';

                        if($selectedType != 'Coming Soon') {
               
                            /*** PERF & CERTS ETC ***/
                            $filspostshtml .= '<div class="row"><div class="col-md-8 col-sm-9 time2">';
                            $filspostshtml .= '<div style="margin-top:5px;">';
                                /*** SHOW TIME "logic" ***/
                                $jacroListClass = 'jacro-showtime-list';
                                if($selectedDate=='moredates' || $selectedType!='Now Showing') {
                                    $jacroListClass = 'jacro-date-showtime-list';
                                }
                                $trueMoreShowTime = true;

                                if($selectedType!='New Release') { 

                                    $filspostshtml .= '<div class="'.$jacroListClass.'">';
                                    $jacroTotalShowTime = 0; $jacroMoreShowTimeFlage = 1; $jacroCountDate = 0;

                                    $filspostshtml .='<div class="neworderpf">';
                                    $allprtimes = array();
                                    foreach($films['IDs']  as $pkey => $pval){                              
                                        $allprtimes[$pval]=strtotime($films[$pval]['start_time']);
                                    }

                                    asort($allprtimes);
                                    $key_array = array();
                                    $picount = 0;

                                    foreach($allprtimes  as $performace_id=>$keydate) {

                                        if (in_array($films[$performace_id]['start_time'], $key_array)) {
                                            continue;
                                        }
                                        $key_array[$picount] = $films[$performace_id]['start_time'];
                                        $picount++;

                                        $date= $file_date;
                                        if($films['showTimeClass']!=-1) {
                                            if(($jacroTotalShowTime>$films['showTimeClass'])&&($trueMoreShowTime==true)) {
                                                $trueMoreShowTime = false;
                                            }
                                            $jacroCountDate++;
                                        }
                                        if(isset($films[$performace_id]) && ($films[$performace_id]!='')) {
                                            $jacroTotalShowTime=($jacroTotalShowTime+1);
                                            if($films['showTimeClass']!=-1) {
                                                if(($jacroTotalShowTime>$films['showTimeClass'])&&($trueMoreShowTime==true)) {
                                                    $trueMoreShowTime = true;
                                                        //break;
                                                }
                                            }
                                            if($firstShowDate==0) {
                                                $jacroDateFormate = JacroDateFormate($films['sorting_dates']);
                                                if($films['film_type']!='Now Showing' || $films['film_date']=='moredates'):
                                                    $filspostshtml .= '<span style="margin-right: 18px;">'.$jacroDateFormate.'</span></br>';
                                                endif;
                                            }

                                            $show_perf = '';                     
                                            if(!empty($films[$performace_id]['special_fea'])){
                                                $show_perf='<p class="heading "><span class="popup_left_text">Special Features:</span><span class="popup_right_text">'.$films[$performace_id]['special_fea'].'</span></p>';
                                            }
                                            
                                            if ($groupby_performance_modifiers) {   
                                                
                                            } else { 
                                                $jacroShowTimeHour = get_option('jacroShowTimeHour');
                                                if($jacroShowTimeHour == true) {
                                                    $jacrobookTimeFormat = date("g:i a", strtotime($films[$performace_id]['start_time']));
                                                } else {
                                                    $jacrobookTimeFormat = date("H:i", strtotime($films[$performace_id]['start_time']));
                                                }

                                                $pfclass_array = explode(' ', $films[$performace_id]['perf_cat_class']);
                                                $pfclass_array_unique = array_unique($pfclass_array);
                                                $pfclass_string_unique = implode(' ', $pfclass_array_unique);

                                                $filspostshtml .= '<div class="1 singlefilmperfs '.$pfclass_string_unique.'">';
                                                   
                                                if ($films[$performace_id]['press_report']== 'N') {
                                                    $filspostshtml .= '<a class="perfbtn disabled" title="Please contact the Box Office to book">'.$jacrobookTimeFormat.'</a>';
                                                } else {
                                                    
                                                    $perfcat_category_message = get_option('perfcat_category_message');
                                                    $pfbtntxt = '';$pfbtnmsg = '';$alertinfo = '';
                                                    if($perfcat_category_message){  
                                                        if($films[$performace_id]['perf_cat_class_val'] == $perfcat_category_message[$films[$performace_id]['perf_cat_class_val']]['name']){
                                                            $pfbtntxt = $perfcat_category_message[$films[$performace_id]['perf_cat_class_val']]['name'];
                                                            if($perfcat_category_message[$films[$performace_id]['perf_cat_class_val']]['message']){
                                                                $alertinfo = 'onclick="showperfinfo(this, event)"';
                                                                $pfbtnmsg  = $perfcat_category_message[$films[$performace_id]['perf_cat_class_val']]['message'];
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
                                                    	if($films[$performace_id]['soldoutlevel'] && $films[$performace_id]['soldoutlevel']=='Y'){
                                                    		$filspostshtml .= '<a class="perfbtn 1 disabled">Sold Out</a>';
                                                    	}else{
                                                        	$filspostshtml .= '<a class="perfbtn 1" '.$alertinfo.' href="'.$films[$performace_id]['book_now_url'].'">'.get_option('showtime_button_text').' '.$jacrobookTimeFormat.' '.$pfbtntxt.'</a>';
                                                        }
                                                    }else{
                                                    	if($films[$performace_id]['soldoutlevel'] && $films[$performace_id]['soldoutlevel']=='Y'){
                                                    		$filspostshtml .= '<a class="perfbtn 1 disabled">Sold Out</a>';
                                                    	}else{
                                                        	$filspostshtml .= '<a class="perfbtn 1.1" '.$alertinfo.' href="'.$films[$performace_id]['book_now_url'].'">'.$jacrobookTimeFormat.' '.$pfbtntxt.'</a>';
                                                        }
                                                    }
                                                    $filspostshtml .= '<input type="hidden" class="perfcat_message" value="'.$pfbtnmsg.'">';
                                                }
                                                $filspostshtml .= '</br>';
                                                if($films[$performace_id]['special_fea']){
                                                    $filspostshtml .= '<span>'.$films[$performace_id]['special_fea'].' </span>';
                                                }if($films[$performace_id]['ad']){
                                                    $filspostshtml .= '<span class="perfad">'.$films[$performace_id]['ad'].' </span>';
                                                }if($films[$performace_id]['sub_title']){
                                                    $filspostshtml .= '<span>'.$films[$performace_id]['sub_title'].'</span>';
                                                }if($films[$performace_id]['is_3d']){
                                                    $filspostshtml .= '<span>'.$films[$performace_id]['is_3d'].' </span>';
                                                }
                                                // if($films[$performace_id]['access']){
                                                //     $filspostshtml .= '<span class="wheelchair_icn"> '.$films[$performace_id]['access'].'</span>';
                                                // }
                                                $filspostshtml .= '</div>';
                                            }

                                            $firstShowDate++;
                                        }

                                        if($films['film_type']!='Now Showing' || $films['film_date']=='moredates'){ $filspostshtml .= ''; }
                                    }
                                    $filspostshtml .= '</div>';  
                                   
                                    $allprtimes = array();

                                    foreach($films['IDs']  as $pkey => $pval){                              
                                        $allprtimes[$pval]=strtotime($films[$pval]['start_time']);
                                    }
                                    
                                    asort($allprtimes);
                                    $prcatdata = 1;
                                    $newarcat = array();
                                    $arct = array();
                                    $key_array = array();
                                    $picount = 0;
           
                                    foreach($allprtimes  as $performace_id=>$keydate) {              
                                        if (in_array($films[$performace_id]['start_time'], $key_array)) {
                                            continue;
                                        }
                                        $key_array[$picount] = $films[$performace_id]['start_time'];
                                        $picount++;
                                        $arct[$films[$performace_id]['perf_cat_class']][$performace_id] = $films[$performace_id]['perf_cat_class'];
                                    }
                                    foreach($arct as $keytop => $valtop) { 
                                        $totalpr = count($valtop);
                                        $sameprct = 1;
                                        $filspostshtml .='<div class="innercatdived" style="display:none;">';
                                        foreach ($valtop as $performace_id => $classname) {   
                                            $date= $file_date;
                                            if($films['showTimeClass']!=-1) {
                                                if(($jacroTotalShowTime>$films['showTimeClass'])&&($trueMoreShowTime==true)) {
                                                    $trueMoreShowTime = false; 
                                                }
                                                $jacroCountDate++;
                                            }
                                            if(isset($films[$performace_id]) && ($films[$performace_id]!='')) {    
                                                $jacroTotalShowTime=($jacroTotalShowTime+1);
                                                if($films['showTimeClass']!=-1) {
                                                    if(($jacroTotalShowTime>$films['showTimeClass'])&&($trueMoreShowTime==true)) {
                                                        $trueMoreShowTime = true;
                                                    }
                                                }
                                                if($firstShowDate==0) {
                                                    $jacroDateFormate = JacroDateFormate($films['sorting_dates']);
                                                    if($selectedType!='Now Showing' || $selectedDate=='moredates'){
                                                        $filspostshtml .= '<span style="margin-right: 18px;">'.$jacroDateFormate.'</span></br>';
                                                    }
                                                }

                                                $show_perf = '';                     
                                                if(!empty($films[$performace_id]['special_fea'])){
                                                    $show_perf='<p class="heading "><span class="popup_left_text">Special Features:</span><span class="popup_right_text">'.$films[$performace_id]['special_fea'].'</span></p>';
                                                }
                                               

                                                if ($groupby_performance_modifiers) {       
                                                                
                                                } else {
       
                                                    $jacroShowTimeHour = get_option('jacroShowTimeHour');
                                                    if($jacroShowTimeHour == true) {
                                                        $jacrobookTimeFormat  = date("g:i a", strtotime($films[$performace_id]['start_time']));
                                                    } else {
                                                        $jacrobookTimeFormat  = date("H:i", strtotime($films[$performace_id]['start_time']));
                                                    }

                                                    $indexes = array_keys($newarcat, $films[$performace_id]['perf_cat_class']);

                                                    $pfclass_array = explode(' ', $films[$performace_id]['perf_cat_class']);
                                                    $pfclass_array_unique = array_unique($pfclass_array);
                                                    $pfclass_string_unique = implode(' ', $pfclass_array_unique);

                                                    $filspostshtml .= '<div class="1.a singlefilmperfs '.$pfclass_string_unique.' count'.count($indexes).'">';
                                                    $newarcat[] = $films[$performace_id]['perf_cat_class'];
                                                    $prcatdata ++;
                                                    
                                                    if ($films[$performace_id]['press_report']== 'N') {
                                                        $filspostshtml .= '<a class="perfbtn disabled " title="Please contact the Box Office to book">'.$jacrobookTimeFormat.'</a>';
                                                    } else {
                                                        $perfcat_category_message = get_option('perfcat_category_message');
                                                        $pfbtntxt = '';$pfbtnmsg = '';$alertinfo = '';
                                                        if($perfcat_category_message){
                                                            if($films[$performace_id]['perf_cat_class_val'] == $perfcat_category_message[$films[$performace_id]['perf_cat_class_val']]['name']){
                                                                $pfbtntxt = $perfcat_category_message[$films[$performace_id]['perf_cat_class_val']]['name'];
                                                                if($perfcat_category_message[$films[$performace_id]['perf_cat_class_val']]['message']){
                                                                    $alertinfo = 'onclick="showperfinfo(this, event)"';
                                                                    $pfbtnmsg  = $perfcat_category_message[$films[$performace_id]['perf_cat_class_val']]['message'];
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
                                                        	if($films[$performace_id]['soldoutlevel'] && $films[$performace_id]['soldoutlevel']=='Y'){
                                                        		$filspostshtml .= '<a class="perfbtn 1 disabled">Sold Out</a>';
                                                        	}else{
                                                        		$filspostshtml .= '<a class="perfbtn 1" '.$alertinfo.' href="'.$films[$performace_id]['book_now_url'].'">'.get_option('showtime_button_text').' '.$jacrobookTimeFormat.' '.$pfbtntxt.'</a>';
                                                        	}
                                                        }else{
                                                        	if($films[$performace_id]['soldoutlevel'] && $films[$performace_id]['soldoutlevel']=='Y'){
                                                        		$filspostshtml .= '<a class="perfbtn 1 disabled">Sold Out</a>';
                                                        	}else{
                                                            	$filspostshtml .= '<a class="perfbtn 1.1a" '.$alertinfo.' href="'.$films[$performace_id]['book_now_url'].'">'.$jacrobookTimeFormat.' '.$pfbtntxt.'</a>';
                                                            }
                                                        }
                                                        $filspostshtml .= '<input type="hidden" class="perfcat_message" value="'.$pfbtnmsg.'">';
                                                        if($totalpr == $sameprct){
                                                            $filspostshtml .= '<span class="filter_percat filter-'.$films[$performace_id]['perf_cat_class'].'">'.$films[$performace_id]['perf_cat_class_val'].'</span>';
                                                        }
                                                        $sameprct++;
                                                    }
                                                    $filspostshtml .= '</br>';
                                                    if($films[$performace_id]['special_fea']){
                                                        $filspostshtml .= '<span>'.$films[$performace_id]['special_fea'].' </span>';
                                                    }if($films[$performace_id]['ad']){
                                                        $filspostshtml .= '<span class="perfad">'.$films[$performace_id]['ad'].' </span>';
                                                    }if($films[$performace_id]['sub_title']){
                                                        $filspostshtml .= '<span>'.$films[$performace_id]['sub_title'].'</span>';
                                                    }if($films[$performace_id]['is_3d']){
                                                        $filspostshtml .= '<span>'.$films[$performace_id]['is_3d'].' </span>';
                                                    }
                                                    // if($films[$performace_id]['access']){
                                                    //     $filspostshtml .= '<span class="wheelchair_icn"> '.$films[$performace_id]['access'].'</span>';
                                                    // }
                                                    $filspostshtml .= '</div>';
                                                }

                                                $firstShowDate++;
                                            }

                                            if($films['film_type']!='Now Showing' || $films['film_date']=='moredates'){ $filspostshtml .= ''; }
                                        }
                                        $filspostshtml .= '</div>';        
                                    }
                                    
                                    if($trueMoreShowTime==true||($jacroCountDate>=1)) {
                                        $more_showtimes_html = '<a href="'.$films['permalink'].'" class="moreshowtimes" target="'.$moreShowTimeTarget.'">More showtimes</a>';
                                    }

                                    $filspostshtml .= '</div>';
                                    
                                } else {
                                    if (!$groupby_performance_modifiers) { 
                                        $more_showtimes_html = '<a href="'.$films['permalink'].'" class="moreshowtimes" target="'.$moreShowTimeTarget.'">Showtimes</a>';
                                    }
                                }

                                $filspostshtml .= '</div>';

                                /*** "logic" ends ***/
                                    
                                if ($groupby_performance_modifiers) { 
                                    // JIRA - Add formatted showtimes_html to the page
                                    $filspostshtml .= generate_showtime_html($films, $arct);
                                    $filspostshtml .= $more_showtimes_html; 
                                } else { }
                            $filspostshtml .= '</div></div>';             

                        }
                            
                        /*** RUN TIME, CERT, MODS ***/
                        $filspostshtml .= '<div class="col-md-4 col-sm-3 running-time"><hr class="space-10"/>';
                        if ($films['runtime']) {
                            $filspostshtml .= '<i style="padding-right:5px;"class="fa fa-film"></i>'.$films['runtime'].' mins';
                        }if ($films['certs']) {
                        $filspostshtml .= '<span style="margin-left:10px;"class="certificate"> '.$films['certs'].'</span>';
                        }if ($films['genre'] && $films['genre'] != 'None') {
                            $filspostshtml .= '<span style="margin-left:10px;"class="genredescription"> '.$films['genre'].'</span>';
                        }
                        $filspostshtml .= '</div>';
                        /*** FILM CONTAINER ENDS ***/
                        $filspostshtml .= '</div></div>';
                        
                    } else {
                        $cl_layout = '';
                        foreach($films['IDs']  as $val){                                   
                            $cl_layout = $films[$val]['perf_cat_class'];
                        }

                        $filspostshtml .= '<div class="poster-case hvr-sweep-to-top '.$poster_width_class.' '.$cl_layout.'" onclick=""  aria-haspopup="true">';
                        $filspostshtml .= '<div class="'.$films['class'].' poster-img result_listing">';                

                        if ($films['img_url'] == 'None') {
                            $filspostshtml .= '<div class="missing_img '.$poster_width_class.'">';
                            $filspostshtml .= '<img class = "poster-missing-img"  alt="'.$films['title'].'" src="'.esc_url($logo['url']).'" >';
                            $filspostshtml .= '</div>';
                        } else { 
                            $filspostshtml .= '<img class = "poster-img '.$poster_width_class.'"  alt="'.$films['title'].'" src="'.$films['img_url'].'" onError="this.onerror=null;this.src=\''.$films['default_img_url'].'\';">';
                        }
                        $filspostshtml .= '</div>';
                        $filspostshtml .= '<a  class="poster-text " style="font-size:15px;color: #101010;" href="'.$films['permalink'].'">';
                        $filspostshtml .= '<span class="poster-title">'.$films['title'].'</span>';
                        $filspostshtml .= '<div class="poster-running"><i style="padding-right:5px;" class="fa fa-film"></i>'.$films['runtime'].' mins</div>';

                        if(!empty($films['certs'])) {
                        $filspostshtml .= '<div class="poster-rating" style="width:100%;text-align:center;" >'.$films['certs'].'</div>';
                        }

                        if ($films['genre'] != 'None') {
                            $filspostshtml .= "<div style='padding-top:10px;'>";
                            $filspostshtml .= '<span style=""><b>'.$films['genre'].'</b></span>';
                            $filspostshtml .= '</div>';
                        }
                        $filspostshtml .= '</a>';
                                                
                        if(get_option('posterlayoutopt') == 'poster_btn'){   
                            $filspostshtml .= '<style>.book-now-btn a {background-image: linear-gradient(to right, '. $primaryColour.', '.$secondaryColour.') !important;} .book-now-btn a:hover {color: #fff !important;}</style>';
                            $filspostshtml .= '<div class="book-now-btn"><a href="'.$films['permalink'].'" class="afterpostrlink"><span>Book Now</span></a></div>';
                        }else{
                            $filspostshtml .= "<div class = 'poster-banner'>".$films['title']."</div>";
                        }
                                                                                                            
                        $filspostshtml .= '</div>';
                    }                

                    $count_row++;
                }
            }
        }

        if($homepage_layout == 'posters') {
            $filspostshtml .= "</div>";
        }

        if($count_row==1) {
            $filspostshtml .= '<div class="col-xs-12 col-sm-4 col-md-4 main-film-area"> <p>No Films Available.</p> </div>';
        }
        //if(isset($selectedDate)) {
            //setcookie('jacroFilmDate', $selectedDate, time()+120, '/');
        //}
        //if(isset($selectedType) && $selectedType !='') {
            //setcookie('jacroFilmType', $selectedType, time()+120, '/');
        //}

        echo $filspostshtml;

        ?>
    </div>
    <!-- End Main Film & Show Time Area -->
    <div style="display:none;" id="process_running" class="">
        <p>Please wait while we fetch the latest performance times</p>
    </div>

    <div style="display:none;" id="layout_changing" class="">
        <p>Please wait while we change the layout...</p>
    </div>

<?php endif; ?>