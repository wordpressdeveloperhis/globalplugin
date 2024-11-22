<?php
global $wp_query;
$args = array(
    'post_type' => 'jacroimages',
    'post_status' => 'publish',
    'meta_key'  => 'jacroImagesType',
    'meta_value'    =>  'TITLE',
    'posts_per_page' => 1,    
);

if(isset($wp_query->query_vars['post_type']) && $wp_query->query_vars['post_type']=='film') {
    if(get_the_ID()!=0) :
        $singlePosterFlage = true;
        $singlPoster = get_post_meta(get_the_ID(), 'Img_title', true);
    endif;
}
$the_query = new WP_Query( $args );
$ritzJacroTopHeaderMobile = get_theme_mod( 'topHeaderMobile' );
$ritzJacroTopHeaderEmail = get_theme_mod( 'topHeaderEmail' );
if ( $the_query->have_posts() ) { ?>
    <div class="main-slider <?php if((isset($ritzJacroTopHeaderMobile) && $ritzJacroTopHeaderMobile != "") || (isset($ritzJacroTopHeaderEmail) && $ritzJacroTopHeaderEmail != "")) { echo 'top-header-active-slider'; } ?>">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
            <?php
            if(isset($singlePosterFlage) && isset($singlPoster) && $singlePosterFlage==true && $singlPoster!='') : ?>
                <div class="item active slider-item" style="background-image: url('<?php echo $singlPoster; ?>');"></div>
            <?php else :
                $argsnew = array(
                    'post_type' => 'attachment',
                    'post_status' => 'inherit',
                    'meta_key' => 'jacroImagesType',
                    'meta_value'    => 'TITLE',
                    'post_parent'   =>  $the_query->post->ID,
                    'posts_per_page' => 1,
                    'orderby'   => 'title',
                    'order' => 'ASC',
                );
                query_posts( $argsnew );
                while ( have_posts() ) : the_post(); ?>
                    <div class="item active slider-item" style="background-image: url(<?php echo wp_get_attachment_url( get_the_ID() ); ?>);"></div>
                <?php endwhile;
                $otherargsnew = array(
                    'post_type' => 'attachment',
                    'post_status' => 'inherit',
                    'meta_key' => 'jacroImagesType',
                    'meta_value'    => 'TITLE',
                    'post_parent'   =>  $the_query->post->ID,
                    'offset'    =>  1,
                    'orderby'   => 'title',
                    'order' => 'ASC',
                );
                query_posts( $otherargsnew );
                while ( have_posts() ) : the_post(); ?>
                    <div class="item slider-item" style="background-image: url(<?php echo wp_get_attachment_url( get_the_ID() ); ?>);"></div>
                <?php endwhile; wp_reset_query(); ?>            
                <div class="container">
                    <a class="left carousel-control main" href="#myCarousel" role="button" data-slide="prev">
                        <span><i class="fa fa-angle-left" aria-hidden="true"></i></i></span>
                        <span class="sr-only"><?php _e('Previous','ritzjacro'); ?></span>
                    </a>
                    <a class="right carousel-control main" href="#myCarousel" role="button" data-slide="next">
                        <span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                        <span class="sr-only"><?php _e('Next','ritzjacro'); ?></span>
                    </a>
                </div>
            <?php endif; ?>
            </div>            
        </div>
    </div>
<?php } ?>