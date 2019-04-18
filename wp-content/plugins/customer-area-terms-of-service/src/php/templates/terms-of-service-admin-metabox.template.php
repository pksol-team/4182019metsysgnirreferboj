<?php
/** Template version: 1.0.0
 *
 * -= 1.0.0 =-
 * - Initial version
 *
 */

/** @var $tos_reset_field */
/** @var $tos_roles_without_agreement */
?>

<div id="cuar-tos-about-metabox" class="metabox-row">
    <h4><?php _e('How does it works?', 'cuarts'); ?></h4>

    <p>
        <?php _e('As soon as you add some content to this page, a checkbox will be displayed on the login and register pages to force your users to accept your terms of service. If you need some time to write this page, change the status of this page to draft so the checkboxes won\'t yet appear.', 'cuarts'); ?>
    </p>
</div>

<hr>

<div id="cuar-tos-permissions-metabox" class="metabox-row">
    <h4><?php _e('Roles that require agreement', 'cuarts'); ?></h4>

    <p><?php echo implode (', ', $tos_roles_without_agreement); ?></p>

    <p>
        <?php printf(__('You can adjust permissions to skip Terms of Service agreement for some roles on the <strong><a href="%s" title="WP Customer Area capabilities" target="_BLANK">capabilities page</a> > General > Terms of Service</strong>.', 'cuarts'),
            admin_url('admin.php?page=wpca-settings&tab=cuar_capabilities')
        ); ?>
    </p>
</div>

<hr>

<div id="cuar-tos-reset-metabox" class="metabox-row">
    <h4><?php _e('Reset', 'cuarts'); ?></h4>

    <input type="checkbox" name="<?php echo $tos_reset_field; ?>" id="cuar_ts_reset_terms_of_service_checkbox">
    <label for="cuar_ts_reset_terms_of_service_checkbox" class="post-attributes-label"><?php _e('Reset agreements', 'cuarts'); ?></label>
    <p class="description">
        <?php _e('Check this box to reset terms of service agreements for all users. This is useful when you have updated the terms and want your users to validate them again.', 'cuarts'); ?>
    </p>
</div>
