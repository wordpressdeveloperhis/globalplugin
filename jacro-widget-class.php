<?php
/**
*   Jacro Custom Widgets
*/

/** Jacro Show Time Widget **/
class JacroWidget extends WP_Widget {

    /** Custom Widget init **/
	public function __construct() {
        $widget_ops = array('description'=>__('Add form in sidebar', 'jacro'), 'classname' => 'jacro-filters jacro-widgets');
        parent::__construct( 'JacroWidget', 'Jacro', $widget_ops );
	}

	/** Display Widget **/
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		// before and after widget arguments are defined by themes
		$title='';
		echo $args['before_widget'];
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];
        $switch_filter = $instance['jacro-filter-switch'];
		// This is where you run the code and display the output
		$jacroWidget = new JacroWidgetsCall();
		$jacroWidget->JacroShowTimeWidget($switch_filter);
		echo $args['after_widget'];
	}

    public function form($instance) {
        $jacro_filter_switch = ! empty( $instance['jacro-filter-switch'] ) ? $instance['jacro-filter-switch'] : '';
        ?>
        <p>
            <label for="jacro-filter-switch"><?php _e('Cinema &raquo; Dates &raquo; Films ',''); ?>
            <input class="widefat select-numpost" id="<?php echo esc_attr($this->get_field_id( 'jacro-filter-switch' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'jacro-filter-switch' )); ?>" id="jacro-filter-switch" type="radio" value="cinema-dates-films" <?php echo (($jacro_filter_switch=='cinema-dates-films')?'checked="checked"':''); ?>></label></br>
            <label for="jacro-filter-switch"><?php _e('Cinema &raquo; Films &raquo; Dates ',''); ?>
            <input class="widefat select-numpost" id="<?php echo esc_attr($this->get_field_id( 'jacro-filter-switch' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'jacro-filter-switch' )); ?>" id="jacro-filter-switch" type="radio" value="cinema-films-dates" <?php echo (($jacro_filter_switch=='cinema-films-dates')?'checked="checked"':''); ?>></label>
        </p><?php
    }

	/** Custom Widget Save Data **/
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['jacro-filter-switch'] = ( ! empty( $new_instance['jacro-filter-switch'] ) ) ? strip_tags( $new_instance['jacro-filter-switch'] ) : '';
		return $instance;
	}
}

/** Jacro Image Widget **/
class JacroAppDownload extends WP_Widget {

    /** Custom Widget init **/
    public function __construct() {
        $widget_ops = array('classname' => 'JacroAppDownload jacro-widgets');
        parent::__construct( 'jacro-image-widget', 'Jacro App Download', $widget_ops );
    }

    /** Display Widget **/
    public function widget($args, $instance) {
        extract($args);
        echo $before_widget;
        $jacroWidget = new JacroWidgetsCall();
		$jacroWidget->JacroAppDownloadWidget($instance);
    	echo $after_widget; 
	}

    /** Custom Widget Form **/
    public function form($instance) {
        $jacroAppDownloadTitle = ! empty( $instance['jacro-app-download-title'] ) ? $instance['jacro-app-download-title'] : '';
        $jacroGoogleAppLink = ! empty( $instance['jacro-google-app-link'] ) ? $instance['jacro-google-app-link'] : '';
        $jacroIphoneAppLink = ! empty( $instance['jacro-iphone-app-link'] ) ? $instance['jacro-iphone-app-link'] : '';
        $jacroAppDownloadDiscription = ! empty( $instance['jacro-app-download-discription'] ) ? $instance['jacro-app-download-discription'] : '';
        ?>
        <p>
            <label for=""><?php _e('Title',''); ?></label><br />
            <input class="widefat select-numpost" id="<?php echo esc_attr($this->get_field_id( 'jacro-app-download-title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'jacro-app-download-title' )); ?>" type="text" value="<?php echo esc_attr( $jacroAppDownloadTitle ); ?>">
        </p>
        <p>
            <label for=""><?php _e('Google App Link',''); ?></label><br />
            <input class="widefat select-numpost" id="<?php echo esc_attr($this->get_field_id( 'jacro-google-app-link' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'jacro-google-app-link' )); ?>" type="url" value="<?php echo esc_attr( $jacroGoogleAppLink ); ?>">
        </p>
        <p>
            <label for=""><?php _e('Iphone App Link',''); ?></label><br />
            <input class="widefat select-numpost" id="<?php echo esc_attr($this->get_field_id( 'jacro-iphone-app-link' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'jacro-iphone-app-link' )); ?>" type="url" value="<?php echo esc_attr( $jacroIphoneAppLink ); ?>">
        </p>
        <p>
            <label for=""><?php _e('Discription',''); ?></label><br />
            <textarea class="widefat select-numpost" id="<?php echo esc_attr($this->get_field_id( 'jacro-app-download-discription' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'jacro-app-download-discription' )); ?>"><?php echo esc_attr( $jacroAppDownloadDiscription ); ?></textarea>
        </p><?php
    }

