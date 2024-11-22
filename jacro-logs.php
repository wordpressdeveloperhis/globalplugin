<?php

// IP address
if(!function_exists('getIP')) {
	function getIP(){
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP'])) {
		   $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		} else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		   $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
		   $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		} else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
		   $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		} else if (isset($_SERVER['HTTP_FORWARDED'])) {
		   $ipaddress = $_SERVER['HTTP_FORWARDED'];
		} else if (isset($_SERVER['REMOTE_ADDR'])) {
		   $ipaddress = $_SERVER['REMOTE_ADDR'];
		} else {
		   $ipaddress = 'UNKNOWN';
		}
		return $ipaddress;
	}
}
function to_email(){
    $to_email = '';
    if(get_option('jacro_log_email')){
        $to_email = get_option( 'jacro_log_email' );
    }else{
        $to_email = get_option( 'admin_email' );
    }
    return $to_email;
}

// blogname change log in general settings
if(!function_exists('blogname_save_log')) {
	function blogname_save_log( $old_time_setting, $new_time_setting ) {
        global $wpdb;
        $wp_track_table = $wpdb->prefix . 'jacro_logs';    
        $user_id = get_current_user_id();
        $user_detail = get_user_by( 'id', $user_id );
        $user_name = $user_detail->display_name; 
        $ip_address =  getIP();
        $current_time = date("Y/m/d h:i:sa");       
        $wpdb->insert($wp_track_table, array('id' => NULL, 'user_id' => $user_id, 'ip_address' => $ip_address, 'changed_page' => $new_time_setting, 'created' => $current_time));
        $to = to_email();
        $subject = 'Jacro Website Changes Log';
        $body = '<html>
                    <body>
                        <table rules="all" cellpadding="5" style="border: 1px solid black;border-collapse: collapse;">
                            <tr><td>Date/Time</td><td>'.$current_time.'</td></tr>    
                            <tr><td>User</td><td>'.$user_name.'</td></tr>
                            <tr><td>IP</td><td>'.$ip_address.'</td></tr>
                            <tr><td>Context</td><td>blogname - general settings</td></tr>
                            <tr><td>Info</td><td>'.$old_time_setting.' <strong>'.$new_time_setting.'</strong></td></tr>
                            <tr><td>Action</td><td>updated</td></tr>
                        </table>
                    </body>
                </html>';
        $headers = array('Content-Type: text/html; charset=UTF-8','From: Jacro <support@jacro.com>');  
        if($wpdb) {
            wp_mail( $to, $subject, $body, $headers );
        }
	}
	add_action( 'update_option_blogname', 'blogname_save_log', 10, 2 );
}

// blogdescription change log in general settings
if(!function_exists('blogdescription_save_log')) {
	function blogdescription_save_log( $old_time_setting, $new_time_setting ) {
        global $wpdb;
        $wp_track_table = $wpdb->prefix . 'jacro_logs';    
        $user_id = get_current_user_id();
        $user_detail = get_user_by( 'id', $user_id );
        $user_name = $user_detail->display_name; 
        $ip_address =  getIP();
        $current_time = date("Y/m/d h:i:sa");
        $wpdb->insert($wp_track_table, array('id' => NULL, 'user_id' => $user_id, 'ip_address' => $ip_address, 'changed_page' => $new_time_setting, 'created' => $current_time));
        $to = to_email();
        $subject = 'Jacro Website Changes Log';
        $body = '<html>
                    <body>
                        <table rules="all" cellpadding="5" style="border: 1px solid black;border-collapse: collapse;">
                            <tr><td>Date/Time</td><td>'.$current_time.'</td></tr>    
                            <tr><td>User</td><td>'.$user_name.'</td></tr>
                            <tr><td>IP</td><td>'.$ip_address.'</td></tr>
                            <tr><td>Context</td><td>blogdescription - general settings</td></tr>
                            <tr><td>Info</td><td>'.$old_time_setting.' <strong>'.$new_time_setting.'</strong></td></tr>
                            <tr><td>Action</td><td>updated</td></tr>
                        </table>
                    </body>
                </html>';
        $headers = array('Content-Type: text/html; charset=UTF-8','From: Jacro <support@jacro.com>');  
        if($wpdb) {
            wp_mail( $to, $subject, $body, $headers );
        }
	}
	add_action( 'update_option_blogdescription', 'blogdescription_save_log', 10, 2 );
}

