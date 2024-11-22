<?php
$filter_per_date = date("Y-m-d", strtotime($filter_date));
$check_today_evets = jacro_check_calender_events($filter_per_date);
$evetn_filmes = jacro_get_live_event('film', '', $filter_per_date);
$post_parent = array();
$data_exist = false;
if (function_exists('fw_get_db_settings_option')) {
	$primaryColour = fw_get_db_settings_option('primary_colour');
	$secondaryColour = fw_get_db_settings_option('secondary_colour');
} else {
	$primaryColour = get_option('primary_colour');
	$secondaryColour = get_option('secondary_colour'); 
}

foreach($evetn_filmes as $film) {
	$post_arr = jacro_get_live_event_performance($film->code, $filter_per_date);
	$filmdtprformance = array();
	foreach($post_arr as $key=>$val) {
		$per_date = $val->performdate;
		if (array_search(date('Y, m, d', strtotime($per_date)), array_column($filmdtprformance, 'date')) !== FALSE) {
			continue;
        } else {
            $filmdtprformance[$counter]['date'] = date('Y, m, d', strtotime($per_date));         
            $film->time = $val->starttime;
            $post_parent[] = (array)$film;
        }
	}
}
usort($post_parent, 'my_sort'); ?>

<style>
	.perfbtn{color: #fff; background-color: <?php echo $primaryColour ?> !important;}
	.perfbtn:hover{color:#fff !important; background-color:<?php echo $secondaryColour ?> !important;}
	.moreshowtimes {background-image: linear-gradient(to right, <?php echo $primaryColour; ?>, <?php echo $secondaryColour; ?>) !important;}
	.moreshowtimes:hover {color: #fff !important;}
</style>

<?php
if(!empty($check_today_evets)) {
	foreach($post_parent as $film) {
		if(in_array($film['code'], $check_today_evets['ids'])){ 
			$data_exist=true; ?>
			<div class="jacro-event">
				<div class="col-md-12 col-sm-12 col-xs-12 no-padding">
					<div class="col-md-3 col-sm-6 col-xs-12">
						<?php $img_url = $film['img_1s'];
						$default_image = plugin_dir_url( __FILE__ ).'images/default.png';
						if($img_url == "" || $img_url == "None"){ $img_url=$default_image; } ?>
						<div class="film_img">
							<a href="<?php echo esc_url($film['url']); ?>" target="">
								<img alt="" style="border-radius: 4px;" src="<?php echo esc_url($img_url); ?>" class="img-responsive" width="150" height="210">
							</a>
						</div>
					</div>
					<div class="col-md-9 col-sm-6 col-xs-12" style="height: auto; margin-bottom: 2em;">
	                    <?php 
	                    $certificate = $film['certificate'];
	                    $running_time = $film['runningtime'];
	                    ?>
						<div class="film-title jacro-text-left" style="margin: 0px !important;">
	                        <h3>
	                            <strong><a style="color: #101010;"  href="<?php echo esc_url($film['url']); ?>" target=""><?php echo esc_html($film['filmtitle']); ?></a></strong>
	                            <span style="font-size:14px;"><span style="float: right; font-size: 13px; font-weight: bold; line-height: 33px; display: inline-block; width: 33px; height: 33px; margin-left: 5px; text-align: center; letter-spacing: 0; color: #fff; border-radius: 50%; background: #4a4a4a;"><?php echo $certificate; ?></span></span>
	                        </h3>
	                    </div>
	                    <?php $synopsis = balanceTags($film['synopsis'], true); ?>
						<div class="film-info"><?php echo htmlsafe_truncate($synopsis, 180, array('html' => true, 'ending' => ' ...', 'exact' => false)); ?></div>
	                    <a href="<?php echo esc_url($film['url']); ?>" class="arrow-button">Full synopsis</a>
					</div>                      
					<div class="col-md-3 col-sm-6 col-xs-12 no-padding" style="padding: 0px;"></div>
					<div class="col-md-9 col-sm-6 col-xs-12 no-padding" style="padding: 0px;">
					<?php
						$post_arr = jacro_get_live_event_performance($film['code'], $filter_per_date);
						$tmp_start_time = ''; $tmparray = array(); $new=0;
						$id_3d = $film['is3d'];
						$id_3d = filmCheckDimension($id_3d);
						$all_perf_flags = array();
						$term_id = $film['location'];
						$cinema_name = get_option('term_'.$term_id);
						$strtotimezone = jacro_strtotimezone($term_id);
						$jacroCountryname = get_option('jacroCountry-'.$term_id); $filter = array();
						if(!empty($post_arr)) { ?>
							<div class="jacro-events">
								<?php
								$start_date_arr =''; 	
								foreach($post_arr as $key=>$val) {
									$perform_date = strtotime($val->performdate);
									$start_time = $val->starttime;
									$trailer_time = $val->trailertime;
									$screen = $val->screen;
									$start_time = date('H:i', strtotime($start_time));
									$approx_end_time = JacroCountApproxEndTime($start_time, $running_time, $trailer_time);
									$approxEndTimeFormate = JacroTimeFormate($approx_end_time, $jacroCountryname);
									$wheelchair_accessible = $val->wheelchairaccessible;
	                                $ad = $val->ad;
	                                if (strpos($ad,'Y') !== false) {
	                                    $ad = str_replace('Y', '<i class="fa fa-audio-description" aria-hidden="true"></i>', $ad); 
	                                }
	                                else {
	                                    $ad = '';
	                                }

	                                $termsID = $val->location;
                            		$termname = jacro_theatre_name($termsID);
                            		$theatre_name = strtolower(preg_replace('/[^\\pL\d]+/u', '-', $termname));

									$subs=$val->subs;
									$soldoutlevel=$val->soldoutlevel;
									$perf_cat_class_val=$val->perfcat;
									$title = basename($film['url']);
									$perf_flags=$val->perfflags;  
									if (strpos($perf_flags,'AUT') !== false) {
	                                    $perf_flags = str_replace('AUT', 'Autism Friendly', $perf_flags); 
	                                }
	                                if (!empty($perf_flags)) {
	                                    $perf_flags .= '</br>';
	                                }
	                                else {
	                                    $perf_flags = ''; 
	                                }
									if($start_date_arr==''):$start_date_arr=$perform_date;endif;
									if($key==0): $new=0;endif;
									if($start_date_arr != $perform_date) {$new = 0; $start_date_arr=$perform_date;}
									$tmparray[date("Y-m-d",$perform_date)][$new]['id'] =  $val->id;
									$tmparray[date("Y-m-d",$perform_date)][$new]['screen'] =  $screen;
									$tmparray[date("Y-m-d",$perform_date)][$new]['start_time'] =  $start_time;
									$tmparray[date("Y-m-d",$perform_date)][$new]['title'] =  $film['filmtitle'];
									$tmparray[date("Y-m-d",$perform_date)][$new]['date'] = $perform_date;
									$tmparray[date("Y-m-d",$perform_date)][$new]['certificate'] =  $certificate;
									$tmparray[date("Y-m-d",$perform_date)][$new]['running_time'] =  $running_time;
									$tmparray[date("Y-m-d",$perform_date)][$new]['approx_end_time'] = $approxEndTimeFormate;
									$tmparray[date("Y-m-d",$perform_date)][$new]['is_3d'] = $id_3d;
                                    $tmparray[date("Y-m-d",$perform_date)][$new]['perf_cat_class_val'] = $perf_cat_class_val;                                
									$tmparray[date("Y-m-d",$perform_date)][$new]['sub_title'] = $subs;
									$tmparray[date("Y-m-d",$perform_date)][$new]['soldoutlevel'] = $soldoutlevel;
									$tmparray[date("Y-m-d",$perform_date)][$new]['wheelchair_accessible'] = $wheelchair_accessible;
									$tmparray[date("Y-m-d",$perform_date)][$new]['special_fea'] = (!empty($perf_flags))?$perf_flags:'';
									$tmparray[date("Y-m-d",$perform_date)][$new]['booknow_url'] = home_url()."/".$theatre_name."/booknow/".$val->code;
									$new++;
								}
								foreach($tmparray as $date=>$datefilms){
									$filmstimearray = array(); 
									$filmstimearray = sorting_time($datefilms);
									$tmp = ''; $is_show_date = 0;
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
										$startTimeHourFormat = JacroTimeFormate($start_time, $jacroCountryname);
										if(strtolower($jacroCountryname)=='us') {
											$showTimeClass = 'show-time-12-hours';
										} elseif(strtolower($jacroCountryname)=='uk') {
											$showTimeClass = '';
										} else {
											$jacroShowTimeHour = get_option('jacroShowTimeHour');
											if($jacroShowTimeHour==true) {$showTimeClass = 'show-time-12-hours';}
											else {$showTimeClass = '';}
										}

										if(strtotime(date('Y-m-d H:i', strtotime("$per_date $start_time"))) > $strtotimezone) { 

											if($tmp=='') { $show_date = true; $tmp = $date; } elseif($tmp==$date){ $show_date = false; }
											$jacroDateFormate = JacroDateFormate($date);
											if($show_date==true) { $is_show_date=1;
												$date_year = date('Y', strtotime($jacroDateFormate));
												$date_month = (date('m', strtotime($jacroDateFormate))-1);
												$date_day = date('d', strtotime($jacroDateFormate));
												echo "<div class='show-time' style='display: inline-block; padding-left: 15px;' >";
											} 
											?>
												
	                                            <div class="perfmods" style="display: inline-block;">
													<?php 
													$jacroShowTimeHour = get_option('jacroShowTimeHour');
	                                                if($jacroShowTimeHour == true) {
	                                                    $jacrobookTimeFormat = date("g:i a", strtotime($startTimeHourFormat));
	                                                } else {
	                                                    $jacrobookTimeFormat = date("H:i", strtotime($startTimeHourFormat));
	                                                }
													?>
	                                                <?php 
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
	                                                   		echo '<a class="perfbtn" '.$alertinfo.' href="'.$films['booknow_url'].'">'.get_option('showtime_button_text').' '.$jacrobookTimeFormat.' '.$pfbtntxt.'</a>';
	                                                   	}
	                                                }else{
	                                                	if($films['soldoutlevel'] && $films['soldoutlevel'] == 'Y') {
                                                            echo '<a class="perfbtn disabled">Sold Out</a>';
                                                        }else{
	                                                   		echo '<a class="perfbtn" '.$alertinfo.' href="'.$films['booknow_url'].'">'.$jacrobookTimeFormat.' '.$pfbtntxt.'</a>';
	                                                   	}
	                                                }
	                                                echo '<input type="hidden" class="perfcat_message" value="'.$pfbtnmsg.'">';

	                                                ?>
	                                            </div>
	                                            <?php if($show_date == true){ echo "</div>"; }
											}
										}
									} ?>
	                                <a style="margin-left: 5px;" href="<?php echo esc_url($film['url']); ?>" class="moreshowtimes" target="">More</a>
							</div><?php
						}
						$all_perf_flags_imp = implode('<li><span>',$all_perf_flags); ?>
	                                           
					</div>
				</div>
			</div><?php 
		}
	}
}
if(!$data_exist) { ?>
	<div class="film-info">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class='jacro-text-center jacro-custom-messages'><?php _e('No films available !', 'jacro'); ?></div>
		</div>
	</div>
<?php } ?>