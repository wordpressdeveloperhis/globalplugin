<div class="theatre theatre-default subscribe-box col-md-6">
    <div class="theatre-body" style="width:500px;">
        <div id="theatremessage"></div>
        <form id="post" method="post" action="?page=locationfeed-save" name="post">
            <fieldset>
                <div class="form-group">
                    <label class="full_width">Customer Code</label>
                    <input class="table-width" placeholder="Please enter theatre feed title" onchange="change_content(this.value)" name="post_title" type="text">
                </div>
                <div class="form-group">
                    <label class="full_width">Customer Feed url</label>
                    <input class="table-width" id="post_content" name="post_content" type="text">
                </div>
                <input name="btn_submit" id="btn_cinema_edit" class="button button-primary" value="Submit" type="submit">
            </fieldset>
        </form>
    </div>
</div>
<script>
function change_content(url_val) {
	jQuery("#post_content").val("https://my.internetticketing.com/taposadmin/"+url_val+"/pos_feed/?type=SITEINFO");
}
</script>