<?php 
function jacro_movies_slider($attr){
    jacroObjectStart();
    extract(shortcode_atts(array(
        'numberofposts' => '5',
        'location' => '',
        'hidegenre' => 'false',
        'hidedescription' => 'false',
        'hidetrailer' => 'false',
        'hidesynopsis' => 'false',
    ), $attr));

    global $wpdb;
    $table = $wpdb->prefix . "jacro_films";
    $table_performances = $wpdb->prefix . "jacro_performances";
    $table_locations = $wpdb->prefix . "jacro_locations";

    if($location) {
        $location_result = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_locations WHERE code = %s LIMIT 1", $location));
    } else {
        $location_result = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_locations LIMIT 1"));
    }
    
    if($location_result) {
        $cinema = $location_result[0]->id;
    }

    $get_films = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table WHERE location = %d LIMIT $numberofposts", $cinema));

    $movieslideroption = get_option("movieslideroption");

    if($movieslideroption == 'manual') {

        $movieslider = get_option("movieslider");
        if($movieslider) { 
            $showCarousel = false;
            $ci = 0;

            foreach ($movieslider as $key => $value) {
                $theatrelocation = $value['theatrelocation'];
                foreach ($theatrelocation as $theaterId => $show) {
                    if ($cinema == $theaterId && $show) {
                        $showCarousel = true;
                        $ci++;
                        break 2;
                    }
                }
            } 

            if ($showCarousel) : ?>
                <div id="hero" class="customslider carousel slide carousel-fade manualslider" data-ride="carousel" data-posts="<?php echo $numberofposts; ?>">
                    <img src="<?php echo CINEMA_URL; ?>/images/scroll-arrow.svg" alt="Scroll down" class="scroll">
                    <div id="carousel" class="carousel slide" data-ride="carousel">
                        <!-- Indicators (control icons) -->
                        <div class="container"> 
                            <ol class="carousel-indicators">
                                <?php foreach ($movieslider as $key => $value) :
                                    foreach ($value['theatrelocation'] as $theaterId => $show) {
                                        if ($cinema == $theaterId && $show) { ?>
                                            <li data-target="#carousel" data-slide-to="<?php echo esc_attr($key); ?>" <?php echo ($key == 0) ? 'class="active"' : ''; ?>></li>
                                        <?php break;
                                        }
                                    }
                                endforeach ?>
                            </ol>
                        </div>
                        <div class="carousel-inner" role="listbox"><?php
                        $ci = 0;
                            foreach ($movieslider as $key => $value) {
                                $sliderimage = $value['sliderimage'];
                                $img_url = str_replace($_SERVER['DOCUMENT_ROOT'], '', $sliderimage); 
                                $slidergenre = $value['slidergenre'];
                                $slidertitle = $value['slidertitle'];
                                $slidercontent = $value['slidercontent'];
                                $slidercertificate = $value['slidercertificate'];
                                $slidertrailer = $value['slidertrailer'];
                                $slidersynopsis = $value['slidersynopsis']; 
                                $theatrelocation = $value['theatrelocation']; 

                                $showCarouselItem = false;
                                foreach ($theatrelocation as $theaterId => $show) {
                                    if ($cinema == $theaterId && $show) {
                                        $showCarouselItem = true;
                                        break;
                                    }
                                } 

                                if ($showCarouselItem) { 
                                     $ci++; ?>
                                <div class="item <?php echo ($ci == 1) ? 'active' : '';?>" style="background-image: url(<?php echo esc_url($img_url); ?>)">
                                    <div class="container">
                                        <div class="row blurb">
                                            <div class="col-md-8 col-sm-12 blurb-content">
                                                <?php if($slidergenre && $slidergenre!='None' && $hidegenre != 'true') { ?>
                                                <span class="title filmgenre"> GENRE: <?php echo $slidergenre; ?></span>
                                                <?php } 
                                                if($slidertitle) { ?>                                   
                                                <header>
                                                    <h1><?php echo $slidertitle; ?></h1>
                                                </header>
                                                <?php } 
                                                if($slidercontent && $hidedescription != 'true'){ ?>
                                                <p class="moviesldrdesc"><?php echo wp_trim_words($slidercontent, 25, '...');?></p>
                                                <?php } ?>
                                                <div class="buttons sldrbtns"><?php 
                                                    if ($slidercertificate) {
                                                        ?><span class="certificate"><?php echo $slidercertificate; ?></span> <?php
                                                    }
                                                    if($slidertrailer && strtolower($slidertrailer)!='none' && $hidetrailer != 'true'){ ?>
                                                    <a href="<?php echo esc_url($slidertrailer);?>"  data-vbtype="video" class="venobox btn btn-default">
                                                        <i class="fa fa-play"></i>
                                                            <span>Trailer</span>
                                                        </a>
                                                    <?php } 
                                                    if($slidersynopsis && $hidesynopsis!= 'true'){ ?>
                                                    <a href="<?php echo esc_url($slidersynopsis);?>" class="btn btn-default gotomoviebtn">
                                                        <span>FULL SYNOPSIS</span>
                                                    </a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><?php
                                }
                            } ?>
                        </div>
                    </div>
                </div><?php
            else :
                echo '<div id="hero" class="customslider carousel slide carousel-fade manualslider" data-ride="carousel" style="display:none;"></div>';
            endif;  
        }

    } else if($movieslideroption == 'advertise') {

        $adsslider = get_option("adsslider");
        if($adsslider){

            $total_slides = count($get_films);
            $addslidesfinal = array();
            $excount = 1;
            foreach ($adsslider as $adkey => $advalue) {
                if(isset($advalue['theatrelocation'][$cinema])){
                    if(!empty($advalue['adsposition'])){
                        $key = $advalue['adsposition'] - 1;
                    }else{
                        $key = $total_slides+$excount - 1;
                        $excount++;
                    }
                    if(!isset($addslidesfinal[$key])){
                        $addslidesfinal[$key] = $advalue;
                    }else{
                        $newky = $key+1;
                        $addslidesfinal[$newky] = $advalue;
                    }
                    
                }
            }

            $ads_slides = count($addslidesfinal);

            $indicator_count = $total_slides + ($adsslider ? $ads_slides : 0);

            $allslidessr = array();
            $emptyindexslides = array();
            if ($addslidesfinal) {    
                foreach ($get_films as $flmkey => $flmvalue) {
                    $keyToAdd = $flmkey;
                    while (isset($addslidesfinal[$keyToAdd]) && !empty($addslidesfinal[$keyToAdd])) {
                        if (is_array($addslidesfinal[$keyToAdd]) && empty($addslidesfinal[$keyToAdd]['adsposition'])) {
                            $emptyindexslides[] = $addslidesfinal[$keyToAdd];
                            unset($addslidesfinal[$keyToAdd]);
                            
                        }
                        $keyToAdd++;
                    }
                    $addslidesfinal[$keyToAdd] = $flmvalue;
                }
            }

            ksort($addslidesfinal);
            $fullarray = array_merge($addslidesfinal,$emptyindexslides);
            
            if($fullarray){ ?>
                <div id="hero" class="customslider carousel slide carousel-fade advertiseslider" data-ride="carousel" data-posts="<?php echo $numberofposts; ?>">
                    <img src="<?php echo CINEMA_URL; ?>/images/scroll-arrow.svg" alt="Scroll down" class="scroll">
                    <div id="carousel" class="carousel slide" data-ride="carousel">
                      <!-- Indicators (control icons) -->
                      <div class="container">
                            <ol class="carousel-indicators">
                                <?php 
                                for ($i = 0; $i < $indicator_count; $i++) : ?>
                                    <li data-target="#carousel" data-slide-to="<?php echo $i; ?>" <?php echo ($i === 0) ? 'class="active"' : ''; ?>></li>
                                <?php endfor; ?>
                            </ol>
                        </div>
                      <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                          <?php $i = 1;         
                            foreach($fullarray as $key => $slide){        
                                if(is_array($slide) && isset($slide['adsimage'])){
                                    $sliderimage = $slide['adsimage'];
                                    $img_url = str_replace($_SERVER['DOCUMENT_ROOT'], '', $sliderimage);
                                    ?>  
                                    <div class="item <?php echo ($i == 1) ? 'active' : '';?>" style="background-image: url(<?php echo $img_url; ?>)">
                                      <div class="container">
                                       
                                      </div>
                                    </div>
                                    <?php
                                    $i++;
                                } else{
                             
                                    $backdrop = $slide->img_bd;
                                    $synopsis = $slide->synopsis;
                                    $certificate = $slide->certificate;
                                    $filmlink = $slide->url;
                                    $film_trailer = $slide->youtube;
                                    $film_genre = $slide->genre; 
                                    $filmtitle = $slide->filmtitle; ?>

                                    <div class="item <?php echo ($i == 1) ? 'active' : '';?>" style="background-image: url(<?php echo esc_url($backdrop); ?>)">

                                        <div class="container">
                                            <div class="row blurb">
                                                <div class="col-md-8 col-sm-12 blurb-content">
                                                    <?php if($film_genre && $film_genre!='None' && $hidegenre != 'true') { ?>
                                                    <span class="title filmgenre"> GENRE: <?php echo esc_attr($film_genre); ?></span>
                                                    <?php } ?>                                  
                                                    <header>
                                                        <h1><?php echo $filmtitle;?></h1>
                                                    </header>
                                                    <?php if($synopsis && $hidedescription != 'true'){ ?>
                                                    <p class="moviesldrdesc"><?php echo wp_trim_words($synopsis, 25, '...');?></p>
                                                    <?php } ?>
                                                    <div class="buttons sldrbtns">
                                                       <!--- hide certificate ring if null --->
                                                        <?php 
                                                        if ($certificate != '') {
                                                            ?><span class="certificate">
                                                                <?php echo $certificate; ?>
                                                            </span> <?php
                                                        }
                                                        ?>
                                                        <?php if($film_trailer && strtolower($film_trailer)!='none' && $hidetrailer != 'true'){ ?>
                                                        <a href="<?php echo esc_url($film_trailer);?>"  data-vbtype="video" class="venobox btn btn-default">
                                                            <i class="fa fa-play"></i>
                                                                <span>Trailer</span>
                                                            </a>
                                                        <?php } ?>  

                                                        <?php if($filmlink && $hidesynopsis!= 'true'){ ?>
                                                        
                                                        <a href="<?php echo esc_url($filmlink);?>" class="btn btn-default gotomoviebtn">
                                                            <span>FULL SYNOPSIS</span>
                                                        </a>
                                                    <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                $i++;
                                }
                            } ?>
                        </div><!-- Carousel End -->
                    </div><!-- Slider Speed & Hover -->
                </div>

           <?php } else {
            echo '<div id="hero" class="customslider carousel slide carousel-fade advertiseslider" data-ride="carousel" style="display:none;">';
           }
        }
    } else {
        if($get_films){ ?>      
            <div id="hero" class="customslider carousel slide carousel-fade autoslider" data-ride="carousel" data-posts="<?php echo $numberofposts; ?>">
                <img src="<?php echo CINEMA_URL; ?>/images/scroll-arrow.svg" alt="Scroll down" class="scroll">
                <div id="carousel" class="carousel slide" data-ride="carousel">
                  <!-- Indicators (control icons) -->
                  <div class="container">   
                        <ol class="carousel-indicators">
                            <?php foreach ( $get_films as $key => $slide ) : ?>
                                <li data-target="#carousel" data-slide-to="<?php echo ($key + 0); ?>" <?php echo ($key == 0) ? 'class="active"' : '';?>></li>
                            <?php endforeach ?>
                        </ol>
                    </div>
                  <!-- Wrapper for slides -->
                  <div class="carousel-inner" role="listbox">
                      <!-- Slides -->
                      <?php $i = 0; 
                      foreach($get_films as $key => $slide){

                        $i++;
                        $backdrop = $slide->img_bd;
                        $synopsis = $slide->synopsis;
                        $certificate = $slide->certificate;
                        $filmlink = $slide->url;
                        $film_trailer = $slide->youtube;
                        $film_genre = $slide->genre;
                        $filmtitle = $slide->filmtitle;
                        
                        ?>
                        <div class="item <?php echo ($i == 1) ? 'active' : '';?>" style="background-image: url(<?php echo esc_url($backdrop); ?>)">
                            <div class="container">
                                <div class="row blurb">
                                    <div class="col-md-8 col-sm-12 blurb-content">
                                        <?php if($film_genre && $film_genre!='None' && $hidegenre != 'true') { ?>
                                        <span class="title filmgenre"> GENRE: <?php echo esc_attr($film_genre); ?></span>
                                        <?php } ?>                                  
                                        <header>
                                            <h1><?php echo $filmtitle;?></h1>
                                        </header>
                                        <?php if($synopsis && $hidedescription != 'true'){ ?>
                                        <p class="moviesldrdesc"><?php echo wp_trim_words($synopsis, 25, '...'); ?></p>
                                        <?php } ?>
                                        <div class="buttons sldrbtns">
                                           <!--- hide certificate ring if null --->
                                            <?php 
                                            if ($certificate != '') {
                                                ?><span class="certificate">
                                                    <?php echo $certificate; ?>
                                                </span> <?php
                                            }
                                            if($film_trailer && strtolower($film_trailer)!='none' && $hidetrailer != 'true'){ ?>
                                                <a href="<?php echo esc_url($film_trailer);?>"  data-vbtype="video" class="venobox btn btn-default">
                                                    <i class="fa fa-play"></i>
                                                    <span>Trailer</span>
                                                </a>
                                            <?php } 
                                            if($filmlink && $hidesynopsis!= 'true'){ ?> 
                                                <a href="<?php echo esc_url($filmlink);?>" class="btn btn-default gotomoviebtn">
                                                    <span>FULL SYNOPSIS</span>
                                                </a><?php 
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>    
                    </div><!-- Slides end -->
                </div><!-- Carousel End -->
            </div><?php 
        } else {
        ?><div id="hero" class="customslider carousel slide carousel-fade autoslider" data-ride="carousel" style="display: none;"></div><?php
        } 
    } ?>
    <?php
    return ob_get_clean();
}
add_shortcode( 'jacro-movie-slider', 'jacro_movies_slider' );