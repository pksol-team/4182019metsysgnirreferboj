<?php
/**
 * Show job application when viewing a single job listing.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/job-application.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     WP Job Manager
 * @category    Template
 * @version     1.16.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<?php if ( $apply = get_the_job_application_method() ) :
	if ( $apply->type === 'url' ) {
	    $application_href = $apply->url;
	} elseif ( $apply->type === 'email' ) {
	    $application_href = sprintf( 'mailto:%1$s%2$s', $apply->email, '?subject=' . rawurlencode( $apply->subject )  );
	}
	?>
	<div class="application">
		<a style="width:1008px;" class="application_button button" href="<?php echo $application_href; ?>"><?php _e( 'Apply for job', 'wp-job-manager' ); ?></a>
	</div>



	<div class="col-lg-12 row" style="padding: 0;">

		<div class="col-lg-2">
			<a style="width:100%" class="application_button button button-vouch" href="javascript:void(0)"><?php _e( 'Vouch', 'wp-job-manager' ); ?></a>
		</div>

		<div class="col-lg-8" style="display: none;">
			<input type="text" name="email" id="email-vouch" placeholder="<?php _e( 'Email', 'wp-job-manager' ); ?>">
		</div>

		<div class="col-lg-2" style="display: none;">
			<button class="application_button button button_send_vouch">Send</button>
		</div>
		
	</div>
	<br>
		
	

<?php endif; ?>

