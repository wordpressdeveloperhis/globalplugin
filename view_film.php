<?php
global $wpdb;
$table_films = $wpdb->prefix . "jacro_films";
$film_result = $wpdb->get_row(
    $wpdb->prepare("SELECT * FROM $table_films WHERE id = %d", $_REQUEST['id'])
);
$shortfilmtitle = $film_result->shortfilmtitle;
$filmtitle = $film_result->filmtitle;
$comingsoon = $film_result->comingsoon;
$code = $film_result->code;
$certificate = $film_result->certificate;
$is3d = $film_result->is3d;
$rentrak = $film_result->rentrak;
$releasedate = $film_result->releasedate;
$runningtime = $film_result->runningtime;
$digital = $film_result->digital;
$genre = $film_result->genre;
$startdate = $film_result->startdate;
if($startdate == '0000-00-00') {
    $startdate = $film_result->releasedate;
}
$imdbcode = $film_result->imdbcode;
$synopsis = $film_result->synopsis;
$img_app = $film_result->img_app;
$img_bd = $film_result->img_bd;
$youtube = $film_result->youtube;
?>
<div class="theatre theatre-default subscribe-box col-md-6">
	<div class="back_film"><a href="?page=film_list" class="button button-primary">Back to films listing page</a></div>
    <div class="theatre-body" style="width:500px;">
        <fieldset class="view-film">
            <div class="form-group">
                <label class="view_lable_film">Short Film Title</label>
                <label class="view_result_film"><?php echo $shortfilmtitle;?></label>
            </div>
            <div class="form-group">
                <label class="view_lable_film">Film Title</label>
                <label class="view_result_film"><?php echo $filmtitle;?></label>
            </div>
             <div class="form-group">
                <label class="view_lable_film">Film Status</label>
                <label class="view_result_film"><?php echo $comingsoon;?></label>
            </div>           
            <div class="form-group">
                <label class="view_lable_film">Code</label>
                <label class="view_result_film"><?php echo $code;?></label>
            </div>
             <div class="form-group">
                <label class="view_lable_film">Certificate</label>
                <label class="view_result_film"><?php echo $certificate;?></label>
            </div>
            <div class="form-group">
                <label class="view_lable_film">Is 3d</label>
                <label class="view_result_film"><?php echo $is3d;?></label>
            </div> 
            <div class="form-group">
                <label class="view_lable_film">Rentrak</label>
                <label class="view_result_film"><?php echo $rentrak;?></label>
            </div>
             <div class="form-group">
                <label class="view_lable_film">Release Date</label>
                <label class="view_result_film"><?php echo $releasedate;?></label>
            </div>
            <div class="form-group">
                <label class="view_lable_film">Running Time</label>
                <label class="view_result_film"><?php echo $runningtime;?></label>
            </div> 
            <div class="form-group">
                <label class="view_lable_film">Digital</label>
                <label class="view_result_film"><?php echo $digital;?></label>
            </div>
            <div class="form-group">
                <label class="view_lable_film">Genre</label>
                <label class="view_result_film"><?php echo $genre;?></label>
            </div>
            <div class="form-group">
                <label class="view_lable_film">Start Date</label>
                <label class="view_result_film"><?php echo JacroDateFormate($startdate); ?></label>
            </div>
            <div class="form-group">
                <label class="view_lable_film">IMDB Code</label>
                <label class="view_result_film"><?php echo $imdbcode;?></label>
            </div>
			<div class="form-group">
                <label class="view_lable_film">Film Synopsis</label>
                <label class="view_result_film" style="width: 560px"><?php echo $synopsis;?></label>
            </div>    
            <div class="form-group">
                <label class="view_lable_film">Poster</label>
                <label class="view_result_film"><img src="<?php echo $img_app;?>" /></label>
            </div>
			<div class="form-group">
                <label class="view_lable_film">Back Drop</label>
                <label class="view_result_film"><img style="max-width: 560px" src="<?php echo $img_bd;?>" /></label>
            </div><?php 
            if($youtube != 'None') : ?>
			<div class="form-group">
                <label class="view_lable_film">Trailer</label>
                <label class="view_result_film"><iframe width="560" height="315" src="<?php echo $youtube;?>"frameborder="0" allowfullscreen></iframe></label>
            </div><?php 
        endif; ?>
        </fieldset>
    </div>
</div>