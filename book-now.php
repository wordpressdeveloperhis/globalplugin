<title>Ticket Booking</title>

<?php
get_header(); 

global $wpdb;
$table_film = $wpdb->prefix . "jacro_films";
$table_performances = $wpdb->prefix . "jacro_performances";
$table_locations = $wpdb->prefix . "jacro_locations";

$current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$path = parse_url($current_url, PHP_URL_PATH);
$code = basename($path);
$url_parts = explode("/" , $current_url);
$location_name = str_replace("-", " ", $url_parts[3]);

$location_result = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_locations WHERE name LIKE %s LIMIT 1", $location_name));
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

$eventloc = get_option( 'booking-header-loc' );
$includevenue = get_option( 'includevenue' );
$default_jacro_image = get_option( 'default_jacro_image' );
$default_image = wp_get_attachment_url( $default_jacro_image);
$jacroCountryname = get_option('jacroCountry-'.$term_id);

$query = $wpdb->prepare("SELECT * FROM $table_performances WHERE location = %d AND code = %s AND selloninternet = %s", $cinema, $code, 'Y');
$book_result = $wpdb->get_row($query);

if($book_result) {
	$query = $wpdb->prepare("SELECT * FROM $table_film WHERE location = %d AND code = %s", $cinema, $book_result->filmcode);
	$film_result = $wpdb->get_row($query);
	if($film_result) {
		$backdrop = $film_result->img_bd;
		$filmtitle = $film_result->filmtitle;
	}
	$pdate = $book_result->performdate;
	$ptime = $book_result->starttime;
	$start_time = date('H:i', strtotime($ptime));
	$startTimeHourFormat = JacroTimeFormate($start_time, $jacroCountryname);
	$screen = $book_result->screen;
	$subs = $book_result->subs;
	if (strpos($subs,'Y') !== false) {
	    $subs = str_replace('Y', '<i class="fa fa-cc" aria-hidden="true"></i>', $subs); 
	} else {
		$subs = '';
	}
	$wheelchair_accessible = $book_result->wheelchairaccessible;
	if (strpos($wheelchair_accessible,'Y') !== false) {
	    $wheelchair_accessible = str_replace('Y', '<i class="fa fa-wheelchair" aria-hidden="true"></i>', $wheelchair_accessible); 
	} else {
	    $wheelchair_accessible = '';
	}
	$ad = $book_result->ad;
	if (strpos($ad,'Y') !== false) {
	    $ad = str_replace('Y', '<i class="fa fa-audio-description" aria-hidden="true"></i>', $ad); 
	} else {
	    $ad = '';
	}
	$perf_flags = $book_result->perfflags;
	if(!empty($perf_flags)) {
	    $perf_flag_arr=explode("|",$perf_flags);
	    $perf_flags=implode(",",$perf_flag_arr);
	}
	if (strpos($perf_flags,'AUT') !== false) {
	    $perf_flags = str_replace('AUT', 'This performance is Autism Friendly', $perf_flags); 
	}

	if ( wp_is_mobile() ) {
		$booking_url = $book_result->internalbookingurlmobile;
	} else {
		$booking_url = $book_result->internalbookingurldesktop;
	}

?>

<link rel="stylesheet" href="/fonts/font-awesome-4.7.0/css/font-awesome.min.css">

<?php get_template_part('inc/header', 'nav'); ?>

<div id="content_hero" class="jacrobookhero" style="background-image: url(<?php echo $backdrop;?>); background-position: 50% 25%; min-height:0px !important;">
	<div style="background: #00000080;">
		<img src="<?php echo plugin_dir_url( __FILE__ ); ?>/images/scroll-arrow.svg" alt="<?php echo esc_attr__('Scroll down', 'specto'); ?>" class="scroll" />
		<div class="container">
			<div class="row blurb">
				<div class="col-md-9">
					<span class="title">You're booking tickets for:</span>
					<header>
						<h1><?php echo $filmtitle; ?></h1>
					</header>
	                <span class="booktimedate">On <?php echo JacroDateFormate($pdate); ?> at <?php echo $startTimeHourFormat; ?><br>
	                    <!--- Grab Location if enabled in settings --->
	                    <?php if ($eventloc) { ?>
						<span class="eventloc"><?php echo $theatre_name ?></span> 
						<?php } else { echo '';  }
							if ($includevenue) { ?> <span class="eventloc">Venue: <?php echo $screen ?></span> 
	                    <?php } else { echo ''; } ?>
						<span id="perfaut"><?php echo $perf_flags; ?></span><span id="perfad"><?php echo $ad; ?></span><span id="prefsub"><?php echo $subs; ?></span><span id="perfwc"><?php echo $wheelchair_accessible; ?></span>
					</span>
	                </br>
	                <?php
	                    $americanlang = get_option( 'americanlang' );
	                    $australianlang = get_option( 'australianlang' );
	                    $uktheatre = get_option( 'uktheatre' );
	                    if ($americanlang) {?>
	                        <a class="backtohome" style="font-size: 15px; margin: 0px; background: transparent !important;"href="<?php echo home_url();?>" style="text-decoration: none;"><i class="fas fa-arrow-left"></i> Back To Movie Times</a>
	                    <?php } elseif ($australianlang) {?>
	                        <a class="backtohome"  style="font-size: 15px; margin: 0px; background: transparent !important;"href="<?php echo home_url();?>" style="text-decoration: none;"><i class="fas fa-arrow-left"></i> Back To All Sessions</a>
	                    <?php } elseif ($uktheatre) {?>
	                        <a class="backtohome" style="font-size: 15px; margin: 0px; background: transparent !important;"href="<?php echo home_url();?>" style="text-decoration: none;"><i class="fas fa-arrow-left"></i> Back To What's On</a>
	                    <?php }else { ?>
	                        <a class="backtohome" style="font-size: 15px; margin: 0px; background: transparent !important;"href="<?php echo home_url();?>" style="text-decoration: none;"><i class="fas fa-arrow-left"></i> Back To What's On</a>
	                    <?php }
	                ?> 
				</div>
			</div>
		</div>
	</div>
</div>

<?php wp_enqueue_script( 'jacro-iframe-resizer-min-js' ); ?>

<div id="content" class="full-width">    
	<?php
	global $wp_query;
	$book_arr=$wp_query->query_vars;
	$jacroGoogleAnalyticsTrackingID = get_option('google-analytics-tracking-id');
	$googleAnalyticsCode = stripslashes(get_option('google_analytics_code'));

    ?>

	<div class="post-content">
		<iframe id="jacro_iframe" width="100%" height="100%" scrolling="no" frameborder="0"></iframe>
	</div>
</div>

<script>
	jQuery(document).ready(function (){
		if(jQuery("#widgets_cinema_id").length != 0) {
			var cinema_val = '<?php echo $cinema;?>'; jQuery("#widgets_cinema_id").val(cinema_val);
		}
		var clientId = '';
		var TaposId = readCookie("TaposContactId");
		if(TaposId == null || TaposId == undefined || TaposId == '') {
			TaposId = randomTaposID(24);
		}
		let sessionUrlParameter = sessionStorage.getItem('sessionUrlParameter') ? sessionStorage.getItem('sessionUrlParameter') : '';
		/** Google Code **/
		if (window.ga && ga.loaded) {
			/** Google tracker Code **/
				(function(i,s,o,g,r,a,m){
					i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
					(i[r].q=i[r].q||[]).push(arguments) },i[r].l=1*new 
					Date();a=s.createElement(o),
					m=s.getElementsByTagName(o)[0];a.async=1;a.src = g;
					m.parentNode.insertBefore(a, m)
				})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
			ga('create', '<?php echo $googleAnalyticsCode; ?>', 'auto' , {
				'allowLinker': true
			});
			ga('require', 'ecommerce', 'ecommerce.js');
			ga('send', 'pageview');
			ga('set', 'anonymizeIp', true);
			/****** tracker *******/
			ga(function(tracker) {
				clientId = tracker.get('clientId');
				var url='<?php echo $booking_url; ?>_ga='+clientId+'&tapos_id='+TaposId+'&'+sessionUrlParameter;
				set_iframe_url(url);
			});
			/** end Google Code **/
		} else {
			// if Tracking Protection on
			var url='<?php echo $booking_url; ?>tapos_id='+TaposId+'&'+sessionUrlParameter;
			set_iframe_url(url);
		}
		/** end Google tracker Code **/
	});

	function set_iframe_url(url){
		var new_url = url.replace('http://','https://');
		new_url = new_url.replace(/\s/g, '');
		new_url = new_url.replace('&amp;', '&');
		jQuery('#jacro_iframe').attr('src', new_url);
		window.addEventListener("DOMContentLoaded", function(e) {
			document.querySelector('iframe').addEventListener('load', function(e) {}, false);
		}, false);
		window.addEventListener( "message", CallJacroIframeListener, false );
		var ifrm = jQuery('#jacro_iframe');
		iFrameResize({
			autoResize:true, checkOrigin:false, log:false, enablePublicMethods:true, resizedCallback: 
			function(messageData){ }
		});
	}
</script>

<?php } else { ?>

	<link rel="stylesheet" href="/fonts/font-awesome-4.7.0/css/font-awesome.min.css">

	<?php get_template_part('inc/header', 'nav'); ?>

	<div id="content_hero" class="jacrobookhero">
		<div style="background: #00000080;">
			<img src="<?php echo plugin_dir_url( __FILE__ ); ?>/images/scroll-arrow.svg" alt="<?php echo esc_attr__('Scroll down', 'specto'); ?>" class="scroll" />
			<div class="container">
				<div class="row blurb">
					<div class="col-md-9">
						<header>
							<h1 style="text-align: center;color: #a94442;letter-spacing: 0;">Sorry, the showtime is not available.</h1>
						</header>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php } ?>

<?php get_footer(); ?>