// siteurl change log in general settings
if(!function_exists('siteurl_save_log')) {
	function siteurl_save_log( $old_time_setting, $new_time_setting ) {
        global $wpdb;
        $wp_track_table = $wpdb->prefix . 'jacro_logs';    
        $user_id = get_current_user_id();
        $user_detail = get_user_by( 'id', $user_id );
        $user_name = $user_detail->display_name; 
        $ip_address =  getIP();
        $current_time = date("Y/m/d h:i:sa");
        $wpdb->insert($wp_track_table, array('id' => NULL, 'user_id' => $user_id, 'ip_address' => $ip_address, 'changed_page' => $new_time_setting, 'created' => $current_time));
        $to = to_email();
        $subject = 'Jacro Website Changes Log';
        $body = '<html>
                    <body>
                        <table rules="all" cellpadding="5" style="border: 1px solid black;border-collapse: collapse;">
                            <tr><td>Date/Time</td><td>'.$current_time.'</td></tr>    
                            <tr><td>User</td><td>'.$user_name.'</td></tr>
                            <tr><td>IP</td><td>'.$ip_address.'</td></tr>
                            <tr><td>Context</td><td>siteurl - general settings</td></tr>
                            <tr><td>Info</td><td>'.$old_time_setting.' <strong>'.$new_time_setting.'</strong></td></tr>
                            <tr><td>Action</td><td>updated</td></tr>
                        </table>
                    </body>
                </html>';
        $headers = array('Content-Type: text/html; charset=UTF-8','From: Jacro <support@jacro.com>');  
        if($wpdb) {
            wp_mail( $to, $subject, $body, $headers );
        }
	}
	add_action( 'update_option_siteurl', 'siteurl_save_log', 10, 2 );
}

// home change log in general settings
if(!function_exists('home_save_log')) {
	function home_save_log( $old_time_setting, $new_time_setting ) {
        global $wpdb;
        $wp_track_table = $wpdb->prefix . 'jacro_logs';    
        $user_id = get_current_user_id();
        $user_detail = get_user_by( 'id', $user_id );
        $user_name = $user_detail->display_name; 
        $ip_address =  getIP();
        $current_time = date("Y/m/d h:i:sa");
        $wpdb->insert($wp_track_table, array('id' => NULL, 'user_id' => $user_id, 'ip_address' => $ip_address, 'changed_page' => $new_time_setting, 'created' => $current_time));
        $to = to_email();
        $subject = 'Jacro Website Changes Log';
        $body = '<html>
                    <body>
                        <table rules="all" cellpadding="5" style="border: 1px solid black;border-collapse: collapse;">
                            <tr><td>Date/Time</td><td>'.$current_time.'</td></tr>    
                            <tr><td>User</td><td>'.$user_name.'</td></tr>
                            <tr><td>IP</td><td>'.$ip_address.'</td></tr>
                            <tr><td>Context</td><td>home - general settings</td></tr>
                            <tr><td>Info</td><td>'.$old_time_setting.' <strong>'.$new_time_setting.'</strong></td></tr>
                            <tr><td>Action</td><td>updated</td></tr>
                        </table>
                    </body>
                </html>';
        $headers = array('Content-Type: text/html; charset=UTF-8','From: Jacro <support@jacro.com>');  
        if($wpdb) {
            wp_mail( $to, $subject, $body, $headers );
        }
	}
	add_action( 'update_option_home', 'home_save_log', 10, 2 );
}

