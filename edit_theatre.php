<?php 
if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
	global $wpdb;
	$table_customers = $wpdb->prefix . "jacro_customers";
	$res=$wpdb->get_row("SELECT * FROM $table_customers WHERE id ='".$_REQUEST['id']."'");
} ?>
<div class="theatre theatre-default subscribe-box col-md-6">
    <div class="theatre-body" style="width:500px;">
        <div id="theatremessage"></div>
        <form id="post" method="post" action="?page=locationfeed-save" name="post">
            <input type="hidden" name="id" id="id" value="<?php echo $res->id;?>" />
            <fieldset>
                <div class="form-group">
                    <label class="full_width">Customer Code</label>
                    <input class="table-width" placeholder="Please enter theatre feed title" onchange="change_content(this.value)" name="post_title" type="text" value="<?php echo $res->code;?>">
                </div>
                <div class="form-group">
                    <label class="full_width">Customer Feed url</label>
                    <input class="table-width" id="post_content" name="post_content" type="text" value="<?php echo $res->url;?>">
                </div>
                <input name="btn_submit" id="btn_cinema_edit" class="button button-primary" value="Update" type="submit">
            </fieldset>
        </form>
    </div>
</div>
<script>
function change_content(url_val) {
	jQuery("#post_content").val("https://my.internetticketing.com/taposadmin/"+url_val+"/pos_feed/?type=SITEINFO");
}
</script>