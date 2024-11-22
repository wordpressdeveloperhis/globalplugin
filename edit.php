<?php 
if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
	global $wpdb;
	$table = $wpdb->prefix . "jacro_locations";
	$res=$wpdb->get_row("SELECT * FROM $table WHERE id ='".$_REQUEST['id']."'");
} ?>
<div class="theatre theatre-default subscribe-box col-md-6">
    <div class="theatre-body" style="width:500px;">
        <div id="theatremessage"></div>
        <form id="post" method="post" action="?page=datafeed_save" name="post">
            <input type="hidden" name="id" id="id" value="<?php echo $res->id;?>" />
            <fieldset>
                <div class="form-group">
                    <label class="full_width">Title</label>
                    <input class="table-width" placeholder="Please enter title" name="term_name" type="text" value="<?php echo $res->code;?>">
                </div>
                <div class="form-group">
                    <label class="full_width">Data Feed url</label>
                    <input class="table-width" id="post_content" name="post_content" type="text" value="<?php echo $res->url;?>">
                </div>
                <input name="btn_submit" id="btn_cinema_edit" class="button button-primary" value="Update" type="submit">
            </fieldset>
        </form>
    </div>
</div>