// admin email change log in general settings
if(!function_exists('admin_email_save_log')) {
	function admin_email_save_log( $old_time_setting, $new_time_setting ) {
        global $wpdb;
        $wp_track_table = $wpdb->prefix . 'jacro_logs';    
        $user_id = get_current_user_id();
        $user_detail = get_user_by( 'id', $user_id );
        $user_name = $user_detail->display_name; 
        $ip_address =  getIP();
        $current_time = date("Y/m/d h:i:sa");
        $wpdb->insert($wp_track_table, array('id' => NULL, 'user_id' => $user_id, 'ip_address' => $ip_address, 'changed_page' => $new_time_setting, 'created' => $current_time));
        $to = to_email();
        $subject = 'Jacro Website Changes Log';
        $body = '<html>
                    <body>
                        <table rules="all" cellpadding="5" style="border: 1px solid black;border-collapse: collapse;">
                            <tr><td>Date/Time</td><td>'.$current_time.'</td></tr>    
                            <tr><td>User</td><td>'.$user_name.'</td></tr>
                            <tr><td>IP</td><td>'.$ip_address.'</td></tr>
                            <tr><td>Context</td><td>admin email - general settings</td></tr>
                            <tr><td>Info</td><td>'.$old_time_setting.' <strong>'.$new_time_setting.'</strong></td></tr>
                            <tr><td>Action</td><td>updated</td></tr>
                        </table>
                    </body>
                </html>';
        $headers = array('Content-Type: text/html; charset=UTF-8','From: Jacro <support@jacro.com>');  
        if($wpdb) {
            wp_mail( $to, $subject, $body, $headers );
        }
	}
	add_action( 'update_option_admin_email', 'admin_email_save_log', 10, 2 );
}

// users can register change log in general settings
if(!function_exists('users_can_register_save_log')) {
	function users_can_register_save_log( $old_time_setting, $new_time_setting ) {
        global $wpdb;
        $wp_track_table = $wpdb->prefix . 'jacro_logs';    
        $user_id = get_current_user_id();
        $user_detail = get_user_by( 'id', $user_id );
        $user_name = $user_detail->display_name; 
        $ip_address =  getIP();
        $current_time = date("Y/m/d h:i:sa");
        $wpdb->insert($wp_track_table, array('id' => NULL, 'user_id' => $user_id, 'ip_address' => $ip_address, 'changed_page' => $new_time_setting, 'created' => $current_time));
        $to = to_email();
        $subject = 'Jacro Website Changes Log';
        $body = '<html>
                    <body>
                        <table rules="all" cellpadding="5" style="border: 1px solid black;border-collapse: collapse;">
                            <tr><td>Date/Time</td><td>'.$current_time.'</td></tr>    
                            <tr><td>User</td><td>'.$user_name.'</td></tr>
                            <tr><td>IP</td><td>'.$ip_address.'</td></tr>
                            <tr><td>Context</td><td>users can register - general settings</td></tr>
                            <tr><td>Info</td><td>'.$old_time_setting.' <strong>'.$new_time_setting.'</strong></td></tr>
                            <tr><td>Action</td><td>updated</td></tr>
                        </table>
                    </body>
                </html>';
        $headers = array('Content-Type: text/html; charset=UTF-8','From: Jacro <support@jacro.com>');  
        if($wpdb) {
            wp_mail( $to, $subject, $body, $headers );
        }
	}
	add_action( 'update_option_users_can_register', 'users_can_register_save_log', 10, 2 );
}

// users can register change log in general settings
if(!function_exists('default_role_save_log')) {
	function default_role_save_log( $old_time_setting, $new_time_setting ) {
        global $wpdb;
        $wp_track_table = $wpdb->prefix . 'jacro_logs';    
        $user_id = get_current_user_id();
        $user_detail = get_user_by( 'id', $user_id );
        $user_name = $user_detail->display_name; 
        $ip_address =  getIP();
        $current_time = date("Y/m/d h:i:sa");
        $wpdb->insert($wp_track_table, array('id' => NULL, 'user_id' => $user_id, 'ip_address' => $ip_address, 'changed_page' => $new_time_setting, 'created' => $current_time));
        $to = to_email();
        $subject = 'Jacro Website Changes Log';
        $body = '<html>
                    <body>
                        <table rules="all" cellpadding="5" style="border: 1px solid black;border-collapse: collapse;">
                            <tr><td>Date/Time</td><td>'.$current_time.'</td></tr>    
                            <tr><td>User</td><td>'.$user_name.'</td></tr>
                            <tr><td>IP</td><td>'.$ip_address.'</td></tr>
                            <tr><td>Context</td><td>default role - general settings</td></tr>
                            <tr><td>Info</td><td>'.$old_time_setting.' <strong>'.$new_time_setting.'</strong></td></tr>
                            <tr><td>Action</td><td>updated</td></tr>
                        </table>
                    </body>
                </html>';
        $headers = array('Content-Type: text/html; charset=UTF-8','From: Jacro <support@jacro.com>');  
        if($wpdb) {
            wp_mail( $to, $subject, $body, $headers );
        }
	}
	add_action( 'update_option_default_role', 'default_role_save_log', 10, 2 );
}

