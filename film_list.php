 <?php
start_session();
global $wpdb;
$table_films = $wpdb->prefix . "jacro_films";
$result = $wpdb->get_results("SELECT * FROM $table_films");

$count = count($result);
$showPost = 30;

$curPage = isset($_GET['paged']) && $_GET['paged'] > 0 ? intval($_GET['paged']) - 1 : 0;
$first = ($curPage * $showPost) + 1;
$last = min(($curPage + 1) * $showPost, $count);
$tot = ceil($count / $showPost);

$offset = $curPage * $showPost;
$query = "SELECT * FROM $table_films LIMIT $offset, $showPost";
$result = $wpdb->get_results($query);

$film_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($film_id > 0) {
  	$query = $wpdb->prepare("DELETE a FROM $table_films a WHERE a.id = %d", $film_id);
 	if ($wpdb->query($query) !== false) {
     	echo '<script>window.location.href="?page=film_list";</script>';
  	} else {
  		$_SESSION['s_message'] = 'Error deleting film.';
  	}
} ?>
<div class="wrap">
	<h2>Films</h2>
  	<div class="clean-option">
		<a href="?page=delete_all_films&field=films" class="button button-primary" id="delete_all" onclick="return confirm('Are you sure you want to delete all films ?','0')" >Delete All</a>
  	</div>
  	<?php if(isset($_SESSION['s_message'])) {?><div class="success"><?php echo $_SESSION['s_message'];?></div><?php unset($_SESSION['s_message']);}?>
  	<table cellspacing="0" width="100%" class="wp-list-table widefat fixed appearance_page_machine-list">
		<thead>
			<tr>
				<th scope="col" class="manage-column column-id" style="" width="38%">Film Title</th> 
				<th scope="col" class="manage-column column-delete" style="">Location</th>
				<th scope="col" class="manage-column column-delete" style="">Film Code</th>
				<th scope="col" class="manage-column column-delete" style="">Start Date</th>
				<th scope="col" id="delete" class="manage-column column-delete" style="">Performances</th>
				<th scope="col" id="delete" class="manage-column column-delete" style="">View</th>
				<th scope="col" id="delete" class="manage-column column-delete" style="">Delete</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th scope="col" class="manage-column column-id" style="" width="40%">Film Title</th>
				<th scope="col" class="manage-column column-delete" style="">Location</th>
				<th scope="col" class="manage-column column-delete" style="">Film Code</th>
				<th scope="col" class="manage-column column-delete" style="">Start Date</th>
				<th scope="col" id="delete" class="manage-column column-delete" style="">Performances</th>
				<th scope="col" id="delete" class="manage-column column-delete" style="">View</th>
				<th scope="col" id="delete" class="manage-column column-delete" style="">Delete</th>
			</tr>
		</tfoot>
		<tbody id="the-list"><?php  
		$i=1;
		foreach($result as $query) { 
			$id = $query->id;
			$link = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."&id=".$id; 
			$code = $query->code;
			$start_date = $query->startdate;
			if($start_date == '0000-00-00') {
				$start_date = $query->releasedate;
			}
			$title = $query->filmtitle; 
			$location = $query->location; 
			if($location) :
				$table = $wpdb->prefix . "jacro_locations";
				$loc_result = $wpdb->get_row(
				    $wpdb->prepare("SELECT * FROM $table WHERE id = %d", $location)
				);
				$loc_name = $loc_result->name;
			endif; ?>
			<tr <?php if($i%2==0) {?> class="alternate" <?php } ?>>
				<td class="email column-email"><?php echo $title;?></td>
				<td class="phone column-phone"><?php echo $loc_name; ?></td>
				<td class="phone column-phone"><?php echo $code;?></td>
				<td class="phone column-phone"><?php echo JacroDateFormate($start_date);?></td>
				<td class="phone column-phone"><a href="?page=performance_list&film_id=<?php echo $id;?>">Perfomances</a></td>
				<td class="phone column-phone"><a href="?page=view_film&id=<?php echo $id;?>"><span class="dashicons dashicons-visibility"></span></a></td>
				<td class="delete column-delete"><a href="<?php echo $link; ?>" onclick="return confirm('Are you sure you want to delete this?')" ><span class="dashicons dashicons-trash"></span></a></td>
			</tr>
			<?php $i++; } ?>
		</tbody>
	</table>
	<div class="tablenav">
	    <div class="tablenav-pages">
	        <span class="displaying-num">Displaying <?php echo $first; ?> &ndash; <?php echo $last ?> of <?php echo $count; ?></span>
	        
	        <?php if ($curPage > 0) : ?>
	            <a href="?page=film_list&paged=<?php echo $curPage; ?>" class="next page-numbers">&laquo;</a>
	        <?php endif; ?>
	        
	        <?php for ($i = 1; $i <= $tot; $i++) : ?>
	            <?php if ($i == ($curPage + 1)) : ?>
	                <span class="page-numbers current"><?php echo $i ?></span>
	            <?php else : ?>
	                <a href="?page=film_list&paged=<?php echo $i ?>" class="page-numbers"><?php echo $i ?></a>
	            <?php endif; ?>
	        <?php endfor; ?>
	        
	        <?php if (($curPage + 1) < $tot) : ?>
	            <a href="?page=film_list&paged=<?php echo $curPage + 2; ?>" class="next page-numbers">&raquo;</a>
	        <?php endif; ?>
	        
	        <br class="clear">
	    </div>
	</div>
</div>