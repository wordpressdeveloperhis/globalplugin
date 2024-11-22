<?php
/**
*   Plugin Name: JACRO Ticketing System
*   Plugin URI: https://jackroe.com
*   Version: 6.7.0
*   Description: JACRO Ticketing Plugin
*   Author: JACRO
*   Author URI: https://jackroe.com
*/

include 'showtime_html.php';
//include 'jacro-logs.php';

$siteurl = home_url();
define('CINEMA_FILE_PATH', dirname(__FILE__));
define('CINEMA_FOLDER', dirname(plugin_basename(__FILE__)));
define('CINEMA_DIR_NAME', basename(CINEMA_FILE_PATH));
define('CINEMA_URL', plugin_dir_url(__FILE__));
define('GIFTURL', 'https://cineticketing.com/websales/sales/');
define('SITEURL', $siteurl);
define('CUSTOM_FILTER_OPTION', 5);

function cinema_scripts() {
    wp_enqueue_style('jacro-bootstrap-min-css', plugin_dir_url( __FILE__ ). 'css/bootstrap.min.css' );
    wp_enqueue_style('jacro-style-css', plugin_dir_url( __FILE__ ) . 'css/style.css' );
    wp_enqueue_style('jacro-style-dash', plugin_dir_url( __FILE__ ) . 'css/dashicons.css' );
    wp_enqueue_style('jacro-style-dashmin', plugin_dir_url( __FILE__ ) . 'css/dashicons.min.css' );
    wp_enqueue_style('fontawesome-css', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css' );
    wp_enqueue_style('jacro-venobox', plugin_dir_url( __FILE__ ) . 'css/venobox.css' );
    wp_enqueue_style('jacro-event-calendar', plugin_dir_url( __FILE__ ) . 'css/mini-event-calendar.min.css' );
    wp_enqueue_script('jquery');
    wp_enqueue_script('jacro-bootstrap-min-js', plugin_dir_url( __FILE__ ). 'js/bootstrap.min.js' );
    wp_enqueue_script ('jacro-iframe-resizer-min-js', plugin_dir_url( __FILE__ ) . 'js/iframeResizer.min.js', array('jquery') );
    wp_register_script ('jacro-caleandar-js', plugin_dir_url( __FILE__ ) . 'js/caleandar.js', array('jquery'), '', true );
    wp_register_style ('jacro-caleandar-css', plugin_dir_url( __FILE__ ).'css/caleandar.css' );
    wp_register_style ('jacro-select2-css', plugin_dir_url( __FILE__ ).'css/select2.min.css' );
    wp_register_script ('jacro-select2-js', plugin_dir_url( __FILE__ ) . 'js/select2.min.js', array('jquery') );
    wp_enqueue_script('jacro-cinema-custom-js', plugin_dir_url( __FILE__ ) . 'js/script.js', array('jquery'));
    wp_localize_script('jacro-cinema-custom-js', 'cinema_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'siteurl' => home_url() ) );
    wp_enqueue_script('jacro-venobox-js', plugin_dir_url( __FILE__ ) . 'js/venobox.min.js', array('jquery'));
    wp_enqueue_script('jacro-event-calendar-js', plugin_dir_url( __FILE__ ) . 'js/mini-event-calendar.min.js', array('jquery'));
}
add_action('wp_enqueue_scripts','cinema_scripts');

include_once(CINEMA_FILE_PATH.'/jacro-movies-slider.php');

/** include db file **/
include_once(CINEMA_FILE_PATH.'/includes/db.php');

/** Admin enqueue **/
function JacroImageUploadJs(){
    wp_enqueue_media();
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_style('jacro-admin-custom-css', CINEMA_URL.'css/admin-custom.css' );
    wp_enqueue_script('jacro-admin-custom-js', CINEMA_URL.'js/admin-custom.js' );
}
add_action('admin_enqueue_scripts','JacroImageUploadJs');

/* menu and sub pages */
function cinema_admin_menu() {
    add_menu_page('Ticketing', 'Ticketing', "manage_options", 'locations', 'theatres');
    add_submenu_page('locations', 'Customer', 'Customer', 'manage_options', 'locations');
    add_submenu_page('locations', 'Locations', 'Locations', 'edit_pages', 'location_list', 'location_list');
    add_submenu_page('locations', 'Films', 'Films', 'edit_pages', 'film_list', 'film_list');
    add_submenu_page('locations', 'Settings', 'Settings', 'edit_pages', 'jacrosettings', 'jacrosettings');
    add_submenu_page('locations', 'Error Log', 'Error Log', 'edit_pages', 'jacro-error-log', 'jacro_error_log');
    add_submenu_page('locations', 'Documentation', 'Documentation', 'manage_options', 'documentation', 'documentation');

    add_submenu_page(NULL, '', '', 'edit_pages', 'edit', 'edit');
    add_submenu_page(NULL, '', '', 'edit_pages', 'datafeed_save', 'datafeed_save');
    add_submenu_page(NULL, '', '', 'edit_pages', 'add-location', 'add_theatre');
    add_submenu_page(NULL, '', '', 'edit_pages', 'edit-location', 'edit_theatre');
    add_submenu_page(NULL, '', '', 'edit_pages', 'locationfeed-save', 'theatrefeed_save');
    add_submenu_page(NULL, '', '', 'edit_pages', 'view_film', 'view_film');
    add_submenu_page(NULL, '', '', 'edit_pages', 'performance_list', 'performance_list');
    add_submenu_page(NULL, '', '', 'edit_pages', 'view_performance', 'view_performance');
    add_submenu_page(NULL, '', '', 'edit_pages', 'jacroShowTimeWidgets', 'jacroShowTimeWidgets');
    add_submenu_page(NULL, '', '', 'edit_pages', 'jacroImageWidgets', 'jacroImageWidgets');
    add_submenu_page(NULL, '', '', 'edit_pages', 'jacroGiftCardWidgets', 'jacroGiftCardWidgets');
    add_submenu_page(NULL, '', '', 'edit_pages', 'film_detail', 'film_detail');
    add_submenu_page(NULL, '', '', 'edit_pages', 'facebook_app', 'facebook_app');
    add_submenu_page(NULL, '', '', 'edit_pages', 'show_film', 'show_film');
    add_submenu_page(NULL, '', '', 'edit_pages', 'film_section', 'film_section');
    add_submenu_page(NULL, '', '', 'edit_pages', 'single_film', 'jacro-single-film');
    add_submenu_page(NULL, '', '', 'edit_pages', 'delete_all_films', 'delete_all_films');
    add_submenu_page(NULL, '', '', 'edit_pages', 'jacro-clear-error', 'jacro_clear_error');
}
add_action('admin_menu','cinema_admin_menu');
add_action('widgets_init','jacroLoadWidget');

// Register and load the widget
function jacroLoadWidget() {
    register_widget('JacroWidget');
    register_widget('JacroAppDownload');
    register_widget('jacroGiftCard');
}

/** Remove Http  **/
function removeHttp($url) {
    $disallowed = array('http://', 'https://', 'http://www.','https://www.','www.');
    foreach($disallowed as $d) {if(strpos($url, $d) === 0) {return str_replace($d, '', $url);}}
    return $url;
}

/* html truncate structure */
function htmlsafe_truncate($text, $length = 100, $options = array()) {
    $default = array(
        'ending' => '...', 'exact' => true, 'html' => false
    );
    $options = array_merge($default, $options);
    extract($options);

    if ($html) {
        if (mb_strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
            return $text;
        }
        $totalLength = mb_strlen(strip_tags($ending));
        $openTags = array();
        $truncate = '';

        preg_match_all('/(<\/?([\w+]+)[^>]*>)?([^<>]*)/', $text, $tags, PREG_SET_ORDER);
        foreach ($tags as $tag) {
            if (!preg_match('/img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param/s', $tag[2])) {
                if (preg_match('/<[\w]+[^>]*>/s', $tag[0])) {
                    array_unshift($openTags, $tag[2]);
                } else if (preg_match('/<\/([\w]+)[^>]*>/s', $tag[0], $closeTag)) {
                    $pos = array_search($closeTag[1], $openTags);
                    if ($pos !== false) {
                        array_splice($openTags, $pos, 1);
                    }
                }
            }
            $truncate .= $tag[1];

            $contentLength = mb_strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $tag[3]));
            if ($contentLength + $totalLength > $length) {
                $left = $length - $totalLength;
                $entitiesLength = 0;
                if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $tag[3], $entities, PREG_OFFSET_CAPTURE)) {
                    foreach ($entities[0] as $entity) {
                        if ($entity[1] + 1 - $entitiesLength <= $left) {
                            $left--;
                            $entitiesLength += mb_strlen($entity[0]);
                        } else {
                            break;
                        }
                    }
                }

                $truncate .= mb_substr($tag[3], 0 , $left + $entitiesLength);
                break;
            } else {
                $truncate .= $tag[3];
                $totalLength += $contentLength;
            }
            if ($totalLength >= $length) {
                break;
            }
        }
    } else {
        if (mb_strlen($text) <= $length) {
            return $text;
        } else {
            $truncate = mb_substr($text, 0, $length - mb_strlen($ending));
        }
    }
    if (!$exact) {
        $spacepos = mb_strrpos($truncate, ' ');
        if (isset($spacepos)) {
            if ($html) {
                $bits = mb_substr($truncate, $spacepos);
                preg_match_all('/<\/([a-z]+)>/', $bits, $droppedTags, PREG_SET_ORDER);
                if (!empty($droppedTags)) {
                    foreach ($droppedTags as $closingTag) {
                        if (!in_array($closingTag[1], $openTags)) {
                            array_unshift($openTags, $closingTag[1]);
                        }
                    }
                }
            }
            $truncate = mb_substr($truncate, 0, $spacepos);
        }
    }
    $truncate .= $ending;

    if ($html) {
        foreach ($openTags as $tag) {
            $tag = str_replace(array('\r\n', '\n\r', '\n', '\r'), '<br>', $tag);

            $truncate .= '</'.$tag.'>';
        }
    }

    return $truncate;
}

add_action('wp_head','jacroHeaderCode');
function jacroHeaderCode() {
    global $wp_query;
    JacroColorSettingsLoad();
    $siteurl = home_url();
    $domainName = removeHttp($siteurl);
    $domainName = str_replace('www.', '', $domainName);
    if (!array_key_exists( 'booknow', $wp_query->query_vars ) && !array_key_exists('theater-name', $wp_query->query_vars)) {
        $googleAnalyticsCode = stripslashes(get_option('google_analytics_code')); ?>
        <script>
            if (window.ga && ga.loaded) {
                (function(i,s,o,g,r,a,m){
                    i['GoogleAnalyticsObject']=r;
                    i[r]=i[r]||function(){
                        (i[r].q=i[r].q||[]).push(arguments)
                    },i[r].l=1*new
                    Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

                ga('create', '<?php echo $googleAnalyticsCode; ?>', '<?php echo $domainName; ?>',  {'cookieName': 'jacroGoogleAnalytic'});
                ga('require', 'linker');
                ga('require', 'ecommerce', 'ecommerce.js');
                ga('linker:autoLink', ['jack-roe.co.uk']);
                ga('send', 'pageview');
                ga('set', 'anonymizeIp', true);

                ga(function (tracker) {
                    clientId = tracker.get('clientId');
                    var dataCookie = { 'action' : 'jacroGetCookies', 'jacroCookie' : clientId, };
                    jQuery.ajax({ type: 'POST', url: '<?php echo admin_url( "admin-ajax.php" ); ?>', data: dataCookie, async: false, success: function (response) {}});
                });
            }
        </script><?php
    }
    $jacroLoader = get_option('jacro-loader-image');
    if($jacroLoader!='') :
        $jacroLoaderImagePath = wp_get_attachment_url( $jacroLoader);
    else :
        $jacroLoaderImagePath = CINEMA_URL.'images/jacro-loader.svg';
    endif; ?>
    <style>
    .jacro-loader {
        background: url(<?php echo $jacroLoaderImagePath; ?>) repeat scroll 0 0 / 100px 100px; top: 40%; left: 45%;
    }
    </style>
    <div class='jacro-loader-overlay'><div class='jacro-loader'></div></div>
    <?php
}

function JacroColorSettingsLoad() {
    $settingsOption = 'jacroColorSettings';
    $jacroColorsSettings = JacroGetSettigns($settingsOption);
    ?>
    <style type='text/css'>
        /** Main Container Color **/
        .jacro-container {
            background:<?php echo (isset($jacroColorsSettings['jacroContainerColor'])?esc_attr($jacroColorsSettings['jacroContainerColor']):''); ?> !important;
        }
        /** Show Time Button **/
        .btn.date_time_btn, .book a, .film_single a {
            background:<?php echo (isset($jacroColorsSettings['jacroButtonColor'])?esc_attr($jacroColorsSettings['jacroButtonColor']):''); ?> !important;
            color:<?php echo (isset($jacroColorsSettings['jacroButtonTextColor'])?esc_attr($jacroColorsSettings['jacroButtonTextColor']):''); ?> !important;
        }
        /** Title Color **/
        .popup-inner h4, .film-title a, .film-title, .poster_name h3 strong, .poster_info h3, .film-head h3, .brand_time h3, .select-cinema, .jacro-widgets-images h3.widget-title, .jacro-widgets h3.widget-title, .jacro-widgets-giftcard h3.widget-title {
            color:<?php echo (isset($jacroColorsSettings['jacroTitleColor'])?esc_attr($jacroColorsSettings['jacroTitleColor']):''); ?> !important;
        }
        /** Title Hover Color **/
        .film-title a:hover {
            color:<?php echo (isset($jacroColorsSettings['jacroTitleHoverColor'])?esc_attr($jacroColorsSettings['jacroTitleHoverColor']):''); ?> !important;
        }
        /** Text Color **/
        .poster_info h4, .poster_date_format h4, .jacro-events, .film_showtime .show_date p, .popup-details span, .run-time, .run-time span {
            color:<?php echo (isset($jacroColorsSettings['jacroTextColor'])?esc_attr($jacroColorsSettings['jacroTextColor']):''); ?> !important;
        }
        .moviedetails-widget .tagcloud1 a, .performance-screens, .tagcloud2 a, .select-cinema {
            border: 1px solid <?php echo (isset($jacroColorsSettings['jacroTextColor'])?esc_attr($jacroColorsSettings['jacroTextColor']):''); ?> !important;
        }
        .main-slider {
            border: 2px solid <?php echo (isset($jacroColorsSettings['jacroTextColor'])?esc_attr($jacroColorsSettings['jacroTextColor']):''); ?> !important;
            border-left: none !important;; border-right: none !important;;
        }
        /** Show Time Button Hover **/
        .btn.date_time_btn:hover, .film_single a:hover, .book a:hover, .tagcloud4 a.active {
            background:<?php echo (isset($jacroColorsSettings['jacroButtonHoverColor'])?esc_attr($jacroColorsSettings['jacroButtonHoverColor']):''); ?> !important;
            color:<?php echo (isset($jacroColorsSettings['jacroButtonTextHoverColor'])?esc_attr($jacroColorsSettings['jacroButtonTextHoverColor']):''); ?> !important;
        }
        /** Filter Background & Text Color **/
        .moviedetails-widget .tagcloud1 > a, .dayshow-widget .tagcloud2 > a {
            background:<?php echo get_theme_mod('filterBtnBackColor'); ?>;
            color:<?php echo get_theme_mod('filterBtnTextColor'); ?>;
        }
        /** Filter Background Hover & Text Hover Color **/
        .moviedetails-widget .tagcloud1 > a:hover, .tagcloud2 > a.active, .dayshow-widget .tagcloud2 > a:hover, .tagcloud1 a.active {
            background:<?php echo get_theme_mod('filterBtnBackHoverColor'); ?>;
            color:<?php echo get_theme_mod('filterBtnTextHoverColor'); ?>;
        }
        /** Film Title Text Hover Color **/
        .film-title a:hover {
            color:<?php echo get_theme_mod('filmTextHoverColor'); ?>;
        }
        /** IE browser compatibility **/
        @media screen and (-ms-high-contrast: active), (-ms-high-contrast: none) {
            .btn.date_time_btn, .book a, .film_single a {
                background:<?php echo (isset($jacroColorsSettings['jacroButtonColor'])?esc_attr($jacroColorsSettings['jacroButtonColor']):''); ?> !important;
                color:<?php echo (isset($jacroColorsSettings['jacroButtonTextColor'])?esc_attr($jacroColorsSettings['jacroButtonTextColor']):''); ?> !important;
            }
            .btn.date_time_btn:hover, .book a:hover, .film_single a:hover, .btn.date_time_btn:hover {
                background:<?php echo (isset($jacroColorsSettings['jacroButtonHoverColor'])?esc_attr($jacroColorsSettings['jacroButtonHoverColor']):''); ?> !important;
                color:<?php echo (isset($jacroColorsSettings['jacroButtonTextHoverColor'])?esc_attr($jacroColorsSettings['jacroButtonTextHoverColor']):''); ?> !important;
            }
            .moviedetails-widget .tagcloud1 > a:hover, .tagcloud2 > a.active, .dayshow-widget .tagcloud2 > a:hover, .tagcloud1 a.active, .moviedetails-widget .tagcloud1 a.active, .tagcloud2 a.active {
                background:<?php echo get_theme_mod('filterBtnBackHoverColor'); ?>;
                color:<?php echo get_theme_mod('filterBtnTextHoverColor'); ?>;
            }
            .active.film_date_value.film-date-first {
                background:<?php echo get_theme_mod('filterBtnBackHoverColor'); ?>;
                color:<?php echo get_theme_mod('filterBtnTextHoverColor'); ?>;
            }
            .film_date_value.filmDateDisable.active {
                background:<?php echo get_theme_mod('filterBtnBackHoverColor'); ?>;
                color:<?php echo get_theme_mod('filterBtnTextHoverColor'); ?>;
            }
            .btn.active .date_time_btn {
                background:<?php echo get_theme_mod('filterBtnBackHoverColor'); ?>;
                color:<?php echo get_theme_mod('filterBtnTextHoverColor'); ?>;
            }
            .tagcloud4 a.active {
                background:<?php echo (isset($jacroColorsSettings['jacroButtonHoverColor'])?esc_attr($jacroColorsSettings['jacroButtonHoverColor']):''); ?> !important;
                color:<?php echo (isset($jacroColorsSettings['jacroButtonTextHoverColor'])?esc_attr($jacroColorsSettings['jacroButtonTextHoverColor']):''); ?> !important;
            }
        }
    </style>
    <?php
}

// Creating widget front-end Finished
include_once(CINEMA_FILE_PATH.'/jacro-widget-class.php');
include_once('jacro-cron.php');

/** Jacro Active **/
register_activation_hook(__FILE__, 'jacroInstall');
function jacroInstall() {
    global $wpdb;
    $table_name = $wpdb->prefix.'jacro_error';
    $tbl_name_two = $wpdb->prefix.'jacro_logs';
    $charset_collate = $wpdb->get_charset_collate();
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        
        $sql = "CREATE TABLE $table_name (
            id int(11) NOT NULL AUTO_INCREMENT,
            error_type varchar(255) NOT NULL,
            error_detail text NOT NULL,
            error_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            UNIQUE KEY id (id)
        ) $charset_collate;";
        require_once(ABSPATH .'wp-admin/includes/upgrade.php');
        
        dbDelta( $sql );

    } if($wpdb->get_var("SHOW TABLES LIKE '$tbl_name_two'") != $tbl_name_two) {
        $sql_two = "CREATE TABLE $tbl_name_two (
            id int(11) NOT NULL AUTO_INCREMENT,
            user_id int(128) NOT NULL,
            ip_address varchar(250) NOT NULL,
            changed_page varchar(250),
            created datetime NOT NULL,          
            UNIQUE KEY id (id)
        ) $charset_collate;";
        
        require_once(ABSPATH .'wp-admin/includes/upgrade.php');
        dbDelta($sql_two);      
    }
    update_option("jacroCurrencyPossion", 'left');
    $existingtimeformate = get_option('time_format');
    $new_value = substr($existingtimeformate, 0, 1);
    if( $new_value == 'g' || $new_value == 'h' ){
        update_option('jacroShowTimeHour', 'true');
    }else{
        update_option('jacroShowTimeHour', false);
    }
    jacro_create_page();
}

/* cron schedule time */
add_filter( 'cron_schedules', 'jacroAddCronInterval');
function jacroAddCronInterval( $schedules ) {
    $showtime_import_interval = get_option('showtime_import_interval');
    if( $showtime_import_interval == '' ){
        $showtime_import_interval = 72000;
    }
    $showtime_intrval_time = $showtime_import_interval/3600;
    $schedules['jacroCronSchedule'] = array(
        'interval' => $showtime_import_interval, // time in seconds
        'display'  => __( 'Every '.$showtime_intrval_time.' hours', 'jacro' )
    );  
    return $schedules;
}

/* import/delete cron action */
add_action('jacroRunImportAction', 'jacroCronImportAction', 10, 0);
add_action('jacroRunDeleteAction', 'jacroCronDeleteAction', 10, 0);

/* jacro cron action schedule */
add_action('wp', 'bd_cron_activation');
function bd_cron_activation() {
    if ( wp_get_schedule('jacroRunImportAction') !== 'jacroCronSchedule' ) {
        if ( $time = wp_next_scheduled('jacroRunImportAction')) { // Get Previously scheduled time interval
            wp_unschedule_event($time, 'jacroRunImportAction');
            wp_schedule_event(time(), 'jacroCronSchedule', 'jacroRunImportAction');
        }
    }
    if ( wp_get_schedule('jacroRunDeleteAction') !== 'jacroCronSchedule' ) {
        if ( $time = wp_next_scheduled('jacroRunDeleteAction')) { // Get Previously scheduled time interval
            wp_unschedule_event($time, 'jacroRunDeleteAction');
            wp_schedule_event(time(), 'jacroCronSchedule', 'jacroRunDeleteAction');
        }
    }
}

/** Jacro Deactivation **/
register_deactivation_hook(__FILE__, 'jacroUninstall');
function jacroUninstall() {
    wp_clear_scheduled_hook('jacroRunImportAction');
    wp_clear_scheduled_hook('jacroRunDeleteAction');
    // Remove Table on plugin deactivation
    global $wpdb;
    $table_name = $wpdb->prefix.'jacro_logs';
    $sql = "DROP TABLE IF EXISTS $table_name";
    $wpdb->query($sql);
}

/* documentation page */
function documentation() { ?>
    <h1>1. Cron Job For Auto Import</h1>
    <p>To import all the films and their performance automatically setup the CRON job for following file :</p>
    <p><pre>/your_wp_directory/wp-cron.php</pre></p>
    <p>Run this Cron job after each 30 mins.</p>
    <p>For more info on setting up the CRON job, </p>
    <ul>
        <li>1. <a href="https://www.namecheap.com/support/knowledgebase/article.aspx/9453/29/how-to-run-scripts-via-cron-jobs" target="_blank">Check this if you have cPanel.</a></li>
        <li>2. <a href="http://askubuntu.com/questions/2368/how-do-i-set-up-a-cron-job" target="_blank">Check this if you have Ubuntu server (VPS or Dedicated).</a></li>
        <li>e.g. Something like <pre>*/10 * * * * /usr/bin/php /var/www/html/dev/jacro/wp-cron.php</pre></li>
    </ul>
    <h1>2. Shortcodes</h1>
    <p>Please use following shortcodes for different types of Film Selection page layouts : </p>
    <table style="width: 100%;" class="admin_ticket_doc">
        <tr>
            <th>S.No.</th>
            <th>Shortcode</th> 
            <th>Description</th>
        </tr>
        <tr>
            <td>1</td>
            <td><strong><pre>[jacro-template-3]</pre></strong></td>
            <td><a href="#" class="preview2">Preview</a></td>
        </tr>
        <tr>
            <td>2</td>
            <td><strong><pre>[jacro-template-3 location="Location_Name"]</pre></strong></td>
            <td><a href="#" class="preview3">Preview</a><p>Use for the specific location</p></td>
        </tr>
        <tr>
            <td>3</td>
            <td><strong><pre>[homepage_buttons_shortcode]</pre></strong></td>
            <td><a href="#" class="preview4">Preview</a><p>Use for the movies and showtimes buttons</p></td>
        </tr>
        <tr>
            <td>4</td>
            <td><strong><pre>[calendar-events-small]</pre></strong></td>
            <td><a href="#" class="preview5">Preview</a><p>Use for the small event calendar</p></td>
        </tr>
        <tr>
            <td>5</td>
            <td><strong><pre>[calendar-events-large]</pre></strong></td>
            <td><a href="#" class="preview6">Preview</a><p>Use for the large event calendar</p></td>
        </tr>
        <tr>
            <td>6</td>
            <td><strong><pre>[jacro-movie-slider]</pre></strong></td>
            <td><a href="#" class="preview7">Preview</a></td>
        </tr>
        <tr>
            <td>7</td>
            <td><strong><pre>[jacro-movie-slider location="COMASTORIA" numberofposts="10" hidegenre="true" hidetrailer="true" hidedescription="true" hidesynopsis="true"]</pre></strong></td>
            <td><p>Use for the jacro movie slider with conditions</p></td>
        </tr>
        <tr>
            <td>8</td>
            <td><strong><pre>[jacro-table-pricing table-type='ticket-pricing']</pre></strong></td>
            <td><p> Use for the table pricing list</p></td>
        </tr>
        <tr>
            <td>9</td>
            <td><strong><pre>[jacro-table-pricing table-type='ticket-pricing-matinee']</pre></strong></td>
            <td><p>Use for the table pricing list for the pricing type "Matinee"</p></td>
        </tr>
        <tr>
            <td>10</td>
            <td><strong><pre>[jacro-table-pricing table-type='ritz-wednesday']</pre></strong></td>
            <td><p>Use for the table pricing list for the pricing type "Ritz Wednesday"</p></td>
        </tr>
        <tr>
            <td>11</td>
            <td><strong><pre>[jacro-slide-show]</pre></strong></td>
            <td><p>Use for the jacro slider</p></td>
        </tr>
    </table>
<?php }