// WPLANG change log in general settings
if(!function_exists('WPLANG_save_log')) {
	function WPLANG_save_log( $old_time_setting, $new_time_setting ) {
        global $wpdb;
        $wp_track_table = $wpdb->prefix . 'jacro_logs';    
        $user_id = get_current_user_id();
        $user_detail = get_user_by( 'id', $user_id );
        $user_name = $user_detail->display_name; 
        $ip_address =  getIP();
        $current_time = date("Y/m/d h:i:sa");
        $wpdb->insert($wp_track_table, array('id' => NULL, 'user_id' => $user_id, 'ip_address' => $ip_address, 'changed_page' => $new_time_setting, 'created' => $current_time));
        $to = to_email();
        $subject = 'Jacro Website Changes Log';
        $body = '<html>
                    <body>
                        <table rules="all" cellpadding="5" style="border: 1px solid black;border-collapse: collapse;">
                            <tr><td>Date/Time</td><td>'.$current_time.'</td></tr>    
                            <tr><td>User</td><td>'.$user_name.'</td></tr>
                            <tr><td>IP</td><td>'.$ip_address.'</td></tr>
                            <tr><td>Context</td><td>WPLANG - general settings</td></tr>
                            <tr><td>Info</td><td>'.$old_time_setting.' <strong>'.$new_time_setting.'</strong></td></tr>
                            <tr><td>Action</td><td>updated</td></tr>
                        </table>
                    </body>
                </html>';
        $headers = array('Content-Type: text/html; charset=UTF-8','From: Jacro <support@jacro.com>');  
        if($wpdb) {
            wp_mail( $to, $subject, $body, $headers );
        }
	}
	add_action( 'update_option_WPLANG', 'WPLANG_save_log', 10, 2 );
}

// timezone string change log in general settings
if(!function_exists('timezone_string_save_log')) {
	function timezone_string_save_log( $old_time_setting, $new_time_setting ) {
        global $wpdb;
        $wp_track_table = $wpdb->prefix . 'jacro_logs';    
        $user_id = get_current_user_id();
        $user_detail = get_user_by( 'id', $user_id );
        $user_name = $user_detail->display_name; 
        $ip_address =  getIP();
        $current_time = date("Y/m/d h:i:sa");
        $wpdb->insert($wp_track_table, array('id' => NULL, 'user_id' => $user_id, 'ip_address' => $ip_address, 'changed_page' => $new_time_setting, 'created' => $current_time));
        $to = to_email();
        $subject = 'Jacro Website Changes Log';
        $body = '<html>
                    <body>
                        <table rules="all" cellpadding="5" style="border: 1px solid black;border-collapse: collapse;">
                            <tr><td>Date/Time</td><td>'.$current_time.'</td></tr>    
                            <tr><td>User</td><td>'.$user_name.'</td></tr>
                            <tr><td>IP</td><td>'.$ip_address.'</td></tr>
                            <tr><td>Context</td><td>timezone string - general settings</td></tr>
                            <tr><td>Info</td><td>'.$old_time_setting.' <strong>'.$new_time_setting.'</strong></td></tr>
                            <tr><td>Action</td><td>updated</td></tr>
                        </table>
                    </body>
                </html>';
        $headers = array('Content-Type: text/html; charset=UTF-8','From: Jacro <support@jacro.com>');  
        if($wpdb) {
            wp_mail( $to, $subject, $body, $headers );
        }
	}
	add_action( 'update_option_timezone_string', 'timezone_string_save_log', 10, 2 );
}

