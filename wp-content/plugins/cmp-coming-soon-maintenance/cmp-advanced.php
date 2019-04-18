<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// check onces and wordpress rights, else DIE
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	if( !wp_verify_nonce($_POST['save_options_field'], 'save_options') || !current_user_can('publish_pages') ) {
		die('Sorry, but this request is invalid');
	}
}

// get all wp pages to array(id->name);
$pages = $this->cmp_get_pages();

if ( isset( $_POST['niteoCS_bypass_id'] ) ) {
	if ( $_POST['niteoCS_bypass_id'] == '' ) {
		update_option('niteoCS_bypass_id', md5( get_home_url() ));
	} else {
		update_option('niteoCS_bypass_id', sanitize_text_field( $_POST['niteoCS_bypass_id'] ));
	}
	
}

if ( isset( $_POST['niteoCS_bypass'] ) && is_numeric($_POST['niteoCS_bypass']) ) {
	update_option('niteoCS_bypass', sanitize_text_field( $_POST['niteoCS_bypass'] ));
}

if ( isset( $_POST['niteoCS_bypass_expire'] ) ) {
	if ( $_POST['niteoCS_bypass_expire'] == '' ) {
		update_option('niteoCS_bypass_expire', 172800);
	} else {
		update_option('niteoCS_bypass_expire', filter_var( $_POST['niteoCS_bypass_expire'], FILTER_SANITIZE_NUMBER_INT ));
	}
	
}

if ( isset( $_POST['niteoCS_page_filter'] ) ) {
	update_option('niteoCS_page_filter', sanitize_text_field( $_POST['niteoCS_page_filter'] ));
}

// update page whitelist if set
if ( isset( $_POST['niteoCS_page-whitelist'] ) ) {

	$whitelist = $_POST['niteoCS_page-whitelist'];
	$sane = false;

	foreach ( $whitelist as $id ) {
		if ( !is_numeric( $id ) ) {
			break;
		} else {
			$sane = true;
		}
	}

	if ( $sane ) {
		$whitelist_json = json_encode( $whitelist );
	}

	update_option('niteoCS_page_whitelist', sanitize_text_field( $whitelist_json ));

} else if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){
	update_option('niteoCS_page_whitelist', '[]');
}

if ( isset( $_POST['niteoCS-whitelist-custom'] ) ) {
	$url_list = explode("\r\n", $_POST['niteoCS-whitelist-custom']);

	if ( !empty( $url_list) && $url_list[0] !== '' ) {
		foreach ( $url_list as $url ) {
			if ( !empty($url) ) {
				$sanitized_whitelist[] = esc_url_raw( trailingslashit($url) );
			}
		}

		update_option('niteoCS_page_whitelist_custom', json_encode( array_filter($sanitized_whitelist) ));

	} else {
		update_option('niteoCS_page_whitelist_custom', '[]');
	}
}

// update page blacklist if set
if ( isset( $_POST['niteoCS_page-blacklist'] ) ) {

	$blacklist = $_POST['niteoCS_page-blacklist'];
	$sane = false;

	foreach ( $blacklist as $id ) {
		if ( !is_numeric( $id ) ) {
			break;
		} else {
			$sane = true;
		}
	}

	if ( $sane ) {
		$blacklist_json = json_encode( $blacklist );
	}

	update_option('niteoCS_page_blacklist', sanitize_text_field( $blacklist_json ));

} else if ($_SERVER['REQUEST_METHOD'] == 'POST' ){
	update_option('niteoCS_page_blacklist', '[]');
}

if ( isset( $_POST['niteoCS-blacklist-custom'] ) ) {
	$url_blacklist = explode("\r\n", $_POST['niteoCS-blacklist-custom']);

	if ( !empty( $url_blacklist) && $url_blacklist[0] !== '' ) {
		foreach ( $url_blacklist as $bl_url ) {
			if ( !empty($bl_url) ) {
				$sanitized_blacklist[] = esc_url_raw( trailingslashit($bl_url) );
			}
		}

		update_option('niteoCS_page_blacklist_custom', json_encode( array_filter($sanitized_blacklist) ));

	} else {
		update_option('niteoCS_page_blacklist_custom', '[]');
	}
}