/* delete films - backend */
function delete_all_films() {
    global $wpdb;
    $table_films = $wpdb->prefix . "jacro_films";
    $table_performances = $wpdb->prefix . "jacro_performances";
    if($_GET['field'] == 'films') {
        $wpdb->query("DELETE FROM $table_films");
        $wpdb->query("DELETE FROM $table_performances");
    } ?>
    <script type="text/javascript">
        location.href = 'admin.php?page=film_list';
    </script>
    <?php
}

/** Delete All unused datas **/
function JacroCleanAllDatas($previousNomberOfDay) {
    global $wpdb;

    $table_locations = $wpdb->prefix . "jacro_locations";
    $table_films = $wpdb->prefix . "jacro_films";
    $table_performances = $wpdb->prefix . "jacro_performances";
    $table_performances = $wpdb->prefix . "jacro_performances";
    
    $location_result = $wpdb->get_results("SELECT id FROM $table_locations");
    if($location_result) {
        foreach($location_result as $locations) {
            $location_id = $locations->id;

            $strtotimezone = jacro_strtotimezone($location_id);
            $today = date("Y-m-d", $strtotimezone);
            $fromdate = date("Y-m-d", strtotime("$today -$previousNomberOfDay day"));

            $film_delete_query = $wpdb->prepare("DELETE FROM $table_films WHERE location = %d AND code IN (SELECT filmcode FROM $table_performances WHERE location = %d AND performdate < %s)", $location_id, $location_id, $fromdate);
            $wpdb->query($film_delete_query);

            if ($wpdb->last_error !== '') {
                return false;
            }

            $performance_delete_query = $wpdb->prepare("DELETE FROM $table_performances WHERE location = %d AND performdate < %s", $location_id, $fromdate);
            $wpdb->query($performance_delete_query);

            if ($wpdb->last_error !== '') {
                return false;
            }
        }
    }
   
    return true;
}

/* create Live Events page */
function jacro_create_page() {
    // Dashboard Page
    $jacro_page_post = array(
        'post_title' => 'Live Events',
        'post_content' => '',
        'post_status' => 'publish',
        'post_author' => get_current_user_id(),
        'post_type' => 'page',
        'post_name' => 'live-events',
        'post_content' => '[live-events]',
    );
    $event_page_post = get_page_by_path('live-events', OBJECT, 'page');
    if (empty($event_page_post)) {
        wp_insert_post($jacro_page_post);
    }
}

// film template - layout
function jacro_film_template($location){
    if(!session_id()) {
        session_start();
    }
    jacroObjectStart();
    global $wpdb;
    $table_locations = $wpdb->prefix . "jacro_locations";
    if((isset($location['location'])) && ($location['location']!='')):
        $single_cinema = $location['location'];
        include_once(CINEMA_FILE_PATH.'/jacro-single-filters.php');
    else :
        $location = array();
        if(isset($_COOKIE['cinema_id'])){
            $stmt = $wpdb->prepare("SELECT * FROM $table_locations WHERE id = %d", $_COOKIE['cinema_id']);
            $result = $wpdb->get_row($stmt);
            if($result) {
                $name = $result->name;
            }
            $location['location'] = $name;
            $location['locationtype'] = 'all';
        }else{
            $location_result = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_locations LIMIT 1"));
            $location_id = $location_result[0]->id;
            $location_name = $location_result[0]->name;
            $location['location'] = $location_name;
            $location['locationtype'] = 'all';
            setcookie('cinema_id', $location_id, time() + (86400 * 30), "/");
        }
        $single_cinema = $location['location'];
        $single_loctype = $location['locationtype'];
        include_once(CINEMA_FILE_PATH.'/jacro-filters.php');
    endif;
    return ob_get_clean();
}
add_shortcode( 'jacro-template-3', 'jacro_film_template' );

function jacro_set_location($location){
    /* NC - 2020-0120 */
    if(!session_id()) {
        session_start();
    }

    jacroObjectStart();
    if((isset($location['location'])) && ($location['location']!='')) {
        $single_cinema = $location['location'];
        $_SESSION['location']= $location['location'];
        $cinemaid = get_term_by('slug', $_SESSION['location'], 'theatre');
        $_SESSION['cinema'] = $cinemaid->term_id;
    }
    return ob_get_clean();
}
add_shortcode( 'jacro-set-location', 'jacro_set_location' );

function jacro_live_events() {
    include_once(CINEMA_FILE_PATH.'/jacro-live-events.php');
}
add_shortcode( 'live-events', 'jacro_live_events' );

function list_of_movies() {
    include_once(CINEMA_FILE_PATH.'/list-of-movies.php');
}
add_shortcode( 'list-of-movies', 'list_of_movies' );

function list_of_dates() {
    include_once(CINEMA_FILE_PATH.'/list-of-dates.php');
}
add_shortcode( 'list-of-dates', 'list_of_dates' );

function filmtoday() {
    include_once(CINEMA_FILE_PATH.'/filmtoday.php');
}
add_shortcode( 'filmtoday', 'filmtoday' );

function homepage_buttons_shortcode() {
    include_once(CINEMA_FILE_PATH.'/homepage_buttons_shortcode.php');
}
add_shortcode( 'homepage_buttons_shortcode', 'homepage_buttons_shortcode' );

function jacro_caleandar_events() {
    $page_template = get_page_template_slug( get_the_ID() );
    if($page_template=='jacro-caleandar-events'){
    ob_start();
        include_once(CINEMA_FILE_PATH.'/jacro-caleandar-events-large.php');
         $output_string = ob_get_contents();
    ob_end_clean();
    return $output_string;
    }
}
add_shortcode( 'calendar-events-large', 'jacro_caleandar_events' );

function jacro_caleandar_event_small() {
    $page_template = get_page_template_slug( get_the_ID() );
    if($page_template=='jacro-caleandar-events'){
    ob_start();
        include_once(CINEMA_FILE_PATH.'/jacro-caleandar-events-small.php');
         $output_string = ob_get_contents();
    ob_end_clean();
    return $output_string;
    }
}
add_shortcode( 'calendar-events-small', 'jacro_caleandar_event_small' );

function single_film(){
    jacroObjectStart();
    include_once(CINEMA_FILE_PATH.'/single-film.php');
    return ob_get_clean();
}
add_shortcode( 'jacro-single-film', 'single_film' );

function jacroTablePricing($tableType){
    $jacroProduct = new jacroProductPricing();
    jacroObjectStart();
    include(CINEMA_FILE_PATH.'/jacro-table-pricing.php');
    if(!isset($tableType['table-type']) || $tableType['table-type']=='ritz-wednesday') :
        $jacroProduct->JacroGetTableType($jacroDeafultTheatorID, 'jacro-ticket-pricing-'.$tableType['table-type']);
        return ob_get_clean();
    else :
        $jacroProduct->JacroGetTableType($jacroDeafultTheatorID, 'jacro-'.$tableType['table-type']);
        return ob_get_clean();
    endif;
}
add_shortcode( 'jacro-table-pricing', 'jacroTablePricing' );

function jacroSlideShow(){
    include_once(CINEMA_FILE_PATH.'/jacro-slideshow.php');
}
add_shortcode( 'jacro-slide-show', 'jacroSlideShow' );
//shortcode ends

function jacrosettings(){
    include_once(CINEMA_FILE_PATH.'/settings.php');
}
function theatres(){
    include_once(CINEMA_FILE_PATH.'/theatre_feed.php');
}
function location_list(){
    include_once(CINEMA_FILE_PATH.'/location_list.php');
}
function add_theatre(){
    include_once(CINEMA_FILE_PATH.'/add_theatre.php');
}
function edit_theatre(){
    include_once(CINEMA_FILE_PATH.'/edit_theatre.php');
}
function edit(){
    include_once(CINEMA_FILE_PATH.'/edit.php');
}
function film_list(){
    include_once(CINEMA_FILE_PATH.'/film_list.php');
}
function view_film(){
    include_once(CINEMA_FILE_PATH.'/view_film.php');
}
function performance_list(){
    include_once(CINEMA_FILE_PATH.'/performance_list.php');
}
function view_performance(){
    include_once(CINEMA_FILE_PATH.'/view_performance.php');
}
include_once(CINEMA_FILE_PATH.'/jacro-widgets.php');

function jacroShowTimeWidgets(){
    jacroObjectStart();
    $jacroWidget = new JacroWidgetsCall();
    $jacroWidget->JacroShowTimeWidget();
    return ob_get_clean();
}

function jacroImageWidgets(){
    jacroObjectStart();
    $jacroWidget = new JacroWidgetsCall();
    $jacroWidget->JacroAppDownloadWidget();
    return ob_get_clean();
}

function jacroGiftCardWidgets(){
    jacroObjectStart();
    $jacroWidget = new JacroWidgetsCall();
    $jacroWidget->JacroGiftCardWidget();
    return ob_get_clean();
}

function theatrefeed_save() {
    global $wpdb; start_session();
    $table_customers = $wpdb->prefix . "jacro_customers";
    $created = date('Y-m-d H:i:s');
    $customer_args = array(
        'code'      => $_REQUEST['post_title'],
        'url'       => $_REQUEST['post_content'],
        'created'   => $created,
    );
    if(!empty($_POST['post_title'])) {
        if(isset($_REQUEST['id'])) {
            $res=$wpdb->get_row("SELECT * FROM $table_customers WHERE code = '".$_REQUEST['post_title']."' and id !='".$_REQUEST['id']."' and url = '".$_REQUEST['post_content']."'");
            if(empty($res)) {
                $where = array(
                    'id' => $_REQUEST['id']
                );
                $update_customer = $wpdb->update($table_customers, $customer_args, $where);
                $_SESSION['s_message']='<span>Location feed url has been updated.</span>';
            } else {
                $_SESSION['s_message']='<span>Location feed url is already added.</span>';
            }
        } else {
            $res=$wpdb->get_row("SELECT * FROM $table_customers WHERE code = '".$_REQUEST['post_title']."' && url = '".$_REQUEST['post_content']."'");
            if(empty($res)) {
                $insert_customer = $wpdb->insert($table_customers, $customer_args);
                $_SESSION['s_message']='<span>Location feed url is added.</span>';
            } else {
                $_SESSION['s_message']='<span>Theatre feed url is already added.</span>';
            }
        }
    } else {
        $_SESSION['s_message']='<span>Please enter location feed url.</span>';
    }
    echo '<script>window.location.href="?page=locations";</script>';
}

// Import All Location And Show Films
function jacro_get_all_theatre() {
    start_session();$return_result = array();
    $taxonomy='theatre';
    $result = get_terms($taxonomy,array("hide_empty"=>0));
    $result['total_location_counter'] = count($result);
    echo json_encode($result); exit;
}
add_action('wp_ajax_jacro_get_all_theatre', 'jacro_get_all_theatre');

/* generate slug url */
function generate_slug($string) {
    $string = preg_replace('/[^a-zA-Z0-9\s]/', '', $string);
    $string = str_replace(' ', '-', $string);
    $string = strtolower($string);
    $string = preg_replace('/-+/', '-', $string);
    $string = trim($string, '-'); 
    return $string;
}

// import xml feed data
function import_film_showtime( $id ) {
    ini_set('max_execution_time', 5000); ignore_user_abort( true );
    if (! ini_get( 'safe_mode' ) ) {@set_time_limit( 0 );}  

    global $wpdb;
    $table = $wpdb->prefix . "jacro_locations";
    $table_films = $wpdb->prefix . "jacro_films";
    $table_performances = $wpdb->prefix . "jacro_performances";
    $table_modifiers = $wpdb->prefix . "jacro_modifiers";
    $table_products = $wpdb->prefix . "jacro_products";
    $table_images = $wpdb->prefix . "jacro_images";
    $table_attributes = $wpdb->prefix . "jacro_attributes";
    $created = date('Y-m-d H:i:s');
    $result = $wpdb->get_row("SELECT * FROM $table WHERE id = $id");

    if($result) {
        $datafeed_url = $result->url;
        $content = file_get_contents_curl($datafeed_url);
        $locationid = $result->id;
        $customerid = $result->customer;
        $locationname = $result->name;

        $arr = array(); $feeds = array(); $modarr = array();    
        $total_performance = 0; $count_feed = 0; $countNewFilms = 0; $countNewPerformance = 0; $countNewModifier = 0; $countNewAttributes = 0;
        
        if($content == 'No connections found') {
            error_log('This Feed URL not working, please check '.$content.' this feed url => '.$datafeed_url);
            $message = 'This Feed URL not working, please check '.$content.' this feed url => '.$datafeed_url;
            jacro_change_error_log( 'insert-location', $message );
            add_action( 'admin_notices', 'jacro_error_notice' );
        } else {
            $feeds = simplexml_load_string($content);
            if(isset($feeds->Films->Film)) :
                $total_film = count($feeds->Films->Film);
            else :
                $total_film = 0;
            endif;
            if(isset($feeds->Performances->Performance)) :
                $total_perfs = count($feeds->Performances->Performance);
            else :
                $total_perfs = 0;
            endif;
            if(isset($feeds->Modifiers->Modifier)) :
                $total_modifier = count($feeds->Modifiers->Modifier);
            else :
                $total_modifier = 0;
            endif;
            if(isset($feeds->attributes->attribute)) :
                $total_attributes = count($feeds->attributes->attribute);
            else :
                $total_attributes = 0;
            endif;
        }

        if(!empty($feeds) && isset($feeds->Films) && $total_film!=0) {

            $allPerformances = $feeds->Performances->Performance;
            
            $filmcodes = array();
            foreach($allPerformances as $key  => $performance){
                $arrayfilmcode= json_decode(json_encode($performance->FilmCode[0]), TRUE);
                $arraySellonInternet = json_decode(json_encode($performance->PressReport[0]), TRUE);
                if($filmcodes[$arrayfilmcode[0]] != 'Y' && $filmcodes[$arrayfilmcode[0]] != 'None'){
                    $filmcodes[$arrayfilmcode[0]] = $arraySellonInternet[0];
                }
            }

            /* film import */
            $curr_codes = array();
            for($count_film=0;$count_film < $total_film;$count_film++) {

                $curr_codes[] = (string)$feeds->Films->Film[$count_film]->Code;
                
                $code = (string)$feeds->Films->Film[$count_film]->Code;   
                $shortfilmtitle = (string)$feeds->Films->Film[$count_film]->ShortFilmTitle;
                $filmtitle = (string)$feeds->Films->Film[$count_film]->FilmTitle;
                $privatewatchparty = (string)$feeds->Films->Film[$count_film]->PrivateWatchParty;
                $certificate = (string)$feeds->Films->Film[$count_film]->Certificate;
                $is3d = (string)$feeds->Films->Film[$count_film]->Is3d;
                $lastmodified = (string)$feeds->Films->Film[$count_film]->LastModified;
                $actors = (string)$feeds->Films->Film[$count_film]->Actors;
                $digital = (string)$feeds->Films->Film[$count_film]->Digital;
                $imgtitle = (string)$feeds->Films->Film[$count_film]->Img_title;
                $startdate = (string)$feeds->Films->Film[$count_film]->StartDate;
                $enddate = (string)$feeds->Films->Film[$count_film]->EndDate;
                $cinecheckflagsdescription = (string)$feeds->Films->Film[$count_film]->CinecheckFlagsDescription;
                $cinecheckflags = (string)$feeds->Films->Film[$count_film]->CinecheckFlags;
                $releasedate = (string)$feeds->Films->Film[$count_film]->ReleaseDate;
                if ((string)$feeds->Films->Film[$count_film]->attributes()['release_date']) {
                    $filmwithreleasedate = (string)$feeds->Films->Film[$count_film]->attributes()['release_date'];
                } else {
                    $filmwithreleasedate = '';
                }
                $img1s = (string)$feeds->Films->Film[$count_film]->Img_1s;
                $genre = (string)$feeds->Films->Film[$count_film]->Genre;
                $filmflagsdescription = (string)$feeds->Films->Film[$count_film]->FilmFlagsDescription;
                $filmstatus = (string)$feeds->Films->Film[$count_film]->ComingSoon;
                $youtubelink = (string)$feeds->Films->Film[$count_film]->Youtube;
                $synopsis = (string)$feeds->Films->Film[$count_film]->Synopsis;
                $certificate_desc = (string)$feeds->Films->Film[$count_film]->Certificate_desc; 
                $genre_code = (string)$feeds->Films->Film[$count_film]->GenreCode;
                $rentrak = (string)$feeds->Films->Film[$count_film]->Rentrak;
                $directors = (string)$feeds->Films->Film[$count_film]->Directors;
                $running_time = (string)$feeds->Films->Film[$count_film]->RunningTime;
                $imgBd = (string)$feeds->Films->Film[$count_film]->img_bd;
                $localfilmCode = (string)$feeds->Films->Film[$count_film]->LocalFilmCode;
                $filmmastercode = (string)$feeds->Films->Film[$count_film]->FilmMasterCode;
                $img_cert_filename_blob = (string)$feeds->Films->Film[$count_film]->img_cert_filename_blob;
                $certimageurl = (string)$feeds->Films->Film[$count_film]->CertImageUrl;
                $filmflags = (string)$feeds->Films->Film[$count_film]->FilmFlags;
                $img_app = (string)$feeds->Films->Film[$count_film]->Img_app;
                $IMDBCode = (string)$feeds->Films->Film[$count_film]->IMDBCode;
                $launch_date = (string)$feeds->Films->Film[$count_film]->launch_date;
                $film_attributes = (string)$feeds->Films->Film[$count_film]->FilmAttributes;
                $film_attributes_description = (string)$feeds->Films->Film[$count_film]->FilmAttributesDescription;
                $titleart_url = (string)$feeds->Films->Film[$count_film]->titleart_url;

                $regions = $feeds->Films->Film[$count_film]->Regions;   
                $region_descriptions = array();
                foreach ($regions->Region as $region) {
                    $region_descriptions[] = (string)$region->Description;
                }  
                $regions_string = implode(', ', $region_descriptions);

                $string = generate_slug($filmtitle);
                $filmloc = strtolower(preg_replace('/[^\\pL\d]+/u', '-', $locationname));
                $page_url = site_url() . '/' .$filmloc. '/film/' . $code . '/' . $string;
                
                $film_args = array(
                    'customer'                      => $customerid,
                    'location'                      => $locationid,
                    'code'                          => $code,
                    'shortfilmtitle'                => $shortfilmtitle,
                    'filmtitle'                     => $filmtitle,
                    'privatewatchparty'             => $privatewatchparty,
                    'certificate'                   => $certificate,
                    'is3d'                          => $is3d,
                    'lastmodified'                  => $lastmodified,
                    'actors'                        => $actors,
                    'digital'                       => $digital,
                    'img_title'                     => $imgtitle,
                    'startdate'                     => $startdate,
                    'enddate'                       => $enddate,
                    'cinecheckflagsdescription'     => $cinecheckflagsdescription,
                    'cinecheckflags'                => $cinecheckflags,
                    'releasedate'                   => $releasedate,
                    'film_with_releasedate'         => $filmwithreleasedate,
                    'img_1s'                        => $img1s,
                    'genre'                         => $genre,
                    'filmflagsdescription'          => $filmflagsdescription,
                    'comingsoon'                    => $filmstatus,
                    'youtube'                       => $youtubelink,
                    'synopsis'                      => $synopsis,
                    'certificate_desc'              => $certificate_desc,
                    'genrecode'                     => $genre_code,
                    'rentrak'                       => $rentrak,
                    'directors'                     => $directors,
                    'runningtime'                   => $running_time,
                    'img_bd'                        => $imgBd,
                    'localfilmcode'                 => $localfilmCode,
                    'filmmastercode'                => $filmmastercode,
                    'img_cert_filename_blob'        => $img_cert_filename_blob,
                    'certimageurl'                  => $certimageurl,
                    'filmflags'                     => $filmflags,
                    'img_app'                       => $img_app,
                    'imdbcode'                      => $IMDBCode,
                    'launch_date'                   => $launch_date,
                    'film_attributes'               => $film_attributes,
                    'film_attributes_description'   => $film_attributes_description,
                    'titleart_url'                  => $titleart_url,
                    'regions'                       => $regions_string,
                    'url'                           => $page_url,
                    'created'                       => $created,
                );

                $existing_films = $wpdb->get_row(
                    $wpdb->prepare(
                        "SELECT * FROM $table_films WHERE customer = %d AND location = %d AND code = %s",
                        $customerid,
                        $locationid,
                        $code
                    )
                );
                if($existing_films) {
                    $where = array('id' => $existing_films->id);
                    $wpdb->update($table_films, $film_args, $where);
                } else {
                    $wpdb->insert($table_films, $film_args);
                    $count_feed++; $countNewFilms++;
                }

            }       

            $existing_codes_query = $wpdb->get_results("SELECT code FROM $table_films WHERE customer = $customerid AND location = $locationid");
            $existing_codes = array();
            foreach ($existing_codes_query as $existing_code) {
                $existing_codes[] = $existing_code->code;
            }
            $deleted_codes = array_diff($existing_codes, $curr_codes);
            if (!empty($deleted_codes)) {
                $deleted_codes_str = implode(',', $deleted_codes);
                $wpdb->query("DELETE FROM $table_films WHERE customer = $customerid AND location = $locationid AND code IN ($deleted_codes_str)");
            }  

            /* performnaces import */
            $curr_pcodes = array();
            $total_performance = count($feeds->Performances->Performance);
            for($count_performance=0; $count_performance < $total_performance; $count_performance++) {

                $curr_pcodes[] = (string)$feeds->Performances->Performance[$count_performance]->Code;

                $perform_date = (string)$feeds->Performances->Performance[$count_performance]->PerformDate;
                $passes = (string)$feeds->Performances->Performance[$count_performance]->Passes;
                $perf_flags = (string)$feeds->Performances->Performance[$count_performance]->PerfFlags;
                $sold_out_level = (string)$feeds->Performances->Performance[$count_performance]->SoldOutLevel;
                $perform_last_modified = (string)$feeds->Performances->Performance[$count_performance]->LastModified;
                $virtual = (string)$feeds->Performances->Performance[$count_performance]->Virtual;
                $perf_cat = (string)$feeds->Performances->Performance[$count_performance]->PerfCat;
                $booking_url = (string)$feeds->Performances->Performance[$count_performance]->BookingURL;
                $ad = (string)$feeds->Performances->Performance[$count_performance]->AD;
                $screen = (string)$feeds->Performances->Performance[$count_performance]->Screen;
                $doors_open = (string)$feeds->Performances->Performance[$count_performance]->DoorsOpen;
                $purchasedprivatewatchparty = (string)$feeds->Performances->Performance[$count_performance]->PurchasedPrivateWatchParty; 
                $film_code = (string)$feeds->Performances->Performance[$count_performance]->FilmCode;
                $sellon_internet = (string)$feeds->Performances->Performance[$count_performance]->SellonInternet;
                $trailer_time = (string)$feeds->Performances->Performance[$count_performance]->TrailerTime;
                $wheelchair_accessible = (string)$feeds->Performances->Performance[$count_performance]->WheelchairAccessible;
                $reserved_seating = (string)$feeds->Performances->Performance[$count_performance]->ReservedSeating;
                $sales_stopped = (string)$feeds->Performances->Performance[$count_performance]->SalesStopped;
                $img_bd_filename_blob = (string)$feeds->Performances->Performance[$count_performance]->img_bd_filename_blob;
                $performance_number_slot = (string)$feeds->Performances->Performance[$count_performance]->PerformanceNumberSlot;
                $desktop_booking_url = (string)$feeds->Performances->Performance[$count_performance]->InternalBookingURLDesktop;
                $code = (string)$feeds->Performances->Performance[$count_performance]->Code;
                $subs = (string)$feeds->Performances->Performance[$count_performance]->Subs;
                $press_report = (string)$feeds->Performances->Performance[$count_performance]->PressReport;
                $mobile_booking_url = (string)$feeds->Performances->Performance[$count_performance]->InternalBookingURLMobile;
                $perfflagsdescription = (string)$feeds->Performances->Performance[$count_performance]->PerfFlagsDescription;
                $screen_code = (string)$feeds->Performances->Performance[$count_performance]->ScreenCode; 
                $start_time = (string)$feeds->Performances->Performance[$count_performance]->StartTime;
                $performances_hidden = (string)$feeds->Performances->Performance[$count_performance]->PerformancesHidden;
                $manager_warning_level = (string)$feeds->Performances->Performance[$count_performance]->ManagerWarningLevel;
                $external_url = (string)$feeds->Performances->Performance[$count_performance]->ExternalURL;
                $sensibledoublefeature = (string)$feeds->Performances->Performance[$count_performance]->SensibleDoubleFeature;
                $zerosales = (string)$feeds->Performances->Performance[$count_performance]->ZeroSales;
                $tickets_sold = (string)$feeds->Performances->Performance[$count_performance]->TicketsSold;

                $performance_args = array(
                    'customer'                      => $customerid,
                    'location'                      => $locationid,
                    'code'                          => $code,
                    'performdate'                   => $perform_date,
                    'passes'                        => $passes,
                    'perfflags'                     => $perf_flags,
                    'soldoutlevel'                  => $sold_out_level,
                    'lastmodified'                  => $perform_last_modified,
                    'virtual'                       => $virtual,
                    'perfcat'                       => $perf_cat,
                    'bookingurl'                    => $booking_url,
                    'ad'                            => $ad,
                    'screen'                        => $screen,
                    'doorsopen'                     => $doors_open,
                    'purchasedprivatewatchparty'    => $purchasedprivatewatchparty,
                    'filmcode'                      => $film_code,
                    'selloninternet'                => $sellon_internet,
                    'trailertime'                   => $trailer_time,
                    'wheelchairaccessible'          => $wheelchair_accessible,
                    'reservedseating'               => $reserved_seating,
                    'salesstopped'                  => $sales_stopped,
                    'img_bd_filename_blob'          => $img_bd_filename_blob,
                    'performancenumberslot'         => $performance_number_slot,
                    'internalbookingurldesktop'     => $desktop_booking_url,
                    'subs'                          => $subs,
                    'pressreport'                   => $press_report,
                    'internalbookingurlmobile'      => $mobile_booking_url,
                    'perfflagsdescription'          => $perfflagsdescription,
                    'screencode'                    => $screen_code,
                    'starttime'                     => $start_time,
                    'performanceshidden'            => $performances_hidden,
                    'managerwarninglevel'           => $manager_warning_level,
                    'externalurl'                   => $external_url,
                    'sensibledoublefeature'         => $sensibledoublefeature,
                    'zerosales'                     => $zerosales,
                    'ticketssold'                   => $tickets_sold,
                    'created'                       => $created,
                );

                $existing_performace = $wpdb->get_row(
                    $wpdb->prepare(
                        "SELECT * FROM $table_performances WHERE customer = %d AND location = %d AND code = %s",
                        $customerid,
                        $locationid,
                        $code
                    )
                );
                if($existing_performace) {
                    $where = array('id' => $existing_performace->id);
                    $wpdb->update($table_performances, $performance_args, $where);
                } else {
                    $wpdb->insert($table_performances, $performance_args);
                    $count_feed++; $countNewPerformance++;
                }
                    
            }

            $existing_performace_query = $wpdb->get_results("SELECT code FROM $table_performances WHERE customer = $customerid AND location = $locationid");
            $existing_perfs = array();
            foreach ($existing_performace_query as $existing_perf) {
                $existing_perfs[] = $existing_perf->code;
            }
            $deleted_perf_codes = array_diff($existing_perfs, $curr_pcodes);
            if (!empty($deleted_perf_codes)) {
                $deleted_perfcodes_str = implode(',', $deleted_perf_codes);
                $wpdb->query("DELETE FROM $table_performances WHERE customer = $customerid AND location = $locationid AND code IN ($deleted_perfcodes_str)");
            }

        }

        /* modifiers */
        $curr_mcodes=array();
        for($count_modifier=0; $count_modifier < $total_modifier; $count_modifier++) {
            $curr_mcodes[] = (string)$feeds->Modifiers->Modifier[$count_modifier]->Code;
            $code = (string)$feeds->Modifiers->Modifier[$count_modifier]->Code;
            $modifier_description = (string)$feeds->Modifiers->Modifier[$count_modifier]->Description;
            $modifier_priority = (string)$feeds->Modifiers->Modifier[$count_modifier]->Priority;
            $modifier_modType = (string)$feeds->Modifiers->Modifier[$count_modifier]->ModType;
            $modifier_cinecheckfile = (string)$feeds->Modifiers->Modifier[$count_modifier]->CinecheckFile;
            $modifier_shortcode = (string)$feeds->Modifiers->Modifier[$count_modifier]->Shortcode;

            $modifier_args = array(
                'customer'      => $customerid,
                'location'      => $locationid,
                'code'          => $code,
                'description'   => $modifier_description,
                'priority'      => $modifier_priority,
                'modtype'       => $modifier_modType,
                'cinecheckfile' => $modifier_cinecheckfile,
                'shortcode'     => $modifier_shortcode,
                'created'       => $created,
            );

            $existing_modifiers = $wpdb->get_row(
                $wpdb->prepare(
                    "SELECT * FROM $table_modifiers WHERE customer = %d AND location = %d AND code = %s",
                    $customerid,
                    $locationid,
                    $code
                )
            );
            if($existing_modifiers) {
                $where = array('id' => $existing_modifiers->id);
                $wpdb->update($table_modifiers, $modifier_args, $where);
            } else {
                $wpdb->insert($table_modifiers, $modifier_args);
                $count_feed++; $countNewModifier++;
            }
        }

        $existing_modifier_query = $wpdb->get_results("SELECT code FROM $table_modifiers WHERE customer = $customerid AND location = $locationid");
        $existing_modcodes = array();
        foreach ($existing_modifier_query as $existing_mod) {
            $existing_modcodes[] = $existing_mod->code;
        }
        $deleted_modcodes = array_diff($existing_modcodes, $curr_mcodes);
        if (!empty($deleted_modcodes)) {
            $deleted_modcodes_str = implode(',', $deleted_modcodes);
            $wpdb->query("DELETE FROM $table_modifiers WHERE customer = $customerid AND location = $locationid AND code IN ($deleted_modcodes_str)");
        }

        /* products */
        if(isset($feeds->product_tables)) {
            $totalPriceTable = count($feeds->product_tables->table);
            if($totalPriceTable>0) {
                $jacroPriceTables = array(); $jacroProductPriceTypes = '';
                for($table=0;$table<$totalPriceTable;$table++) :
                    $priceTables = $feeds->product_tables->table[$table]->attributes()->description;
                    $priceTableAttribute = explode(',',$priceTables);
                    if(isset($priceTableAttribute[0])) :
                        $jacroProductPriceTypes = $priceTableAttribute[0];
                    endif;
                    $totalProduct = count($feeds->product_tables->table[$table]->product);
                    for($product=0;$product<$totalProduct;$product++) :
                        $priceTablesDatas = $feeds->product_tables->table[$table]->product[$product]->attributes();
                        $priceTablesMinType = $feeds->product_tables->table[$table]->product[$product]->attributes()->description;
                        $productType = explode(',',$priceTablesMinType);
                        $productType = preg_replace('/\s+/', '', $productType[0]);
                        foreach($priceTablesDatas as $k=>$priceTablesData) :
                            $priceTablesData = explode(',',$priceTablesData);
                            if(isset($priceTablesData[0])) :
                                $jacroPriceTables[$jacroProductPriceTypes][$productType][$k] = $priceTablesData[0];
                            endif;
                        endforeach;
                    endfor;
                endfor;
                foreach($jacroPriceTables as $priceType=>$jacroProduct) {
                    $priceDatas[$priceType] = $jacroProduct;
                }
                $priceDatas = json_encode($priceDatas);

                $product_args = array(
                    'customer'      => $customerid,
                    'location'      => $locationid,
                    'pricingtable'  => $priceDatas,
                    'created'       => $created,
                );

                $wpdb->insert($table_products, $product_args);
            }
        }

        /* images - onesheet */
        $curr_onesheet = array();
        if(isset($feeds->images->onesheet)) {
            $totalOneSheetImages = count($feeds->images->onesheet->image);
            if($totalOneSheetImages>0) {
                foreach($feeds->images->onesheet->image as $image) {
                    $curr_onesheet[] = (string) $image['filename'];
                    $order = (int) $image['order'];
                    $frequency = (int) $image['frequency'];
                    $url_data = (int) $image['url_data'];
                    $content_type = (string) $image['content_type'];
                    $filename = (string) $image['filename'];

                    $onesheet_args = array(
                        'customer'      => $customerid,
                        'location'      => $locationid,
                        'type'          => 'onesheet',
                        'sequence'      => $order,
                        'frequency'     => $frequency,
                        'url_data'      => $url_data,
                        'content_type'  => $content_type,
                        'filename'      => $filename,
                        'created'       => $created,
                    );

                    $existing_onesheetimg = $wpdb->get_row(
                        $wpdb->prepare(
                            "SELECT * FROM $table_images WHERE customer = %d AND location = %d AND type = %s AND filename = %s",
                            $customerid,
                            $locationid,
                            'onesheet',
                            $filename
                        )
                    );
                    if($existing_onesheetimg) {
                        $where = array('id' => $existing_onesheetimg->id);
                        $wpdb->update($table_images, $onesheet_args, $where);
                    } else {
                        $wpdb->insert($table_images, $onesheet_args);
                    }
                }
                $existing_onesheet_query = $wpdb->get_results("SELECT filename FROM $table_images WHERE customer = $customerid AND location = $locationid");
                $existing_onesheet_codes = array();
                foreach ($existing_onesheet_query as $existing_onesht) {
                    $existing_onesheet_codes[] = $existing_onesht->filename;
                }
                $deleted_onesheet_codes = array_diff($existing_onesheet_codes, $curr_onesheet);
                if (!empty($deleted_onesheet_codes)) {
                    $deleted_onecodes_str = implode(',', $deleted_onesheet_codes);
                    $wpdb->query("DELETE FROM $table_images WHERE customer = $customerid AND location = $locationid AND filename IN ($deleted_onecodes_str)");
                }
            }
        }

        /* images - app */  
        $curr_appsheet = array();
        if(isset($feeds->images->app)) {
            $totalAppImages = count($feeds->images->app->image);
            if($totalAppImages>0) {
                foreach($feeds->images->app->image as $image) {
                    $curr_appsheet[] = (string) $image['filename'];
                    $order = (int) $image['order'];
                    $frequency = (int) $image['frequency'];
                    $url_data = (int) $image['url_data'];
                    $content_type = (string) $image['content_type'];
                    $filename = (string) $image['filename'];

                    $appimg_args = array(
                        'customer'      => $customerid,
                        'location'      => $locationid,
                        'type'          => 'app',
                        'sequence'      => $order,
                        'frequency'     => $frequency,
                        'url_data'      => $url_data,
                        'content_type'  => $content_type,
                        'filename'      => $filename,
                        'created'       => $created,
                    );

                    $existing_appimg = $wpdb->get_row(
                        $wpdb->prepare(
                            "SELECT * FROM $table_images WHERE customer = %d AND location = %d AND type = %s AND filename = %s",
                            $customerid,
                            $locationid,
                            'app',
                            $filename
                        )
                    );
                    if($existing_appimg) {
                        $where = array('id' => $existing_appimg->id);
                        $wpdb->update($table_images, $appimg_args, $where);
                    } else {
                        $wpdb->insert($table_images, $appimg_args);
                    }
                }
                $existing_app_query = $wpdb->get_results("SELECT filename FROM $table_images WHERE customer = $customerid AND location = $locationid");
                $existing_appimg_codes = array();
                foreach ($existing_app_query as $existing_app) {
                    $existing_appimg_codes[] = $existing_app->filename;
                }
                $deleted_appimg_codes = array_diff($existing_appimg_codes, $curr_appsheet);
                if (!empty($deleted_appimg_codes)) {
                    $deleted_appimg_str = implode(',', $deleted_appimg_codes);
                    $wpdb->query("DELETE FROM $table_images WHERE customer = $customerid AND location = $locationid AND filename IN ($deleted_appimg_str)");
                }
            }
        }

        /* attributes */
        $curr_attcodes = array();
        for($count_attributes=0; $count_attributes < $total_attributes; $count_attributes++) {
            $curr_attcodes[] = (string)$feeds->attributes->attribute[$count_attributes]->Code;
            $code = (string)$feeds->attributes->attribute[$count_attributes]->Code;
            $attr_description = (string)$feeds->attributes->attribute[$count_attributes]->Description;
            $attr_priority = (string)$feeds->attributes->attribute[$count_attributes]->Priority;
            $attr_modType = (string)$feeds->attributes->attribute[$count_attributes]->ModType;
            $attr_cinecheckfile = (string)$feeds->attributes->attribute[$count_attributes]->CinecheckFile;
            $attr_shortcode = (string)$feeds->attributes->attribute[$count_attributes]->Shortcode;

            $attributes_args = array(
                'customer'      => $customerid,
                'location'      => $locationid,
                'code'          => $code,
                'description'   => $attr_description,
                'priority'      => $attr_priority,
                'modtype'       => $attr_modType,
                'cinecheckfile' => $attr_cinecheckfile,
                'shortcode'     => $attr_shortcode,
                'created'       => $created,
            );

            $existing_attributes = $wpdb->get_row(
                $wpdb->prepare(
                    "SELECT * FROM $table_attributes WHERE customer = %d AND location = %d AND code = %s",
                    $customerid,
                    $locationid,
                    $code
                )
            );
            if($existing_attributes) {
                $where = array('id' => $existing_attributes->id);
                $wpdb->update($table_attributes, $attributes_args, $where);
            } else {
                $wpdb->insert($table_attributes, $attributes_args);
                $count_feed++; $countNewAttributes++;
            }
        }
        $existing_attr_query = $wpdb->get_results("SELECT code FROM $table_attributes WHERE customer = $customerid AND location = $locationid");
        $existing_attrcodes = array();
        foreach ($existing_attr_query as $existing_attr) {
            $existing_attrcodes[] = $existing_attr->code;
        }
        $deleted_attrcodes = array_diff($existing_attrcodes, $curr_attcodes);
        if (!empty($deleted_attrcodes)) {
            $deleted_attrcodes_str = implode(',', $deleted_attrcodes);
            $wpdb->query("DELETE FROM $table_attributes WHERE customer = $customerid AND location = $locationid AND code IN ($deleted_attrcodes_str)");
        }

    } else {
        $message = 'Theatre location is correct';
        jacro_change_error_log( 'location-error', $message );
        add_action( 'admin_notices', 'jacro_error_notice' );
    }

    $return_data['total_film'] = $total_film;
    $return_data['count_feed'] = $count_feed;
    $return_data['total_performance'] = $total_performance;
    $return_data['totalNewFilm'] = $countNewFilms;
    $return_data['totalNewPerformance'] = $countNewPerformance;
    $return_data['total_modifier'] = $total_modifier;
    $return_data['total_attributes'] = $total_attributes;
    $return_data['totalNewModifier'] = $countNewModifier;
    $return_data['totalNewAttributes'] = $countNewAttributes;

    return $return_data;
}

