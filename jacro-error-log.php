<div class="wrap col-md-12">
    <h2>Error Log</h2>
    <div class="clean-option">
    <a onclick="return confirm('Are you sure you want to cleare error log ?','0')" id="clear_error_log" class="button button-primary" href="?page=jacro-clear-error">Clear Error Log</a>
  </div>
    <div class="row wrap">
        <?php
            global $wpdb; $table_name = $wpdb->prefix . 'jacro_error';
            $time = current_time( 'Y-m-d    H:i:s' );
            $error_datas = $wpdb->get_results("SELECT * FROM $table_name");
        ?>
        <table id='' class='wp-list-table widefat fixed appearance_page_machine-list'>
            <thead>
                <tr>
                    <th><?php _e('Error Type','jacro'); ?></th>
                    <th><?php _e('Error Details','jacro'); ?></th>
                    <th><?php _e('Error Time','appraisal-app'); ?></th>
                </tr>
            </thead>
            <tbody id="">
                <?php foreach( $error_datas as $error ) : ?>
                    <tr>
                        <td><?php echo $error->error_type; ?></td>
                        <td><?php echo $error->error_detail; ?></td>
                        <td><?php echo $error->error_time; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>