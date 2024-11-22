<?php
/**
*	Display Jacro Widgets
*/

/** Jacro Widgets CaLL **/
Class JacroWidgetsCall {
        
	/** Show Time Widget **/
	public function JacroShowTimeWidget($switch_filter=false) {
		//wp_enqueue_style('jacro-select2-css');
		wp_enqueue_style('jacro-caleandar-css');
		//wp_enqueue_script('jacro-select2-js');
		wp_enqueue_script('jacro-caleandar-js');
		$taxonomy='theatre';
		$terms_arr=array();
		$terms = get_terms($taxonomy,array("hide_empty"=>0));
		foreach($terms as $term) {
			$term_name=get_option( 'term_'.$term->term_id);
			$terms_arr[$term->term_id]=ucwords($term_name);
		}
		asort($terms_arr);
		$display_cinema ='block;';
		if(count($terms_arr)==1 || count($terms_arr)==0) {$display_cinema='none;';} ?>
		<style>
		#jacro-date-events .cld-main {width: auto;}
		#jacro-date-events ul.cld-days a { background: #48b195; padding: 5px; border-radius: 50%; }
		#jacro-date-events ul.cld-days li.cld-day.currMonth.today { background: #48b195; border-color: #48b195;}
		#jacro-date-events ul.cld-days li.cld-day.currMonth.today:hover { background: #48b195; border-color: #48b195;}
		#jacro-date-events ul.cld-days li.cld-day.currMonth.today p:hover { background: #48b195; border-color: #48b195;}
		#jacro-date-events ul.cld-days span.cld-title {overflow: hidden;padding: 2px;float: right;}
		#jacro-date-events ul.cld-days a{padding: 3px !important;border-radius: 50%;margin: 0px !important;float: left;}
		#jacro-date-events .cld-main ul.cld-labels {padding: 2px;background: #48b195;font-size: 12px;}
		#jacro-date-events .cld-main .cld-datetime {padding: 0px;font-size: 15px;}
		#jacro-date-events .cld-main ul.cld-days li.cld-day {height:auto;}
		#jacro-date-events li.cld-day {border:none !important; border-top: 1px solid #ddd !important; border-bottom: 1px solid #ddd !important;padding: 3px !important;}
		.jacro-event-cursor-pointer {cursor: pointer !important;background: #CCC;overflow: hidden !important;}
		#jacro-date-events .cld-day.nextMonth, #jacro-date-events .cld-day.prevMonth {opacity: 1 !important;}
		#jacro-date-events .cld-day.nextMonth, #jacro-date-events .cld-day.prevMonth{background: #eee !important;}
		#jacro-date-events .cld-day.nextMonth p, #jacro-date-events .cld-day.prevMonth p{opacity: 0.2 !important;}
		#jacro-date-events .cld-number{font-size: 11px;}
		</style>
		<div class="jacro-widgets">
			<h3 class="widget-title">BOOK NOW</h3>
			<div class="sidebar-subscribe">
				<label for="" style="display:<?php echo $display_cinema; ?>">Select Cinema</label>
				<input type="hidden" name="switch_filter" id="switch_filter" value="<?php echo $switch_filter; ?>" />
				<?php if($switch_filter=='cinema-dates-films'): ?>
					<select <?php if(!is_front_page()): ?>onchange="redirect_home()"<?php endif; ?> class="form-control subselect-cinema-theater left-select-cinema toggled" style="display:<?php echo $display_cinema; ?>" id="widgets_cinema_id" onchange="get_timing_from_cinema(this.value)">
					<!-- <select <?php if(!is_front_page()): ?>onchange="redirect_home()"<?php endif; ?> class="form-control subselect-cinema-theater left-select-cinema toggled" style="display:<?php echo $display_cinema; ?>" id="widgets_cinema_id" onchange="jacro_reload_page(this.value)"> -->
					    <?php
						$count_k=0;
						$top_cinema=$first_value=''; 
						foreach($terms_arr as $key=>$term) {
							$selected='';if($count_k==0){$top_cinema=$key;$first_value=$key;$selected='selected="selected"';}
							$count_k++;?>
					    	<option value="<?php echo $key; ?>" <?php echo $selected;?>><?php echo $term;?></option>
					    <?php } ?>
					</select>
					<?php
					if(isset($_SESSION["cinema"])){
					    $default_selected = $_SESSION["cinema"];
					} else {
						$default_selected = $top_cinema;
					}
					?>
					<input type="hidden" name="cinema_id" id="cinema_id" value="<?php echo $default_selected; ?>" />
					<div class="jacro-messages" id="jacro-calender-messages"></div>
					<div class="jacro-widget-date-movie-section" id="jacro-widget-date-movie-section">
						<div class="leftside-wars">
							<label for="">Select a Date</label>
							<div id="jacro-caleandar-section"><div class="jacro-events" id="jacro-date-events"></div></div>
							<!-- <select class="form-control left-select-cinema" id="timing_list" onchange="get_movies_from_date(this.value)">
								<option value="">Select</option>
							</select> -->
						</div>
						<div class="leftside-wars">
							<?php 
                                                            $americanlang = get_option( 'americanlang' );
                                                            $australianlang = get_option( 'australianlang' );
                                                            $uktheatre = get_option( 'uktheatre' );
                                                            if ($americanlang) {?>
                                                                <label for="">Select A Movie</label>
                                                            <?php } elseif ($australianlang) {?>
                                                                <label for="">Select A Movie</label>
                                                            <?php } elseif ($uktheatre) {?>
                                                                <label for="">Select an Event</label>
                                                            <?php } else { ?>
                                                                <label for="">Select A Film</label>
                                                            <?php }
                                                        ?>
							<select class="form-control left-select-cinema" name="film_list[]" id="film_list" onchange="get_performance_from_movie(this.value)">
								<option value="">Select</option>
							</select>
						</div>
					</div>
				<?php else :
					//wp_enqueue_script('jacro-sol-js');
					//wp_enqueue_style('jacro-chosen-css');
					//wp_enqueue_script('jacro-chosen-js');
				?>
					<select <?php if(!is_front_page()): ?>onchange="redirect_home()"<?php endif; ?> class="form-control subselect-cinema-theater left-select-cinema toggled" style="display:<?php echo $display_cinema; ?>" id="widgets_cinema_id" onchange="get_films(this.value)">
					    <?php
						$count_k=0;
						$top_cinema=$first_value=''; 
						foreach($terms_arr as $key=>$term) {
							$selected='';if($count_k==0){$first_value=$key;$selected='selected="selected"';}
							$count_k++;?>
					    	<option value="<?php echo $key; ?>" <?php echo $selected;?>><?php echo $term;?></option>
					    <?php } ?>
					</select>
					<div class="leftside-wars">
                                                <?php 
                                                    $americanlang = get_option( 'americanlang' );
                                                    $australianlang = get_option( 'australianlang' );
                                                    $uktheatre = get_option( 'uktheatre' );
                                                    if ($americanlang) {?>
                                                        <label for="">Select A Movie</label>
                                                    <?php } elseif ($australianlang) {?>
                                                        <label for="">Select A Movie</label>
                                                    <?php } elseif ($uktheatre) {?>
                                                        <label for="">Select an Event</label>
                                                    <?php }else { ?>
                                                        <label for="">Select A Film</label>
                                                    <?php }
                                                ?>
						<select class="form-control left-select-cinema" name="film_list[]" id="film_list" onchange="get_timing(this.value)">
							<option value="">Select</option>
						</select>
					</div>
					<div class="leftside-wars">
						<label for="">Select Date</label>
						<select class="form-control left-select-cinema" id="timing_list" onchange="get_performance(this.value)">
							<option value="">Select</option>
						</select>
					</div>
				<?php endif; ?>
				<div class="sample2-showtime-widget" id="jacro-widget-showtime-section">
				   	<div class="tagcloud4" id="performance_list"></div>
				</div>
				<div class="no_booking_fee_text">
					<?php $no_booking_fee_text=get_option( 'no_booking_fee_text' );?>
				    <h2><?php echo $no_booking_fee_text;?></h2>
				</div>
			</div>
		</div>
		<style>.chosen-container-single .chosen-single span{padding:5px 0px;}.chosen-container-single .chosen-single{height:34px !important;background:#FFF !important;}
		.chosen-container-single .chosen-single div b{background: #fff url("<?php echo plugin_dir_url( __FILE__ ).'images/jacro-down.png'; ?>") no-repeat scroll right center / 22px auto !important;}
		</style>
		<?php if(!is_home()) : endif; ?>
		<script> function redirect_home() { window.location.href="<?php echo home_url(); ?>"; } </script><?php
	}

	/** Download App Widgets (Image Widget) **/
	public function JacroAppDownloadWidget($instance) { ?>
		<div class="jacro-widgets-images">
			<h3 class="widget-title"><?php if(isset($instance['jacro-app-download-title'])) : echo esc_html($instance['jacro-app-download-title']); endif; ?></h3>
			<div class="jacro-images">
	        	<div class="jacro-image-text">
		        	<p><?php if(isset($instance['jacro-app-download-discription'])) : echo esc_html($instance['jacro-app-download-discription']); endif; ?></p>
		        </div>
		        <div class="jacro-image-section">
		        	<div class="jacro-image">
						<a href="<?php if(isset($instance['jacro-google-app-link'])) : echo esc_url($instance['jacro-google-app-link']); endif; ?>" target="_new">
							<img src="<?php echo esc_url(CINEMA_URL.'images/jacro-google-app.png'); ?>" width="130" height="40" />
						</a>
				    </div>
				    <div class="jacro-image">
						<a href="<?php if(isset($instance['jacro-iphone-app-link'])) : echo esc_url($instance['jacro-iphone-app-link']); endif; ?>" target="_new">
							<img src="<?php echo esc_url(CINEMA_URL.'images/jacro-apple-app.png'); ?>" width="130" height="40" />
						</a>
				    </div>
	        	</div>
	        </div>
		</div><?php
	}

	/** Gift Card Widget **/
	public function JacroGiftCardWidget($instanceDatas) { ?>
		<div class="jacro-widgets-giftcard">
			<h3 class="widget-title"><?php if(isset($instanceDatas['title'])) : echo esc_html($instanceDatas['title']); endif; ?></h3>
			<div class="jacro-images">
				<div class="jacro-gift-section">
					<?php if(isset($instanceDatas['giftImageUrl'])) :
					/*$giftCardUrl = jacro_add_query_parameters(array('jacro-gift-card'=>'sell-giftcard', 'gift-code'=>$instanceDatas['giftCode']));*/
					$giftCardUrl = SITEURL.'/jacro-gift-card/sell-giftcard/'.$instanceDatas['giftCode'];
					?>
					<?php if($giftCardUrl!='') : ?> <a href="<?php echo esc_url($giftCardUrl); ?>"> <?php endif; ?>
						<img src="<?php echo esc_url($instanceDatas['giftImageUrl']); ?>" />
					<?php if($giftCardUrl!='') : ?> </a> <?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
		</div> <?php
	}
}
?>