function file_get_contents_curl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

// DataFeed Save
function datafeed_save() {
    global $wpdb; start_session();
    $table = $wpdb->prefix . "jacro_locations";
    $created = date('Y-m-d H:i:s');
    $args = array(
        'code'      => $_REQUEST['term_name'],
        'url'       => $_REQUEST['post_content'],
        'created'   => $created,
    );
    if(!empty($_POST['term_name'])) {
        if(isset($_REQUEST['id'])) {
            $res=$wpdb->get_row("SELECT * FROM $table WHERE code = '".$_REQUEST['term_name']."' and id !='".$_REQUEST['id']."' and url = '".$_REQUEST['post_content']."'");
            if(empty($res)) {
                $where = array(
                    'id' => $_REQUEST['id']
                );
                $update_customer = $wpdb->update($table, $args, $where);
                $_SESSION['s_message']='<span>Title has been updated.</span>';
            } else {
                $_SESSION['s_message']='<span>Title has been updated.</span>';
            }
        } else {
            $res=$wpdb->get_row("SELECT * FROM $table WHERE code = '".$_REQUEST['term_name']."' && url = '".$_REQUEST['post_content']."'");
            if(empty($res)) {
                $insert_customer = $wpdb->insert($table, $args);
                $_SESSION['s_message']='<span>Title is added.</span>';
            } else {
                $_SESSION['s_message']='<span>This title is already added.</span>';
            }
        }
    } else {
        $_SESSION['s_message']='<span>Please enter title.</span>';  
    }
    echo '<script>window.location.href="?page=location_list";</script>';
}

/** Select Movies Option  **/
function show_film() {
    global $wpdb;
    $table = $wpdb->prefix . "jacro_films";
    $cinema = $_REQUEST['cinema_id'];
    $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table WHERE location = %d", $cinema));
    $filmhtml = '';
    foreach($result as $films) :
        $filmhtml .= '<option value="'.$films->id.'">'.$films->filmtitle.'</option>';
    endforeach;
    $datas['html'] = $filmhtml;
    echo json_encode($datas); exit;
}
add_action( 'wp_ajax_show_film', 'show_film' );
add_action( 'wp_ajax_nopriv_show_film', 'show_film' );

function get_dates_from_cinema(){
    $args = array(
        'post_type' => 'film',
        'orderby' => 'post_title',
        'order' => 'ASC',
        'posts_per_page'=>-1,
        'meta_query' => array(
            array(
                'key' => 'jacroFilmTheatreID',
                'value' => $cinema_id,
                'compare' => '=',
            ),
        ),
    );
    $get_films = get_posts($args); $array_for_sorting = array();$couter = 0;$filmhtml='';$check_axist_array = array();
    if(!empty($get_films)):
        foreach($get_films as $key=>$films) {
            $fimtimes = check_times($films->ID);
            if(!empty($fimtimes)) :
                foreach($fimtimes as $key=>$fimtime) {
                    if(!in_array(strtotime($fimtime), $check_axist_array)){
                        $array_for_sorting[] = date('Y, m, d', strtotime($fimtime));
                        $check_axist_array[] = strtotime($fimtime);
                    }
                    $couter++;
                }
            endif;
        }
    endif;
    $datas['dates'] = $array_for_sorting; echo json_encode($datas); exit;
}
add_action( 'wp_ajax_get_dates_from_cinema', 'get_dates_from_cinema' );
add_action( 'wp_ajax_nopriv_get_dates_from_cinema', 'get_dates_from_cinema' );

function usort_function( $a, $b ) {
    return ($a["date"] - $b["date"]);
}

function show_timing() {
    $filmhtml .= '<option value="">Select</option>';
    $today_date = jacro_current_time(true, "Y-m-d");// current date
    $tomorrow_date = strtotime($today_date." +1 day");
    $fimtimes = check_times($_REQUEST['film_id']);
    if(!empty($fimtimes)) :
        foreach($fimtimes as $key=>$fimtime) {
            if(strtotime($today_date)==strtotime($fimtime)){
                $filmhtml .=  '<option value="'.$key.'">Today ('.date("l F jS", strtotime($fimtime)).')</option>';
            } else if($tomorrow_date==strtotime($fimtime)){
                $filmhtml .=  '<option value="'.$key.'">Tomorrow ('.date("l F jS", strtotime($fimtime)).')</option>';
            } else {
                $filmhtml .=  '<option value="'.$key.'">'.JacroDateFormate($fimtime).'</option>';
            }
        }
    endif;
    $datas['html'] = $filmhtml; echo json_encode($datas); exit;
}
add_action( 'wp_ajax_show_timing', 'show_timing' );
add_action( 'wp_ajax_nopriv_show_timing', 'show_timing' );

function check_times($film_ID) {
    $filmdates = array();
    $check_performance_on_date=check_performance_on_date($film_ID); $counter_key=0;
    if($check_performance_on_date) {
        foreach($check_performance_on_date as $key=>$post):
            $perform_date = $post->performdate;
            $perform_date = date("Y-m-d",strtotime($perform_date));
            if(is_array($filmdates)&&!in_array($perform_date, $filmdates)):
                $filmdates[$counter_key] = date("Y-m-d",strtotime($perform_date));$counter_key++;
            endif;
        endforeach;
    }
    return $filmdates;
}

function show_performances() {
    global $wpdb;
    $table_films = $wpdb->prefix . "jacro_films";
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

    $filmhtml = '';
    $fimtimes = check_times($_REQUEST['film_id']);
    if(!empty($fimtimes)) :
        $filmdate = date("Y-m-d",strtotime($fimtimes[$_REQUEST['timing_id']]));
    endif;
    $query = $wpdb->prepare("SELECT * FROM $table_performances WHERE location = %d AND performdate = %s AND selloninternet = %s ORDER BY starttime ASC", $cinema, $filmdate, 'Y');
    $post_arr = $wpdb->get_results($query);

    $count_res=0;
    $jacroBookNowOpenLink = get_option('jacroBookNowOpenLink');
    if(count($post_arr) > 0) {
        foreach($post_arr as $val) {
            $perform_date = $val->performdate;
            $start_time = $val->starttime;
            $trailer_time = $val->trailertime;
            $start_time = substr($start_time, 0, -3);
            $film_code = $val->filmcode;
            $wheelchair_accessible = $val->wheelchairaccessible;
            $subs = $val->subs;
            $cinema_name = get_option('term_'.$_REQUEST['cinemaid']);
            $screen = $val->screen;

            $existing_tmp = array();
            $filmresult = $wpdb->get_row("SELECT * FROM $table_films WHERE filmcode = " . $film_code);
            if($filmresult) {
                if (in_array($filmresult->filmtitle, $existing_tmp)) {
                    continue;
                } else {
                    $existing_tmp[] = $filmresult->filmtitle;
                }

                $per_title = $filmresult->filmtitle;
                $running_time = $filmresult->runningtime;
                $certificate = $filmresult->certificate_desc;
                $id_3d = $filmresult->is3d;
                if($id_3d=='N')
                    $id_3d='2D';
                else
                    $id_3d='3D';

            }

            $perf_flags=$val->perfflags;
            if(!empty($perf_flags)) {
                $perf_flag_arr=explode("|",$perf_flags);
                $perf_flags=implode(",",$perf_flag_arr);
            }

            $approx_end_time = JacroCountApproxEndTime($start_time, $running_time, $trailer_time);
            $jacroCountryname = get_option('jacroCountry-'.$_REQUEST['cinemaid']);

            $startTimeHourFormat = JacroTimeFormate($start_time, $jacroCountryname);
            $approxEndTimeFormate = JacroTimeFormate($approx_end_time, $jacroCountryname);

            if(strtotime(date('Y-m-d H:i', strtotime("$perform_date $start_time"))) > strtotime(current_time('Y-m-d H:i'))) {
                $a_class='';
                if($count_res==0):/*$a_class='active';*/endif;
                $show_perf='';
                $termsID = $val->location;
                $theatre_name = strtolower(preg_replace('/[^\\pL\d]+/u', '-', get_option('term_'.$termsID)));
                if(!$theatre_name){
                    $term = get_term_by( 'id', $termsID, 'theatre' ); 
                    $theatre_name = strtolower($term->name);
                } 
                $booking_url = home_url()."/".$theatre_name."/booknow/".$val->id;
                if(!empty($perf_flags)) {
                    $show_perf='<p class="heading"><span class="popup_left_text">Special Features</span><span class="popup_right_text">'.$perf_flags.'</span></p>';
                }
                $newTarget=''; if($jacroBookNowOpenLink==true): $newTarget = '_blank'; endif;
                $filmhtml .= '<a class="btn '.$a_class.' date_time_btn" data-toggle="modal" title="'.$cinema_name.' - '.$screen.'" data-target="#jacroPopup'.$val->id.'" href=".$booking_url." alt='.$per_title.'>'.$startTimeHourFormat.'</a>
                <div class="modal fade" id="jacroPopup'.$val->id.'" role="dialog">
                    <div class="modal-content">
                        <div class="popup-inner">
                            <span class="close" data-dismiss="modal"><img src="'.plugin_dir_url( __FILE__ ).'images/close-icon.png" width="16" height="16"></span>
                            <h4>PERFORMANCE DETAILS</h4>
                            <div class="popup-details">
                                <p><span>'.$per_title.'</span></p>
                                <p><span>'.JacroDateFormate($perform_date).'</span></p>
                                <p><span>Cinema Name:</span><span>'.$cinema_name.'</span></p>
                                <p><span>Screen:</span><span>'.$screen.'</p>
                                <p><span>Certificate:</span><span>'.$certificate.'</span></p>
                                <p><span>Start Time:</span><span>'.$startTimeHourFormat.'</span></p>
                                <p><span>Running Time:</span><span>'.$running_time.' mins.</span></p>
                                <p><span>Approx End Time:</span><span>'.$approxEndTimeFormate.'</span></p>
                                <p class="hr"></p>
                                <p><span>2D / 3D:</span><span>'.$id_3d.'</span></p>
                                <p><span>Subtitled:</span><span>'.$subs.'</span></p>
                                <p><span>Wheelchair Access:</span><span>'.$wheelchair_accessible.'</span></p>'.$show_perf.'
                                <div class="book">
                                    <a href="'.$booking_url.'" target="'.$newTarget.'">BOOK NOW</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
                $count_res++;
            }
        }
        if($count_res==0) {
            $filmhtml .= '<div class="top-time"><label for="empty">No performance found.</label></div>';
        }
        // Popup Script
        $filmhtml .= "";
    } else {
        $filmhtml .= '<div class="top-time"><label for="empty">No performance found.</label> </div>';
    }
    $datas['html'] = $filmhtml; echo json_encode($datas); exit;
}
add_action( 'wp_ajax_show_performances', 'show_performances' );
add_action( 'wp_ajax_nopriv_show_performances', 'show_performances' );

function get_films_from_date(){
    $filmhtml = '';
    $time_stamp = str_replace(' ', '', ($_REQUEST['timing_id']));
    $time_stamp = strtotime($time_stamp);
    $filmdate = date("Y-m-d",$time_stamp);
    $cinemaid = $_REQUEST['cinemaid'];

    $time = jacro_current_time(true, 'H:i:s');
    if(strtotime(jacro_current_time(true, 'Y-m-d'))==strtotime($filmdate)){
        $meta_query = array(
            'relation' => 'AND',
            array(
                'key'     => 'perform_date',
                'value'   => $filmdate,
                'compare' => '=',
            ), array(
                'key'     => 'start_time',
                'value'   => $time,
                'compare' => '>=',
            ), array(
                'key'       =>  'performance_theater',
                'value'     =>  $cinemaid,
                'compare'   =>  '=',
            ),
        );
    } else {
        $meta_query = array(
            'relation' => 'AND',
            array(
                'key'     => 'perform_date',
                'value'   => $filmdate,
                'compare' => '=',
            ), array(
                'key'       =>  'performance_theater',
                'value'     =>  $cinemaid,
                'compare'   =>  '=',
            ),
        );
    }
    $args_check_per = array(
        'post_type' => 'performance',
        'orderby' => 'ID',
        'press_report' => 'press_report',
        'order' => 'DESC',
        'posts_per_page'=>-1,
        'meta_query' => $meta_query
    );
    $related_films = ''; $already_exist_array = array();
    $postsarr = get_posts($args_check_per);
    if(!empty($postsarr)):
        foreach($postsarr as $fils) {
            $film_id = $fils->post_parent;
            $film_name = get_the_title($fils->post_parent);
            if(!in_array($film_name, $already_exist_array)){
                $already_exist_array[] = $film_name;
                $related_films .= '<option value="'.esc_attr($film_id).'">'.esc_html($film_name).'</option>';
            } else {continue;}
        }
    endif;
    $returl_data['html'] = $related_films;
    echo json_encode($returl_data); exit;
}
add_action( 'wp_ajax_get_films_from_date', 'get_films_from_date' );
add_action( 'wp_ajax_nopriv_get_films_from_date', 'get_films_from_date' );

