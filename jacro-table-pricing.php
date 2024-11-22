<?php
$jacro_theme_color  = get_option('jacro_color_theme');
echo "<style>
    .tagcloud1 a:hover, .tagcloud2 a:hover {
        background: ".$jacro_theme_color." !important;
    }
    .tagcloud1 a.active, .tagcloud2 a.active {
        background: ".$jacro_theme_color." !important;
    }
</style>";
$termID = '';
$taxonomy='theatre'; $terms_arr=array();
$terms = get_terms($taxonomy,array("hide_empty"=>0));
foreach($terms as $term) {
    $term_name=get_option( 'term_'.$term->term_id);
    $terms_arr[$term->term_id]['ID']= $term->term_id;
    $terms_arr[$term->term_id]['Name']= ucwords($term_name);
}
asort($terms_arr);
$display_cinema='block;';
//if(count($terms_arr)==1) {
    $display_cinema='none;';
//}
?>
<div class="col-xs-12">
    <div class="col-md-9 col-sm-8 col-xs-12">
        <div class="row">
            <div class="cinema-select">
                <label for="" style="display:<?php echo $display_cinema; ?>"><?php _e('Select Cinema', ''); ?></label>
                <select class="form-control left-select-cinema toggled" style="display:<?php echo $display_cinema; ?>" id="jacro-table-pricing-cinema" name="jacro-table-pricing-cinema">
                    <option value=""><?php _e('Select Cinema', ''); ?></option>
                    <?php
                    $count_k=0;
                    $top_cinema=$first_value='';
                    foreach($terms_arr as $key=>$term) {
                        $selected='';
                        if($count_k==0) {
                            $first_value=$key;
                            $selected = 'selected="selected"';
                            $jacroDeafultTheatorID = $term['ID'];
                        }
                        $count_k++; ?>
                        <option value="<?php echo $term['ID']; ?>" <?php echo $selected;?>><?php echo $term['Name'];?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
</div>
<div style="display:none;" id="process_running" class="">
    <p>Please wait while we fetch data</p>
</div>