    /** Custom Widget Save Data **/
    public function update($new_instance, $old_instance) {
        $instance[] = $old_instance;
        $instance['jacro-app-download-title'] = ! empty( $new_instance['jacro-app-download-title'] ) ? esc_attr($new_instance['jacro-app-download-title']) : '';
        $instance['jacro-google-app-link'] = ! empty( $new_instance['jacro-google-app-link'] ) ? esc_attr($new_instance['jacro-google-app-link']) : '';
        $instance['jacro-iphone-app-link'] = ! empty( $new_instance['jacro-iphone-app-link'] ) ? esc_attr($new_instance['jacro-iphone-app-link']) : '';
        $instance['jacro-app-download-discription'] = ! empty( $new_instance['jacro-app-download-discription'] ) ? esc_attr($new_instance['jacro-app-download-discription']) : '';
        return $instance;
    }
}

/** Jacro Gift Card Widget **/
class jacroGiftCard extends WP_Widget {

    /** Custom Widget init **/
    public function __construct() {
        $widget_ops = array('classname' => 'jacroGiftCard jacro-widgets');
        parent::__construct( 'jacro-gift-card-widget', 'Jacro Gift Card', $widget_ops );        
    }

    /** Display Widget **/
    public function widget($args, $instance) {
        extract($args);
        echo $before_widget;
        $jacroWidget = new JacroWidgetsCall();
        $jacroWidget->JacroGiftCardWidget($instance);
        echo $after_widget;
    }
    
    /** Custom Widget Form **/
    public function form($instance) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $giftCode = ! empty( $instance['giftCode'] ) ? $instance['giftCode'] : '';
        $giftCardImageUrl = ! empty( $instance['giftImageUrl'] ) ? $instance['giftImageUrl'] : ''; ?>
        <script type="text/javascript">
            jQuery(document).ready( function(){
                function media_upload1( button_class) {
                    var _custom_media = true,
                    _orig_send_attachment = wp.media.editor.send.attachment;
                    jQuery('body').on('click',button_class, function(e) {
                        var button_id ='#'+jQuery(this).attr('id');
                        console.log(button_id);
                        var self = jQuery(button_id);
                        var send_attachment_bkp = wp.media.editor.send.attachment;
                        var button = jQuery(button_id);
                        var id = button.attr('id').replace('_button', '');
                        _custom_media = true;
                        wp.media.editor.send.attachment = function(props, attachment){
                            if ( _custom_media  ) {
                                jQuery('.custom_media_id').val(attachment.id);
                                jQuery('.custom_media_url1').val(attachment.url);
                                jQuery('.custom_media_image1').attr('src',attachment.url).css('display','block');   
                            } else {
                                return _orig_send_attachment.apply( button_id, [props, attachment] );
                            }
                        }
                        wp.media.editor.open(button);
                        return false;
                    });
                }
                media_upload1( '.custom_media_upload1');
            });
        </script>
        <p>
            <label for=""><?php _e('Title',''); ?></label><br />
            <input class="widefat select-numpost" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('giftImageUrl'); ?>"><?php _e('Gift Card Image', 'themename'); ?></label><br />
            <?php if(!empty($instance['giftImageUrl'])){ ?>
                <img class="custom_media_image1" src="<?php echo $instance['giftImageUrl']; ?>" style="margin:0;padding:0;max-width:100px;float:left;display:inline-block" />
            <?php } ?>
            <input type="text" class="widefat custom_media_url1" name="<?php echo $this->get_field_name('giftImageUrl'); ?>" id="<?php echo $this->get_field_id('giftImageUrl'); ?>" value="<?php echo $instance['giftImageUrl']; ?>">
            <input type="button" value="<?php _e( 'Upload Image', 'themename' ); ?>" class="button custom_media_upload1" id="jacroGiftCardImageUplaod"/>        
        </p>
        <p>
            <label for=""><?php _e('Gift Code',''); ?></label><br />
            <input class="widefat select-numpost" id="<?php echo esc_attr($this->get_field_id( 'giftCode' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'giftCode' )); ?>" type="url" value="<?php echo esc_attr( $giftCode ); ?>">
        </p><?php
    }

    /** Custom Widget Save Data **/
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? esc_html( $new_instance['title'] ) : '';
        $instance['giftCode'] = ( ! empty( $new_instance['giftCode'] ) ) ? esc_html( $new_instance['giftCode'] ) : '';
        $instance['giftImageUrl'] = ( ! empty( $new_instance['giftImageUrl'] ) ) ? esc_html( $new_instance['giftImageUrl'] ) : '';
        return $instance;
    }
}
?>