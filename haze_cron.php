<?php

require_once ('../../../wp-blog-header.php');

global $wpdb;
$table = $wpdb->prefix . "jacro_customers";
$table_locations = $wpdb->prefix . "jacro_locations";
$result = $wpdb->get_results("SELECT * FROM $table");
if($result) {
    foreach($result as $customer) {
    	$theatrefeed_url = $customer->url;
    	$post_title = $customer->code;
        $customer_id = $customer->id;
    	$content = file_get_contents_curl($theatrefeed_url);
    	$feeds = json_decode($content);
    	$locationCounter = 0;
    	$return_results = array();
    	foreach($feeds->theatres as $theatres) {
    		$term = $theatres->theatre->tsite;
    		$cinema_name = '';
            if(isset($theatres->theatre->t)) $cinema_name = $theatres->theatre->t;
            $country = $theatres->theatre->country;
            $booking_url = $theatres->theatre->booking_url;
            $showtimes_url = $theatres->theatre->showtimes_url;
            $facilities = $theatres->theatre->facilities;
            $timezone = $theatres->theatre->timezone;
            $geo_location = serialize(array('latitude'=>$theatres->theatre->lat, 'longitude'=>$theatres->theatre->long));
            $details = serialize($theatres->theatre);
            foreach($feeds->theatres as $theatres) {
                $term = $theatres->theatre->tsite;
                $cinema_name = '';
                if(isset($theatres->theatre->t)) $cinema_name = $theatres->theatre->t;
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
    	}

    	$count = 1;
    	foreach ($return_results as $finalresult) {
    		$term = $finalresult['term_id'];

    		import_film_showtime( $term );
    		$count++;		
    	};

    	error_log('Cron import finished...');
    	exit();
    }

}