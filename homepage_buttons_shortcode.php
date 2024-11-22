<?php

start_session();

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

$order_by_date = true;
$post_films = get_films('Now Showing', $cinema, 'moredates', $order_by_date);

$count_row=1; 
foreach($post_films['post'] as $key=>$film_val) {
    $post_arr = get_performances( $film_val->code, 'moredates', 'Now Showing', $cinema);

    if(!empty($post_arr)) {
        foreach($post_arr as $val):
        $perform_date = $val->performdate;
        $start_time = $val->starttime;
        $start_time = substr($start_time, 0, -3);
        $post_title = $film_val->filmtitle;
        if(strtotime("$perform_date $start_time") >= jacro_current_time()) {
            $datasarray[$post_title][$film_val->filmtitle]['film_id'] = $film_val->code;
            $datasarray[$post_title][$film_val->filmtitle]['title'] = $film_val->filmtitle;
            $datasarray[$post_title][$film_val->filmtitle]['location'] = $film_val->location;
        }
        endforeach;
    }
} ?>

<div class="row jacro-container">
    <div class="homepage_bottons">
        <h5 id="mobidatesh5" class="hbs1">
            <select class="select_movie" name="select_movie" id="select_movie">
                <option value="-1">Select Movie</option><?php
                ksort($datasarray); 
                foreach($datasarray as $file_date=>$films_data) :       
                    foreach($films_data as $file_title=>$films):
                        echo '<option value="'.$films['film_id'].'" attr_loc="'.$films['location'].'">'.$films['title'].'</option>';
                    endforeach;
                endforeach; ?>
            </select>
        </h5>
        <h5 id="mobidatesh5" class="hbs2">
            <select class="select_showtime" name="select_showtime" id="select_showtime">
                <option value="-1">Select Showtime</option>
            </select>
        </h5>
    </div>
</div>