function get_performances_from_date(){
    $filmhtml = '';
    $time_stamp = str_replace(' ', '', ($_REQUEST['timing_id']));
    $time_stamp = strtotime($time_stamp);
    $filmdate = date("Y-m-d",$time_stamp);
    $args = array(
        'post_type' => 'performance',
        'post_parent' => $_REQUEST['film_id'],
        'posts_per_page'=>-1,
        'order' => 'ASC',
        'orderby' => 'meta_value',
        'meta_key' => 'start_time',
        'meta_query' => array(
            array(
                'key' => 'perform_date',
                'value' => $filmdate,
                'compare' => '=',
            ), array(
                'key' => 'performance_theater',
                'value' => $_REQUEST['cinemaid'],
                'compare' => '=',
            ), array(
                'key' => 'sellon_internet',
                'value' => 'Y',
                'compare' => '=',
            )
        )
    );
    $post_arr = get_posts($args);
    $count_res=0;
    $jacroBookNowOpenLink   =   get_option('jacroBookNowOpenLink');
    if(count($post_arr) > 0) {
        foreach($post_arr as $val) {
            $per_title=get_the_title($val->ID);
            $perform_date=get_post_meta($val->ID, "perform_date",true);
            $start_time=get_post_meta($val->ID,"start_time",true);
            $trailer_time=get_post_meta($val->ID,"trailer_time",true);
            $start_time=substr($start_time, 0, -3);
            $film_code=get_post_meta($val->ID,"film_code",true);
            $wheelchair_accessible=get_post_meta($val->ID,"wheelchair_accessible",true);
            $subs=get_post_meta($val->ID,"subs",true);
            $cinema_name = get_option('term_'.$_REQUEST['cinemaid']);
            $screen = get_post_meta($val->ID,"screen",true);
            $running_time=get_post_meta($_REQUEST['film_id'], "running_time",true);
            $certificate= (get_post_meta($_REQUEST['film_id'], "certificate",true))?get_post_meta($_REQUEST['film_id'],"certificate",true):'&nbsp;';
            $id_3d=get_post_meta($_REQUEST['film_id'],"id_3d",true);
            if($id_3d=='N')
                $id_3d='2D';
            else
                $id_3d='3D';
            $perf_flags=get_post_meta($_REQUEST['film_id'], "perf_flags",true);
            if(!empty($perf_flags)) {
                $perf_flag_arr=explode("|",$perf_flags);
                $perf_flags=implode(",",$perf_flag_arr);
            }

            $approx_end_time = JacroCountApproxEndTime($start_time, $running_time, $trailer_time);
            $jacroCountryname = get_option('jacroCountry-'.$_REQUEST['cinemaid']);

            $startTimeHourFormat = JacroTimeFormate($start_time, $jacroCountryname);
            $approxEndTimeFormate = JacroTimeFormate($approx_end_time, $jacroCountryname);

            if(strtotime(date('Y-m-d H:i', strtotime("$perform_date $start_time"))) > strtotime(current_time('Y-m-d H:i'))) {
                $a_class='';
                if($count_res==0):/*$a_class='active';*/endif;
                $show_perf='';
                $postdatas = get_post($_REQUEST['film_id']);
                //$terms = wp_get_post_terms( $_REQUEST['film_id'], "theatre", array( 'fields' => 'ids' ));
                $termsID = get_post_meta( $_REQUEST['film_id'], "jacroFilmTheatreID", true);
                $theatre_name = strtolower(preg_replace('/[^\\pL\d]+/u', '-', get_option('term_'.$termsID)));
                if(!$theatre_name){
                    $term = get_term_by( 'id', $termsID, 'theatre' ); 
                    $theatre_name = strtolower($term->name);
                } 
                $booking_url = home_url()."/".$theatre_name."/booknow/".$val->ID;
                if(!empty($perf_flags)) {
                    $show_perf='<p class="heading"><span class="popup_left_text">Special Features</span><span class="popup_right_text">'.$perf_flags.'</span></p>';
                }
                $newTarget=''; if($jacroBookNowOpenLink==true): $newTarget = '_blank'; endif;
                $filmhtml .= '<a class="btn '.$a_class.' date_time_btn" data-toggle="modal" title="'.$cinema_name.' - '.$screen.'" data-target="#jacroPopup'.$val->ID.'" href="#" alt='.$per_title.'>'.$startTimeHourFormat.'</a>
                <div class="modal fade" id="jacroPopup'.$val->ID.'" role="dialog">
                    <div class="modal-content">
                        <div class="popup-inner">
                            <span class="close" data-dismiss="modal"><img src="'.plugin_dir_url( __FILE__ ).'images/close-icon.png" width="16" height="16"></span>
                            <h4>PERFORMANCE DETAILS</h4>
                            <div class="popup-details">
                                <p><span>'.get_the_title($_REQUEST['film_id']).'</span></p>
                                <p><span>'.JacroDateFormate($perform_date).'</span></p>
                                <p><span>Cinema Name:</span><span>'.$cinema_name.'</span></p>
                                <p><span>Screen:</span><span>'.$screen.'</p>
                                <p><span>Certificate:</span><span>'.$certificate.'</span></p>
                                <p><span>Start Time:</span><span>'.$startTimeHourFormat.'</span></p>
                                <p><span>Running Time:</span><span>'.$running_time.' mins.</span></p>
                                <p><span>Approx End Time:</span><span>'.$approxEndTimeFormate.'</span></p>
                                <p class="hr"></p>
                                <p><span>2D / 3D:</span><span>'.$id_3d.'</span></p>
                                <p><span>Subtitled:</span><span>'.$subs.'</span></p>
                                <p><span>Wheelchair Access:</span><span>'.$wheelchair_accessible.'</span></p>'.$show_perf.'
                                <div class="book">
                                    <a href="'.$booking_url.'" target="'.$newTarget.'">BOOK NOW</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
                $count_res++;
            }
        }
        if($count_res==0) {
            $filmhtml .= '<div class="top-time"><label for="empty">No performance found.</label></div>';
        }
        // Popup Script
        $filmhtml .= "";
    } else {
        $filmhtml .= '<div class="top-time"><label for="empty">No performance found.</label> </div>';
    }
    $datas['html'] = $filmhtml; echo json_encode($datas); exit;
}
add_action( 'wp_ajax_get_performances_from_date', 'get_performances_from_date' );
add_action( 'wp_ajax_nopriv_get_performances_from_date', 'get_performances_from_date' );

/*function check_performance_on_date($film_id=NULL, $date, $time) {*/
function check_performance_on_date($film_id=NULL) {
    global $wpdb;
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

    $postsarr = array(); 
    $date = jacro_current_time(true, 'Y-m-d');

    $query = $wpdb->prepare("SELECT * FROM $table_performances WHERE location = %d AND filmcode = %s AND performdate >= %s AND selloninternet = %s ORDER BY performdate ASC", $cinema, $film_id, $date, 'Y');
    $result = $wpdb->get_results($query);

    if($result) {
        return $result;
    }
}

function check_film_on_date($cinema_id='', $date='', $time='') {
    global $wpdb;
    $table = $wpdb->prefix . "jacro_performances";
    if(strtotime(jacro_current_time(true, 'Y-m-d')) == strtotime($date)){
        $query = $wpdb->prepare("SELECT * FROM $table WHERE location = %d AND performdate = %s AND starttime = %s", $cinema_id, $date, $time);
        $result = $wpdb->get_results($query);
    } else {
        $query = $wpdb->prepare("SELECT * FROM $table WHERE location = %d AND performdate = %s", $cinema_id, $date);
        $result = $wpdb->get_results($query);
    }
    return count($result);
}

/** start time sort in film secion third **/
if ( ! function_exists('prformanceSorting') ) {
    function prformanceSorting ($a, $b) {
        return strcmp($a['start_time'], $b['start_time']);
    }
}

/** time sort in calendar **/
function my_sort($a,$b) {
    return strcmp($a['time'], $b['time']);
}

function titleSorting ($a, $b) {
    return strcasecmp($a['title'], $b['title']);
}

/* theatre name */
function jacro_theatre_name($id){
    global $wpdb;
    $table = $wpdb->prefix . "jacro_locations";
    $result = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM $table WHERE id = %d", $id)
    );
    $name = $result->name;
    return $name;
}

/* wp date */
function jacro_strtotimezone($cinema_id){
    global $wpdb;
    $table_locations = $wpdb->prefix . "jacro_locations";

    $strtotimezone = '';
    $locresult = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_locations WHERE id = %d", $cinema_id));

    $cinematimezone = $locresult->timezone;
    if(isset($cinematimezone)) {
        date_default_timezone_set('UTC');
        date('d-m-Y g:i:s A', strtotime("$cinematimezone hours"));
        date('d-m-Y g:i:s A', time() + ($cinematimezone * 60 * 60));
        $date = new DateTime;
        $date->modify("$cinematimezone hours");
        $strtotimezone = strtotime($date->format('Y-m-d H:i:s'));
    }   

    if(!$cinema_id) {
        $strtotimezone = current_time('timestamp');
    }

    return $strtotimezone;
}

/** Get films with showtime layout using ajax **/
function jacro_filter_result() {

    $cookie_name = "visitedcinema_id";
    $cookie_value = $_REQUEST['cinema_id'];
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
    
    if(empty($_REQUEST['film_type'])){       
        if(isset($_COOKIE['jacroFilmType']) && $_COOKIE['jacroFilmType']!='') : 
            $_REQUEST['film_type'] = $_COOKIE['jacroFilmType'];
        else :
           $_REQUEST['film_type'] = 'Now Showing';
        endif;
    }

    $show_time_header = get_option("show_time_header");
    $tab_header_now_showing = get_option("tab_header_now_showing");
    $tab_header_advance_bookings = get_option("tab_header_advance_bookings");
    $tab_header_new_releases = get_option("tab_header_new_releases");
    $groupby_performance_modifiers = get_option("groupby_performance_modifiers");
    $date_sort_recent = (get_option("date-sort-recent")?get_option("date-sort-recent"):false);
    $order_by_date=false;
    $eventlocation = get_option('includevenue');
    if(($date_sort_recent)&&($_REQUEST['film_date']!='moredates')){$order_by_date=true;}

    $post_films = get_films( $_REQUEST['film_type'], $_REQUEST['cinema_id'], $_REQUEST['film_date'],$order_by_date );

    $fimlPerPage = 10;
    $count_time=0; $count_row=1; $datasarray = array();
        
    if (function_exists('fw_get_db_settings_option')) {
        $primaryColour = fw_get_db_settings_option('primary_colour');
        $secondaryColour = fw_get_db_settings_option('secondary_colour');
    } else {
        $primaryColour = get_option('primary_colour');
        $secondaryColour = get_option('secondary_colour'); 
    }

    foreach($post_films['post'] as $key=>$film_val) {  

        $post_arr = get_performances( $film_val->code, $_REQUEST['film_date'] ,$_REQUEST['film_type'], $_REQUEST['cinema_id']);
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

            foreach($post_arr as $perfpost) :
                $pfcatclass = strtolower(str_replace(' ', '_', $perfpost->perfcat));
                $perfclass[] = ' percate'.preg_replace('/[^A-Za-z0-9]/', '', $pfcatclass);
            endforeach;
            $perfclass = array_unique($perfclass);
            $filmperfclass = implode(" ",$perfclass);

            foreach($post_arr as $val):

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
                    $mod_scores = show_modifiers($_REQUEST['cinema_id']);
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

                // Get Date and Time based on Timezone
                if($_COOKIE['cinema_id'] && $_COOKIE['cinema_id'] != 'undefined') {
                    $idcine = $_COOKIE['cinema_id'];
                } elseif($_COOKIE['visitedcinema_id'] && $_COOKIE['visitedcinema_id'] != 'undefined') {
                    $idcine = $_COOKIE['visitedcinema_id'];
                }
                
                $strtotimezone = jacro_strtotimezone($idcine);

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
                    $datasarray[$perform_date][$filmtitle]['film_type'] = $_REQUEST['film_type'];
                    $datasarray[$perform_date][$filmtitle]['film_date'] = $_REQUEST['film_date'];
                    $datasarray[$perform_date][$filmtitle][$val->id]['cinema_name'] = get_option('term_'.$_REQUEST['cinema_id']);
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
            endforeach;
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

    if(isset($datasarray)&&!empty($datasarray)) : 

        $countFilms=count($datasarray);

        ksort($datasarray);
        $existing_tmp = array();  
        foreach($datasarray as $file_date=>$films_datast) :

            usort($films_datast, 'prformanceSorting');

            $films_data = array();
            foreach($films_datast as $newfdate){
                $films_data[$newfdate['title']]=$newfdate;
            }    
            foreach($films_data as $file_title=>$films):   
                if($_REQUEST['film_date']=='moredates' || $_REQUEST['film_type']!='Now Showing') :
                    if(in_array($file_title, $existing_tmp)){
                        continue;
                    }else {
                        $existing_tmp[]=$file_title;
                    }
                endif;

                $firstShowDate = 0;
                $bookNowNewTarget=''; if($jacroBookNowOpenLink==true): $bookNowNewTarget = '_blank'; endif;
                $moreShowTimeTarget=''; if($jacroMoreShowtimesLink==true): $moreShowTimeTarget = '_blank'; endif;
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

                    if($_REQUEST['film_type'] != 'Coming Soon') {
           
                        /*** PERF & CERTS ETC ***/
                        $filspostshtml .= '<div class="row"><div class="col-md-8 col-sm-9 time2">';
                        $filspostshtml .= '<div style="margin-top:5px;">';
                            /*** SHOW TIME "logic" ***/
                            $jacroListClass = 'jacro-showtime-list';
                            if($_REQUEST['film_date']=='moredates' || $_REQUEST['film_type']!='Now Showing') {
                                $jacroListClass = 'jacro-date-showtime-list';
                            }
                            $trueMoreShowTime = true;

                            if($_REQUEST['film_type']!='New Release') :  

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
                                    if($films['showTimeClass']!=-1) :
                                        //if(($jacroTotalShowTime>$films['showTimeClass'] || ($jacroCountDate>=1))&&($trueMoreShowTime==true)) {
                                        if(($jacroTotalShowTime>$films['showTimeClass'])&&($trueMoreShowTime==true)) {
                                            $trueMoreShowTime = false; 
                                            //break;
                                        }
                                        $jacroCountDate++;
                                    endif;
                                    if(isset($films[$performace_id]) && ($films[$performace_id]!='')) :
                                        $jacroTotalShowTime=($jacroTotalShowTime+1);
                                        if($films['showTimeClass']!=-1) :
                                            if(($jacroTotalShowTime>$films['showTimeClass'])&&($trueMoreShowTime==true)) {
                                                $trueMoreShowTime = true;
                                                    //break;
                                            }
                                        endif;
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
                                            $jacroShowTimeHour  =   get_option('jacroShowTimeHour');
                                            if($jacroShowTimeHour == true) {
                                                $jacrobookTimeFormat  = date("g:i a", strtotime($films[$performace_id]['start_time']));
                                            } else {
                                                $jacrobookTimeFormat  = date("H:i", strtotime($films[$performace_id]['start_time']));
                                            }

                                            $pfclass_array = explode(' ', $films[$performace_id]['perf_cat_class']);
                                            $pfclass_array_unique = array_unique($pfclass_array);
                                            $pfclass_string_unique = implode(' ', $pfclass_array_unique);

                                            $filspostshtml .= '<div class="1 singlefilmperfs '.$pfclass_string_unique.'">';
                                               
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
                                                        $filspostshtml .= '<a class="perfbtn 1 disabled">Sold out</a>';
                                                    }else{
                                                        $filspostshtml .= '<a class="perfbtn 1" '.$alertinfo.' href="'.$films[$performace_id]['book_now_url'].'">'.get_option('showtime_button_text').' '.$jacrobookTimeFormat.' '.$pfbtntxt.'</a>';
                                                    }
                                                }else{
                                                    if($films[$performace_id]['soldoutlevel'] && $films[$performace_id]['soldoutlevel']=='Y'){
                                                        $filspostshtml .= '<a class="perfbtn 1 disabled">Sold out</a>';
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
                                    endif;

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
                                foreach($arct as $keytop => $valtop) : 
                                    $totalpr = count($valtop);
                                    $sameprct = 1;
                                    $filspostshtml .='<div class="innercatdived" style="display:none;">';
                                    foreach ($valtop as $performace_id => $classname) {   
                                        $date= $file_date;
                                        if($films['showTimeClass']!=-1) :
                                            //if(($jacroTotalShowTime>$films['showTimeClass'] || ($jacroCountDate>=1))&&($trueMoreShowTime==true)) {
                                            if(($jacroTotalShowTime>$films['showTimeClass'])&&($trueMoreShowTime==true)) {
                                                $trueMoreShowTime = false; 
                                                //break;
                                            }
                                            $jacroCountDate++;
                                        endif;
                                        if(isset($films[$performace_id]) && ($films[$performace_id]!='')) :    
                                            $jacroTotalShowTime=($jacroTotalShowTime+1);
                                            if($films['showTimeClass']!=-1) :
                                                if(($jacroTotalShowTime>$films['showTimeClass'])&&($trueMoreShowTime==true)) {
                                                    $trueMoreShowTime = true;
                                                        //break;
                                                }
                                            endif;
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
   
                                                $jacroShowTimeHour  =   get_option('jacroShowTimeHour');
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
                                                            $filspostshtml .= '<a class="perfbtn 1 disabled">Sold out</a>';
                                                        }else{
                                                            $filspostshtml .= '<a class="perfbtn 1" '.$alertinfo.' href="'.$films[$performace_id]['book_now_url'].'">'.get_option('showtime_button_text').' '.$jacrobookTimeFormat.' '.$pfbtntxt.'</a>';
                                                        }
                                                    }else{
                                                        if($films[$performace_id]['soldoutlevel'] && $films[$performace_id]['soldoutlevel']=='Y'){
                                                            $filspostshtml .= '<a class="perfbtn 1 disabled">Sold out</a>';
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
                                        endif;

                                        if($films['film_type']!='Now Showing' || $films['film_date']=='moredates'){ $filspostshtml .= ''; }
                                    }
                                    $filspostshtml .= '</div>';        
                                endforeach;
                                
                                if($trueMoreShowTime==true||($jacroCountDate>=1)) :
                                    $more_showtimes_html = '<a href="'.$films['permalink'].'" class="moreshowtimes" target="'.$moreShowTimeTarget.'">More showtimes</a></div>';
                                endif;
                                else :
                                    if (!$groupby_performance_modifiers) { 
                                        $more_showtimes_html = '<a href="'.$films['permalink'].'" class="moreshowtimes" target="'.$moreShowTimeTarget.'">Showtimes</a></div>';
                                    }
                                endif;

                                /*** "logic" ends ***/
                                
                                if ($groupby_performance_modifiers) { 
                                    // JIRA - Add formatted showtimes_html to the page
                                    $filspostshtml .= generate_showtime_html($films, $arct);
                                    $filspostshtml .= $more_showtimes_html;
                                    
                                    
                                } else {
                                }
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
                    /*** FILM CONTAINER ENDS ***/
                    $filspostshtml .= '</div></div></div></div></div>';
                    
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
            endforeach;
        endforeach;
    endif;

    if($homepage_layout == 'posters') {
        $filspostshtml .= "</div>";
    }

    if($count_row==1) {
        $filspostshtml .= '<div class="col-xs-12 col-sm-4 col-md-4 main-film-area"> <p>No Films Available.</p> </div>';
    }
    if(isset($_REQUEST['film_date'])) :
        //setcookie('jacroFilmDate', $_REQUEST['film_date'], time()+120, '/');
    endif;
    if(isset($_REQUEST['film_type']) && $_REQUEST['film_type'] !='') {
        //setcookie('jacroFilmType', $_REQUEST['film_type'], time()+120, '/');
    }
    $filspostshtml .= $datas['html'] = $filspostshtml;
    echo json_encode($datas); exit;
}
add_action( 'wp_ajax_jacro_filter_result', 'jacro_filter_result' );
add_action( 'wp_ajax_nopriv_jacro_filter_result', 'jacro_filter_result' );

/* ajax action - search filter */
function search_filter_results() {
    global $wpdb;
    $table = $wpdb->prefix . "jacro_films";
    $table_performances = $wpdb->prefix . "jacro_performances";

    $cinema = $_REQUEST['cinema_id'];

    $search_string = sanitize_text_field($_REQUEST['searchfilter']);
    $search_string = preg_replace('/[^\w\s].*/', '', $search_string);
    $search_words = explode(' ', $search_string);

    $query = "SELECT * FROM $table WHERE location = %d AND (";
    $placeholder_values = array($cinema);

    foreach ($search_words as $index => $word) {
        if ($index == 0) {
            $query .= "(";
        } else {
            $query .= " AND ";
        }

        $query .= "(filmtitle LIKE %s OR synopsis LIKE %s)";
        $placeholder_values[] = '%' . $word . '%';
        $placeholder_values[] = '%' . $word . '%';

        if ($index == count($search_words) - 1) {
            $query .= ")";
        }
    }

    $query .= ")";
    $query = $wpdb->prepare($query, $placeholder_values);
    $post_films = $wpdb->get_results($query);

    $show_time_header = get_option("show_time_header");
    $tab_header_now_showing = get_option("tab_header_now_showing");
    $tab_header_advance_bookings = get_option("tab_header_advance_bookings");
    $tab_header_new_releases = get_option("tab_header_new_releases");
    $groupby_performance_modifiers = get_option("groupby_performance_modifiers");
    $date_sort_recent = (get_option("date-sort-recent")?get_option("date-sort-recent"):false);$order_by_date=false;
    $eventlocation = get_option('includevenue');
    if(($date_sort_recent)&&($_REQUEST['film_date']!='moredates')){
        $order_by_date=true;
    }

    $count_time=0; $count_row=1; $datesarray = array();
    if (function_exists('fw_get_db_settings_option')) {
        $primaryColour = fw_get_db_settings_option('primary_colour');
        $secondaryColour = fw_get_db_settings_option('secondary_colour');
    } else {
        $primaryColour = get_option('primary_colour');
        $secondaryColour = get_option('secondary_colour'); 
    }
    foreach($post_films as $key=>$film_val) {
        $nc_filmclass = '';
        $post_arr = get_performances( $film_val->code, $_REQUEST['film_date'] ,$_REQUEST['film_type'], $_REQUEST['cinema_id']);
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
            $synopsis=balanceTags($film_val->synopsis, true);
            $id_3d=$film_val->is3d;
            $id_3d=filmCheckDimension($id_3d);

            $filmtitle = $film_val->filmtitle;
            $filmlink = $film_val->url;

            $film_date='';
            //$performancepostmeta = get_post_meta($post_arr[0]->ID);
            $perfclass=array(); $perfromanceclass = ''; $filmclass = ''; $dateclass = '';
            foreach($filmspostmeta['genre'] as $filmpost) :
                $filmclass .= ' filmecat_'.strtolower(str_replace(' ', '_', $filmpost));
            endforeach;

            foreach($post_arr as $perfpost) :
                $pfcatclass = strtolower(str_replace(' ', '_', $perfpost->perfcat));
                $perfclass[] = ' percate'.preg_replace('/[^A-Za-z0-9]/', '', $pfcatclass);
            endforeach;
            $perfclass = array_unique($perfclass);
            $filmperfclass = implode(" ",$perfclass);

            // foreach($performancepostmeta['perform_date'] as $datefpost) :
            //     $dateclass .= ' date_'.strtolower(str_replace(' ', '_', $datefpost));
            // endforeach;
            foreach($post_arr as $val):

                $perform_date=$val->performdate;
                $start_time=$val->starttime;             
                $trailer_time=$val->trailertime;
                $press_report=$val->pressreport;
                $perf_cat=$val->perfcat;
                $film_code=$val->filmcode;
                $screen=$val->screen;
                $wheelchair_accessible=$val->wheelchairaccessible;
                $subs=$val->subs;
                $ad=$val->ad;
                $perf_flags=$val->perfflags;

                $ctclass = strtolower(str_replace(' ', '_', $perf_cat));
                $nc_filmclass .= ' percate'.preg_replace('/[^A-Za-z0-9]/', '', $ctclass);

                if(!empty($perf_flags)) {
                    $perf_flag_arr=explode("|",$perf_flags);
                    $perf_flags=implode(",",$perf_flag_arr);
                }
                if(empty($film_date)) {
                    $film_date=$perform_date;
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

                if($_COOKIE['cinema_id'] && $_COOKIE['cinema_id'] != 'undefined') {
                    $idcine = $_COOKIE['cinema_id'];
                } elseif($_COOKIE['visitedcinema_id'] && $_COOKIE['visitedcinema_id'] != 'undefined') {
                    $idcine = $_COOKIE['visitedcinema_id'];
                }
                
                $strtotimezone = jacro_strtotimezone($idcine);

                if(strtotime("$perform_date $start_time") > $strtotimezone) { 
                    $datasarray[$perform_date][$filmtitle]['class'] = $filmclass.$filmperfclass.$dateclass.' s1';
                    $datasarray[$perform_date][$filmtitle]['permalink'] = $filmlink;
                    $datasarray[$perform_date][$filmtitle]['showTimeClass'] = $jacro_showtime_length;
                    $datasarray[$perform_date][$filmtitle]['title'] = $filmtitle;
                    $datasarray[$perform_date][$filmtitle]['img_url'] = $img_url;
                    $datasarray[$perform_date][$filmtitle]['start_time'] = $start_time;
                    $datasarray[$perform_date][$filmtitle]['default_img_url'] = $default_image;
                    $datasarray[$perform_date][$filmtitle]['genre'] = $genre;
                    $datasarray[$perform_date][$filmtitle]['synopsis'] = $synopsis;
                    $datasarray[$perform_date][$filmtitle]['certs'] = $certificate;
                    $datasarray[$perform_date][$filmtitle]['runtime'] = $running_time;
                    $datasarray[$perform_date][$filmtitle]['IDs'][$val->id] = $val->id;
                    $datasarray[$perform_date][$filmtitle]['sorting_dates'] = $perform_date;
                    $datasarray[$perform_date][$filmtitle]['dates'][$perform_date] = $perform_date;
                    $datasarray[$perform_date][$filmtitle]['film_type'] = $_REQUEST['film_type'];
                    $datasarray[$perform_date][$filmtitle]['film_date'] = $_REQUEST['film_date'];
                    $datasarray[$perform_date][$filmtitle][$val->id]['cinema_name'] = get_option('term_'.$_REQUEST['cinema_id']);
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
            endforeach;
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
    if(isset($datasarray)&&!empty($datasarray)) :
        $countFilms=count($datasarray);
        if(!$order_by_date){ksort($datasarray);}
        $existing_tmp = array();       
        foreach($datasarray as $file_date=>$films_datast) :

            usort($films_datast, 'prformanceSorting');

            $films_data = array();
            foreach($films_datast as $newfdate){
                $films_data[$newfdate['title']]=$newfdate;
            }

            foreach($films_data as $file_title=>$films):
                if($_REQUEST['film_date']=='moredates' || $_REQUEST['film_type']!='Now Showing') :
                    if(in_array($file_title, $existing_tmp)){continue;}
                    else {$existing_tmp[]=$file_title;}
                endif;
                $firstShowDate = 0;
                $bookNowNewTarget=''; if($jacroBookNowOpenLink==true): $bookNowNewTarget = '_blank'; endif;
                $moreShowTimeTarget=''; if($jacroMoreShowtimesLink==true): $moreShowTimeTarget = '_blank'; endif;
                                /*** START FILM CONTAINER ***/
                                /*** GRAB SUPER COOL STYLING ***/
                                $class_array = explode(' ', $films['class']);
                                $class_array_unique = array_unique($class_array);
                                $class_string_unique = implode(' ', $class_array_unique);

                                if($homepage_layout == 'detail') {
                                $filspostshtml .= '<style>.perfbtn{color: #fff; background-color:' . $primaryColour . ' !important;}.perfbtn:hover{color:#fff !important; background-color:' . $secondaryColour . ' !important;} .moreshowtimes {background-image: linear-gradient(to right, ' . $primaryColour. ', ' . $secondaryColour  . ') !important;}.moreshowtimes:hover {color: #fff !important; background-image: linear-gradient(to right, ' . $secondaryColour. ', ' . $secondaryColour  . ') !important;}</style>';
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

                                    if($_REQUEST['film_type'] == 'Coming Soon') {
                    
                                    } else {
                                    /*** PERF & CERTS ETC ***/
                                    $filspostshtml .= '<div class="row"><div class="col-md-8 col-sm-9 time1">';
                                        /*** SHOW TIMES ***/
//                                         if($show_time_header){
//                                         $filspostshtml .= '<span class="viewing-times"><i class="fa fa-clock-o"></i>'.$show_time_header.'</span>';
//                                      }
                                        $filspostshtml .= '<div style="margin-top:5px;">';
                                            /*** SHOW TIME "logic" ***/
                                            $jacroListClass = 'jacro-showtime-list';
                                            if($_REQUEST['film_date']=='moredates' || $_REQUEST['film_type']!='Now Showing') {
                                                $jacroListClass = 'jacro-date-showtime-list';
                                            }
                                            $trueMoreShowTime = true;

                                            if($_REQUEST['film_type']!='New Release') :
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
                                                    if($films['showTimeClass']!=-1) :
                                                        //if(($jacroTotalShowTime>$films['showTimeClass'] || ($jacroCountDate>=1))&&($trueMoreShowTime==true)) {
                                                        if(($jacroTotalShowTime>$films['showTimeClass'])&&($trueMoreShowTime==true)) {
                                                            $trueMoreShowTime = false; 
                                                            //break;
                                                        }
                                                        $jacroCountDate++;
                                                    endif;
                                                    if(isset($films[$performace_id]) && ($films[$performace_id]!='')) :
                                                        $jacroTotalShowTime=($jacroTotalShowTime+1);
                                                        if($films['showTimeClass']!=-1) :
                                                            if(($jacroTotalShowTime>$films['showTimeClass'])&&($trueMoreShowTime==true)) {
                                                                $trueMoreShowTime = true;
                                                                    //break;
                                                            }
                                                        endif;
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

                                                            $jacroShowTimeHour  =   get_option('jacroShowTimeHour');
                                                            if($jacroShowTimeHour == true) {
                                                                $jacrobookTimeFormat  = date("g:i a", strtotime($films[$performace_id]['start_time']));
                                                            } else {
                                                                $jacrobookTimeFormat  = date("H:i", strtotime($films[$performace_id]['start_time']));
                                                            }

                                                            $pfclass_array = explode(' ', $films[$performace_id]['perf_cat_class']);
                                                            $pfclass_array_unique = array_unique($pfclass_array);
                                                            $pfclass_string_unique = implode(' ', $pfclass_array_unique);

                                                            $filspostshtml .= '<div class="1.b singlefilmperfs '.$pfclass_string_unique.'">';
                                                            
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
                                                                        $filspostshtml .= '<a class="perfbtn 1 disabled">Sold out</a>';
                                                                    }else{
                                                                        $filspostshtml .= '<a class="perfbtn 1" '.$alertinfo.' href="'.$films[$performace_id]['book_now_url'].'">'.get_option('showtime_button_text').' '.$jacrobookTimeFormat.' '.$pfbtntxt.'</a>';
                                                                    }
                                                                }else{
                                                                    if($films[$performace_id]['soldoutlevel'] && $films[$performace_id]['soldoutlevel']=='Y'){
                                                                        $filspostshtml .= '<a class="perfbtn 1.1b disabled">Sold out</a>';
                                                                    }else{
                                                                        $filspostshtml .= '<a class="perfbtn 1.1b" '.$alertinfo.' href="'.$films[$performace_id]['book_now_url'].'">'.$jacrobookTimeFormat.' '.$pfbtntxt.'</a>';
                                                                    }
                                                                }
                                                                $filspostshtml .= '<input type="hidden" class="perfcat_message" value="'.$pfbtnmsg.'">';
                                                            }
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
                                                    endif;

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
                                                foreach($arct as $keytop => $valtop) :
                                                    $totalpr = count($valtop);
                                                    $sameprct = 1;
                                                    $filspostshtml .='<div class="innercatdived" style="display:none;">';
                                                    foreach ($valtop as $performace_id => $classname) {
                                                        $date= $file_date;
                                                    if($films['showTimeClass']!=-1) :
                            //if(($jacroTotalShowTime>$films['showTimeClass'] || ($jacroCountDate>=1))&&($trueMoreShowTime==true)) {
                            if(($jacroTotalShowTime>$films['showTimeClass'])&&($trueMoreShowTime==true)) {
                                $trueMoreShowTime = false; 
                                //break;
                            }
                            $jacroCountDate++;
                                                    endif;
                                                    if(isset($films[$performace_id]) && ($films[$performace_id]!='')) :
                            $jacroTotalShowTime=($jacroTotalShowTime+1);
                                                            if($films['showTimeClass']!=-1) :
                                if(($jacroTotalShowTime>$films['showTimeClass'])&&($trueMoreShowTime==true)) {
                                    $trueMoreShowTime = true;
                                        //break;
                                }
                                                            endif;
                                                            if($firstShowDate==0) {
                                $jacroDateFormate = JacroDateFormate($date);
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

        $jacroShowTimeHour  =   get_option('jacroShowTimeHour');
        if($jacroShowTimeHour == true) {
            $jacrobookTimeFormat  = date("g:i a", strtotime($films[$performace_id]['start_time']));
        } else {
            $jacrobookTimeFormat  = date("H:i", strtotime($films[$performace_id]['start_time']));
        }

        $indexes = array_keys($newarcat, $films[$performace_id]['perf_cat_class']);
        $filspostshtml .= '<div class="2 singlefilmperfs '.$films[$performace_id]['perf_cat_class'].' count'.count($indexes).'"><div="perfmods">';
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
                    $filspostshtml .= '<a class="perfbtn 2 disabled">Sold out</a>';
                }else{
                    $filspostshtml .= '<a class="perfbtn 2" '.$alertinfo.' href="'.$films[$performace_id]['book_now_url'].'">'.get_option('showtime_button_text').' '.$jacrobookTimeFormat.' '.$pfbtntxt.'</a>';
                }
            }else{
                if($films[$performace_id]['soldoutlevel'] && $films[$performace_id]['soldoutlevel']=='Y'){
                    $filspostshtml .= '<a class="perfbtn 2.1 disabled">Sold out</a>';
                }else{
                    $filspostshtml .= '<a class="perfbtn 2.1" '.$alertinfo.' href="'.$films[$performace_id]['book_now_url'].'">'.$jacrobookTimeFormat.' '.$pfbtntxt.'</a>';
                }
            }
            $filspostshtml .= '<input type="hidden" class="perfcat_message" value="'.$pfbtnmsg.'">';
            if($totalpr == $sameprct){
                $filspostshtml .= '<span class="filter_percat filter-'.$films[$performace_id]['perf_cat_class'].'">'.$films[$performace_id]['perf_cat_class_val'].'</span>';
            }
            $sameprct++;
        }
        $filspostshtml .= '<span #="">'.$films[$performace_id]['special_fea'].' </span><span #="perfad">'.$films[$performace_id]['ad'].' </span><span #="">'.$films[$performace_id]['sub_title'].'</span><span #="">'.$films[$performace_id]['is_3d'].' </span><span #=""> '.$films[$performace_id]['access'].'</span></div>';
    }

                                                $firstShowDate++;
                                            endif;

                                            if($films['film_type']!='Now Showing' || $films['film_date']=='moredates'){ $filspostshtml .= ''; }
                                        }
                                        $filspostshtml .= '</div>';         
                                        endforeach;
                                            if($trueMoreShowTime==true||($jacroCountDate>=1)) :
                        $more_showtimes_html = '<a href="'.$films['permalink'].'" class="moreshowtimes" target="'.$moreShowTimeTarget.'">More showtimes</a></div>';
                                                endif;
                                            else :
                                                if (!$groupby_performance_modifiers) {
                                                    $more_showtimes_html = '<a href="'.$films['permalink'].'" class="moreshowtimes" target="'.$moreShowTimeTarget.'">Showtimes</a></div>';
                                                }
                                                endif;

                                            /*** "logic" ends ***/
    
    if ($groupby_performance_modifiers) {

        // JIRA - Add formatted showtimes_html to the page
        $filspostshtml .= generate_showtime_html($films, $arct);
        $filspostshtml .= $more_showtimes_html;
        
    } else {
    }
       $filspostshtml .= '</div></div>';

}


//      $filspostshtml .= '<div class="more-show-time"><a href="'.$films['permalink'].'" class="perfbtn date_time_btn jacro-more-showtime">More Showtimes</a></div>';
                        
    /*** RUN TIME, CERT, MODS ***/
                                        $filspostshtml .= '<div class="col-md-4 col-sm-3 running-time"><hr class="space-10"/><i style="padding-right:5px;"class="fa fa-film"></i>'.$films['runtime'].' mins<span style="margin-left:10px;"class="certificate"> '.$films['certs'].'</span><span style="margin-left:10px;"class="genredescription"> '.$films['genre'].'</span></div>';
                                /*** FILM CONTAINER ENDS ***/
                                    $filspostshtml .= '</div></div></div></div>';

                                } else {
                                    $cl_layout = '';
                                    foreach($films['IDs']  as $val){                                   
                                        $cl_layout = $films[$val]['perf_cat_class'];
                                    }
                                    $filspostshtml .= '<div class="poster-case hvr-sweep-to-top '.$poster_width_class.' '.$cl_layout.'" onclick=""  aria-haspopup="true">';
                                    $filspostshtml .= '<div class="'.$films['perfclass'].' '.$films['filmclass'].' poster-img result_listing">';
                                    // $external_link = $films['img_url'];
                                    // if (@getimagesize($external_link)) {
                                    //  $filspostshtml .= '<img class = "poster-img '.$poster_width_class.'"  alt="'.$films['title'].'" src="'.$external_link.'" >';
                                    // } else {
                                    //  $filspostshtml .= '<img class = "poster-img '.$poster_width_class.'"  alt="'.$films['title'].'" src="'.$films['default_img_url'].'" >';
                                    // }
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
                                        
                                        $filspostshtml .= '<style>
                                         .book-now-btn a {background-image: linear-gradient(to right, '. $primaryColour.', '.$secondaryColour.') !important;} .book-now-btn a:hover {color: #fff !important;}
                                        </style>';
                                        
                                        $filspostshtml .= '<div class="book-now-btn"><a href="'.$films['permalink'].'" class="afterpostrlink"><span>Book Now</span></a></div>';
                                    }else{
                                        $filspostshtml .= "<div class = 'poster-banner'>".$films['title']."</div>";
                                    }
                                
                                    $filspostshtml .= '</div>';
                                }

                $count_row++;
            endforeach;
        endforeach;
    endif;

    if($homepage_layout == 'posters') {
        $filspostshtml .= "</div>";
    }

    if($count_row==1) {
        $filspostshtml .= '<div class="col-xs-12 col-sm-4 col-md-4 main-film-area"> <p>No Films Available.</p> </div>';
    }
    // if(isset($_REQUEST['film_date'])) :
    //     setcookie('jacroFilmDate', $_REQUEST['film_date'], time()+120, '/');
    // endif;
    // if(isset($_REQUEST['film_type'])) :
    //     setcookie('jacroFilmType', $_REQUEST['film_type'], time()+120, '/');
    // endif;
    $filspostshtml .= $datas['html'] = $filspostshtml;
    echo json_encode($datas); exit;

}
add_action( 'wp_ajax_search_filter_results', 'search_filter_results' );
add_action( 'wp_ajax_nopriv_search_filter_results', 'search_filter_results' );


