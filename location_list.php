<?php 
start_session();
global $wpdb;
$table = $wpdb->prefix . "jacro_locations";
$result = $wpdb->get_results("SELECT * FROM $table");

$location_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($location_id > 0) {
  $table_films = $wpdb->prefix . "jacro_films";
  $table_performances = $wpdb->prefix . "jacro_performances";
  $table_modifiers = $wpdb->prefix . "jacro_modifiers";
  $table_products = $wpdb->prefix . "jacro_products";
  $table_images = $wpdb->prefix . "jacro_images";

  $query = $wpdb->prepare(
      "DELETE a, b, c, d, e, f
      FROM $table a
      LEFT JOIN $table_films b ON (a.id = b.location)
      LEFT JOIN $table_performances c ON (a.id = c.location)
      LEFT JOIN $table_modifiers d ON (a.id = d.location)
      LEFT JOIN $table_products e ON (a.id = e.location)
      LEFT JOIN $table_images f ON (a.id = f.location)
      WHERE a.id = %d",
      $location_id
  );

 	if ($wpdb->query($query) !== false) {
      $_SESSION['s_message'] = 'location feed has been deleted.';
      echo '<script>window.location.href="?page=location_list";</script>';
  } else {
  	$_SESSION['s_message'] = 'Error deleting location data.';
  }
} ?>

<div class="wrap">
  <h2>Location List</h2>
  <div class="jacro-messages notice" id="jacro-messages"></div>
  <div style="text-align:center;margin:5px;"><a href="#" class="import_all_films_performaces">Import All</a></div>
  <?php if(isset($_SESSION['s_message'])) {?><div class="success"><?php echo $_SESSION['s_message'];?></div><?php unset($_SESSION['s_message']);}?>
  <table cellspacing="0" width="100%" class="wp-list-table widefat fixed appearance_page_machine-list">
		<thead>
		<tr>
			<th scope="col" class="manage-column column-id">Title</th>
			<td class="phone column-phone" style="width:47%;">Feed URL</td>
			<th scope="col" class="manage-column column-delete">Import Action</th>
			<th scope="col" id="delete" class="manage-column column-delete" style="">Edit</th>
			<th scope="col" id="delete" class="manage-column column-delete" style="">Delete</th>
		</tr>
		</thead>
		<tfoot>
		<tr>
			<th scope="col" class="manage-column column-id">Title</th>
			<td class="phone column-phone">Feed URL</td>
			<th scope="col" class="manage-column column-delete">Import Action</th>
			<th scope="col" id="delete" class="manage-column column-delete" style="">Edit</th>
			<th scope="col" id="delete" class="manage-column column-delete" style="">Delete</th>
		</tr>
		</tfoot>

		<tbody id="the-list">
			<?php  	
			if($result) {
				$i=1;
				foreach($result as $query) {
					$id=$query->id;
					$title=$query->code;
					$url=$query->url;
					$link = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."&id=".$id; ?>
					<tr <?php if($i%2==0) {?> class="alternate" <?php } ?>>
						<td class="email column-email"><?php echo $title;?></td>
						<td class="email column-email"><?php echo $url;?></td>
						<td class="phone column-phone"><a href="javascript:void(0);" data-id="<?php echo $id;?>" class="import_films_performaces">Import Showtimes</a></td>
			      <td class="phone column-phone"><a href="?page=edit&id=<?php echo $id;?>">Edit</a></td>
			      <td class="delete column-delete"><a href="<?php echo $link?>" onclick="return confirm('Are you sure you want to delete this?')" ><span class="dashicons dashicons-trash"></span></a></td>
		      </tr>
			<?php $i++; }
		} ?>
		</tbody>
	</table>
</div>
<?php jacro_import_loader(); ?>