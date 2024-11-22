<?php
global $wpdb;
$table_performances = $wpdb->prefix . "jacro_performances";
$performance_result = $wpdb->get_row(
    $wpdb->prepare("SELECT * FROM $table_performances WHERE id = %d", $_REQUEST['id'])
);
$performancenumberslot = $performance_result->performancenumberslot;
$performdate = $performance_result->performdate;
$code = $performance_result->code;
$reservedseating = $performance_result->reservedseating;
$subs = $performance_result->subs;
$soldoutlevel = $performance_result->soldoutlevel;
$screen = $performance_result->screen;
$perfcat = $performance_result->perfcat;
$screencode = $performance_result->screencode;
$wheelchairaccessible = $performance_result->wheelchairaccessible;
$starttime = $performance_result->starttime;
$salesstopped = $performance_result->salesstopped;
$managerwarninglevel = $performance_result->managerwarninglevel;
$selloninternet = $performance_result->selloninternet;
$passes = $performance_result->passes;
$trailertime = $performance_result->trailertime;
$doorsopen = $performance_result->doorsopen;
$ad = $performance_result->ad;

$location = $performance_result->location; 
if($location) :
    $table = $wpdb->prefix . "jacro_locations";
    $loc_result = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM $table WHERE id = %d", $location)
    );
    $loc_name = $loc_result->name;
endif;

?>
<div class="theatre theatre-default subscribe-box col-md-6">
    <div class="back_film"><a href="?page=performance_list&film_id=<?php echo $_REQUEST['film_id'];?>" class="button button-primary">Back to Performances page</a></div>
    <div class="theatre-body" style="width:500px;">
        <fieldset>
            <div class="form-group">
                <label class="view_lable_film">Performance Number Slot</label>
                <label class="view_result_film"><?php echo $performancenumberslot;?></label>
            </div>
            <div class="form-group">
                <label class="view_lable_film">Perform Date</label>
                <label class="view_result_film"><?php echo JacroDateFormate($performdate); ?></label>
            </div>
            <div class="form-group">
                <label class="view_lable_film">Code</label>
                <label class="view_result_film"><?php echo $code;?></label>
            </div>
            <div class="form-group">
                <label class="view_lable_film">Reserved Seating</label>
                <label class="view_result_film"><?php echo $reservedseating;?></label>
            </div>
            <div class="form-group">
                <label class="view_lable_film">Subs</label>
                <label class="view_result_film"><?php echo $subs;?></label>
            </div>
            <div class="form-group">
                <label class="view_lable_film">Sold Out Level</label>
                <label class="view_result_film"><?php echo $soldoutlevel;?></label>
            </div>
            <div class="form-group">
                <label class="view_lable_film">Location Name</label>
                <label class="view_result_film"><?php echo $loc_name; ?></label>
            </div>
            <div class="form-group">
                <label class="view_lable_film">Screen</label>
                <label class="view_result_film"><?php echo $screen;?></label>
            </div>
            <div class="form-group">
                <label class="view_lable_film">Perf Cat</label>
                <label class="view_result_film"><?php echo $perfcat;?></label>
            </div>
            <div class="form-group">
                <label class="view_lable_film">ScreenCode</label>
                <label class="view_result_film"><?php echo $screencode;?></label>
            </div>
            <div class="form-group">
                <label class="view_lable_film">Wheelchair Accessible</label>
                <label class="view_result_film"><?php echo $wheelchairaccessible;?></label>
            </div>
            <div class="form-group">
                <label class="view_lable_film">StartTime</label>
                <label class="view_result_film"><?php echo $starttime;?></label>
            </div>
            <div class="form-group">
                <label class="view_lable_film">Sales Stopped</label>
                <label class="view_result_film"><?php echo $salesstopped;?></label>
            </div>
            <div class="form-group">
                <label class="view_lable_film">Manager Warning Level</label>
                <label class="view_result_film"><?php echo $managerwarninglevel;?></label>
            </div>
            <div class="form-group">
                <label class="view_lable_film">Sell on Internet</label>
                <label class="view_result_film"><?php echo $selloninternet;?></label>
            </div>
            <div class="form-group">
                <label class="view_lable_film">Passes</label>
                <label class="view_result_film"><?php echo $passes;?></label>
            </div>
            <div class="form-group">
                <label class="view_lable_film">Trailer Time</label>
                <label class="view_result_film"><?php echo $trailertime;?></label>
            </div>
            <div class="form-group">
                <label class="view_lable_film">Doors Open</label>
                <label class="view_result_film"><?php echo $doorsopen;?></label>
            </div>
            <div class="form-group">
                <label class="view_lable_film">AD</label>
                <label class="view_result_film"><?php echo $ad;?></label>
            </div>
        </fieldset>
    </div>
</div>