function all_film_sort(&$arr, $date=''){
    $col = 'sorting_dates';
    //$col = 'dates';
    $dir = SORT_ASC; $sort_col = array();
    if($date=='moredates'){
        foreach ($arr as $key=> $row) {
            $sort_col[$key] = $row[$col];
        }
        array_multisort($sort_col, $dir, $arr);
    }
}

/** Film Performase **/
function jacroGetSingleFilmPerformce() {
    global $wpdb;
    $table_performances = $wpdb->prefix . "jacro_performances";
    $strtotimezone = jacro_strtotimezone($_POST['cinemaID']);
    $today = date("Y-m-d", $strtotimezone);
    $query = $wpdb->prepare("SELECT * FROM $table_performances WHERE location = %d AND filmcode = %s AND performdate >= %s AND selloninternet = %s ORDER BY performdate ASC", $_POST['cinemaID'], $_POST['filmId'], $today, 'Y');
    $perf_result = $wpdb->get_results($query);

    $start_date_arr =''; $singleFilmPerformaceHtml = ''; $datas = array();
    $tmparray = array(); $new=0;
    $jacroCountryname = get_option('jacroCountry-'.$_POST['cinemaID']);
    $groupby_performance_modifiers = get_option("groupby_performance_modifiers");   

    if(!empty($perf_result)){
        foreach($perf_result as $key=>$performance) {
            $perform_date = strtotime($performance->performdate);
            $start_time = $performance->starttime;
            $start_time = date('H:i', strtotime($start_time));
            $press_report = $performance->pressreport;
            $soldoutlevel = $performance->soldoutlevel;
            $ad = $performance->ad;
            $access = $performance->wheelchairaccessible;
            if (strpos($access,'Y') !== false) {
                $access = str_replace('Y', '<i class="fa fa-wheelchair" aria-hidden="true"></i>', $access);
            } else {
                $access = '';
            }
            $termsID = $performance->location;
            $termname = jacro_theatre_name($termsID);
            $theatre_name = strtolower(preg_replace('/[^\\pL\d]+/u', '-', $termname));

            $perf_cat_class_val = $performance->perfcat;
            $pf_filmclass = preg_replace('/[^A-Za-z0-9]/', '', $perf_cat_class_val);
            $pfclass = mb_strtolower($pf_filmclass);
            $perf_flags = $performance->perfflags;
            if(!empty($perf_flags)) {
                $perf_flag_arr = explode("|",$perf_flags);
                $perf_flags = implode(",",$perf_flag_arr);
            }
            if($start_date_arr=='')
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
                $tmparray[date("Y-m-d",$perform_date)][$new]['start_time'] = $start_time;
                $tmparray[date("Y-m-d",$perform_date)][$new]['press_report'] = $press_report;
                $tmparray[date("Y-m-d",$perform_date)][$new]['title'] = $_POST['filmName'];
                $tmparray[date("Y-m-d",$perform_date)][$new]['date'] = $perform_date;
                $tmparray[date("Y-m-d",$perform_date)][$new]['perf_cat_class_val'] = $perf_cat_class_val; 
                $tmparray[date("Y-m-d",$perform_date)][$new]['perf_cat_class'] = 'percate'.$pfclass;
                $tmparray[date("Y-m-d",$perform_date)][$new]['access'] =  $access;
                $tmparray[date("Y-m-d",$perform_date)][$new]['ad'] = $ad;
                $tmparray[date("Y-m-d",$perform_date)][$new]['soldoutlevel'] = $soldoutlevel;
                $tmparray[date("Y-m-d",$perform_date)][$new]['special_fea'] = (!empty($perf_flags))?$perf_flags:'';
                $tmparray[date("Y-m-d",$perform_date)][$new]['book_now_url'] = home_url()."/".$theatre_name."/booknow/".$performance->code;
                $new++;
            }
        }
            
        foreach($tmparray as $date=>$datefilms) {
            $filmstimearray = array();
            $arct = array();
            $fmct = array();
            $filmstimearray = sorting_time($datefilms);

            foreach($filmstimearray as $key=>$val) {
                $fmct[$val['id']] = $val;
                $arct[$val['perf_cat_class']][$val['id']] = $val['perf_cat_class'];
            }

            if ($groupby_performance_modifiers) {
                $singleFilmPerformaceHtml .= generate_showtime_html($fmct,$arct);
            }

            $tmp = '';
            $key_array = array();
            $picount = 0;
            foreach($filmstimearray as $k=>$films) {
                if (in_array($films['start_time'], $key_array)) {
                    continue;
                }
                $key_array[$picount] = $films['start_time'];
                $picount++;
                $per_date = date("Y-m-d",$films['date']);
                $start_time = $films['start_time'];
                $press_report = $films['press_report'];
                $startTimeHourFormat = JacroTimeFormate($start_time, $jacroCountryname);
                if(strtolower($jacroCountryname)=='us') {
                    $showTimeClass = 'show-time-12-hours';
                } elseif(strtolower($jacroCountryname)=='uk') {
                    $showTimeClass = '';
                } else {
                    $jacroShowTimeHour = get_option('jacroShowTimeHour');
                    if($jacroShowTimeHour == true) {
                        $showTimeClass = 'show-time-12-hours';
                    } else {
                        $showTimeClass = '';
                    }
                }
                $jacroShowTimeHour = get_option('jacroShowTimeHour');
                if($jacroShowTimeHour == true) {
                    $jacrobookTimeFormat = date("g:i a", strtotime($startTimeHourFormat));
                } else {
                    $jacrobookTimeFormat = date("H:i", strtotime($startTimeHourFormat));
                }

                if(strtotime(date('Y-m-d H:i', strtotime("$per_date $start_time"))) > $strtotimezone) {
                    if($tmp=='') { $show_date = true; $tmp = $date; } elseif($tmp==$date){ $show_date = false; $tmp = $date; }
                    $jacroDateFormate = JacroDateFormate($date);
                    if($show_date==true) :
                        $singleFilmPerformaceHtml .= '<div class="date-row col-md-12 col-sm-12 col-xs-12"><span style="margin-right: 18px;">'.$jacroDateFormate.'</span></br>';
                        $singleFilmPerformaceHtml .= "<div class='show-time'>";
                    endif;

                    $singleFilmPerformaceHtml .= '<div class="3 singlefilmperfs show-time-12-hours">';
                    $singleFilmPerformaceHtml .= '<div class="perfmods">';

                    if ($groupby_performance_modifiers) {
                            
                    }else{
                        if ($press_report == 'N') { 
                            $singleFilmPerformaceHtml .= '<a class="perfbtn disabled" title="Please contact the Box Office to book">'.$jacrobookTimeFormat.'</a>';
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
                                if($films['soldoutlevel'] && $films['soldoutlevel']=='Y'){
                                    $filspostshtml .= '<a class="perfbtn 3 disabled">Sold out</a>';
                                }else{
                                    $singleFilmPerformaceHtml .= '<a class="perfbtn 3" '.$alertinfo.' href="'.$films['book_now_url'].'">'.get_option('showtime_button_text').' '.$jacrobookTimeFormat.' '.$pfbtntxt.'</a>';
                                }
                            }else{
                                if($films['soldoutlevel'] && $films['soldoutlevel']=='Y'){
                                    $filspostshtml .= '<a class="perfbtn 3 disabled">Sold out</a>';
                                }else{
                                    $singleFilmPerformaceHtml .= '<a class="perfbtn 3" '.$alertinfo.' href="'.$films['book_now_url'].'">'.$jacrobookTimeFormat.' '.$pfbtntxt.'</a>';
                                }
                            }
                            $singleFilmPerformaceHtml .= '<input type="hidden" class="perfcat_message" value="'.$pfbtnmsg.'">';
                        }
                    }
                    // $singleFilmPerformaceHtml .= '<span #="">'.$films['special_fea'].'</span>';
                    // $singleFilmPerformaceHtml .= '<span #="perfad">'.$films['ad'].' </span>';
                    // $singleFilmPerformaceHtml .= '<span #=""> '.$films['access'].'</span>';
                    $singleFilmPerformaceHtml .= '</div>';
                    $singleFilmPerformaceHtml .= '</div>';
                }
            }
            $singleFilmPerformaceHtml .= '</div>';
            $singleFilmPerformaceHtml .= "</div></div></div>";
        }
    } else {
        $singleFilmPerformaceHtml .= 'No Performance Found';
    }
    $datas['html'] = $singleFilmPerformaceHtml;
    echo json_encode($datas); exit;
}
add_action( 'wp_ajax_jacroGetSingleFilmPerformce', 'jacroGetSingleFilmPerformce' );
add_action( 'wp_ajax_nopriv_jacroGetSingleFilmPerformce', 'jacroGetSingleFilmPerformce' );


/** Film Performase **/
function display_showtime_byfilmid() {
    global $wpdb;
    $table_performances = $wpdb->prefix . "jacro_performances";
    $select_movie = $_POST['select_movie'];
    $movie_loc = $_POST['movie_loc'];

    $query = $wpdb->prepare("SELECT * FROM $table_performances WHERE location = %d AND filmcode = %s AND selloninternet = %s ORDER BY performdate ASC", $movie_loc, $select_movie, 'Y');
    $perf_result = $wpdb->get_results($query);

    foreach($perf_result as $key=>$val) {
        $perform_date = $val->performdate;
        $start_time = $val->starttime;
        $start_time = date('H:i', strtotime($start_time));
        $approx_end_time = JacroCountApproxEndTime($start_time, $running_time, $trailer_time);
        $approxEndTimeFormate = JacroTimeFormate($approx_end_time, $jacroCountryname);
        $jacroDateFormate = JacroDateFormateanother($perform_date);       

        $termsID = $val->location;
        $termname = jacro_theatre_name($termsID);
        $theatre_name = strtolower(preg_replace('/[^\\pL\d]+/u', '-', $termname));  

        $booking_url = home_url()."/".$theatre_name."/booknow/".$val->code;;

        $start_time = date('H:i', strtotime($start_time));
        $startTimeHourFormat = JacroTimeFormate($start_time, 'us');
        if(strtotime(date('Y-m-d H:i', strtotime("$perform_date $start_time"))) >= strtotime(current_time('Y-m-d H:i'))) {
            if($cdate != $jacroDateFormate){
                $html .= '<option disabled selected>'.$jacroDateFormate.'</option>';
            }
            $html .= '<option value="'.$booking_url.'">'.$startTimeHourFormat.'</option>';
            $cdate = $jacroDateFormate;
        }
    }
    $datas['html']  =   $html;
    echo json_encode($datas); 
    exit;
}
add_action( 'wp_ajax_display_showtime_byfilmid', 'display_showtime_byfilmid' );
add_action( 'wp_ajax_nopriv_display_showtime_byfilmid', 'display_showtime_byfilmid' );

/* time sort */
function sorting_time($array) {
    for($i=0; $i<(count($array));$i++) :
        for($j=$i+1; $j<(count($array));$j++) :
            if(strtotime($array[$i]['start_time'])>strtotime($array[$j]['start_time'])) :
                $tmp = $array[$j];
                $array[$j] = $array[$i];
                $array[$i] = $tmp;
            endif;
        endfor;
    endfor;
    return $array;
}

/** Change The Date Foramate **/
function JacroDateFormate($date) {
    if (!is_object($date)) {
        $dateobj = date_create($date); 
        return date_format($dateobj, "l, jS F");
    }else{
        return date_format($date, "l, F jS");
    }  
}

