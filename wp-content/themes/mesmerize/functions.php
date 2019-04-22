<?php

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 */

if ( ! defined('MESMERIZE_THEME_REQUIRED_PHP_VERSION')) {
    define('MESMERIZE_THEME_REQUIRED_PHP_VERSION', '5.3.0');
}

add_action('after_switch_theme', 'mesmerize_check_php_version');

function mesmerize_check_php_version()
{
    // Compare versions.
    if (version_compare(phpversion(), MESMERIZE_THEME_REQUIRED_PHP_VERSION, '<')) :
        // Theme not activated info message.
        add_action('admin_notices', 'mesmerize_php_version_notice');
        
        
        // Switch back to previous theme.
        switch_theme(get_option('theme_switched'));
        
        return false;
    endif;
}

function mesmerize_php_version_notice()
{
    ?>
    <div class="notice notice-alt notice-error notice-large">
        <h4><?php _e('Mesmerize theme activation failed!', 'mesmerize'); ?></h4>
        <p>
            <?php _e('You need to update your PHP version to use the <strong>Mesmerize</strong>.', 'mesmerize'); ?> <br/>
            <?php _e('Current php version is:', 'mesmerize') ?> <strong>
                <?php echo phpversion(); ?></strong>, <?php _e('and the minimum required version is ', 'mesmerize') ?>
            <strong><?php echo MESMERIZE_THEME_REQUIRED_PHP_VERSION; ?></strong>
        </p>
    </div>
    <?php
}

if (version_compare(phpversion(), MESMERIZE_THEME_REQUIRED_PHP_VERSION, '>=')) {
    require_once get_template_directory() . "/inc/functions.php";
    
     
    
    if ( ! mesmerize_can_show_cached_value("mesmerize_cached_kirki_style_mesmerize")) {
        
        if ( ! mesmerize_skip_customize_register()) {
            do_action("mesmerize_customize_register_options");
        }
    }
    
} else {
    add_action('admin_notices', 'mesmerize_php_version_notice');
}


add_action( 'wp_ajax_sending_invitation', 'sending_invitation' );

function sending_invitation() { 


    $email = $_POST['email'] . '<br>';
    $user = get_current_user_id() . '<br>';
    $send_date = date('M d,Y H:i:s a') . '<br>';
    $status = 'pending';
    $invitation_code = uniqid();

    global $wpdb;
    $invitation_table = $wpdb->prefix.'invitations';

    $data = array(
        'email' => $email,
        'user' => $user,
        'send_date' => $send_date,
        'status' => $status,
        'invitation_code' => $invitation_code
    );
        
    $wpdb->insert( $invitation_table, $data);

    // send mail



    die();

}



// add_action('user_register','registration_function');

// function registration_function($user_id){

//     update_option('test', 'working');
    
// }

add_action( 'wp_ajax_get_vouches', 'get_vouches' );
function get_vouches() { 

    global $wpdb;
    $invitation_table = $wpdb->prefix.'invitations';

    $user_id = get_current_user_id();
    
    $rows = $wpdb->get_results("SELECT * FROM $invitation_table WHERE user = $user_id", OBJECT);

    $table = '<table class="vouches_table">
                <tr>
                    <th>Email</th>
                    <th>Send Date</th>
                    <th>Accept Date</th>
                    <th>Status</th>
                </tr>
    ';

    if(count($rows) > 0) {
        
        foreach ($rows as $key => $row) {
            
            $accept_date = ($row->accept_date == '') ? '-' : $row->accept_date;

            $table .= '<tr>
                <td>'.$row->email.'</td>
                <td>'.$row->send_date.'</td>
                <td>'.$accept_date.'</td>
                <td>'.$row->status.'</td>
            </tr>';
        }

    } else {
        $table .= '<tr>' . _e( 'No Records Found', 'mesmerize' ) . '</tr>';
    }


    $table .= '</table>';

    echo $table;

    

    die();
}






