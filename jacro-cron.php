<?php 
/* jacro import cron action */
function jacroCronImportAction() {
	start_session();
	global $wpdb;
	$table = $wpdb->prefix . "jacro_locations";
	$query = $wpdb->prepare("SELECT * FROM $table");
	$result = $wpdb->get_results($query);
	if($result) {
		foreach($result as $locations) {
			$datas = import_film_showtime($locations->id);
		}
	}
}

/* jacro delete cron action */
function jacroCronDeleteAction() {	
	$previousNomberOfDay = JacroGetSettigns('jacro_auto_clean_performace');
	$previousNomberOfDay = (($previousNomberOfDay!='')?$previousNomberOfDay:7);
	JacroCleanAllDatas($previousNomberOfDay);
}

?>