/** Change The Date Foramate **/
function JacroDateFormateanother($date) {
    if (!is_object($date)) {
        $dateobj = date_create($date); 
        return date_format($dateobj, "l, jS F");
    }else{
        return date_format($date, "l, F jS");
    }
}

/** Change Time Formate **/
function JacroTimeFormate($jacroTime, $jacroCountryname) {
    if(strtolower($jacroCountryname)=='us') {
        $jacroTimeFormat  = date("g:i a", strtotime($jacroTime));
    } elseif(strtolower($jacroCountryname)=='uk') {
        $jacroTimeFormat  = date("H:i", strtotime($jacroTime));
    } else {
        $jacroShowTimeHour  =   get_option('jacroShowTimeHour');
        if($jacroShowTimeHour==true) {
            $jacroTimeFormat  = date("g:i a", strtotime($jacroTime));
        } else {
            $jacroTimeFormat  = date("H:i", strtotime($jacroTime));
        }
    }
    return (string)$jacroTimeFormat;
}

function JacroCountApproxEndTime($sTime, $rTime, $tTime) {
    $date = new DateTime($sTime);
    $totalRunTime = ((int)$rTime + (int)$tTime);
    $date->add(new DateInterval('PT'.$totalRunTime.'M'));
    return $date->format('H:i:s');
}

function start_session(){
    if( session_id() == '') : @session_start(); endif;
}

/* show film performances (showtimes) */
function show_film_performances() {
    start_session();
    global $wpdb;
    $table = $wpdb->prefix . "jacro_films";
    $table_performances = $wpdb->prefix . "jacro_performances";
    $cinema = $_REQUEST['cinema_id'];
    $strtotimezone = jacro_strtotimezone($cinema);
    $today = date("Y-m-d", $strtotimezone);
    $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table WHERE location = %d", $cinema));
    if($result) :
        $filmcategorysdatas = $performancecatdatas = '';
        $datas = array(); $film_cats = array(); $performance_cats = array();
        $jacroShowPerformanceCategoryFilters = get_option('jacroShowPerformanceCategoryFilters');
        $jacroShowCinemaCategoryFilters = get_option('jacroShowCinemaCategoryFilters');

        foreach($result as $films) :
            if (!in_array($films->genre, $film_cats)) {
                $film_cats[] = $films->genre;
            }
            $filmcode = $films->code;
            $result_performances = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_performances WHERE location = %d AND filmcode = %s AND performdate >= %s AND selloninternet = %s", $cinema, $filmcode, $today, 'Y'));
            foreach($result_performances as $performance) :
                if (!in_array($performance->perfcat, $performance_cats)) {
                    $performance_cats[] = $performance->perfcat;
                }
            endforeach;

            $performance_cats = array_unique($performance_cats);

        endforeach;

        if(($jacroShowPerformanceCategoryFilters == true)){
            $performancecatdatas .= '<div class="">';
            $performancecatdatas .= '<span class="multiselect-selected-text">Performance Category </span>';
            $performancecatdatas .= '<div class="col-md-12 category-dropdown"><ul>';
            $performancecatdatas .= '<div class="">';
            if(!empty($performance_cats)) {
                foreach ($performance_cats as $key=>$performance_cat) {
                    $performancecatdatas .= '<li class="col-md-4"><label class="checkbox"><input type="checkbox" class="performance_checkbox" data-type="performance" value="' . $performance_cat . '" onchange="filter_films(this)" name="performance_cats[]" id="squaredThree_' . $key . '">' . $performance_cat . '</label></li>';
                }
            }
            $performancecatdatas .= '</div></ul></div></div>';
        }

        if(($jacroShowCinemaCategoryFilters == true)) {
            $filmcategorysdatas .= '<div>';
            $filmcategorysdatas .= '<span class="multiselect-selected-text">Cinema film Categories</span>';
            $filmcategorysdatas .= '<div class="col-md-12 category-dropdown"><ul>';
            $filmcategorysdatas .= '<div>';
            if(!empty($film_cats)) {
                foreach($film_cats as $key=>$film_cat) {
                    $filmcategorysdatas .= '<li class="col-md-4"><label class="checkbox"><input type="checkbox" class="film_checkbox" data-type="film" value="'.$film_cat.'" name="film_cats[]" onchange="filter_films(this)" id="squared_'.$key.'">'.$film_cat.'</label></li>';
                }
            }
            $filmcategorysdatas .= '</div></ul></div></div>';
        }

        $datas['performancecatdatas'] = $performancecatdatas;
        $datas['filmcategorysdatas'] = $filmcategorysdatas;
        echo json_encode($datas); exit;
    endif;
}
add_action( 'wp_ajax_show_film_performances', 'show_film_performances' );
add_action( 'wp_ajax_nopriv_show_film_performances', 'show_film_performances' );

function get_custom_post_type_template($single_template) {
    global $post;
    if ($post->post_type == 'film') {
        $single_template = dirname( __FILE__ ) . '/single-film.php';
    }
    return $single_template;
}
add_filter( 'single_template', 'get_custom_post_type_template' );

function get_meta_values( $key = '', $type = 'post',$film_ids=NULL, $status = 'publish' ) {
    global $wpdb;
    if( empty( $key ) || empty($film_ids) )
        return;
    $r = $wpdb->get_col("SELECT pm.meta_value FROM {$wpdb->postmeta} pm LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id WHERE pm.meta_key = '".$key."' AND p.post_status = '".$status."' AND p.ID in (".$film_ids.") AND p.post_type = '".$type."' group by pm.meta_value");
    return $r;
}

/* get all films */
function get_films( $film_type='', $cinema_id='', $film_date='', $order_by_date=false ) {

    global $wpdb;
    $table = $wpdb->prefix . "jacro_films";

    $strtotimezone = jacro_strtotimezone($cinema_id);

    $today = date("Y-m-d", $strtotimezone);

    $advance_booking_days = get_option( 'advance_booking_days' );
    if(!$advance_booking_days){
        $advance_booking_days = 7;
    }
    $advanceday = date("Y-m-d",strtotime(date("Y-m-d", strtotime($today)) . "+".$advance_booking_days." day"));

    if (get_option('theatre_section_override')) {
        return get_films_theatre_override( $film_type, $cinema_id, $film_date, $order_by_date);
    }

    $default_jacro_image = get_option( 'default_jacro_image' );
    $default_image = wp_get_attachment_url( $default_jacro_image );
    if($default_image=='') :
        $default_image = plugin_dir_url( __FILE__ ).'images/default.png';
    endif;

    if($film_type=="Now Showing") {
        $query = $wpdb->prepare("SELECT * FROM $table WHERE location = %d ORDER BY startdate ASC", $cinema_id);
        $result = $wpdb->get_results($query);
    } elseif ($film_type == "Coming Soon") {
        $query = $wpdb->prepare("SELECT * FROM $table WHERE location = %d AND comingsoon = %s AND film_with_releasedate >= %s ORDER BY film_with_releasedate ASC", $cinema_id, 'Coming Soon', $today);
        $result = $wpdb->get_results($query);
    } elseif ($film_type == "Advance Sales") {
        $query = $wpdb->prepare("SELECT * FROM $table WHERE location = %d AND comingsoon = %s AND startdate > %s ORDER BY startdate ASC", $cinema_id, 'Coming Soon', $advanceday);
        $result = $wpdb->get_results($query);
    } else {
        $query = $wpdb->prepare("SELECT * FROM $table WHERE location = %d ORDER BY startdate DESC", $cinema_id);
        $result = $wpdb->get_results($query);
    }

    $datas['post'] = $result;
    $datas['img'] = $default_image;

    return $datas;
}


// New function to display Screen/Stage for Stag 
// Just hijacks Now Playing/Advance Booking sections TODO - use some other indicator to filter
function get_films_theatre_override( $film_type='', $cinema_id='', $film_date='', $order_by_date=false ) {
    $default_jacro_image = get_option( 'default_jacro_image' );
    $default_image = wp_get_attachment_url( $default_jacro_image );
    if($default_image=='') :
        $default_image = plugin_dir_url( __FILE__ ).'images/default.png';
    endif;
    $filspostshtml = ''; $cinema_filter = array();
    if($cinema_id!='') {
        $cinema_filter=array('key'=>'jacroFilmTheatreID', 'value'=>$cinema_id,'compare'=>'=');
    }
    
    //$genres = ['LIVE','AIW'];
    $genres = explode(',', get_option("theatre_screen_genre_exclude"));


    // = STAGE SECTION
    if($film_type!='Now Showing') {
        $args = array(
           'post_type' => 'film',
           'orderby' => 'start_date',
           'order' => 'DESC',
           'posts_per_page'=>-1,
           'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'film_status',
                    'value' => $film_type,
                    'compare' => '=', 
                ),array(
                    'key' => 'genre_code',
                    'value' => 'LIVE',
                    'compare' => '=',
                ),
               
                $cinema_filter
           ),
         );
    } else {
    // = SCREEN SECTION
        if($film_type=="Now Showing") {
            $args = array(
                'post_type' => 'film',
                'meta_query' => array(
                    'relation' => 'AND',
                    $cinema_filter,
                    array(
                        'relation' => 'AND',
                        array(
                            'key' => 'genre_code',
                            'value' => $genres,
                            'compare' => 'NOT IN'
                        ),
                    ),
                ),
                'order' => 'ASC',
                'orderby' => 'meta_value',
                'posts_per_page' => -1,
            );
        } else {
            $args = array(
                'post_type' => 'film',
                'meta_key' => 'start_date',
                'order' => 'DESC',
                'orderby' => 'meta_value',
                'posts_per_page'=>-1
            );
        }
    }
        if($order_by_date){
        $args['meta_key']='start_date';
        $args['order']='DESC';
        $args['orderby']='meta_value';
    }
    $count_row = 1;
    $datas['post'] = get_posts($args); $datas['img']=$default_image;

    return $datas;
}


/* get performances */
function get_performances( $film_id='', $film_date='', $film_type='', $cinema_id='' ) {

    global $wpdb;
    $table = $wpdb->prefix . "jacro_performances";

    $strtotimezone = jacro_strtotimezone($cinema_id);

    $today = date("Y-m-d", $strtotimezone);

    $now_showing_days = get_option( 'now_showing_days' );
    if(!$now_showing_days){
        $now_showing_days = 14;
    }
    $advance_booking_days = get_option( 'advance_booking_days' );
    if(!$advance_booking_days){
        $advance_booking_days = 15;
    }
    $fromdate = date("Y-m-d",strtotime(date("Y-m-d", strtotime($today)) . "+".$now_showing_days." day"));
    $advanceday = date("Y-m-d",strtotime(date("Y-m-d", strtotime($today)) . "+".$advance_booking_days." day"));

    if($film_type == "Now Showing") {
        if($film_date != 'moredates') :
            $query = $wpdb->prepare("SELECT * FROM $table WHERE location = %d AND filmcode = %s AND performdate = %s AND selloninternet = %s AND salesstopped = %s ORDER BY performdate ASC", $cinema_id, $film_id, $film_date, 'Y', 'N');
            $result = $wpdb->get_results($query);
        else :
            $query = $wpdb->prepare("SELECT * FROM $table WHERE location = %d AND filmcode = %s AND performdate >= %s AND performdate <= %s AND selloninternet = %s AND salesstopped = %s ORDER BY performdate ASC", $cinema_id, $film_id, $today, $fromdate, 'Y', 'N');
            $result = $wpdb->get_results($query);
        endif;
    } elseif($film_type == "Advance Sales") {
        $query = $wpdb->prepare("SELECT * FROM $table WHERE location = %d AND filmcode = %s AND performdate >= %s AND selloninternet = %s AND salesstopped = %s ORDER BY performdate ASC", $cinema_id, $film_id, $advanceday, 'Y', 'N');
        $result = $wpdb->get_results($query);
    } else {
        $query = $wpdb->prepare("SELECT * FROM $table WHERE location = %d AND filmcode = %s AND performdate >= %s AND selloninternet = %s ORDER BY performdate ASC", $cinema_id, $film_id, $today, 'Y');
        $result = $wpdb->get_results($query);
    }

    return $result;
    
}

/** Live Event **/
function get_live_event_performances( $film_id='', $cinema_id='' ) {
    $today=date("Y-m-d");
    $fromdate = date("Y-m-d",strtotime(date("Y-m-d", strtotime($today)) . " +6 day"));
    $cinema_filter = array();
    if($cinema_id!='') :
        $cinema_filter = array(array(
                'key' => 'performance_theater',
                'value' => $cinema_id,
                'compare' => '=',
            ), array(
                'key' => 'sellon_internet',
                'value' => 'Y',
                'compare' => '=',
            )
        );
    endif;
    $args = array(
        'post_type' => 'performance',
        'post_parent' => $film_id,
        'meta_key'  => 'perform_date',
        'orderby' => 'meta_value',
        'order' => 'ASC',
        'posts_per_page'=>-1,
        'meta_query' =>  $cinema_filter
    );
    return get_posts($args);
}

function jacroGetPerformaces($filmID, $cinemaID) {

    $idcine = '';
    $strtotimezone = '';
    if($_COOKIE['cinema_id'] && $_COOKIE['cinema_id'] != 'undefined') {
        $idcine = $_COOKIE['cinema_id'];
    } elseif($_COOKIE['visitedcinema_id'] && $_COOKIE['visitedcinema_id'] != 'undefined') {
        $idcine = $_COOKIE['visitedcinema_id'];
    }
    
    $term_timezone_meta = get_term_meta($idcine);
    $cinematimezone = $term_timezone_meta['timezone'][0];
    if(isset($cinematimezone)) {
        date_default_timezone_set('UTC');
        date('d-m-Y g:i:s A', strtotime("$cinematimezone hours"));
        date('d-m-Y g:i:s A', time() + ($cinematimezone * 60 * 60));
        $date = new DateTime;
        $date->modify("$cinematimezone hours");
        $strtotimezone = strtotime($date->format('Y-m-d H:i:s'));
    }   

    if(!$idcine) {
        $strtotimezone = current_time('timestamp');
    }

    $today = $strtotimezone;
    $today_date = date("Y-m-d", $today);
    //$fromdate = date("Y-m-d",strtotime(date("Y-m-d", strtotime($today)) . " +6 day"));
    $args = array(
        'post_type' => 'performance',
        'post_parent' => $filmID,
        'meta_key'  => 'perform_date',
        'press_report'  => 'press_report',
        'orderby' => 'meta_value',      
        'order' => 'ASC',
        'posts_per_page'=>-1,
        'meta_query' => array(array(
                'key' => 'perform_date',
                'value' => $today_date,
                'compare' => '>='
            ), array(
                'key' => 'performance_theater',
                'value' => $cinemaID,
                'compare' => '=',
            ), array(
                'key' => 'sellon_internet',
                'value' => 'Y',
                'compare' => '=',
            )
        ),
    );
    return get_posts($args);
}

/** Object Start **/
function jacroObjectStart() {
    if (!in_array('ob_gzhandler', ob_list_handlers())) {
        ob_start('ob_gzhandler');
    } else {
        ob_start();
    }
}

/** get film all cinemas (Theatre) if cinemasID is null('') **/
function jacroGetCinemasForFilm($filmName='', $cinemasID=''){
    global $wpdb;
    $table = $wpdb->prefix . "jacro_films";
    if($filmName) {
        $result = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE location = %d AND filmtitle = %s", $cinemasID, $filmName));
    } else {
        $result = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE location = %d", $cinemasID));
    }
    return $result;
}

/** get All cinemas (Theatre) if id is null('') **/
function jacroGetCinemas($filmName='', $id=''){
    global $wpdb;
    $table_locations = $wpdb->prefix . "jacro_locations";
    $location_result = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_locations"));
    $theatores = array();
    if(!empty($location_result)) { 
        foreach($location_result as $key=>$term) {  
            $filsPerformanceCheck = jacroGetCinemasForFilm($filmName, $term->id);        
            if(!empty($filsPerformanceCheck)&&isset($term->id)) {
                $theatores[$key]['id'] = $term->id;
                $theatores[$key]['name'] = $term->name; 
            }
        } 
    }
    $obj_tht = (object)json_decode (json_encode ($theatores), FALSE);
    return $obj_tht;
}

// Create the rewrites
function userpage_rewrite_rule() {
    add_rewrite_tag( '%booknow%', '([^&]*)' );
    add_rewrite_tag( '%film%', '([^/]*)' );
    add_rewrite_tag( '%theater-name%', '([^/]*)' );

    add_rewrite_rule( '([^/]*)/booknow/([\-\w+]*)/?', 'index.php?&booknow=$matches[2]&theater-name=$matches[1]', 'top' );
    flush_rewrite_rules();

    add_rewrite_rule('^([^/]*)/film/([^/]*)/?', 'index.php?cinema=$matches[1]&film=$matches[2]', 'top');
    flush_rewrite_rules();

    add_rewrite_tag( '%jacro-gift-card%', '([^/]*)' );
    add_rewrite_tag( '%sell-giftcard%', '([^/]*)' );
    add_rewrite_rule( '^jacro-gift-card/([^/]*)/([^/]*)', 'index.php?&jacro-gift-card=$matches[2]&sell-giftcard=$matches[1]', 'top' );
    flush_rewrite_rules(false);
}
add_action('init', 'userpage_rewrite_rule');

// Catch the URL and redirect it to a template file
function userpage_rewrite_catch() {
    
    global $wp_query; 
    $query_var_array = $wp_query->query_vars;
    
    /** Book-Now Page **/
    if ( array_key_exists( 'booknow', $query_var_array ) && array_key_exists('theater-name', $query_var_array)) {
        include (CINEMA_FILE_PATH . '/book-now.php'); exit;
    }

    /** Film Page **/
    if ( array_key_exists( 'film', $query_var_array )) {
        include (CINEMA_FILE_PATH . '/single-film.php'); exit;
    }

    /** Gift Card Page **/
    if ( array_key_exists( 'jacro-gift-card', $query_var_array ) && array_key_exists('sell-giftcard', $query_var_array) && isset($query_var_array['sell-giftcard']) && $query_var_array['sell-giftcard']=='sell-giftcard') {
        include(CINEMA_FILE_PATH .'/jacro-gift-card.php'); exit;
    }
}
add_action( 'template_redirect', 'userpage_rewrite_catch' );

/** Error Log **/
function jacro_error_log() {
    include_once(CINEMA_FILE_PATH.'/jacro-error-log.php');
}

/** Create Error Log **/
function jacro_change_error_log( $type, $string ) {
    global $wpdb; $table_name = $wpdb->prefix . 'jacro_error';
    $time = current_time( 'Y-m-d    H:i:s' );
    $message = preg_replace('/[^A-Za-z0-9\-]/', ' ', $string);
    return $wpdb->query("INSERT INTO $table_name VALUES( NULL, '$type', '$message', '$time' )");
}

/** Clear Error Log **/
function jacro_clear_error() {
    global $wpdb; $table_name = $wpdb->prefix . 'jacro_error';
    $wpdb->query("DELETE FROM $table_name");
    echo '<script>window.location.href="?page=jacro-error-log";</script>';
}

function jacro_error_notice() { ?>
    <div class="error notice">
        <p><?php _e( 'There has been an error, The following error log', '' ); ?> <a href="?page=jacro-error-log">Show</a></p>
    </div>
<?php }

function jacroGetTheaterTablePrices(){
    $htmlDatas = ''; $datas = array();
    if(isset($_POST['theatorID']) && $_POST['theatorID']!='' && $_POST['theatorID']!=0) :
        $jacroProduct = new jacroProductPricing();
        $jacroProductDatas = $jacroProduct->jacroGetPricingDatas($_POST['theatorID']);
        $defaultJacroCountry    =   get_option('jacroCountry-'.$_POST['theatorID']);
        $defaultJacroCurrencySymbol   =   get_option('jacroCurrencySymbol-'.$_POST['theatorID']);
        $defaultJacroCurrencyPosition   =   get_option('jacroCurrencyPossion');
        foreach($jacroProductDatas as $pricetableType=>$productTable) :
            $htmlDatas .= '<div class="jacro-table-pricing-head">'.$pricetableType.'</div>';
            $htmlDatas .= '<table class="jacro-table-pricing" id="jacro-table-pricing">';
            $htmlDatas .= '<thead> <tr><td>Description</td><td>Price</td></tr></thead><tbody>';
            foreach($productTable as $priceType=>$product) :
                $htmlDatas .= '<tr><td>'.$product->description.'</td><td>';
                if($defaultJacroCurrencyPosition=='' || $defaultJacroCurrencyPosition=='left') { $htmlDatas .= '<span class="jacro-currency">'.$defaultJacroCurrencySymbol.'</span> '.$product->price; }
                else { $htmlDatas .= $product->price.' <span class="jacro-currency">'.$defaultJacroCurrencySymbol.'<span>'; }
                $htmlDatas .= '</td></tr>';
            endforeach;
            $htmlDatas .= '</tbody><tfoot></tfoot></table>';
        endforeach;
        $datas['htmlData'] = $htmlDatas;
        $datas['errors'] = false;
    else :
        $datas['errors'] = true;
    endif;
    echo json_encode($datas); exit;
}
add_action( 'wp_ajax_jacroGetTheaterTablePrices', 'jacroGetTheaterTablePrices' );
add_action( 'wp_ajax_nopriv_jacroGetTheaterTablePrices', 'jacroGetTheaterTablePrices' );

function JacroChangeUrl($id) {
    $booking_url = '';
    if ( wp_is_mobile() ) {
        $booking_url = get_post_meta($id,"mobile_booking_url", true);
    } else {
        $booking_url = get_post_meta($id,"desktop_booking_url", true);
    }
    $performanceCode = get_post_meta($id, 'code', true);
    $theatreCode = get_post_meta($id, 'performance_theater', true);

    $taxonomy='theatre'; $theatreName = '';
    if($id!='') : $terms = get_term($theatreCode, $taxonomy, array("hide_empty"=>0)); endif;
    if($terms) :  $theatreName = $terms->name; endif;

    $newSiteUrl = str_replace("<sitecode>",$theatreName, $booking_url);
    $newSiteUrl = str_replace("<perfcode>",$performanceCode, $newSiteUrl);
    if(stripos($newSiteUrl,'?') >0) {
        $newSiteUrl=$newSiteUrl.'&';
    } else {
        $newSiteUrl=$newSiteUrl.'?';
    }
    return $newSiteUrl;
}


/** Ajax to check Date performace **/
function jacroCheckFilmOnDate(){
    $today_date = jacro_current_time(); $results = array();
    $dates[0] = $today_date;// current date
    $dates[1] = strtotime(date("Y-m-d H:i:s", $today_date) . " +1 day");
    $dates[2] = strtotime(date("Y-m-d H:i:s", $today_date) . " +2 day");
    $dates[3] = strtotime(date("Y-m-d H:i:s", $today_date) . " +3 day");
    $dates[4] = strtotime(date("Y-m-d H:i:s", $today_date) . " +4 day");
    $dates[5] = strtotime(date("Y-m-d H:i:s", $today_date) . " +5 day");
    $dates[6] = strtotime(date("Y-m-d H:i:s", $today_date) . " +6 day");
    $dates[7] = strtotime(date("Y-m-d H:i:s", $today_date) . " +7 day");
    $cinemaID = $_POST['cinema_id'];
    foreach($dates as $k=>$date) :
        $results[date("Y-m-d",$date)] = check_film_on_date($cinemaID, date("Y-m-d",$date),date("H:i:s",jacro_current_time()));
    endforeach;
    $datas['jacroCheckFilmOnDate'] = $results;
    echo json_encode($datas); exit;
}
add_action( 'wp_ajax_jacroCheckFilmOnDate', 'jacroCheckFilmOnDate' );
add_action( 'wp_ajax_nopriv_jacroCheckFilmOnDate', 'jacroCheckFilmOnDate' );

/** Get Google Analize Cookies **/
function jacroGetCookies() {
    if(isset($_POST['jacroCookie']) && $_POST['jacroCookie']!='') :
        update_option('google-analytics-tracking-id', sanitize_text_field($_POST['jacroCookie']));
    endif;
    exit;
}
add_action( 'wp_ajax_jacroGetCookies', 'jacroGetCookies' );
add_action( 'wp_ajax_nopriv_jacroGetCookies', 'jacroGetCookies' );


/** Check Film Dimension **/
function filmCheckDimension($dimension) {
    if($dimension=='N') : return '2D'; else : return '3D'; endif;
}

/** Class For new Function **/
class jacroProductPricing {

    // Get Pricing Datas
    public function JacroGetTableType($ID, $tableType) {
        $jacroAllPricingTable = $this->jacroGetPricingDatas($ID); $jacroTicketPricingTypeDatas = array(); $jacroTicketPricingType = '';
        $defaultJacroCurrency    =   get_option('jacroCountry-'.$ID);
        $defaultJacroCurrencyPosition   =   get_option('jacroCurrencyPossion');
        $defaultJacroCurrencySymbol   =   get_option('jacroCurrencySymbol-'.$ID); ?>
        <div class="col-xs-12">
            <div class="col-md-9 col-sm-8 col-xs-12">
                <div class="row">
                    <div class="" id="jacro-table-pricing">
                    <?php foreach ($jacroAllPricingTable as $pricetableType => $jacroProductTable) :
                            if($pricetableType=='Ticket Pricing' && $tableType=='jacro-ticket-pricing') :
                                $jacroTicketPricingTypeDatas = $jacroProductTable; $jacroTicketPricingType = $pricetableType;
                            endif;
                            if($pricetableType=='Ticket Pricing Matinee' && $tableType=='jacro-ticket-pricing-matinee') :
                                $jacroTicketPricingTypeDatas = $jacroProductTable; $jacroTicketPricingType = $pricetableType;
                            endif;
                            if($pricetableType=='Ritz Wednesday' && $tableType=='jacro-ticket-pricing-ritz-wednesday') :
                                $jacroTicketPricingTypeDatas = $jacroProductTable; $jacroTicketPricingType = $pricetableType;
                            endif;
                        endforeach; ?>
                        <div class="jacro-table-pricing-head"><?php echo esc_html($jacroTicketPricingType); ?></div>
                        <table class="jacro-table-pricing" id="jacro-table-pricing">
                            <thead> <tr><td>Description</td><td>Price</td></tr></thead>
                            <tbody>
                            <?php foreach($jacroTicketPricingTypeDatas as $priceTypeTable=>$product) : ?>
                                <tr><td><?php echo $product->description; ?></td>
                                    <td>
                                    <?php if($defaultJacroCurrencyPosition=='' || $defaultJacroCurrencyPosition=='left') { echo '<span class="jacro-currency">'.$defaultJacroCurrencySymbol.'</span> '.$product->price; }
                                    else { echo $product->price.' <span class="jacro-currency">'.$defaultJacroCurrencySymbol.'</span>'; } ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody><tfoot></tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div><?php
    }

