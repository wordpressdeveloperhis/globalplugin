<?php 
start_session();
global $wpdb;
$table = $wpdb->prefix . "jacro_customers";
$second_query = $wpdb->get_results("SELECT * FROM $table");

$customer_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
 
if ($customer_id > 0) {
	$table_locations = $wpdb->prefix . "jacro_locations";
    $table_films = $wpdb->prefix . "jacro_films";
    $table_performances = $wpdb->prefix . "jacro_performances";
    $table_modifiers = $wpdb->prefix . "jacro_modifiers";
    $table_products = $wpdb->prefix . "jacro_products";
    $table_images = $wpdb->prefix . "jacro_images";
	$table_attributes = $wpdb->prefix . "jacro_attributes";

    $query = $wpdb->prepare(
        "DELETE a, b, c, d, e, f, g, h
        FROM $table a
        LEFT JOIN $table_locations b ON (a.id = b.customer)
        LEFT JOIN $table_films c ON (a.id = c.customer)
        LEFT JOIN $table_performances d ON (a.id = d.customer)
        LEFT JOIN $table_modifiers e ON (a.id = e.customer)
        LEFT JOIN $table_products f ON (a.id = f.customer)
        LEFT JOIN $table_images g ON (a.id = g.customer)
        LEFT JOIN $table_attributes h ON (a.id = h.customer)
        WHERE a.id = %d",
        $customer_id
    );

	 if ($wpdb->query($query) !== false) {
        $_SESSION['s_message'] = 'Customer feed has been deleted.';
        echo '<script>window.location.href="?page=locations";</script>';
    } else {
    	$_SESSION['s_message'] = 'Error deleting customer data.';
    }
} ?>
<div class="wrap">
	<h2>Customer Feeds  &nbsp;&nbsp;&nbsp;&nbsp;<a href="?page=add-location">Add</a></h2>
	<?php if(isset($_SESSION['s_message'])) {?><div class="success"><?php echo $_SESSION['s_message'];?></div><?php unset($_SESSION['s_message']);}?>
  	<div class="jacro-messages notice" id="jacro-messages"></div>
  	<table cellspacing="0" width="100%" class="wp-list-table widefat fixed appearance_page_machine-list">
		<thead>
			<tr>
				<th scope="col" class="manage-column column-id" width="20%">Customer Code</th>
				<th scope="col" class="manage-column column-id" width="40%">Link</th>
				<th scope="col" class="manage-column column-delete" width="20%">Import Action</th>
				<th scope="col" id="delete" class="manage-column column-delete">Edit</th>
				<th scope="col" id="delete" class="manage-column column-delete">Delete</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th scope="col" class="manage-column column-id">Customer Code</th>
				<th scope="col" class="manage-column column-id">Link</th>
				<th scope="col" class="manage-column column-id">Import Action</th>
				<th scope="col" id="Delete" class="manage-column column-delete">Edit</th>
				<th scope="col" id="delete" class="manage-column column-delete">Delete</th>
			</tr>
		</tfoot>
		<tbody id="the-list">
		<?php  	
		if($second_query) {
			$i=1;
			foreach($second_query as $query) {
				$id=$query->id;
				$title=$query->code;
				$url=$query->url;
				$link = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."&id=".$id; ?>
				<tr <?php if($i%2==0) { ?> class="alternate" <?php } ?>>
					<td class="email column-email"><?php echo $title;?></td>
					<td class="email column-email"><?php echo $url;?></td>
					<td class="phone column-phone"><a href="javascript:void(0);" data-id="<?php echo $id; ?>" class="import_customer">Import Locations & Showtimes</a></td>
					<td class="phone column-phone"><a href="?page=edit-location&id=<?php echo $id;?>">Edit</a></td>
					<td class="delete column-delete"><a href="<?php echo $link?>" onclick="return confirm('Are you sure you want to delete this?')" ><span class="dashicons dashicons-trash"></span></a></td>
					</tr>
			<?php $i++; } 
		} ?>
		</tbody>
	</table>
	<?php jacro_import_loader(); ?>