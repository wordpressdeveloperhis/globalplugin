<?php

//Class for sorting showtimes by modifier JIRA
class Modifier{
    function __construct($description, $sub_title, $is_3d, $access, $perf) {
        $this->description = $description;
        $this->sub_title = $sub_title;
        $this->is_3d = $is_3d;
        $this->access = $access;
        $this->score = 0;
        $this->showtimes = array($perf);
	}
	
}

//Performance object contains performance info
class Perf{
    function __construct($time, $perf_cat_class, $perf_cat_class_val, $press_report, $url, $soldoutlevel) {
        $this->time = $time;
        $this->perf_cat_class = $perf_cat_class;
        $this->perf_cat_class_val = $perf_cat_class_val;
        $this->press_report = $press_report;
        $this->url = $url;
        $this->soldoutlevel = $soldoutlevel;
	}
}

// generate modifier function
function generate_showtime_html($films, $performancedt){

    $cinemaid = '';
    if($_COOKIE['cinema_id'] && $_COOKIE['cinema_id'] != 'undefined') {
        $cinemaid = $_COOKIE['cinema_id'];
    } elseif($_COOKIE['visitedcinema_id'] && $_COOKIE['visitedcinema_id'] != 'undefined') {
        $cinemaid = $_COOKIE['visitedcinema_id'];
    }
    
    $modifiers = array();
    $error_log = '';

    foreach($performancedt as $keytop => $valtop) { 
        foreach ($valtop as $performace_id => $classname) {
            //and none of the showtimes rows (film subtitle won't ever match the 'Format' of the performance)
            if( $films['title'] == $films[$performace_id]['special_fea'] && $films[$performace_id]['special_fea'] !== '' ){
                continue;
            }
                   
            $error_log .= "ok here";
            $modifier_from_showtime = $films[$performace_id]['special_fea'];
            
            //Create showtime object
            $perf = new Perf(
                    $films[$performace_id]['start_time'],
                    $films[$performace_id]['perf_cat_class'],
                    $films[$performace_id]['perf_cat_class_val'],
                    $films[$performace_id]['press_report'],
                    $films[$performace_id]['book_now_url'],
                    $films[$performace_id]['soldoutlevel']
                );

                
            //Variable to identify if modifier exists in existing modifiers, so that it can be added if it does not
            $record_entered = 'N';

            //Loop through modifiers to see if it already exists, and add showtime to it if it does
            foreach($modifiers as $mod){
                if ($mod->description == $modifier_from_showtime){
                    array_push($mod->showtimes,$perf);
                    $record_entered = 'Y';
                    break;
                }
            }

            //If modifier was not found then add it, and add showtime to it
                //Create modifier object
            if ($record_entered == 'N'){
                $modifier = new Modifier($modifier_from_showtime,
                    $films[$performace_id]['sub_title'],
                    $films[$performace_id]['ad'],
                    $films[$performace_id]['access'],
                    $perf); /*** BUG question***/

                //Add modifier to array
                array_push($modifiers, $modifier);

                //Add showtime to modifier
                //array_push($modifiers->showtimes,$perf);
            }

        }

    }

    $mod_scores = show_modifiers($cinemaid);
    
    //Score each showtime based on the modifers attached to it
            
    foreach($modifiers as $mod) {
        foreach($mod_scores as $key => $value){
            if (strpos($mod->description,$key) !== false){
                $mod->score = $value;
                break;
            }
        }
    }

    //usort($modifiers, 'comparator_high_to_low');

    //Create empty string to store showtimes html
    $showtime_html = '';
    
    foreach($modifiers as $mod){
        $mod->description = str_replace("</br>","",$mod->description);
        $modifier_array = explode(",",$mod->description);
        $priority_mod = array_intersect_key($mod_scores,array_flip($modifier_array));
        /* The img is commented out and replace with the span to resolve issues with the images displaying in chrome. */
        foreach($priority_mod as $key=>$array_element) {
            //$showtime_html .= '<img class="modifier" src="../img/'.$array_element.'.gif" onerror="this.onerror=null;" alt="'.$array_element.'" width="100" height="120">';
            $showtime_html .= '<span class="modifier">'.$key.' </span>';
        }
        if (isset($mod->ad)){
            $showtime_html .=$mod->ad;
        }
        if (isset($mod->sub_title)){
            $showtime_html .=$mod->sub_title;
        }
        if (isset($mod->is_3d)){
            $showtime_html .=$mod->is_3d;
        }
        // if (isset($mod->access)){
        //     $showtime_html .=$mod->access;
        // }
        $showtime_html .='<BR>';
       // $showtime_html .=$mod->ad.$mod->sub_title.$mod->is_3d.$mod->access.'<BR>';
        $datatimes = $mod->showtimes;
        $keys = array_column($datatimes, 'time');
        array_multisort($keys, SORT_ASC, $datatimes);
        
        //Add the showtimes underneath the list of modifiers       
        $key_array = array();
        $picount = 0;

        foreach($datatimes as $showtime) {
            $inrarr = (array) $showtime;
            if (!in_array($inrarr['time'], $key_array)) { 

                $key_array[$picount] = $inrarr['time'];         
                $showtime_html;
                $jacroShowTimeHour = get_option('jacroShowTimeHour');
                if($jacroShowTimeHour==true) {
                    $jacrobookTimeFormat  = date("g:i a", strtotime($showtime->time));
                } else {
                    $jacrobookTimeFormat  = date("H:i", strtotime($showtime->time));
                }

                if ($showtime->press_report == 'N') {
                    $showtime_html .= '<div class="singlefilmperfs"><div="perfmods"><a class="perfbtn disabled '.$showtime->perf_cat_class.'" title="Please contact the Box Office to book">'.$jacrobookTimeFormat.'</a></br></div>';
                }else {
                    if($showtime->time){
                        $perfcat_category_message = get_option('perfcat_category_message');
                        $pfbtntxt = '';
                        $pfbtnmsg = '';
                        $alertinfo = '';

                        if(isset($perfcat_category_message[$showtime->perf_cat_class_val]['name']) && $showtime->perf_cat_class_val == $perfcat_category_message[$showtime->perf_cat_class_val]['name']){
                            $pfbtntxt = $perfcat_category_message[$showtime->perf_cat_class_val]['name'];
                            if(isset($perfcat_category_message[$showtime->perf_cat_class_val]['message'])){
                                $alertinfo = 'onclick="showperfinfo(this, event)"';
                                $pfbtnmsg  = $perfcat_category_message[$showtime->perf_cat_class_val]['message'];
                            }else{
                                $pfbtnmsg = '';
                                $alertinfo = '';
                            }

                        }

                        $showtime_html .= '<div class="singlefilmperfs '.$showtime->perf_cat_class.'"><div="perfmods">';
                        if(get_option('showtime_button_text')){
                        	if($showtime->soldoutlevel && $showtime->soldoutlevel=='Y'){
                        		$showtime_html .= '<a class="perfbtn 4 disabled">Sold Out</a>';
                        	}else{
                        		$showtime_html .= '<a class="perfbtn 4" '.$alertinfo.' href="'.$showtime->url.'">'.get_option('showtime_button_text').' '.$jacrobookTimeFormat.' '.$pfbtntxt.'</a>';
                        	}
                        }else{
                        	if($showtime->soldoutlevel && $showtime->soldoutlevel=='Y'){
                        		$showtime_html .= '<a class="perfbtn 4 disabled">Sold Out</a>';
                        	}else{
                            	$showtime_html .= '<a class="perfbtn 4" '.$alertinfo.' href="'.$showtime->url.'">'.$jacrobookTimeFormat.' '.$pfbtntxt.'</a>';
                            }
                        }
                        $showtime_html .= '<input type="hidden" class="perfcat_message" value="'.$pfbtnmsg.'">';
                        $showtime_html .= '</div>';
                        	  
                    }
                }
                
            } 
            $picount++;      
        }
        $showtime_html .= '<BR>';
    }

    return $showtime_html;
}

?>