<?php

/**

* Template Name: Jacro Coming Soon

*

* @package Jacro

* @subpackage Jacro

*/

$primaryColour = get_option('primary_colour');

$secondaryColour = get_option('secondary_colour');

?>

<style>

.perfbtn{color: #fff; background-color: <?php echo $primaryColour ?> !important;}

.perfbtn:hover{color:#fff !important; background-color:<?php echo $secondaryColour ?> !important;}

.moreshowtimes {background-image: linear-gradient(to right, <?php echo $primaryColour; ?>, <?php echo $secondaryColour; ?>) !important;}

.moreshowtimes:hover {color: #fff !important;}

</style>

<div class="row jacro-container">

	<div class="row jacro-events">

		<div class="col-md-12 col-sm-12 col-xs-12">

			<?php

	$poster_width_class = get_option('homepage_poster_width', "w220");

	$parent_poster_width_class = "grid".$poster_width_class;

	$logo = ( function_exists( 'get_option' ) ) ? get_option('logo') : '';

	$post_films = get_films( 'Now Showing', 37, 'moredates',$order_by_date );



	foreach($post_films['post'] as $key=>$film_val) {

		$nc_filmclass = '';

		$filmspostmeta = get_post_meta($film_val->ID);

		$post_arr = get_performances( $film_val->ID, 'moredates' ,'Now Showing', 37);

		$default_image=$post_films['img'];

		if(!empty($post_arr)) {

			$img_url=get_post_meta($film_val->ID,"img_url",true);

			if(empty($img_url)){

				$img_url=$default_image;

			} elseif (strpos($img_url, 'http') !== false){

				$img_url=get_post_meta($film_val->ID,"img_url",true);

			} else {

				$img_url=$default_image;

			}

			$running_time=get_post_meta($film_val->ID,"running_time",true);

			$certificate=get_post_meta($film_val->ID,"certificate",true);

			$genre=get_post_meta($film_val->ID,"genre",true);

			$film_date='';

			$performancepostmeta = get_post_meta($post_arr[0]->ID);

			$filmclass = ''; $dateclass = '';

			foreach($filmspostmeta['genre'] as $filmpost) :

				$filmclass .= ' filmecat_'.strtolower(str_replace(' ', '_', $filmpost));

			endforeach;

			foreach($performancepostmeta['perform_date'] as $datefpost) :

				$dateclass .= ' date_'.strtolower(str_replace(' ', '_', $datefpost));

			endforeach;

			foreach($post_arr as $val):

				$perform_date=get_post_meta($val->ID,"perform_date",true);

				$start_time=get_post_meta($val->ID,"start_time",true);

				$press_report=get_post_meta($val->ID,"press_report",true);

				$perf_cat=get_post_meta($val->ID,"perf_cat",true);

				$nc_filmclass .= ' percate_'.strtolower(str_replace(' ', '_', $perf_cat));

				$start_time=substr($start_time, 0, -3);

				if(strtotime("$perform_date $start_time") > jacro_current_time()) {

					$datasarray[$perform_date][$film_val->post_title]['class'] = $filmclass.$nc_filmclass.$dateclass;

					$datasarray[$perform_date][$film_val->post_title]['permalink'] = get_permalink($film_val->ID);

					$datasarray[$perform_date][$film_val->post_title]['title'] = $film_val->post_title;

					$datasarray[$perform_date][$film_val->post_title]['img_url'] = $img_url;

					$datasarray[$perform_date][$film_val->post_title]['start_time'] = $start_time;

                    $datasarray[$perform_date][$film_val->post_title]['genre'] = $genre;

					$datasarray[$perform_date][$film_val->post_title]['runtime'] = $running_time;

					$datasarray[$perform_date][$film_val->post_title]['certificate'] = $certificate;

					$datasarray[$perform_date][$film_val->post_title]['film_type'] = 'Now Showing';

					$datasarray[$perform_date][$film_val->post_title]['film_date'] = 'moredates';

				}

			endforeach;

		}

	}

	$filspostshtml = '';

	if(isset($datasarray)&&!empty($datasarray)) :

		foreach($datasarray as $file_date=>$films_data) :

			foreach($films_data as $file_title=>$films):

				?>

				<div class="col-md-12 col-sm-12 col-xs-12 no-padding">

					<div class="col-md-3 col-sm-6 col-xs-12">

						<div class="film_img">

							<a href="<?php echo $films['permalink']; ?>" target="">

								<img alt="" style="border-radius: 4px;" src="<?php echo $films['img_url']; ?>" class="img-responsive" width="150" height="210">

							</a>

						</div>

					</div>

					<div class="col-md-9 col-sm-6 col-xs-12" style="height: auto; margin-bottom: 2em;">

						<div class="film-title jacro-text-left" style="margin: 0px !important;">

                                                    <h3>

                                                        <strong><a style="color: #101010;"  href="<?php echo $films['permalink']; ?>" target=""><?php echo $films['title']; ?></a></strong>

                                                        <span style="float: right; font-size: 13px; font-weight: bold; line-height: 33px; display: inline-block; width: 33px; height: 33px; margin-left: 5px; text-align: center; letter-spacing: 0; color: #fff; border-radius: 50%; background: #4a4a4a;"><?php echo $films['certificate']; ?></span>

                                                    </h3>

                                                </div>

                                                <?php $synopsis=get_post_meta($film->ID, 'synopsis', true); ?>

						<div class="film-info"><?php echo ($synopsis); ?></div>

                                                <a href="<?php echo esc_url(get_permalink($film->ID)); ?>" class="arrow-button">Full synopsis</a>

					</div>

                                    

					<div class="col-md-3 col-sm-6 col-xs-12 no-padding" style="padding: 0px;"></div>

					<div class="col-md-9 col-sm-6 col-xs-12 no-padding" style="padding: 0px;">

					<?php

						$post_arr = jacro_get_live_event_performance($film->ID, $filter_per_date);

						$tmp_start_time = ''; $tmparray = array(); $new=0;

						$id_3d=filmCheckDimension($id_3d);

						$all_perf_flags=array();

						$term_id = get_post_meta($film->ID, "jacroFilmTheatreID", true);

						$cinema_name = get_option('term_'.$term_id);

						$jacroCountryname = get_option('jacroCountry-'.$term_id); $filter = array();

						if(!empty($post_arr)) : ?>

							<div class="row jacro-events">

								<?php

								$start_date_arr ='';

								foreach($post_arr as $key=>$val) {

									$perform_date=strtotime(get_post_meta($val->ID,"perform_date",true));

									$start_time=get_post_meta($val->ID,"start_time",true);

									$trailer_time=get_post_meta($val->ID,"trailer_time",true);

									$screen=get_post_meta($val->ID,"screen",true);

									$start_time=date('H:i', strtotime($start_time));

									$approx_end_time = JacroCountApproxEndTime($start_time, $running_time, $trailer_time);

									$approxEndTimeFormate = JacroTimeFormate($approx_end_time, $jacroCountryname);

									$wheelchair_accessible=get_post_meta($val->ID,"wheelchair_accessible",true);

                                                                        $ad=get_post_meta($val->ID,"ad",true);

                                                                        if (strpos($ad,'Y') !== false) {

                                                                            $ad = str_replace('Y', '<i class="fa fa-audio-description" aria-hidden="true"></i>', $ad); 

                                                                        }

                                                                        else {

                                                                            $ad = '';

                                                                        }

									$theatre_name = strtolower(preg_replace('/[^\\pL\d]+/u', '-', $cinema_name));

                                    if(!$theatre_name){
                                        $term = get_term_by( 'id', $cinema_name, 'theatre' ); 
                                        $theatre_name = strtolower($term->name);
                                    } 

									$subs=get_post_meta($val->ID,"subs",true);

									$perf_flags=get_post_meta($val->ID,"perf_flags",true);

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

									$tmparray[date("Y-m-d",$perform_date)][$new]['id'] =  $val->ID;

									$tmparray[date("Y-m-d",$perform_date)][$new]['cinema_name'] =  $cinema_name;

									$tmparray[date("Y-m-d",$perform_date)][$new]['screen'] =  $screen;

									$tmparray[date("Y-m-d",$perform_date)][$new]['start_time'] =  $start_time;

									$tmparray[date("Y-m-d",$perform_date)][$new]['title'] =  get_the_title();

									$tmparray[date("Y-m-d",$perform_date)][$new]['date'] = $perform_date;

									$tmparray[date("Y-m-d",$perform_date)][$new]['certificate'] =  $certificate;

									$tmparray[date("Y-m-d",$perform_date)][$new]['running_time'] =  $running_time;

									$tmparray[date("Y-m-d",$perform_date)][$new]['approx_end_time'] =  $approxEndTimeFormate;

									$tmparray[date("Y-m-d",$perform_date)][$new]['is_3d'] =  $id_3d;

                                                                       

									$tmparray[date("Y-m-d",$perform_date)][$new]['sub_title'] =  $subs;

									$tmparray[date("Y-m-d",$perform_date)][$new]['wheelchair_accessible'] =  $wheelchair_accessible;

									$tmparray[date("Y-m-d",$perform_date)][$new]['special_fea'] =  (!empty($perf_flags))?$perf_flags:'';

									$tmparray[date("Y-m-d",$perform_date)][$new]['booknow_url'] =  home_url()."/".$theatre_name."/booknow/".$val->post_content;

									$new++;

								}

								foreach($tmparray as $date=>$datefilms):

									$filmstimearray = array(); 

									$filmstimearray = sorting_time($datefilms);

									$tmp = ''; $is_show_date = 0;



									foreach($filmstimearray as $k=>$films) :  

										$per_date = date("Y-m-d",$films['date']);

										$start_time = $films['start_time'];

										$startTimeHourFormat = JacroTimeFormate($start_time, $jacroCountryname);

										if(strtolower($jacroCountryname)=='us') {

											$showTimeClass = 'show-time-12-hours';

										} elseif(strtolower($jacroCountryname)=='uk') {

											$showTimeClass = '';

										} else {

											$jacroShowTimeHour  =   get_option('jacroShowTimeHour');

											if($jacroShowTimeHour==true) {$showTimeClass = 'show-time-12-hours';}

											else {$showTimeClass = '';}

										}

										//if(strtotime(date('Y-m-d H:i', strtotime("$per_date $start_time"))) > strtotime(current_time('Y-m-d H:i'))) {

											if($tmp=='') { $show_date = true; $tmp = $date; } elseif($tmp==$date){ $show_date = false; }

											$jacroDateFormate = JacroDateFormate($date);

											if($show_date==true) { $is_show_date=1;

												$date_year = date('Y', strtotime($jacroDateFormate));

												$date_month = (date('m', strtotime($jacroDateFormate))-1);

												$date_day = date('d', strtotime($jacroDateFormate));

												//echo '<div class="date-row col-md-12 col-sm-12 col-xs-12"><div class="col-md-3 col-sm-12 col-xs-12 show_date no-padding"><p>'.$jacroDateFormate.'</p></div>';

												echo "<div class='show-time' style='display: inline-block; padding-left: 15px;' >";

											} ?>

												<!---<a class="perfbtn" data-toggle="modal" data-target="#jacroPopup<?php echo $films['id']; ?>" title="<?php echo $films['cinema_name'].' - '.$films['screen']; ?>" href="#">

													<?php echo $startTimeHourFormat; ?>

												</a>--->

                                                                                                <div class="perfmods" style="display: inline-block;">
																									<?Php 
																									$jacroShowTimeHour  =   get_option('jacroShowTimeHour');
        if($jacroShowTimeHour == true) {
            $jacrobookTimeFormat  = date("g:i a", strtotime($startTimeHourFormat));
        } else {
            $jacrobookTimeFormat  = date("H:i", strtotime($startTimeHourFormat));
        } ?>

                                                                                                        <a class="perfbtn" href="<?php echo $films['booknow_url']; ?>"><?php echo $jacrobookTimeFormat; ?></a>

                                                                                                       <!--- <span #=""><?php echo $films['perf_flags']; ?></span>

                                                                                                        <span #="perfad"><?php echo $films['ad']; ?></span>

                                                                                                        <span #=""><?php echo $films['sub_title']; ?></span>

                                                                                                        <span #=""><?php echo $films['is_3d']; ?></span>

                                                                                                        <span #=""><?php echo $films['wheelchair_accessible']; ?></span>--->

                                                                                                </div>

											<?php //}

									endforeach;

									if($is_show_date):

                                                                            echo "";endif;

								endforeach; ?>

                                                            <a style="margin-left: 5px;" href="<?php echo esc_url(get_permalink($film->ID)); ?>" class="moreshowtimes" target="">More</a></div>

							</div><?php

						endif;

						$all_perf_flags_imp=implode('<li><span>',$all_perf_flags); ?>

                                               

					</div>

		

				<?php

			endforeach;

		endforeach;

		echo '</div>';

	endif;

			?>

		</div>

	</div>

</div>