<?php	

	$order_by_date=true;

	$post_films = get_films('Now Showing', 37, 'moredates',$order_by_date );	

	$count_row=1;

	$primaryColour = get_option('primary_colour');

	$secondaryColour = get_option('secondary_colour');

	echo '<style>.perfbtn{color: #fff; background-color:' . $primaryColour . ' !important;}.perfbtn:hover{color:#fff !important; background-color:' . $secondaryColour . ' !important;} .moreshowtimes {background-image: linear-gradient(to right, ' . $primaryColour. ', ' . $secondaryColour  . ') !important;}.moreshowtimes:hover {color: #fff !important; background-image: linear-gradient(to right, ' . $secondaryColour. ', ' . $secondaryColour  . ') !important;}</style>';

	foreach($post_films['post'] as $key=>$film_val) {

		$post_arr = get_performances( $film_val->ID, 'moredates' ,'Now Showing', 37);		

		if(!empty($post_arr)) { 

			foreach($post_arr as $val):

				$perform_date=get_post_meta($val->ID,"perform_date",true);

				if(strtotime("$perform_date $start_time") > jacro_current_time()) {

					$datasarray[$perform_date][$film_val->post_title]['postid'] = $film_val->ID;

					$datasarray[$perform_date][$film_val->post_title]['perform_date'] = $perform_date;

				}

			endforeach;

		}

	}

	ksort($datasarray);

	foreach($datasarray as $file_date=>$films_data) {		

		foreach($films_data as $file_title=>$films) {

			$perform_date = $films['perform_date'];

			$jacroDateFormate = JacroDateFormateanother($perform_date);			

			echo '<div class="row movie-tabs">';

				echo '<div class="col-md-10 col-sm-9 col-xs-12">';

					echo '<div class="row">';

						echo '<div class="jacro-date-showtime-list">';

							$post_arr = get_performances( $films['postid'], 'moredates' ,'Now Showing', 37);

							foreach($post_arr as $val) {

								$perform_date=get_post_meta($val->ID,"perform_date",true);

								$jacroDateFormate = JacroDateFormateanother($perform_date);

								$start_time=get_post_meta($val->ID,"start_time",true);

								$booking_url = JacroChangeUrl($val->ID);

								$start_time=date('H:i', strtotime($start_time));

								$startTimeHourFormat = JacroTimeFormate($start_time, 'us');

								echo '<div>'.$jacroDateFormate.'</div>';

								echo '<div class="singlefilmperfs">

	                        		<div id="perfmods">                          				

	                          			<a class="perfbtn" href="'.$booking_url.'">'.$startTimeHourFormat.'</a>

	                          		</div>

	                      		</div>';

	                      	}

						echo '</div>';

					echo '</div>';

				echo '</div>';

			echo '</div>';

			$count_row++;

		}

	}

	if($count_row==1) {

		echo '<div class="col-xs-12 col-sm-4 col-md-4 main-film-area"> <p>No Films Available.</p> </div>';

	}

?>