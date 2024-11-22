<?php
session_start();

global $wpdb;

$table_films = $wpdb->prefix . "jacro_films";
$film_result = $wpdb->get_row(
    $wpdb->prepare("SELECT * FROM $table_films WHERE id = %d", $_REQUEST['film_id'])
);
$code = $film_result->code;
$location = $film_result->location;
$filmtitle = $film_result->filmtitle;

$table_performances = $wpdb->prefix . "jacro_performances";
if($_REQUEST['film_id']) :
	$result = $wpdb->get_results("SELECT * FROM $table_performances WHERE filmcode = '$code' AND location = $location");
else :
	$result = $wpdb->get_results("SELECT * FROM $table_performances");
endif;

$count = count($result);
$showPost = 30;

$curPage = isset($_GET['paged']) && $_GET['paged'] > 0 ? intval($_GET['paged']) - 1 : 0;
$first = ($curPage * $showPost) + 1;
$last = min(($curPage + 1) * $showPost, $count);
$tot = ceil($count / $showPost);

$offset = $curPage * $showPost;
if($_REQUEST['film_id']) :
	$query = "SELECT * FROM $table_performances WHERE filmcode = {$code} AND location = $location LIMIT $offset, $showPost";
else :
	$query = "SELECT * FROM $table_performances LIMIT $offset, $showPost";
endif;
$result = $wpdb->get_results($query);

$perf_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($perf_id > 0) {
    $query = $wpdb->prepare("DELETE FROM $table_performances WHERE id = %d", $perf_id);
    if ($wpdb->query($query) !== false) {
        $_SESSION['s_message'] = 'Performance has been deleted.';
        echo '<script>window.location.href="?page=performance_list&film_id='.$_REQUEST['film_id'].'";</script>';
    } else {
        $_SESSION['s_message'] = 'Error deleting Performance.';
    }
} ?>
<div class="wrap"><?php 
if($_REQUEST['film_id']) : ?><h2>Performances of "<?php echo $filmtitle; ?>"</h2><?php endif; ?>
  	<?php if(isset($_SESSION['s_message'])) {?><div class="success"><?php echo $_SESSION['s_message'];?></div><?php unset($_SESSION['s_message']);}?>
  	<div class="back_film"><a href="?page=film_list" class="button button-primary">Back to Films page</a></div>
  	<table cellspacing="0" width="100%" class="wp-list-table widefat fixed appearance_page_machine-list">
		<thead>
			<tr>
				<th scope="col" class="manage-column column-id" style="" width="40%">Perform Date</th>
				<th scope="col" class="manage-column column-delete" style="">Code</th>
				<th scope="col" class="manage-column column-delete" style="">Start Time</th>
				<th scope="col" id="delete" class="manage-column column-delete" style="">View</th>
				<th scope="col" id="delete" class="manage-column column-delete" style="">Delete</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th scope="col" class="manage-column column-id" style="" width="40%">Perform Date</th>
				<th scope="col" class="manage-column column-delete" style="">Code</th>
				<th scope="col" class="manage-column column-delete" style="">Start Time</th>
				<th scope="col" id="delete" class="manage-column column-delete" style="">View</th>
				<th scope="col" id="delete" class="manage-column column-delete" style="">Delete</th>
			</tr>
		</tfoot>
		<tbody id="the-list"><?php  
			$i=1;
			foreach($result as $query) { 
				$id = $query->id;
				$link = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."&id=".$id."&film_id=".$_REQUEST['film_id'];
				$code = $query->code;
				$start_date = $query->startdate;
				$perform_date = $query->performdate;
				$start_time = $query->starttime; ?>
					<td class="email column-email"><?php echo JacroDateFormate($perform_date); ?></td>
					<td class="phone column-phone"><?php echo $code; ?></td>
					<td class="phone column-phone"><?php echo $start_time; ?></td>
					<td class="phone column-phone"><a href="?page=view_performance&id=<?php echo $id;?>&film_id=<?php echo $_REQUEST['film_id'];?>"><span class="dashicons dashicons-visibility"></span></a></td>
					<td class="delete column-delete"><a href="<?php echo $link?>" onclick="return confirm('Are you sure you want to delete this?')" ><span class="dashicons dashicons-trash"></span></a></td>
				</tr>
			<?php $i++; } ?>
		</tbody>
	</table>
	<div class="tablenav">
  		<div class="tablenav-pages">
			<span class="displaying-num">Displaying <?php echo $first; ?> &ndash; <?php echo $last ?> of <?php echo $count; ?></span>
			
			<?php if ($curPage > 0) : ?>
				<a href="?page=performance_list&film_id=<?php echo $_REQUEST['film_id'];?>&paged=<?php echo $curPage; ?>" class="next page-numbers">&laquo;</a>
			<?php endif; ?>
			
			<?php for ($i = 1; $i <= $tot; $i++) : ?>
				<?php if ($i == ($curPage + 1)) : ?>
					<span class="page-numbers current"><?php echo $i ?></span>
				<?php else : ?>
					<a href="?page=performance_list&film_id=<?php echo $_REQUEST['film_id'];?>&paged=<?php echo $i ?>" class="page-numbers"><?php echo $i ?></a>
				<?php endif; ?>
			<?php endfor; ?>
			
			<?php if (($curPage + 1) < $tot) : ?>
				<a href="?page=performance_list&film_id=<?php echo $_REQUEST['film_id'];?>&paged=<?php echo $curPage + 2; ?>" class="next page-numbers">&raquo;</a>
			<?php endif; ?>
			
			<br class="clear">
		</div>
	</div>
</div>