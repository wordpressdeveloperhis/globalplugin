<?php
global $wpdb;
$table_customers = $wpdb->prefix . "jacro_customers";
$table_locations = $wpdb->prefix . "jacro_locations";
$table_films = $wpdb->prefix . "jacro_films";
$table_performances = $wpdb->prefix . "jacro_performances";
$table_modifiers = $wpdb->prefix . "jacro_modifiers";
$table_products = $wpdb->prefix . "jacro_products";
$table_images = $wpdb->prefix . "jacro_images";
$table_attributes = $wpdb->prefix . "jacro_attributes";

/* table - customers */
if($wpdb->get_var("SHOW TABLES LIKE '$table_customers'") != $table_customers) {
    $customer_sql = "CREATE TABLE " . $table_customers . " (
        id int(11) NOT NULL AUTO_INCREMENT,
        code VARCHAR(255) NOT NULL,
        url text NOT NULL,
        created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY id (id)
    );";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($customer_sql);
}
/* table - locations */
if($wpdb->get_var("SHOW TABLES LIKE '$table_locations'") != $table_locations) {
    $location_sql = "CREATE TABLE " . $table_locations . " (
        id int(11) NOT NULL AUTO_INCREMENT,
        customer int(11) NOT NULL,
        name varchar(255) NOT NULL,
        code varchar(55) NOT NULL,
        url text NOT NULL,
        country varchar(55) NOT NULL,
        timezone varchar(55) NOT NULL,
        facilities varchar(255) NOT NULL,
        geolocation varchar(255) NOT NULL,
        bookingurl varchar(255) NOT NULL,
        details LONGTEXT NOT NULL,
        created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY id (id)
    );";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($location_sql);
}
/* table - films */
if($wpdb->get_var("SHOW TABLES LIKE '$table_films'") != $table_films) {
    $film_sql = "CREATE TABLE " . $table_films . " (
        id int(11) NOT NULL AUTO_INCREMENT,
        customer int(11) NOT NULL,
        location int(11) NOT NULL,
        code varchar(255) NOT NULL,
        shortfilmtitle varchar(255) NOT NULL,
        filmtitle varchar(255) NOT NULL,
        privatewatchparty varchar(255) NOT NULL,
        certificate varchar(255) NOT NULL,
        is3d varchar(255) NOT NULL,
        lastmodified datetime NOT NULL,
        actors varchar(255) NOT NULL,
        digital varchar(255) NOT NULL,
        img_title varchar(255) NOT NULL,
        startdate date NOT NULL,
        enddate date NOT NULL,
        cinecheckflagsdescription varchar(255) NOT NULL,
        cinecheckflags varchar(255) NOT NULL,
        releasedate date NOT NULL,
        film_with_releasedate date NOT NULL,
        img_1s varchar(255) NOT NULL,
        genre varchar(255) NOT NULL,
        filmflagsdescription varchar(255) NOT NULL,
        comingsoon varchar(255) NOT NULL,
        youtube varchar(255) NOT NULL,
        synopsis LONGTEXT NOT NULL,
        certificate_desc varchar(255) NOT NULL,
        genrecode varchar(255) NOT NULL,
        rentrak varchar(255) NOT NULL,
        directors varchar(255) NOT NULL,
        runningtime varchar(255) NOT NULL,
        img_bd varchar(255) NOT NULL,
        localfilmcode varchar(255) NOT NULL,
        filmmastercode varchar(255) NOT NULL,
        img_cert_filename_blob varchar(255) NOT NULL,
        certimageurl varchar(255) NOT NULL,
        filmflags varchar(255) NOT NULL,
        img_app varchar(255) NOT NULL,
        imdbcode varchar(255) NOT NULL,
        launch_date varchar(255) NOT NULL,
        film_attributes varchar(255) NOT NULL,
        film_attributes_description LONGTEXT NOT NULL,
        titleart_url text NOT NULL,
		regions text NOT NULL,
        url text NOT NULL,
        created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY id (id)
    );";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($film_sql);
}
/* table - performances */
if($wpdb->get_var("SHOW TABLES LIKE '$table_performances'") != $table_performances) {
    $performance_sql = "CREATE TABLE " . $table_performances . " (
        id int(11) NOT NULL AUTO_INCREMENT,
        customer int(11) NOT NULL,
        location int(11) NOT NULL,
        code varchar(255) NOT NULL,
        performdate date NOT NULL,
        passes varchar(255) NOT NULL,
        perfflags varchar(255) NOT NULL,
        soldoutlevel varchar(255) NOT NULL,
        lastmodified datetime NOT NULL,
        virtual varchar(255) NOT NULL,
        perfcat varchar(255) NOT NULL,
        bookingurl varchar(255) NOT NULL,
        ad varchar(255) NOT NULL,
        screen varchar(255) NOT NULL,
        doorsopen time NOT NULL,
        purchasedprivatewatchparty varchar(255) NOT NULL,
        filmcode varchar(255) NOT NULL,
        selloninternet varchar(255) NOT NULL,
        trailertime varchar(255) NOT NULL,
        wheelchairaccessible varchar(255) NOT NULL,
        reservedseating varchar(255) NOT NULL,
        salesstopped varchar(255) NOT NULL,
        img_bd_filename_blob varchar(255) NOT NULL,
        performancenumberslot varchar(255) NOT NULL,
        internalbookingurldesktop varchar(255) NOT NULL,
        subs varchar(255) NOT NULL,
        pressreport varchar(255) NOT NULL,
        internalbookingurlmobile varchar(255) NOT NULL,
        perfflagsdescription varchar(255) NOT NULL,
        screencode varchar(255) NOT NULL,
        starttime time NOT NULL,
        performanceshidden varchar(255) NOT NULL,
        managerwarninglevel varchar(255) NOT NULL,
        externalurl varchar(255) NOT NULL,
        sensibledoublefeature varchar(255) NOT NULL,
        zerosales varchar(255) NOT NULL,
        ticketssold varchar(255) NOT NULL,
        created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY id (id)
    );";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($performance_sql);
}
/* table - modifiers */
if($wpdb->get_var("SHOW TABLES LIKE '$table_modifiers'") != $table_modifiers) {
    $modifier_sql = "CREATE TABLE " . $table_modifiers . " (
        id int(11) NOT NULL AUTO_INCREMENT,
        customer int(11) NOT NULL,
        location int(11) NOT NULL,
        code VARCHAR(255) NOT NULL,
        description VARCHAR(255) NOT NULL,
        priority VARCHAR(255) NOT NULL,
        modtype VARCHAR(255) NOT NULL,
        cinecheckfile VARCHAR(255) NOT NULL,
        shortcode VARCHAR(255) NOT NULL,
        created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY id (id)
    );";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($modifier_sql);
}
/* table - products */
if($wpdb->get_var("SHOW TABLES LIKE '$table_products'") != $table_products) {
    $product_sql = "CREATE TABLE " . $table_products . " (
        id int(11) NOT NULL AUTO_INCREMENT,
        customer int(11) NOT NULL,
        location int(11) NOT NULL,
        pricingtable LONGTEXT NOT NULL,
        created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY id (id)
    );";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($product_sql);
}
/* table - images */
if($wpdb->get_var("SHOW TABLES LIKE '$table_images'") != $table_images) {
    $image_sql = "CREATE TABLE " . $table_images . " (
        id int(11) NOT NULL AUTO_INCREMENT,
        customer int(11) NOT NULL,
        location int(11) NOT NULL,
        type VARCHAR(255) NOT NULL,
        sequence VARCHAR(255) NOT NULL,
        frequency VARCHAR(255) NOT NULL,
        url_data VARCHAR(255) NOT NULL,
        content_type VARCHAR(255) NOT NULL,
        filename VARCHAR(255) NOT NULL,
        created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY id (id)
    );";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($image_sql);
}
/* table - attributes */
if($wpdb->get_var("SHOW TABLES LIKE '$table_attributes'") != $table_attributes) {
    $image_sql = "CREATE TABLE " . $table_attributes . " (
        id int(11) NOT NULL AUTO_INCREMENT,
        customer int(11) NOT NULL,
        location int(11) NOT NULL,
        code VARCHAR(255) NOT NULL,
        description VARCHAR(255) NOT NULL,
        priority VARCHAR(255) NOT NULL,
        modtype VARCHAR(255) NOT NULL,
        cinecheckfile VARCHAR(255) NOT NULL,
        shortcode VARCHAR(255) NOT NULL,
        created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY id (id)
    );";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($image_sql);
}
?>