// date format change log in general settings
if(!function_exists('date_format_save_log')) {
	function date_format_save_log( $old_time_setting, $new_time_setting ) {
        global $wpdb;
        $wp_track_table = $wpdb->prefix . 'jacro_logs';    
        $user_id = get_current_user_id();
        $user_detail = get_user_by( 'id', $user_id );
        $user_name = $user_detail->display_name; 
        $ip_address =  getIP();
        $current_time = date("Y/m/d h:i:sa");
        $wpdb->insert($wp_track_table, array('id' => NULL, 'user_id' => $user_id, 'ip_address' => $ip_address, 'changed_page' => $new_time_setting, 'created' => $current_time));
        $to = to_email();
        $subject = 'Jacro Website Changes Log';
        $body = '<html>
                    <body>
                        <table rules="all" cellpadding="5" style="border: 1px solid black;border-collapse: collapse;">
                            <tr><td>Date/Time</td><td>'.$current_time.'</td></tr>    
                            <tr><td>User</td><td>'.$user_name.'</td></tr>
                            <tr><td>IP</td><td>'.$ip_address.'</td></tr>
                            <tr><td>Context</td><td>date format - general settings</td></tr>
                            <tr><td>Info</td><td>'.$old_time_setting.' <strong>'.$new_time_setting.'</strong></td></tr>
                            <tr><td>Action</td><td>updated</td></tr>
                        </table>
                    </body>
                </html>';
        $headers = array('Content-Type: text/html; charset=UTF-8','From: Jacro <support@jacro.com>');  
        if($wpdb) {
            wp_mail( $to, $subject, $body, $headers );
        }
	}
	add_action( 'update_option_date_format', 'date_format_save_log', 10, 2 );
}

// time format change log in genral settings
if(!function_exists('time_format_save_log')) {
	function time_format_save_log( $old_time_setting, $new_time_setting ) {
        global $wpdb;
        $wp_track_table = $wpdb->prefix . 'jacro_logs';    
        $user_id = get_current_user_id();
        $user_detail = get_user_by( 'id', $user_id );
        $user_name = $user_detail->display_name; 
        $ip_address =  getIP();
        $current_time = date("Y/m/d h:i:sa");
        $wpdb->insert($wp_track_table, array('id' => NULL, 'user_id' => $user_id, 'ip_address' => $ip_address, 'changed_page' => $new_time_setting, 'created' => $current_time));
        $to = to_email();
        $subject = 'Jacro Website Changes Log';
        $body = '<html>
                    <body>
                        <table rules="all" cellpadding="5" style="border: 1px solid black;border-collapse: collapse;">
                            <tr><td>Date/Time</td><td>'.$current_time.'</td></tr>    
                            <tr><td>User</td><td>'.$user_name.'</td></tr>
                            <tr><td>IP</td><td>'.$ip_address.'</td></tr>
                            <tr><td>Context</td><td>time format - general settings</td></tr>
                            <tr><td>Info</td><td>'.$old_time_setting.' <strong>'.$new_time_setting.'</strong></td></tr>
                            <tr><td>Action</td><td>updated</td></tr>
                        </table>
                    </body>
                </html>';
        $headers = array('Content-Type: text/html; charset=UTF-8','From: Jacro <support@jacro.com>');  
        if($wpdb) {
            wp_mail( $to, $subject, $body, $headers );
        }
	}
	add_action( 'update_option_time_format', 'time_format_save_log', 10, 2 );
}

// start of week change log in genral settings
if(!function_exists('start_of_week_save_log')) {
	function start_of_week_save_log( $old_time_setting, $new_time_setting ) {
        global $wpdb;
        $wp_track_table = $wpdb->prefix . 'jacro_logs';    
        $user_id = get_current_user_id();
        $user_detail = get_user_by( 'id', $user_id );
        $user_name = $user_detail->display_name; 
        $ip_address =  getIP();
        $current_time = date("Y/m/d h:i:sa");
        $wpdb->insert($wp_track_table, array('id' => NULL, 'user_id' => $user_id, 'ip_address' => $ip_address, 'changed_page' => $new_time_setting, 'created' => $current_time));
        $to = to_email();
        $subject = 'Jacro Website Changes Log';
        $body = '<html>
                    <body>
                        <table rules="all" cellpadding="5" style="border: 1px solid black;border-collapse: collapse;">
                            <tr><td>Date/Time</td><td>'.$current_time.'</td></tr>    
                            <tr><td>User</td><td>'.$user_name.'</td></tr>
                            <tr><td>IP</td><td>'.$ip_address.'</td></tr>
                            <tr><td>Context</td><td>start of week - general settings</td></tr>
                            <tr><td>Info</td><td>'.$old_time_setting.' <strong>'.$new_time_setting.'</strong></td></tr>
                            <tr><td>Action</td><td>updated</td></tr>
                        </table>
                    </body>
                </html>';
        $headers = array('Content-Type: text/html; charset=UTF-8','From: Jacro <support@jacro.com>');  
        if($wpdb) {
            wp_mail( $to, $subject, $body, $headers );
        }
	}
	add_action( 'update_option_start_of_week', 'start_of_week_save_log', 10, 2 );
}