// update cmp bypass roles if set
if ( isset( $_POST['niteoCS_roles'] ) ) {

	$roles = $_POST['niteoCS_roles'];
	$sane = false;

	foreach ( $roles as $id => $role ) {
		$roles[$id] = sanitize_text_field($role);
	}

	update_option('niteoCS_roles', json_encode( $roles ));
	
} else if ($_SERVER['REQUEST_METHOD'] == 'POST' ){
	update_option('niteoCS_roles', '[]');
}


// update cmp roles topbar access
if ( isset( $_POST['niteoCS_roles_topbar'] ) ) {

	$roles = $_POST['niteoCS_roles_topbar'];
	$sane = false;

	foreach ( $roles as $id => $role ) {
		$roles[$id] = sanitize_text_field($role);
	}

	update_option('niteoCS_roles_topbar', json_encode( $roles ));
	
} else if ($_SERVER['REQUEST_METHOD'] == 'POST' ){
	update_option('niteoCS_roles_topbar', '[]');
}

// update cmp roles topbar access
if ( isset( $_POST['niteoCS_head_scripts'] ) ) {

	$head_scripts = $_POST['niteoCS_head_scripts'];
	$sane = false;

	foreach ( $head_scripts as $id => $head_script ) {
		$h_scripts[$id] = sanitize_text_field($head_script);
	}

	update_option('niteoCS_head_scripts', json_encode( $h_scripts ));

} else if ($_SERVER['REQUEST_METHOD'] == 'POST' ){
	update_option('niteoCS_head_scripts', '[]');
}

// update cmp roles topbar access
if ( isset( $_POST['niteoCS_footer_scripts'] ) ) {

	$footer_scripts = $_POST['niteoCS_footer_scripts'];
	$sane = false;

	foreach ( $footer_scripts as $id => $footer_script ) {
		$f_scripts[$id] = sanitize_text_field( $footer_script );
	}

	update_option('niteoCS_footer_scripts', json_encode( $f_scripts ));
	
} else if ($_SERVER['REQUEST_METHOD'] == 'POST' ){
	update_option('niteoCS_footer_scripts', '[]');
}

$niteoCS_page_filter 			= get_option('niteoCS_page_filter', '0');
$niteoCS_page_whitelist			= json_decode(get_option('niteoCS_page_whitelist', '[]'), true);
$niteoCS_page_whitelist_custom	= json_decode(get_option('niteoCS_page_whitelist_custom', '[]'), true);
$niteoCS_page_blacklist			= json_decode(get_option('niteoCS_page_blacklist', '[]'), true);
$niteoCS_page_blacklist_custom	= json_decode(get_option('niteoCS_page_blacklist_custom', '[]'), true);
$niteoCS_roles					= json_decode(get_option('niteoCS_roles', '[]'), true);
$niteoCS_roles_topbar			= json_decode(get_option('niteoCS_roles_topbar', '[]'), true);
$head_scripts					= json_decode(get_option('niteoCS_head_scripts', '[]'), true);
$footer_scripts					= json_decode(get_option('niteoCS_footer_scripts', '[]'), true);
$bypass							= get_option('niteoCS_bypass', '0');
$bypass_id 						= get_option('niteoCS_bypass_id', md5( get_home_url() ));
$bypass_expire 					= get_option('niteoCS_bypass_expire', '172800');
$topbar_icon 					= get_option('niteoCS_topbar_icon', '1');

?>