    public function jacroGetPricingDatas($ID) {
        if($ID!='' && $ID!=0) {
            $args = array(
                'post_type'     =>  'jacroproduct',
                'post_status'   =>  'publish',
                'meta_key'      =>  'theaterID',
                'meta_value'    =>   $ID,
                'posts_per_page'    =>  1,
            );
            $posts_array = get_posts( $args ); $jacroPricingTable = array();
            foreach($posts_array as $k=>$post) :
                $jacroPricingTable = json_decode(get_post_meta($post->ID, 'jacroPricingTable', true));
            endforeach;
            return $jacroPricingTable;
        }
    }
}

/** admin save settings **/
function JacroSaveSettings($settingsType = '', $settings = array()) {
    
    if($settingsType=='jacro-filter-settings') {
        $menuorder = (isset($_POST['menuorder'])?$_POST['menuorder']:false);
        $defaultheadermenu = (isset($_POST['defaultheadermenu'])?$_POST['defaultheadermenu']:false);
        $posterlayoutopt = (isset($_POST['posterlayoutopt'])?$_POST['posterlayoutopt']:false);
        $jacrologinmenu = (isset($_POST['jacrologinmenu'])?$_POST['jacrologinmenu']:false);
        
        $custom_filter_option = array();
        for($filter_option=0;$filter_option<=CUSTOM_FILTER_OPTION;$filter_option++) :
            $filter_name = 'jacro-custom-filter'.$filter_option.'-name';
            $filter_code_name = 'jacro-custom-filter'.$filter_option.'-code';
            $filter_show_name = 'jacro-custom-filter'.$filter_option.'-show';
            $custom_filter_option[$filter_name] = (isset($_POST[$filter_name])?$_POST[$filter_name]:'');
            $custom_filter_option[$filter_code_name] = (isset($_POST[$filter_code_name])?$_POST[$filter_code_name]:'');
            $custom_filter_option[$filter_show_name] = (isset($_POST[$filter_show_name])?$_POST[$filter_show_name]:'');
        endfor;
        update_option("jacro_csutom_filter_options", $custom_filter_option);
        $cinema_model_show = (isset($_POST['cinema-modal-popup-show'])?$_POST['cinema-modal-popup-show']:false);
        $cinema_auto_select_nearest = (isset($_POST['cinema-auto-select-nearest'])?$_POST['cinema-auto-select-nearest']:false);
        $date_filter_select_today = (isset($_POST['date-filter-select-today'])?$_POST['date-filter-select-today']:false);
        $events_films_sorting_title = (isset($_POST['events-films-sorting-title'])?$_POST['events-films-sorting-title']:false);
        $booking_header_loc = (isset($_POST['booking-header-loc'])?$_POST['booking-header-loc']:false);
        $date_sort_recent = (isset($_POST['date-sort-recent'])?$_POST['date-sort-recent']:false);
        $includevenue = (isset($_POST['includevenue'])?$_POST['includevenue']:false);
        $homepage_layout = (isset($_POST['homepage_layout'])?$_POST['homepage_layout']:false);
        $homepage_poster_width = (isset($_POST['homepage_poster_width'])?$_POST['homepage_poster_width']:false);
        $date_filter_format = (isset($_POST['date_filter_format'])?$_POST['date_filter_format']:false);
        $theatre_section_override = (isset($_POST['theatre_section_override'])?$_POST['theatre_section_override']:false);
        $theatre_screen_genre_exclude = (isset($_POST['theatre_screen_genre_exclude'])?$_POST['theatre_screen_genre_exclude']:false);
        $groupby_performance_modifiers = (isset($_POST['groupby_performance_modifiers'])?$_POST['groupby_performance_modifiers']:false);
        $tab_header_now_showing = (isset($_POST['tab_header_now_showing'])?$_POST['tab_header_now_showing']:false);
        $tab_header_advance_bookings = (isset($_POST['tab_header_advance_bookings'])?$_POST['tab_header_advance_bookings']:false);
        $tab_header_new_releases = (isset($_POST['tab_header_new_releases'])?$_POST['tab_header_new_releases']:false);
        $tab_header_advance_sales = (isset($_POST['tab_header_advance_sales'])?$_POST['tab_header_advance_sales']:false);
        $tab_header_all_performances = (isset($_POST['tab_header_all_performances'])?$_POST['tab_header_all_performances']:false);
        $now_showing_days = (isset($_POST['now_showing_days'])?$_POST['now_showing_days']:false);
        $advance_booking_days = (isset($_POST['advance_booking_days'])?$_POST['advance_booking_days']:false);

        $show_time_header = (isset($_POST['show_time_header'])?$_POST['show_time_header']:false);
        $showtime_button_text = (isset($_POST['showtime_button_text'])?$_POST['showtime_button_text']:false);
        

        $tab_hide_now_showing = (isset($_POST['tab_hide_now_showing'])?$_POST['tab_hide_now_showing']:false);
        $tab_hide_advance_bookings = (isset($_POST['tab_hide_advance_bookings'])?$_POST['tab_hide_advance_bookings']:false);
        $tab_hide_new_releases = (isset($_POST['tab_hide_new_releases'])?$_POST['tab_hide_new_releases']:false);
        $tab_hide_advance_sales = (isset($_POST['tab_hide_advance_sales'])?$_POST['tab_hide_advance_sales']:false);
        $tab_hide_all_performances = (isset($_POST['tab_hide_all_performances'])?$_POST['tab_hide_all_performances']:false);
        $hideallshows = (isset($_POST['hideallshows'])?$_POST['hideallshows']:false);
        $uktheatre = (isset($_POST['uktheatre'])?$_POST['uktheatre']:false);
        $americanlang = (isset($_POST['americanlang'])?$_POST['americanlang']:false);
        $australianlang = (isset($_POST['australianlang'])?$_POST['australianlang']:false);

        $hide_single_film_rating = (isset($_POST['hide_single_film_rating'])?$_POST['hide_single_film_rating']:false);
        $hide_single_film_runningtime = (isset($_POST['hide_single_film_runningtime'])?$_POST['hide_single_film_runningtime']:false);
        $hide_single_film_releaseddate = (isset($_POST['hide_single_film_releaseddate'])?$_POST['hide_single_film_releaseddate']:false);
        $hide_single_film_genre = (isset($_POST['hide_single_film_genre'])?$_POST['hide_single_film_genre']:false);

        $perfcat_section_override = (isset($_POST['perfcat_section_override'])?$_POST['perfcat_section_override']:false);
        $movieslideroption = (isset($_POST['movieslideroption'])?$_POST['movieslideroption']:false);
        
        if (isset($_POST['perfcat_category']) && is_array($_POST['perfcat_category'])) {
            $valdata = $_POST['perfcat_category'];
            $valdata = array_map('array_filter', $valdata);
            $perfcat_category = array_filter($valdata);
        } else {
            $perfcat_category = [];
        }
        
        if ($perfcat_section_override) {
            update_option("perfcat_category_message", $perfcat_category);
        } else {
            update_option("perfcat_category_message", '');
        }
        
        update_option("cinema-modal-popup-show", $cinema_model_show);
        update_option( "booking-header-loc", $booking_header_loc);
        update_option("date-sort-recent", $date_sort_recent);
        update_option("cinema-auto-select-nearest", $cinema_auto_select_nearest);
        update_option("date-filter-select-today", $date_filter_select_today);
        update_option("includevenue", $includevenue);
        update_option("homepage_layout", $homepage_layout);
        update_option("homepage_poster_width", $homepage_poster_width);
        update_option("date_filter_format", $date_filter_format);
        update_option("theatre_section_override", $theatre_section_override);
        update_option("theatre_screen_genre_exclude", $theatre_screen_genre_exclude);
        update_option("groupby_performance_modifiers", $groupby_performance_modifiers);
        update_option("hideallshows", $hideallshows);
        update_option("show_time_header",  htmlentities(stripslashes($show_time_header)));
        update_option("showtime_button_text",  htmlentities(stripslashes($showtime_button_text)));
        update_option("tab_header_now_showing",  htmlentities(stripslashes($tab_header_now_showing)));
        update_option("tab_header_advance_bookings",  htmlentities(stripslashes($tab_header_advance_bookings)));
        update_option("tab_header_new_releases",  htmlentities(stripslashes($tab_header_new_releases)));
        update_option("tab_header_advance_sales",  htmlentities(stripslashes($tab_header_advance_sales)));  
        update_option("tab_header_all_performances",  htmlentities(stripslashes($tab_header_all_performances)));    
        update_option("now_showing_days",  htmlentities(stripslashes($now_showing_days)));  
        update_option("advance_booking_days",  htmlentities(stripslashes($advance_booking_days)));

        update_option("tab_hide_now_showing", $tab_hide_now_showing);
        update_option("tab_hide_advance_bookings", $tab_hide_advance_bookings);
        update_option("tab_hide_new_releases", $tab_hide_new_releases);
        update_option("tab_hide_advance_sales", $tab_hide_advance_sales);
        update_option("tab_hide_all_performances", $tab_hide_all_performances);
        update_option("events-films-sorting-title", $events_films_sorting_title);
        update_option("uktheatre", $uktheatre);
        update_option("americanlang", $americanlang);
        update_option("australianlang", $australianlang);
        update_option("menuorder", $menuorder);
        update_option("defaultheadermenu", $defaultheadermenu);
        update_option("posterlayoutopt", $posterlayoutopt);
        update_option("jacrologinmenu", $jacrologinmenu);

        update_option("hide_single_film_rating", $hide_single_film_rating);
        update_option("hide_single_film_runningtime", $hide_single_film_runningtime);
        update_option("hide_single_film_releaseddate", $hide_single_film_releaseddate);
        update_option("hide_single_film_genre", $hide_single_film_genre);

        update_option("perfcat_section_override", $perfcat_section_override);
        update_option("movieslideroption", $movieslideroption);
    
    }

    /** Save Theme Settings **/
    if($settingsType=='jacro-color-settings') {
        $themeSettingsOption['jacroContainerColor'] = $settings['jacro-movies-page-container-color'];
        $themeSettingsOption['jacroTitleColor'] = $settings['jacro-title-text-color'];
        $themeSettingsOption['jacroTitleHoverColor'] = $settings['jacro-title-text-hover-color'];
        $themeSettingsOption['jacroTextColor'] = $settings['jacro-text-color'];
        $themeSettingsOption['jacroButtonColor'] = $settings['jacro-button-color'];
        $themeSettingsOption['jacroButtonHoverColor'] = $settings['jacro-button-hover-color'];
        $themeSettingsOption['jacroButtonTextColor'] = $settings['jacro-button-text-color'];
        $themeSettingsOption['jacroButtonTextHoverColor'] = $settings['jacro-button-text-hover-color'];
        update_option("jacroColorSettings", $themeSettingsOption);
    }

    /** Save Other Settings **/
    if($settingsType=='jacro-other-settings') {

        /** clear previous cron after update **/
        wp_clear_scheduled_hook('jacroRunImportAction');
        wp_clear_scheduled_hook('jacroRunDeleteAction');
        wp_schedule_event(time(), 'jacroCronSchedule', 'jacroRunImportAction');
        wp_schedule_event(time(), 'jacroCronSchedule', 'jacroRunDeleteAction');

        $jacro_showtime_length = (isset($settings['jacro-showtime-length'])?$settings['jacro-showtime-length']:'');
        $jacro_log_email = (isset($_POST['jacro_log_email'])?$_POST['jacro_log_email']:false);

        update_option( "no_booking_fee_text", $settings['no_booking_fee_text']);
        update_option( "google_analytics_code", $settings['google_analytics_code']);
        //update_option( "jacroShowTimePerPage", $_REQUEST['jacro-show-time-per-page']);
        update_option( "jacroCurrencyPossion", $settings['currency-position']);
        //update_option( "jacroShowTimeHour", $settings['jacro-showtime-hour']);
        update_option( "jacroShowPerformanceCategoryFilters", $settings['jacro-show-performance-category-filters']);
        update_option( "jacroShowCinemaCategoryFilters", $settings['jacro-show-cinema-category-filters']);

        update_option( "jacroMoreShowtimesLink", $settings['jacro-more-showtimes-link']);
        update_option( "jacroBookNowOpenLink", $settings['jacro-booknow-open-link']);
        update_option( "jacro_showtime_length", $jacro_showtime_length);
        update_option( "jacro_auto_clean_performace", $settings['jacro-auto-clean-performace']);
        update_option( "showtime_import_interval", $settings['showtime_import_interval']);
        update_option( "jacro_log_email", $jacro_log_email);
    }
}

function get_custom_filters() {
    $custom_filter_option = get_option("jacro_csutom_filter_options"); $newfilter='';
    for($filter_option=0;$filter_option<=CUSTOM_FILTER_OPTION;$filter_option++) :
        $filter_name = 'jacro-custom-filter'.$filter_option.'-name';
        $filter_code_name = 'jacro-custom-filter'.$filter_option.'-code';
        $filter_show_name = 'jacro-custom-filter'.$filter_option.'-show';
        $code = (isset($custom_filter_option[$filter_code_name])?$custom_filter_option[$filter_code_name]:'');
        $name = (isset($custom_filter_option[$filter_name])?$custom_filter_option[$filter_name]:'');
        if ((isset($custom_filter_option[$filter_show_name])&&$custom_filter_option[$filter_show_name]==true)&&($code!=''&&$name!='')) {
            $newquery = add_query_arg(array('code'=>$code), get_permalink(get_page_by_path('live-events')));
            $newfilter .= '<li><a href="'.esc_url($newquery).'" class="live-events last" rel="'.esc_html($name).'">'.esc_html($name).'</a></li>';
        }
    endfor;
    return $newfilter;
}

function get_mobile_custom_filters() {
    $custom_filter_option = get_option("jacro_csutom_filter_options"); $newfilter='';
    for($filter_option=0;$filter_option<=CUSTOM_FILTER_OPTION;$filter_option++) :
        $filter_name = 'jacro-custom-filter'.$filter_option.'-name';
        $filter_code_name = 'jacro-custom-filter'.$filter_option.'-code';
        $filter_show_name = 'jacro-custom-filter'.$filter_option.'-show';
        $code = (isset($custom_filter_option[$filter_code_name])?$custom_filter_option[$filter_code_name]:'');
        $name = (isset($custom_filter_option[$filter_name])?$custom_filter_option[$filter_name]:'');
        if ((isset($custom_filter_option[$filter_show_name])&&$custom_filter_option[$filter_show_name]==true)&&($code!=''&&$name!='')) {
            $newquery = add_query_arg(array('code'=>$code), get_permalink(get_page_by_path('live-events')));
            $newfilter .= '<option value="'.esc_url($newquery).'">'.esc_html($name).'</option>';
        }
    endfor;
    return $newfilter;
}

function JacroGetSettigns($optionName, $settingsType = '') {
    $optionData = get_option($optionName);
    if($settingsType=='') {
        return $optionData;
    } else {
        if(($settingsType!='')&&(isset($optionData[$settingsType]))) {
            return $optionData[$settingsType];
        }
    }
    return false;
}

/** Video player **/
function jacro_player($video_url) {
    $video_url=jacro_trailer_url_convert($video_url);
    jacroObjectStart();
    if($video_url!=''): ?>
        <div class="jacro-player">
            <iframe class="jacro-player-frame" width="100%" height="100%" src="<?php echo esc_url($video_url); ?>?autoplay=0&showinfo=0&controls=1" frameborder="0" allowfullscreen></iframe>
        </div><?php
    endif;
    return ob_get_clean();
}

/** Convert Video Url in embed tag**/
function jacro_trailer_url_convert( $url ) {
    $video_type = jacro_video_type($url); $return_url = $video_id = '';
    if($video_type=='youtube') :
        if (strpos($url, 'youtube.com') !== FALSE) {
            $video_pattern_regexp = '/youtube.com\/(?:embed|v){1}\/([a-zA-Z0-9_-]+)\??/i';
        } else if (strpos($url, 'youtu.be') !== FALSE) {
            $video_pattern_regexp = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
        }
        preg_match($video_pattern_regexp, $url, $matches);
        if(!empty($matches)) :
            $video_id = (isset($matches[1]))?$matches[1]:0;
        endif;
        $return_url = 'https://www.youtube.com/embed/'.$video_id;
    endif;
    return $return_url;
}

/** Get Video Type **/
function jacro_video_type($url) {
    if ((strpos($url, 'youtube') > 0) || (strpos($url, 'youtu') > 0)) {
        return 'youtube';
    } elseif (strpos($url, 'vimeo') > 0) {
        return 'vimeo';
    } else {
        return 'unknown';
    }
}

function jacro_check_calender_events($date=''){
    global $wpdb;
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

    $films = jacro_get_live_event('film'); 
    $performace_return = array();
    foreach($films as $key=>$film):
        $get_performaces = jacro_get_live_event_performance($film->code, $date);
        if(!empty($get_performaces)){
            foreach($get_performaces as $key=>$performace):
                $per_date=$performace->performdate;
                $start_time=$performace->starttime;
                $start_time=date('H:i', strtotime($start_time));
                if(strtotime(date('Y-m-d H:i', strtotime("$per_date $start_time"))) >= $strtotimezone) {
                    $performace_return['date'][]=date('Y, m, d', strtotime($per_date));
                    $performace_return['ids'][]=$performace->filmcode;
                }
            endforeach;
        }
    endforeach;

    if (isset($performace_return['ids']) && is_array($performace_return['ids'])) {
        $performace_return['ids'] = array_unique($performace_return['ids']);
    } else {
        $performace_return['ids'] = array();
    }

    return $performace_return; exit;
}

function jacro_action_call(){
    $performace_return = array();
    if(isset($_POST['jacro_call']) && ($_POST['jacro_call'] == 'get_live_event_dates')){
        $strtotimezone = jacro_strtotimezone($_POST['cinemaid']);
        $films = jacro_get_live_event('film');
        $countfm = 0;
        foreach($films as $key=>$film){
            $get_performaces = jacro_get_live_event_performance($film->code);
            $filmdtprformance = array();
            if(!empty($get_performaces)){
                $counter = 0;
                foreach($get_performaces as $key=>$performace){
                    $per_date = $performace->performdate;
                    $start_time = $performace->starttime;
                    $start_time = date('H:i', strtotime($start_time));
                    if(strtotime(date('Y-m-d H:i', strtotime("$per_date $start_time"))) >= $strtotimezone) {
                        if (array_search(date('Y, m, d', strtotime($per_date)), array_column($filmdtprformance, 'date')) !== FALSE) {
                            continue;
                        } else {
                            $filmdtprformance[$counter]['date'] = date('Y, m, d', strtotime($per_date));
                            $filmdtprformance[$counter]['movie'] = $film->filmtitle;
                            $perform_date[$countfm][$film->ID][$counter]['date'] = date('Y, m, d', strtotime($per_date));
                            $perform_date[$countfm][$film->ID][$counter]['title'] = $film->filmtitle;
                            $perform_date[$countfm][$film->ID][$counter]['url'] = $film->url;
                        }
                    }
                    $counter++;
                }
                $performace_return['dates'] = $perform_date;
                $performace_return['success'] = true;
            } else {
                $performace_return['success'] = false;
            }
            $countfm++;
        }
    }
    echo json_encode($performace_return); exit;
}
add_action( 'wp_ajax_jacro_action_call', 'jacro_action_call' );
add_action( 'wp_ajax_nopriv_jacro_action_call', 'jacro_action_call' );

/** Get all live event film using genre code form films **/
function jacro_get_live_event($fild='', $genre_code='', $date='', $sellon_internet=''){
    global $wpdb;
    $table_locations = $wpdb->prefix . "jacro_locations";
    $table_films = $wpdb->prefix . "jacro_films";

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

    $query = "SELECT * FROM $table_films WHERE location = %d";

    if (!empty($genre_code)) {
        $query .= " AND genrecode = %s";
    }

    $query .= " ORDER BY startdate ASC";

    if (!empty($genrecode)) {
        $sql = $wpdb->prepare($query, $cinema, $genre_code);
    } else {
        $sql = $wpdb->prepare($query, $cinema);
    }

    $result = $wpdb->get_results($sql);

    if($fild=='film') {
        return $result;
    } elseif($fild=='genrecode') {
        if(!empty($result)) :
            $genrecodes = array();
            foreach($result as $film) :
                $genrecodes[] = $film->genrecode;
            endforeach;
            return array_unique($genrecodes);
        else :
            return false;
        endif;
    }
    return false;
}

function jacro_get_live_event_performance($film_id='', $today_only=''){
    global $wpdb;
    $table_locations = $wpdb->prefix . "jacro_locations";
    $table_performances = $wpdb->prefix . "jacro_performances";

    $location_result = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_locations LIMIT 1"));
    if($location_result) {
        $location_id = $location_result[0]->id;
    }

    if (isset($_COOKIE['cinema_id']) && $_COOKIE['cinema_id'] != 'undefined') {
        $cinema = $_COOKIE['cinema_id'];
    } elseif (isset($_COOKIE['visitedcinema_id']) && $_COOKIE['visitedcinema_id'] != 'undefined') {
        $cinema = $_COOKIE['visitedcinema_id'];
    } else {
        $cinema = $location_id;
    }

    $query = "SELECT * FROM $table_performances WHERE location = %d AND filmcode = %s AND selloninternet = %s";
    if (!empty($today_only)) {
        $query .= " AND performdate = %s";
    }
    $query .= " ORDER BY performdate ASC";
    if (!empty($today_only)) {
        $sql = $wpdb->prepare($query, $cinema, $film_id, 'Y', $today_only);
    } else {
        $sql = $wpdb->prepare($query, $cinema, $film_id, 'Y');
    }
    $perf_result = $wpdb->get_results($sql);

    return $perf_result;
}

function jacro_ajax_get_live_event_performance(){
    $filter_date = (isset($_POST['date'])?$_POST['date']:'');
    $filter_date = strtr($filter_date, '/ ','-');
    $date = new DateTime($filter_date);
    $filter_date = $date->format('Y-m-d');
    jacroObjectStart();
    include(CINEMA_FILE_PATH.'/caleandar-events-template.php');
    $result['events_template'] = ob_get_contents();ob_end_clean();
    $result['success'] = true;
    echo json_encode($result); exit;
}
add_action( 'wp_ajax_get_calender_event', 'jacro_ajax_get_live_event_performance' );
add_action( 'wp_ajax_nopriv_get_calender_event', 'jacro_ajax_get_live_event_performance' );

function jacro_buynow_process_start(){
    $start_buy_now = (isset($_POST['buynow'])?$_POST['buynow']:false);
    if($start_buy_now){
        start_session();
        unset($_SESSION["startup_chinema"]);
    }
    $result['success'] = true;
    echo json_encode($result); exit;
}
add_action( 'wp_ajax_jacro_buynow_process_start', 'jacro_buynow_process_start' );
add_action( 'wp_ajax_nopriv_jacro_buynow_process_start', 'jacro_buynow_process_start' );

/** Jacro Get back link **/
function jacro_get_back_page_link($name='back_to_prev_page') {
    $back_to_prev_page=get_transient($name);
    if(empty($back_to_prev_page)) {
        if(isset($_SERVER['HTTP_REFERER'])) :
            $back_to_prev_page = $_SERVER['HTTP_REFERER'];
        endif;
        set_transient($name,$back_to_prev_page,2400);
    }
    return get_transient($name);
}

function jacro_add_query_parameters($args = array(), $url=''){
    $site_url=$url;if($site_url==''){$site_url=site_url();}
    return esc_url(add_query_arg($args, $site_url));
}

function jacro_current_time($is_formate=false, $date_formate=''){
    $current_time = current_time('timestamp', false);
    if($date_formate==''){$date_formate = get_option( 'date_format' );}
    if($is_formate){return date($date_formate, $current_time);}
    else {return $current_time;}
}

function jacro_get_nearest_location($terms=array()){
    $all_cinemas_regions = array();
    if(!empty($terms)):
        foreach($terms as $key=>$term):
            $tmp = get_term_meta($term->term_id, 'theatre_geo_location', true);
            $lat = (isset($tmp['latitude'])?$tmp['latitude']:''); $lon = (isset($tmp['longitude'])?$tmp['longitude']:'');
            $all_cinemas_regions[] = array('term_id'=>$term->term_id, 'lon'=>$lon, 'lat'=>$lat);
        endforeach;
    else :
        return false;
    endif;
    $current_geo_data = @unserialize(file_get_contents('http://ip-api.com/php/'));
    $distances = array();
    if(isset($current_geo_data['status'])&&$current_geo_data['status']=='success'){
        $current_geo_location[] = (isset($current_geo_data['lon'])?$current_geo_data['lon']:'');
        $current_geo_location[] = (isset($current_geo_data['lat'])?$current_geo_data['lat']:'');

        $distances = array_map(function($all_cinemas_region) use($current_geo_location) {
            $tmp = array($all_cinemas_region['lon'], $all_cinemas_region['lat']);
            return  jacro_calculate_geo_distance($tmp, $current_geo_location);
        }, $all_cinemas_regions);
        asort($distances);
        return (isset($all_cinemas_regions[key($distances)])?$all_cinemas_regions[key($distances)]:false);
    } else {
        return false;
    }
}