// Page/Post update log
if(!function_exists('publish_page_record')) {
	function publish_page_record( $post_id , $post_after, $post_before ) {
        global $wpdb;     
        $event = null;
        if($post_before -> post_status === 'auto-draft' && $post_after -> post_status === 'publish') {
            $event = 'created';
        } else if($post_before -> post_status === 'draft' && $post_after -> post_status === 'publish') {
            $event = 'created';
        } else if($post_before -> post_status === 'publish' && $post_after -> post_status === 'publish') {
            $event = 'updated';
        } else {
            return;
        }

        $wp_track_table = $wpdb->prefix . 'jacro_logs';        
        $user_id = get_current_user_id();
        $user_detail = get_user_by( 'id', $user_id );
        $user_name = $user_detail->display_name; 
        $ip_address =  getIP();
        $p_title = get_the_title($post_id);
        $p_context = get_post_type($post_id);
        $current_time = date("Y/m/d h:i:sa");
        if($p_context == 'page' || $p_context == 'posts' || $p_context == 'fw-slider'){ 
            $wpdb->insert($wp_track_table, array('user_id' => $user_id, 'ip_address' => $ip_address, 'changed_page' => $new_time_setting, 'created' => $current_time));
            $to = to_email();
            $subject = 'Jacro Website Changes Log';
            $body = '<html>
                        <body>
                            <table rules="all" cellpadding="10" style="border: 1px solid black;border-collapse: collapse;">
                                <tr><td>Date/Time</td><td>'.$current_time.'</td></tr>    
                                <tr><td>User</td><td>'.$user_name.'</td></tr>
                                <tr><td>IP</td><td>'.$ip_address.'</td></tr>
                                <tr><td>Context</td><td>'.$p_context.'</td></tr>
                                <tr><td>Info</td><td>'.$p_title.'</td></tr>
                                <tr><td>Action</td><td>'.$event.'</td></tr>
                            </table>
                        </body>
                    </html>';
            $headers = array('Content-Type: text/html; charset=UTF-8','From: Jacro <support@jacro.com>');  
            if($wpdb) {
                wp_mail( $to, $subject, $body, $headers);
            }  
        } 
	}
	add_action( 'post_updated', 'publish_page_record', 10, 3 );
}

// Plugin activate log
if(!function_exists('pluign_activated_record')) {
	function pluign_activated_record( $plugin ) {
	    global $wpdb;     
        $plugin_name = strtok($plugin, "/");  
        $wp_track_tablee = $wpdb->prefix . 'jacro_logs';
        $user_id = get_current_user_id();
        $user_detail = get_user_by( 'id', $user_id );
        $user_name = $user_detail->display_name;
        $ip_address =  getIP();
        $current_time = date("Y/m/d h:i:sa");
        $wpdb->insert($wp_track_tablee, array('user_id' => $user_id, 'ip_address' => $ip_address, 'changed_page' => $new_time_setting, 'created' => $current_time));
        $to = to_email();
        $subject = 'Jacro Website Changes Log';
        $body = '<html>
                    <body>
                        <table rules="all" cellpadding="10" style="border: 1px solid black;border-collapse: collapse;">
                            <tr><td>Date/Time</td><td>'.$current_time.'</td></tr>    
                            <tr><td>User</td><td>'.$user_name.'</td></tr>
                            <tr><td>IP</td><td>'.$ip_address.'</td></tr>
                            <tr><td>Context</td><td>plugins</td></tr>
                            <tr><td>Info</td><td>'.$plugin_name.'</td></tr>
                            <tr><td>Action</td><td>activated</td></tr>
                        </table>
                    </body>
                </html>';
        $headers = array('Content-Type: text/html; charset=UTF-8','From: Jacro <support@jacro.com>');  
        if($wpdb) {
            wp_mail( $to, $subject, $body, $headers);
        }  
	}
	add_action( 'activated_plugin', 'pluign_activated_record');
}