<div class="wrap cmp-coming-soon-maintenance">

	<h1></h1>
	<div id="icon-users" class="icon32"></div>
	<div class="settings-wrap">
	<form method="post"	action="admin.php?page=cmp-advanced&status=settings-saved" id="csoptions">
		<?php wp_nonce_field('save_options','save_options_field'); ?>
		
		<div class="cmp-advanced">

			<div class="cmp-inputs-wrapper">

				<div class="table-wrapper general">

					<h3 class="no-icon"><?php _e('CMP Page Whitelist and Blacklist Settings', 'cmp-coming-soon-maintenance');?></h3>
					<table class="general">
						<tbody>
						<tr>

							<th>
								<fieldset>
									<legend class="screen-reader-text">
										<span><?php _e('Whitelist Settings', 'cmp-coming-soon-maintenance');?></span>
									</legend>

									<p>
										<label title="Page Whitelist">
										 	<input type="radio" class="page-whitelist" name="niteoCS_page_filter" value="1" <?php checked('1', $niteoCS_page_filter);?>><?php _e('Page Whitelist', 'cmp-coming-soon-maintenance');?>
										</label>
									</p>

									<p>
										<label title="Page Blacklist">
										 	<input type="radio" class="page-whitelist" name="niteoCS_page_filter" value="2" <?php checked('2', $niteoCS_page_filter);?>><?php _e('Page Blacklist', 'cmp-coming-soon-maintenance');?>
										</label>
									</p>

									<p>
										<label title="Disabled">
										 	<input type="radio" class="page-whitelist" name="niteoCS_page_filter" value="0" <?php checked('0', $niteoCS_page_filter);?>><?php _e('Disabled', 'cmp-coming-soon-maintenance');?>
										</label>
									</p>

								</fieldset>
							</th>

							<td>
								<fieldset class="page-whitelist-switch x1" style="margin-top: 1em;">
									<h4><?php _e('You can limit to display CMP Page only to specific pages.', 'cmp-coming-soon-maintenance');?></h4>
									<select name="niteoCS_page-whitelist[]" class="cmp-whitelist" multiple="multiple">
										<option value="-1" <?php echo in_array('-1', $niteoCS_page_whitelist) ? 'selected' : '';?>><?php _e('Homepage', 'cmp-coming-soon-maintenance');?></option>
										<?php
										foreach ( $pages as $page ) { ?>
											<option value="<?php echo esc_attr( $page['id'] );?>" <?php echo in_array($page['id'], $niteoCS_page_whitelist) ? 'selected' : ''; ?>><?php echo esc_attr( $page['name'] );?></option>
											<?php 
										} ?>
									</select>

									<p class="cmp-hint" style="margin-top:0"><?php _e('By default CMP is enabled on all pages. Leave this field empty to use default settings.', 'cmp-coming-soon-maintenance');?></p>
									
									<h4><?php _e('You can also add the Page URLs manually.', 'cmp-coming-soon-maintenance');?></h4>
									<textarea name="niteoCS-whitelist-custom" cols="40" rows="5"><?php 
										if ( !empty($niteoCS_page_whitelist_custom) ) {
											foreach ($niteoCS_page_whitelist_custom as $wl_url) {
												echo esc_url($wl_url) . PHP_EOL;
											}
										} ?></textarea>
								</fieldset>

								<fieldset class="page-whitelist-switch x2" style="margin-top: 1em;">
									<h4><?php _e('CMP Blacklist - Select the pages to NOT display CMP landing page.', 'cmp-coming-soon-maintenance');?></h4>
									<select name="niteoCS_page-blacklist[]" class="cmp-blacklist" multiple="multiple">
										<option value="-1" <?php echo in_array('-1', $niteoCS_page_blacklist) ? 'selected' : '';?>><?php _e('Homepage', 'cmp-coming-soon-maintenance');?></option>
										<?php
										foreach ( $pages as $page ) { ?>
											<option value="<?php echo esc_attr( $page['id'] );?>" <?php echo in_array($page['id'], $niteoCS_page_blacklist) ? 'selected' : '';?>><?php echo esc_attr( $page['name'] );?></option>
											<?php 
										} ?>
									</select>

									<p class="cmp-hint" style="margin-top:0"><?php _e('If you want to exclude some pages from CMP you can select them here.', 'cmp-coming-soon-maintenance');?></p>

									<h4><?php _e('You can also add the Page URLs manually.', 'cmp-coming-soon-maintenance');?></h4>
									<textarea name="niteoCS-blacklist-custom" cols="40" rows="5"><?php 
										if ( !empty($niteoCS_page_blacklist_custom) ) {
											foreach ($niteoCS_page_blacklist_custom as $bl_url) {
												echo esc_url($bl_url) . PHP_EOL;
											}
										} ?></textarea>
								</fieldset>

								<p class="cmp-hint page-whitelist-switch x1 x2" style="margin-top:0"><?php _e('Insert separate URL at each line. Please make sure your Permalinks work correctly!<br> You can also use asterisk (*) as a wildcard to match any string.', 'cmp-coming-soon-maintenance');?></p>

								<p class="page-whitelist-switch x0"><?php _e('CMP landing page is displayed on all pages by default. You can enable Page Whitelist to display CMP only on specific page(s) or Page Blacklist to exclude CMP landing page on specific page(s) by enabling Page Whitelist or Page Blacklist here.', 'cmp-coming-soon-maintenance');?></p>

							</td>
						</tr>

						<?php echo $this->render_settings->submit(); ?>

						</tbody>
					</table>

				</div>

				<div class="table-wrapper general">

					<h3 class="no-icon"><?php _e('CMP Bypass by User Roles', 'cmp-coming-soon-maintenance');?></h3>
					<table class="general">
						<tbody>
						<tr>
							<th>
								<fieldset>
									<legend class="screen-reader-text">
										<span><?php _e('User Roles Settings', 'cmp-coming-soon-maintenance');?></span>
									</legend>

									<p>
										<h4><?php _e('Bypass User Roles', 'cmp-coming-soon-maintenance');?></h4>
									</p>

								</fieldset>
							</th>

							<td>
								<fieldset style="margin-top: 1em;">
									<h4><?php _e('Select User Roles to bypass CMP landing page.', 'cmp-coming-soon-maintenance');?></h4>
									
									<select name="niteoCS_roles[]" class="cmp-user_roles" multiple="multiple">

										<?php 
										$roles = get_editable_roles();

										foreach ( $roles as $role => $details ) {

											if ( $role != 'administrator') { ?>
												<option value="<?php echo esc_attr($role);?>" <?php echo in_array($role, $niteoCS_roles) ? 'selected' : '';?>><?php echo esc_attr($details['name']);?></option>
												<?php 
											}
										} ?>

									</select>

									<p class="cmp-hint" style="margin-top:0"><?php _e('Administrator role always bypass CMP by default.', 'cmp-coming-soon-maintenance');?></p>

								</fieldset>

							</td>
						</tr>

						<?php echo $this->render_settings->submit(); ?>

						</tbody>
					</table>

				</div>

				<div class="table-wrapper general">
					<h3 class="no-icon"><?php _e('CMP Bypass URL', 'cmp-coming-soon-maintenance');?></h3>
					<table class="general">
						<tbody>
						<tr>

							<th>
								<fieldset>
									<legend class="screen-reader-text">
										<span><?php _e('Whitelist Settings', 'cmp-coming-soon-maintenance');?></span>
									</legend>

									<p>
										<label title="Page Whitelist">
										 	<input type="radio" class="cmp-bypass" name="niteoCS_bypass" value="1" <?php checked('1', $bypass);?>><?php _e('Enabled', 'cmp-coming-soon-maintenance');?>
										</label>
									</p>

									<p>
										<label title="Disabled">
										 	<input type="radio" class="cmp-bypass" name="niteoCS_bypass" value="0" <?php checked('0', $bypass);?>><?php _e('Disabled', 'cmp-coming-soon-maintenance');?>
										</label>
									</p>

								</fieldset>
							</th>

							<td>

								<fieldset class="cmp-bypass-switch x1" style="margin-top: 1em;">
									
									<h4 style="margin-bottom:0.5em"><?php _e('Bypass URL', 'cmp-coming-soon-maintenance');?></h4>
									<code><?php echo get_home_url().'/?cmp_bypass=' . $bypass_id;?></code>

									<p><?php _e('You can use this URL to bypass CMP maintenance page. Once you access your website with this URL, CMP Cookie will be set with default expiration of 2 days. If the cookie expires, you need to access your website again with this URL.', 'cmp-coming-soon-maintenance');?></p>

									<h4><?php _e('Set Bypass Passphrase', 'cmp-coming-soon-maintenance');?></h4>
									<input type="text" name="niteoCS_bypass_id" value="<?php echo esc_attr( $bypass_id ); ?>" class="regular-text code"><br>

									<p class="cmp-hint" style="margin-top:0"><?php _e('You can use passphrase which contains letters, numbers, underscores or dashes only.', 'cmp-coming-soon-maintenance');?></p>

									<h4><?php _e('Set bypass cookie Expiration Time in seconds', 'cmp-coming-soon-maintenance');?></h4>
									<input type="text" name="niteoCS_bypass_expire" value="<?php echo esc_attr( $bypass_expire ); ?>" class="regular-text code"><br>

									<p class="cmp-hint" style="margin-top:0"><?php _e('You can set custom Bypass CMP Cookie expiration time in seconds (1hour = 3600). Default expiration time is 2 days (172800).', 'cmp-coming-soon-maintenance');?></p>

									<p><?php _e('Please note this solution is using browser cookies which might not work correctly if you are using caching plugins.', 'cmp-coming-soon-maintenance');?></p>

								</fieldset>

								<p class="cmp-bypass-switch x0"><?php _e('You can Enable CMP Bypass where you can set custom URL parameter to bypass CMP page. You can send this URL to anyone who would like to sneak peak into your Website while it is under development or maintanence.', 'cmp-coming-soon-maintenance');?></p>

							</td>
						</tr>

						<?php echo $this->render_settings->submit(); ?>

						</tbody>
					</table>

				</div>

				<div class="table-wrapper general">

					<h3 class="no-icon"><?php _e('CMP Top Bar Icon', 'cmp-coming-soon-maintenance');?></h3>
					<table class="general">
						<tbody>

						<tr>
							<th>
								<fieldset>
									<legend class="screen-reader-text">
										<span><?php _e('CMP Top Bar Icon', 'cmp-coming-soon-maintenance');?></span>
									</legend>

									<p>
										<label title="Enabled">
										 	<input type="radio" class="cmp-topbar-icon" name="niteoCS_topbar_icon" value="1" <?php checked('1', $topbar_icon);?>><?php _e('Enabled', 'cmp-coming-soon-maintenance');?>
										</label>
									</p>

									<p>
										<label title="Disabled">
										 	<input type="radio" class="cmp-topbar-icon" name="niteoCS_topbar_icon" value="0" <?php checked('0', $topbar_icon);?>><?php _e('Disabled', 'cmp-coming-soon-maintenance');?>
										</label>
									</p>
								</fieldset>
							</th>

							<td>
								<fieldset class="cmp-topbar-icon-switch x1" style="margin-top: 1em;">
									<h4><?php _e('You can specify which roles have access to CMP Top Bar icon.', 'cmp-coming-soon-maintenance');?></h4>
									
									<select name="niteoCS_roles_topbar[]" class="cmp-user_roles" multiple="multiple">

										<?php 
										$roles = get_editable_roles();

										foreach ( $roles as $role => $details ) {

											if ( $role != 'administrator') { ?>
												<option value="<?php echo esc_attr($role);?>" <?php echo in_array( $role, $niteoCS_roles_topbar ) ? 'selected' : '';?>><?php echo esc_attr( $details['name'] );?></option>
												<?php 
											}
										} ?>

									</select>

									<p class="cmp-hint" style="margin-top:0"><?php _e('Administrator role can always access Top Bar Icon', 'cmp-coming-soon-maintenance');?></p>
								</fieldset>
								
								<div class="cmp-topbar-icon-switch x0">
									<p><?php _e('CMP Top Bar Icon is disabled.', 'cmp-coming-soon-maintenance');?></p>
									<img src="<?php echo plugins_url('/img/topbar.png', __FILE__);?>" alt="CMP Top Bar Icon">
									<p><?php _e(' If you enable it again, you can quickly enable or disable Coming Soon Mode or check out CMP Preview without visiting CMP Settings Plugin page.', 'cmp-coming-soon-maintenance');?></p>
								</div>

							</td>
						</tr>
						<?php echo $this->render_settings->submit(); ?>

						</tbody>
					</table>

				</div>

				<div class="table-wrapper general">

					<h3 class="no-icon"><?php _e('Custom External Scripts', 'cmp-coming-soon-maintenance');?></h3>
					<table class="general">
						<tbody>
						<tr>
							<th>
								<fieldset>
									<legend class="screen-reader-text">
										<span><?php _e('Add External Head Scripts', 'cmp-coming-soon-maintenance');?></span>
									</legend>

									<p>
										<h4><?php _e('Head Scripts', 'cmp-coming-soon-maintenance');?></h4>
									</p>
								</fieldset>
							</th>

							<td>
								<fieldset style="margin-top: 1em;">
									<h4><?php _e('Insert Javascript or CSS external file URL', 'cmp-coming-soon-maintenance');?></h4>
									<div id="wrapper-head_scripts">

										<div class="source-repeater-fields">
											<input type="text" name="niteoCS_head_scripts[]" value="<?php echo (empty( $head_scripts )) ? '' : esc_attr( $head_scripts[0] );?>" placeholder="Insert script full URL" class="regular-text code"><a href="#delete-head_scripts"><i class="fa fa-times" aria-hidden="true"></i></a>
										</div>

										<div class="target-repeater-fields">
											<?php 
											if ( count( $head_scripts ) > 1 ) {
												foreach ( $head_scripts as $id => $script ) {
													if ( $id != 0 ) {?>
													<input type="text" name="niteoCS_head_scripts[]" value="<?php echo esc_attr( $script );?>" placeholder="Insert full script full URL" class="regular-text code"><a href="#delete-head_scripts"><i class="fa fa-times" aria-hidden="true"></i></a>
													<?php 
													}
												}
											} ?>
										</div>

									</div>

									<button id="add-head_scripts" class="button"><?php _e('Add More', 'cmp-coming-soon-maintenance');?></button>
								</fieldset>

							</td>
						</tr>

						<tr>
							<th>
								<fieldset>
									<legend class="screen-reader-text">
										<span><?php _e('Add External Footer Scripts', 'cmp-coming-soon-maintenance');?></span>
									</legend>

									<p>
										<h4><?php _e('Footer Scripts', 'cmp-coming-soon-maintenance');?></h4>
									</p>
								</fieldset>
							</th>

							<td>
								<fieldset style="margin-top: 1em;">
									<h4><?php _e('Insert Javascript or CSS external file URL', 'cmp-coming-soon-maintenance');?></h4>
									<div id="wrapper-footer_scripts">

										<div class="source-repeater-fields">
											<input type="text" name="niteoCS_footer_scripts[]" value="<?php echo (empty( $footer_scripts )) ? '' : esc_attr( $footer_scripts[0] );?>" placeholder="Insert script full URL" class="regular-text code"><a href="#delete-footer_scripts"><i class="fa fa-times" aria-hidden="true"></i></a>
										</div>

										<div class="target-repeater-fields">
											<?php 
											if ( count( $footer_scripts ) > 1 ) {
												foreach ( $footer_scripts as $id => $footer_script ) {
													if ( $id != 0 ) {?>
													<input type="text" name="niteoCS_footer_scripts[]" value="<?php echo esc_attr( $footer_script );?>" placeholder="Insert script full URL" class="regular-text code"><a href="#delete-footer_scripts"><i class="fa fa-times" aria-hidden="true"></i></a>
													<?php 
													}
												}
											} ?>
										</div>

									</div>

									<button id="add-footer_scripts" class="button"><?php _e('Add More', 'cmp-coming-soon-maintenance');?></button>
								</fieldset>

							</td>
						</tr>

						<?php echo $this->render_settings->submit(); ?>

						</tbody>
					</table>

				</div>

			</div> <!-- <div class="cmp-inputs-wrapper"> -->

		</div> <!-- <div class="cmp-settings-wrapper"> -->

	</form>
	<?php 
	// get sidebar with "widgets"
	if ( file_exists(dirname(__FILE__) . '/cmp-sidebar.php') ) {
		require (dirname(__FILE__) . '/cmp-sidebar.php');
	}

	?>
	</div>