function jacro_get_current_location(){
    global $wpdb;
    $query = "SELECT id, ( 3959 * acos( cos( radians(37) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(-122) ) + sin( radians(37) ) * sin( radians( lat ) ) ) ) AS distance FROM markers HAVING distance < 25 ORDER BY distance LIMIT 0 , 20";
    $response_data = $wpdb->query($query);
    print_r($response_data); exit;
}

function jacro_calculate_geo_distance($a, $b) {
    list($lat1, $lon1) = $a; list($lat2, $lon2) = $b;
    $lat2 = floatval($lat2);
    $lat1 = floatval($lat1);
    $lon1 = floatval($lon1);
    $lon2 = floatval($lon2);
    $deltaLat = $lat2 - $lat1;
    $deltaLon = $lon2 - $lon1;
    $earthRadius = 3959; // in miles 6371 in meters.
    $alpha      = floatval($deltaLat/2);
    $beta       = floatval($deltaLon/2);
    $a          = sin(deg2rad($alpha)) * sin(deg2rad($alpha)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin(deg2rad($beta)) * sin(deg2rad($beta)) ;
    $c          = 2 * atan2(sqrt($a), sqrt(1-$a));
    $distance   =  $earthRadius * $c;
    return $distance;
}

add_filter ('theme_page_templates', 'jacro_add_page_template');
function jacro_add_page_template($templates){
    $templates['jacro-caleandar-events'] = 'Jacro Live Events';
    return $templates;
}

function jacro_import_feeds(){
    $customer_id = ($_POST['customer_id']);
    $arr = array(); 
    start_session();
    global $wpdb;
    $table = $wpdb->prefix . "jacro_customers";
    $table_locations = $wpdb->prefix . "jacro_locations";
    $created = date('Y-m-d H:i:s');
    $result = $wpdb->get_row("SELECT * FROM $table WHERE id = $customer_id");
    
    if($result) {
        $theatrefeed_url = $result->url;
        $post_title = $result->code;
        $content = file_get_contents_curl($theatrefeed_url);
        $feeds = json_decode($content);
        $locationCounter = 0;
        $return_results = array();
        
        foreach($feeds->theatres as $theatres) {
            $term = $theatres->theatre->tsite;
            $cinema_name = '';
            if(isset($theatres->theatre->t)) $cinema_name=$theatres->theatre->t;
            $country = $theatres->theatre->country;
            $booking_url = $theatres->theatre->booking_url;
            $showtimes_url = $theatres->theatre->showtimes_url;
            $facilities = $theatres->theatre->facilities;
            $timezone = $theatres->theatre->timezone;
            $geo_location = serialize(array('latitude'=>$theatres->theatre->lat, 'longitude'=>$theatres->theatre->long));
            $details = serialize($theatres->theatre);
            
            $args = array(
                'customer'     => $customer_id,
                'name'         => $cinema_name,
                'code'         => $term,
                'url'          => $showtimes_url,
                'country'      => $country,
                'timezone'     => $timezone,
                'facilities'   => $facilities,
                'geolocation'  => $geo_location,
                'bookingurl'   => $booking_url,
                'details'      => $details,
                'created'      => $created,
            );

            $existing_location = $wpdb->get_row("SELECT * FROM $table_locations WHERE customer = $customer_id AND code = '$term'");
            
            if($existing_location) {
                $where = array('id' => $existing_location->id);
                $update_location = $wpdb->update($table_locations, $args, $where);
                $return_results[$locationCounter]['term_id'] = $existing_location->id;
                $return_results[$locationCounter]['cinema_name'] = $cinema_name;
            } else {
                $insert_location = $wpdb->insert($table_locations, $args);
                if($insert_location) {
                    $insert_id = $wpdb->insert_id;
                    $return_results[$locationCounter]['term_id'] = $insert_id;
                    $return_results[$locationCounter]['cinema_name'] = $cinema_name;
                }
            }
            
            $locationCounter++;
        }
        
        $return_results['total_location_counter'] = $locationCounter;
        echo json_encode($return_results);
        exit;
    }
}
add_action('wp_ajax_jacro_import_feeds', 'jacro_import_feeds');


function jacro_import_films_performance(){
    $term_id = (isset($_POST['term_id'])?$_POST['term_id']:'');
    $import_result = import_film_showtime($term_id);
    echo json_encode($import_result); exit;
}
add_action('wp_ajax_jacro_import_films_performance', 'jacro_import_films_performance');

function jacro_import_loader(){
    echo '<div id="jacro-loader"><p style="color:red">Don\'t close window and tab.</p><p>Locations are being imported – this could take a few minutes</p><div class="imported-message"></div><p>Please wait...</p><img src="'.CINEMA_URL.'images/ajax-loader.gif" /></div></div>';
}

add_action( 'wp_ajax_changeLayoutView', 'changeLayoutView' );
add_action( 'wp_ajax_nopriv_changeLayoutView', 'changeLayoutView' );
function changeLayoutView(){
    $result = array();
    if($_POST['type']){
        setcookie('jacroFilmLayout', $_POST['type'], time()+120, '/');
        $result['status']='success';

    }else{
        $result['status']='failed';
    }

    echo json_encode($result); 
    exit;

}

add_filter( 'wp_get_nav_menu_items', 'custom_nav_menu_items', 20, 2 );
function custom_nav_menu_items( $items, $menu ){
    $jacrologinmenu = get_option('jacrologinmenu');
    $jacromenutype = get_option('defaultheadermenu');
    if ( $menu->term_id == $jacrologinmenu ){
        if($jacromenutype == 'h_login'){
            if(isset($_COOKIE['user_logined']) && $_COOKIE['user_logined']!='') {
                $loginclass = array('login-btn', 'hiddenmenu');
                $accountclass = array('account-btn');
            }else{
                $loginclass = array('login-btn');
                $accountclass = array('account-btn', 'hiddenmenu');
            }
            $detailclass = array('inner-detail-btn', 'hiddenmenudetail');
            $logoutclass = array('logout-btn', 'hiddenmenulogout');
            $items[] = _custom_nav_menu_item( 'Member Login', '#', 99, $loginclass);
            $items[] = _custom_nav_menu_item( 'Account', '#', 100, $accountclass);
            $items[] = _custom_nav_menu_item( 'Details', '#', 101, $detailclass, 1000100);
            $items[] = _custom_nav_menu_item( 'Log Out', '#', 102, $logoutclass, 1000100);
            wp_enqueue_script('header-booking-menu-js', plugin_dir_url( __FILE__ ) . 'js/header-booking-menu.js', array('jquery'));
        }elseif($jacromenutype == 'h_membership'){
            $membershipclass = array('membership-btn');
            $items[] = _custom_nav_menu_item( 'Membership', '#' , 99, $loginclass);
            wp_enqueue_script('header-booking-menu-js', plugin_dir_url( __FILE__ ) . 'js/header-booking-menu.js', array('jquery'));
        }else{

        }
    }
    return $items;
}  

function _custom_nav_menu_item( $title, $url, $order, $classes, $parent = 0 ){
    $item = new stdClass();
    $item->ID = 1000000 + $order + $parent;
    $item->db_id = $item->ID;
    $item->title = $title;
    $item->url = $url;
    $item->menu_order = $order;
    $item->menu_item_parent = $parent;
    $item->type = '';
    $item->object = '';
    $item->object_id = '';
    $item->classes = $classes;
    $item->target = '';
    $item->attr_title = '';
    $item->description = '';
    $item->xfn = '';
    $item->status = '';
    return $item;
}

/* additional iframes */
function additional_iframes_sites(){
    global $wpdb;
    $table_customers = $wpdb->prefix . "jacro_customers";
    $customers = $wpdb->get_results("SELECT * FROM $table_customers");
    foreach($customers as $customer) {
        echo '<input type="hidden" name="cust_location" id="cust_location" value="'.$customer->code.'">';
    }

    // Get options and set URLs accordingly
    $americanlang = get_option( 'americanlang' );
    $australianlang = get_option( 'australianlang' );
    $uktheatre = get_option( 'uktheatre' );
    if($americanlang) { 
        echo '<input type="hidden" name="us_url" id="us_url" value="https://www.internet-ticketing.com">';
    }elseif($australianlang) {
        echo '<input type="hidden" name="au_url" id="au_url" value="https://www.cineticketing.com.au">';
    }else { 
        echo '<input type="hidden" name="uk_url" id="uk_url" value="https://www.jack-roe.co.uk">';
    }
    echo '<iframe id="login-iframe" frameborder="0" allowtransparency="true"></iframe>
        <iframe id="logout-iframe" frameborder="0" style="display:none"></iframe>
        <iframe id="jacro-giftcard-balance" frameborder="0" allowtransparency="true" style="display:none"></iframe>
        <iframe id="contact-preferences-iframe" frameborder="0" style="display:none"></iframe>';
}
add_action('wp_head','additional_iframes_sites');

//Adding the Open Graph in the Language Attributes
function add_opengraph_doctype( $output ) {
    return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
}
add_filter('language_attributes', 'add_opengraph_doctype');

function first_sentence($content) {
   $pos = strpos($content, '.');
   return substr($content, 0, $pos+1);
}
 
//remove default title tag
remove_action('wp_head', '_wp_render_title_tag', 1);

//Lets add Open Graph Meta Info 
function insert_searchmeta_in_head() {
    global $post;
    $sitename = get_bloginfo('name');
    echo "<title>".html_entity_decode(get_the_title())." - ".$sitename."</title>". "\n";
    if ( is_home() ) {
        echo '<meta name="description" content="' . get_bloginfo( "description" ) . '" />' . "\n";
    }
    if ( is_singular() ) {
        $des_post = strip_tags( get_post_meta($post->ID,"synopsis",true) );
        echo '<meta name="description" content="'.str_replace('"', "'", first_sentence($des_post)).'" />' . "\n";
    }
    echo '<meta property="og:title" content="' . get_the_title($post->ID) . '"/>'. "\n";
    echo '<meta property="og:type" content="article"/>';
    echo '<meta property="og:url" content="' .get_the_permalink(). '"/>'. "\n";
    echo '<meta property="og:site_name" content="'.$sitename.'"/>'. "\n";
    $img_url = get_post_meta($post->ID,"img_url",true);
    if($img_url) { 
        echo '<meta property="og:image" content="'.$img_url.'"/>'. "\n";
    }
    else{
        $default_image=plugin_dir_url( __FILE__ )  . 'images/default.png'; 
        echo '<meta property="og:image" content="' . $default_image . '"/>'. "\n";  
    }
    echo '<meta name="twitter:card" content="'.$sitename.'" />'. "\n";
}
add_action( 'wp_head', 'insert_searchmeta_in_head', 5 );

/* time format set */
function time_options_save( $old_value, $new_value ) {
    $new_value = substr($new_value, 0, 1);
    if( $new_value == 'g' || $new_value == 'h' ){
        update_option('jacroShowTimeHour', 'true');
    }else{
        update_option('jacroShowTimeHour', false);
    }
}
add_action( 'update_option_time_format', 'time_options_save', 10, 2 );

/* empty log record in database */
function delete_log_record(){
    extract($_POST);
    $response = array();
    global $wpdb;
    $table_name = $wpdb->prefix . 'jacro_logs';
    $delete_log = $wpdb->query('TRUNCATE TABLE '.$table_name);
    if($delete_log){
        $response = array('status'=>'success');
    }else{
        $response = array('status'=>'failed');
    }
    wp_send_json($response);
    wp_die();
}
add_action( 'wp_ajax_delete_log_record', 'delete_log_record' );

/* modifier order set */
function ascending_modifier($a, $b) {   
    if ($a == $b) {        
        return 0;
    }   
        return ($a < $b) ? -1 : 1; 
}  

/* show all modifier */
function show_modifiers($term_id) {
    $modifiers = array();
    global $wpdb;
    $table = $wpdb->prefix . "jacro_modifiers";
    $query = $wpdb->prepare("SELECT * FROM $table WHERE location = %d", $term_id);
    $result = $wpdb->get_results($query);
    if($result) {
        foreach($result as $post_val) {
            $shortcode = $post_val->shortcode;
            $priority = $post_val->priority;
            $modifiers[$shortcode] = $priority;
        }
        uasort($modifiers,"ascending_modifier");
    }
    return $modifiers;       
}

/* show all performance category */
function show_perfcat_films() {
    global $wpdb;
    $table_performances = $wpdb->prefix . "jacro_performances";
    $query = $wpdb->prepare("SELECT * FROM $table_performances WHERE selloninternet = %s ORDER BY starttime ASC", 'Y');
    $perf_result = $wpdb->get_results($query);
    $perfcategoy = array();
    if($perf_result) {
        foreach($perf_result as $performance) {
            $perfcategoy[] = $performance->perfcat;
        }  
    }
    $uniqueperfcat = array_unique($perfcategoy);
    return $uniqueperfcat;    
}

/* show information onclick performance category on showtime */
$perfcat_section_override = get_option('perfcat_section_override');
if($perfcat_section_override){
    function show_infomessage_beforebooking() {
        ?>
        <div style="display:none;" id="showinfo" class="">
            <div class="innerpopbk">
                <span class='closeppp'>+</span>
                <p></p>
                <a href="" class="bkingbtn">OK</a>
            </div>  
        </div>
        <?php
    }
    add_action( 'wp_footer', 'show_infomessage_beforebooking' );
}

/* update movie slider */
add_action('wp_ajax_update_movie_slider', 'update_movie_slider');
add_action('wp_ajax_nopriv_update_movie_slider', 'update_movie_slider');

function update_movie_slider() {
    extract($_POST);
    $response = array();
    $html = '';

    global $wpdb;
    $table = $wpdb->prefix . "jacro_films";
    
    if ($cinema_id) {

        $get_films = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table WHERE location = %d LIMIT $numberofposts", $cinema_id));

        $movieslideroption = get_option("movieslideroption");

        if($movieslideroption == 'manual') {

            $movieslider = get_option("movieslider");
            
            if($movieslider){ 
                $showCarousel = false;
                $ci = 0;

                foreach ($movieslider as $key => $value) {
                    $theatrelocation = $value['theatrelocation'];
                    foreach ($theatrelocation as $theaterId => $show) {
                        if ($cinema_id == $theaterId && $show) {
                            $showCarousel = true;
                            $ci++;
                            break 2;
                        }
                    }
                }  

                if ($showCarousel) :
                    $html .= '<div id="hero" class="customslider carousel slide carousel-fade" data-ride="carousel">
                    <img src="'.CINEMA_URL.'/images/scroll-arrow.svg" alt="Scroll down" class="scroll">
                    <div id="carousel" class="carousel slide" data-ride="carousel">
                        <!-- Indicators (control icons) -->
                        <div class="container"> 
                            <ol class="carousel-indicators">';
                                foreach ($movieslider as $key => $value) :
                                    foreach ($value['theatrelocation'] as $theaterId => $show) {
                                        if ($cinema_id == $theaterId && $show) {
                                            $html .= '<li data-target="#carousel" data-slide-to="' . esc_attr($key) . '" ' . (($key == 0) ? 'class="active"' : '') . '></li>';
                                            break;
                                        }
                                    }
                                endforeach;
                            $html .= '</ol>
                        </div>
                        <div class="carousel-inner" role="listbox">';
                            $ci = 0;
                            foreach ($movieslider as $key => $value) {
                                $sliderimage = $value['sliderimage'];
                                $img_url = str_replace($_SERVER['DOCUMENT_ROOT'], '', $sliderimage); 
                                $slidergenre = $value['slidergenre'];
                                $slidertitle = $value['slidertitle'];
                                $slidercontent = $value['slidercontent'];
                                $slidercertificate = $value['slidercertificate'];
                                $slidertrailer = $value['slidertrailer'];
                                $slidersynopsis = $value['slidersynopsis']; 
                                $theatrelocation = $value['theatrelocation']; 

                                $showCarouselItem = false;
                                foreach ($theatrelocation as $theaterId => $show) {
                                    if ($cinema_id == $theaterId && $show) {
                                        $showCarouselItem = true;
                                        break;
                                    }
                                } 

                                if ($showCarouselItem) { 
                                    $ci++;
                                    $html .= '<div class="item ' . (($ci == 1) ? 'active' : '') . '" style="background-image: url(' . esc_url($img_url) . ')">
                                        <div class="container">
                                            <div class="row blurb">
                                                <div class="col-md-8 col-sm-12 blurb-content">';
                                                    if($slidergenre) {
                                                        $html .= '<span class="title filmgenre"> GENRE: '.$slidergenre.'</span>';
                                                    } 
                                                    if($slidertitle) {                                  
                                                        $html .= '<header><h1>'.$slidertitle.'</h1></header>';
                                                    }
                                                    if($slidercontent && $hidedescription != 'true'){
                                                        $html .= '<p class="moviesldrdesc">' . wp_trim_words($slidercontent, 25, '...') . '</p>';
                                                    }
                                                    $html .= '<div class="buttons sldrbtns">';
                                                        if ($slidercertificate) {
                                                            $html .= '<span class="certificate">'.$slidercertificate.'</span>';
                                                        }
                                                        if($slidertrailer && $hidetrailer != 'true'){
                                                            $html .= '<a href="'.esc_url($slidertrailer).'" data-vbtype="video" class="venobox btn btn-default"><i class="fa fa-view"></i><span>Trailer</span></a>';
                                                        } 
                                                        if($slidersynopsis){
                                                            $html .= '<a href="'.esc_url($slidersynopsis).'" class="btn btn-default gotomoviebtn"><span>FULL SYNOPSIS</span></a>';
                                                        }
                                                    $html .= '</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                }
                            }
                        $html .= '</div>
                    </div>
                </div>';
                $response = array('status' => 'success', 'htm' => $html);
            else :
                $response = array('status' => 'failed');
                endif;  
            }
            

        } else if($movieslideroption == 'advertise') {

        $adsslider = get_option("adsslider");


        if($adsslider){

            $total_slides = count($get_films);
            $addslidesfinal = array();
            $excount = 1;
            foreach ($adsslider as $adkey => $advalue) {
                if(isset($advalue['theatrelocation'][$cinema_id])){
                    if(!empty($advalue['adsposition'])){
                        $key = $advalue['adsposition'] - 1;
                    }else{
                        $key = $total_slides+$excount - 1;
                        $excount++;
                    }
                    if(!isset($addslidesfinal[$key])){
                        $addslidesfinal[$key] = $advalue;
                    }else{
                        $newky = $key+1;
                        $addslidesfinal[$newky] = $advalue;
                    }
                    
                }
            }

            $ads_slides = count($addslidesfinal);
            $indicator_count = $total_slides + ($adsslider ? $ads_slides : 0);

            $allslidessr = array();
            $emptyindexslides = array();
            if ($addslidesfinal) {
                foreach ($get_films as $flmkey => $flmvalue) {
                    $keyToAdd = $flmkey;
                    while (isset($addslidesfinal[$keyToAdd]) && !empty($addslidesfinal[$keyToAdd])) {
                        if (is_array($addslidesfinal[$keyToAdd]) && empty($addslidesfinal[$keyToAdd]['adsposition'])) {
                            $emptyindexslides[] = $addslidesfinal[$keyToAdd];
                            unset($addslidesfinal[$keyToAdd]);
                            
                        }
                        $keyToAdd++;
                    }
                    $addslidesfinal[$keyToAdd] = $flmvalue;
                }
            }

            ksort($addslidesfinal);
            $fullarray = array_merge($addslidesfinal,$emptyindexslides);

            if($fullarray){ 
                $html .= '<div id="hero" class="customslider carousel slide carousel-fade advertiseslider" data-ride="carousel">
                    <img src="' . CINEMA_URL . '/images/scroll-arrow.svg" alt="Scroll down" class="scroll">
                    <div id="carousel" class="carousel slide" data-ride="carousel">
                      <div class="container">
                            <ol class="carousel-indicators">';
                                for ($i = 0; $i < $indicator_count; $i++){  
                                    if($i === 0){
                                        $class = 'class="active"';
                                    }else{
                                        $class = '';
                                    }
                                    $html .= '<li data-target="#carousel" data-slide-to="'.$i.'" '.$class.'></li>';
                                }
                            $html .= '</ol>
                        </div>';
                
                        $html .= '<div class="carousel-inner" role="listbox">';
                          $i = 1; 
                          foreach($fullarray as $key => $slide){
                            
                            if(is_array($slide) && isset($slide['adsimage'])){
                                
                                $sliderimage = $slide['adsimage'];
                                $img_url = str_replace($_SERVER['DOCUMENT_ROOT'], '', $sliderimage);
                                    if($i === 1){
                                        $class = 'active';
                                    }else{
                                        $class = '';
                                    }
                                $html .= '<div class="item '.$class.'" style="background-image: url('.$img_url.')">
                                  <div class="container">
                                   
                                  </div>
                                </div>';
                            
                                $i++;
                            }else{
                         
                                $backdrop = $slide->img_bd;
                                $synopsis = $slide->synopsis;
                                $certificate = $slide->certificate;
                                $filmlink = $slide->url;
                                $film_trailer = $slide->youtube;
                                $film_genre = $slide->genre; 
                                $filmtitle = $slide->filmtitle;
                                if($i === 1){
                                    $class = 'active';
                                }else{
                                    $class = '';
                                }
                              
                                $html .= '<div class="item '.$class.'" style="background-image: url('.esc_url($backdrop).')">

                                    <div class="container">
                                        <div class="row blurb">
                                            <div class="col-md-8 col-sm-12 blurb-content">';
                                                if($film_genre && $film_genre!='None') {
                                                $html .= '<span class="title filmgenre"> GENRE: '.esc_attr($film_genre).'</span>';
                                                }                                   
                                                $html .= '<header>
                                                    <h1>'.$filmtitle.'</h1>
                                                </header>';
                                                if($synopsis && $hidedescription != 'true'){
                                                    $html .= '<p class="moviesldrdesc">'.wp_trim_words($synopsis, 25, '...').'</p>';
                                                }
                                                $html .= '<div class="buttons sldrbtns">';
                                                    
                                                    if ($certificate != '') {
                                                        $html .= '<span class="certificate">
                                                            '.$certificate.'
                                                        </span>';
                                                    }
                                                    
                                                    if($film_trailer && $hidetrailer != 'true'){ 
                                                    $html .= '<a href="'.esc_url($film_trailer).'"  data-vbtype="video" class="venobox btn btn-default">
                                                        <i class="fa fa-view"></i>
                                                            <span>Trailer</span>
                                                        </a>';
                                                    }   

                                                    if($filmlink){
                                                    
                                                    $html .= '<a href="'.esc_url($filmlink).'" class="btn btn-default gotomoviebtn">
                                                        <span>FULL SYNOPSIS</span>
                                                    </a>';
                                                }
                                                $html .= '</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                            
                            $i++;
                            }
                        }
                        $html .= '</div>
                    </div>
                  </div>';
                  $response = array('status' => 'success', 'htm' => $html);
                }   
                else {
                    $response = array('status' => 'failed');
                }
            }
            
    }else {

            if ($get_films) {
                $html .= '<img src="' . CINEMA_URL . '/images/scroll-arrow.svg" alt="Scroll down" class="scroll">';
                $html .= '<div id="carousel" class="carousel slide" data-ride="carousel">
                    <div class="container">
                        <ol class="carousel-indicators">';

                foreach ($get_films as $key => $slide) {
                    $active = ($key == 0) ? 'class="active"' : '';
                    $html .= '<li data-target="#carousel" data-slide-to="' . ($key + 0) . '" ' . $active . '></li>';
                }

                $html .= '</ol>
                    </div>
                    <div class="carousel-inner" role="listbox">';

                $i = 0;
                foreach ($get_films as $key => $slide) {
                    $i++;
                    $backdrop = $slide->img_bd;
                    $synopsis = $slide->synopsis;
                    $certificate = $slide->certificate;
                    $filmlink = $slide->url;
                    $film_trailer = $slide->youtube;
                    $film_genre = $slide->genre;
                    $filmtitle = $slide->filmtitle;

                    $html .= '<div class="item ' . (($i == 1) ? 'active' : '') . '" style="background-image: url(' . esc_url($backdrop) . ')">
                                <div class="container">
                                    <div class="row blurb">
                                        <div class="col-md-8 col-sm-12 blurb-content">';

                    if ($film_genre && $film_genre!='None') {
                        $html .= '<span class="title filmgenre"> GENRE: ' . esc_attr($film_genre) . '</span>';
                    }

                    $html .= '<header>
                                    <h1>' . $filmtitle . '</h1>
                                </header>';

                    if ($synopsis && $hidedescription != 'true') {
                        $html .= '<p class="moviesldrdesc">' . wp_trim_words($synopsis, 25, '...') . '</p>';
                    }

                    $html .= '<div class="buttons sldrbtns">';

                    if ($certificate != '') {
                        $html .= '<span class="certificate">' . $certificate . '</span>';
                    }

                    if ($film_trailer && $hidetrailer != 'true') {
                        $html .= '<a href="' . esc_url($film_trailer) . '"  data-vbtype="video" class="venobox btn btn-default">
                                        <i class="fa fa-view"></i>
                                        <span>Trailer</span>
                                    </a>';
                    }

                    if ($filmlink) {
                        $html .= '<a href="' . esc_url($filmlink) . '" class="btn btn-default gotomoviebtn">
                                        <span>FULL SYNOPSIS</span>
                                    </a>';
                    }

                    $html .= '</div>
                                </div>
                            </div>
                        </div>
                    </div>';
                }

                $html .= '</div>
                    </div>';
                $response = array('status' => 'success', 'htm' => $html);
            } else {
                $response = array('status' => 'failed');
            }
        }
    } else {
        $response = array('status' => 'failed');
    }

    wp_send_json($response);
    wp_die();
}