// Plugin deactivate log
if(!function_exists('pluign_deactivated_record')) {
	function pluign_deactivated_record( $plugin ) {
	    global $wpdb;     
        $plugin_name = strtok($plugin, "/");
        $wp_track_tablee = $wpdb->prefix . 'jacro_logs';
        $user_id = get_current_user_id();
        $user_detail = get_user_by( 'id', $user_id );
        $user_name = $user_detail->display_name;
        $ip_address =  getIP();
        $current_time = date("Y/m/d h:i:sa");
        $wpdb->insert($wp_track_tablee, array('user_id' => $user_id, 'ip_address' => $ip_address, 'changed_page' => $new_time_setting, 'created' => $current_time));
        $to = to_email();
        $subject = 'Jacro Website Changes Log';
        $body = '<html>
                    <body>
                        <table rules="all" cellpadding="10" style="border: 1px solid black;border-collapse: collapse;">
                            <tr><td>Date/Time</td><td>'.$current_time.'</td></tr>    
                            <tr><td>User</td><td>'.$user_name.'</td></tr>
                            <tr><td>IP</td><td>'.$ip_address.'</td></tr>
                            <tr><td>Context</td><td>plugins</td></tr>
                            <tr><td>Info</td><td>'.$plugin_name.'</td></tr>
                            <tr><td>Action</td><td>deactivated</td></tr>
                        </table>
                    </body>
                </html>';
        $headers = array('Content-Type: text/html; charset=UTF-8','From: Jacro <support@jacro.com>');  
        if($wpdb) {
            wp_mail( $to, $subject, $body, $headers);
        }     
	}
	add_action( 'deactivated_plugin', 'pluign_deactivated_record');
}

// Plugin delete log
if(!function_exists('pluign_delete_record')) {
	function pluign_delete_record( $plugin_file ) {
	    global $wpdb;     
        $plugin_name = strtok($plugin_file, "/");
        $wp_track_table = $wpdb->prefix . 'jacro_logs';
        $user_id = get_current_user_id();
        $user_detail = get_user_by( 'id', $user_id );
        $user_name = $user_detail->display_name;
        $ip_address =  getIP();
        $current_time = date("Y/m/d h:i:sa");
        $wpdb->insert($wp_track_table, array('user_id' => $user_id, 'ip_address' => $ip_address, 'changed_page' => $new_time_setting, 'created' => $current_time));
        $to = to_email();
        $subject = 'Jacro Website Changes Log';
        $body = '<html>
                    <body>
                        <table rules="all" cellpadding="10" style="border: 1px solid black;border-collapse: collapse;">
                            <tr><td>Date/Time</td><td>'.$current_time.'</td></tr>    
                            <tr><td>User</td><td>'.$user_name.'</td></tr>
                            <tr><td>IP</td><td>'.$ip_address.'</td></tr>
                            <tr><td>Context</td><td>plugins</td></tr>
                            <tr><td>Info</td><td>'.$plugin_name.'</td></tr>
                            <tr><td>Action</td><td>deleted</td></tr>
                        </table>
                    </body>
                </html>';
        $headers = array('Content-Type: text/html; charset=UTF-8','From: Jacro <support@jacro.com>');
        if($wpdb) {
            wp_mail( $to, $subject, $body, $headers);
        }  
    }
	add_action( 'deleted_plugin', 'pluign_delete_record', 10, 3 );
}