</div> <!-- <div id="wrap"> -->

<script>
jQuery(document).ready(function($) {
	toggle_settings('page-whitelist');
	toggle_settings('cmp-bypass');
	toggle_settings('cmp-topbar-icon');

	function toggle_settings ( classname ) {
		// Logo type inputs
		jQuery('.'+classname).change(function() {
			var value = jQuery('.'+classname+':checked' ).val();
			value = ( jQuery.isNumeric(value) ) ? 'x'+value : value;

			jQuery('.'+classname+'-switch.'+value).css('display','block');
			jQuery('.'+classname+'-switch:not(.'+value+')').css('display','none');
		});

		jQuery('.'+classname).first().trigger('change');
	}

	jQuery('.cmp-whitelist, .cmp-blacklist, .cmp-user_roles').select2({
		width: 'calc(100% - 1em)',
		placeholder: 'Click to select..',

	});

	cmp_repeat_fields('head_scripts');
	cmp_repeat_fields('footer_scripts');

	function cmp_repeat_fields( field_id ) {
		jQuery('#add-' + field_id).click(function(e){
			e.preventDefault();
			var $wrapper = jQuery('#wrapper-' + field_id);
			var $target = jQuery('#wrapper-' + field_id + ' .target-repeater-fields');
			var $fields = $wrapper.find('.source-repeater-fields').children().clone();
			$($fields[0]).val('');
			$($target).append($fields);
		});

		cmp_delete_field( field_id );
	}

	function cmp_delete_field( field_id ) {
		jQuery('#wrapper-' + field_id + ' .target-repeater-fields' ).on('click', 'a[href=#delete-' + field_id + ']', function(e){
			e.preventDefault();
			$(this).prev().remove();
			$(this).remove();
		});

		jQuery('#wrapper-' + field_id + ' .source-repeater-fields' ).on('click', 'a[href=#delete-' + field_id + ']', function(e){
			e.preventDefault();
			$(this).prev().val('');
		});
	}
});
</script>
