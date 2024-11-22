<?php	
	$order_by_date=true;
	$post_films = get_films('Now Showing', 37, 'moredates',$order_by_date );
	$count_row=1; 
	foreach($post_films['post'] as $key=>$film_val) {
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
			$synopsis=get_post_meta($film_val->ID,"synopsis",true);
			foreach($post_arr as $val):
				$perform_date=get_post_meta($val->ID,"perform_date",true);
				$start_time=get_post_meta($val->ID,"start_time",true);
				$start_time=substr($start_time, 0, -3);
				$post_title = $film_val->post_title;
				if(strtotime("$perform_date $start_time") > jacro_current_time()) {
					$datasarray[$post_title][$film_val->post_title]['permalink'] = get_permalink($film_val->ID);
					$datasarray[$post_title][$film_val->post_title]['title'] = $film_val->post_title;
					$datasarray[$post_title][$film_val->post_title]['img_url'] = $img_url;
					$datasarray[$post_title][$film_val->post_title]['default_img_url'] = $default_image;
                    $datasarray[$post_title][$film_val->post_title]['synopsis'] = $synopsis;
				}
			endforeach;
		}
	}
	//echo '<pre>';
	ksort($datasarray); 
	foreach($datasarray as $file_date=>$films_data) :		
		foreach($films_data as $file_title=>$films):
			echo '<div class="row movie-tabs">';
				echo '<div class="col-md-2 col-sm-3 col-xs-12"><a href="'.$films['permalink'].'"><img id="jacroappimg" alt="" src="'.$films['img_url'].'" onError="this.onerror=null;this.src=\''.$films['default_img_url'].'\';"</a></div>';
				echo '<div class="col-md-10 col-sm-9 col-xs-12">';
				echo '<header><h3 class="no-underline"><a style="color: #101010;" href="'.$films['permalink'].'">'.$films['title'].'</a></h3>';
				echo '<p>'.htmlsafe_truncate($films['synopsis'], 180, array('html' => true, 'ending' => ' ...', 'exact' => false)).'</p>';
				echo '<p><a id="tempsynoplink" href="'.$films['permalink'].'" class="arrow-button">Full synopsis</a></p>';
			echo '</div></div>';
			$count_row++;
		endforeach;
	endforeach;
	if($count_row==1) {
		echo '<div class="col-xs-12 col-sm-4 col-md-4 main-film-area"> <p>No Films Available.</p> </div>';
	}
?>