// Theme switch log
if(!function_exists('switch_my_theme')) {
	function switch_my_theme( $new_name ) {
	    global $wpdb;     
        $wp_track_tablee = $wpdb->prefix.'jacro_logs';
        $user_id = get_current_user_id();
        $user_detail = get_user_by( 'id', $user_id );
        $user_name = $user_detail->display_name; 
        $ip_address =  getIP();
        $current_time = date("Y/m/d h:i:sa");
        $wpdb->insert($wp_track_tablee, array('user_id' => $user_id, 'ip_address' => $ip_address, 'changed_page' => $new_time_setting, 'created' => $current_time));
        $to = to_email();
        $subject = 'Jacro Website Changes Log';
        $body = '<html>
                    <body>
                        <table rules="all" cellpadding="10" style="border: 1px solid black;border-collapse: collapse;">
                            <tr><td>Date/Time</td><td>'.$current_time.'</td></tr>    
                            <tr><td>User</td><td>'.$user_name.'</td></tr>
                            <tr><td>IP</td><td>'.$ip_address.'</td></tr>
                            <tr><td>Context</td><td>themes</td></tr>
                            <tr><td>Info</td><td>'.$new_name.'</td></tr>
                            <tr><td>Action</td><td>updated</td></tr>
                        </table>
                    </body>
                </html>';
        $headers = array('Content-Type: text/html; charset=UTF-8','From: Jacro <support@jacro.com>');
        if($wpdb) {
            wp_mail( $to, $subject, $body, $headers);
        }
	}
	add_action( 'switch_theme', 'switch_my_theme', 10, 3 );
}

// Delete theme log
if(!function_exists('delete_my_theme')) {
	function delete_my_theme( $stylesheet, $deleted ) {
	    global $wpdb;     
        $wp_track_tablee = $wpdb->prefix.'jacro_logs';
        $user_id = get_current_user_id();
        $user_detail = get_user_by( 'id', $user_id );
        $user_name = $user_detail->display_name; 
        $ip_address =  getIP();
        $current_time = date("Y/m/d h:i:sa");
        $wpdb->insert($wp_track_tablee, array('user_id' => $user_id, 'ip_address' => $ip_address, 'changed_page' => $new_time_setting, 'created' => $current_time));
        $to = to_email();
        $subject = 'Jacro Website Changes Log';
        $body = '<html>
                    <body>
                        <table rules="all" cellpadding="10" style="border: 1px solid black;border-collapse: collapse;">
                            <tr><td>Date/Time</td><td>'.$current_time.'</td></tr>    
                            <tr><td>User</td><td>'.$user_name.'</td></tr>
                            <tr><td>IP</td><td>'.$ip_address.'</td></tr>
                            <tr><td>Context</td><td>themes</td></tr>
                            <tr><td>Info</td><td>'.$stylesheet.'</td></tr>
                            <tr><td>Action</td><td>deleted</td></tr>
                        </table>
                    </body>
                </html>';
        $headers = array('Content-Type: text/html; charset=UTF-8','From: Jacro <support@jacro.com>');
        if($wpdb) {
            wp_mail( $to, $subject, $body, $headers);
        }
	}
	add_action( 'deleted_theme', 'delete_my_theme', 10, 2 );
}

// Jacro ticket setting update log
if(!function_exists('jacro_settings_updated_noti')) {
	function jacro_settings_updated_noti( $stylesheet, $deleted ) {
	    global $wpdb;     
        $wp_track_tablee = $wpdb->prefix.'jacro_logs';
        $user_id = get_current_user_id();
        $user_detail = get_user_by( 'id', $user_id );
        $user_name = $user_detail->display_name; 
        $ip_address =  getIP();
        $current_time = date("Y/m/d h:i:sa");
        $wpdb->insert($wp_track_tablee, array('user_id' => $user_id, 'ip_address' => $ip_address, 'changed_page' => $new_time_setting, 'created' => $current_time));
        $to = to_email();
        $subject = 'Jacro Website Changes Log';
        $body = '<html>
                    <body>
                        <table rules="all" cellpadding="10" style="border: 1px solid black;border-collapse: collapse;">
                            <tr><td>Date/Time</td><td>'.$current_time.'</td></tr>    
                            <tr><td>User</td><td>'.$user_name.'</td></tr>
                            <tr><td>IP</td><td>'.$ip_address.'</td></tr>
                            <tr><td>Context</td><td>themes</td></tr>
                            <tr><td>Info</td><td>'.$stylesheet.'</td></tr>
                            <tr><td>Action</td><td>updated</td></tr>
                        </table>
                    </body>
                </html>';
        $headers = array('Content-Type: text/html; charset=UTF-8','From: Jacro <support@jacro.com>');
        if($wpdb) {
            wp_mail( $to, $subject, $body, $headers);
        }
	}
}
?>