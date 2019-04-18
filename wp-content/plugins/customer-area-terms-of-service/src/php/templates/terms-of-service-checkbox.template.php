<?php
/** Template version: 1.0.0
 *
 * -= 1.0.0 =-
 * - Initial version
 *
 */
?>

<?php /** @var string $tos_page_url */ ?>
<?php /** @var string $tos_field_name */ ?>

<div class="cuar-tos-checkbox-form-register form-group">
    <div class="checkbox-custom checkbox mb-md">
        <input type="checkbox" id="cuar_tos_checkbox" name="<?php echo esc_attr($tos_field_name); ?>"> <label for="cuar_tos_checkbox">
            <?php
            printf(__('By checking this box, you agree to our <a href="%s" target="_BLANK" class="btn btn-default btn-xs">terms of service</a> (required).', 'cuarts'),
                $tos_page_url);
            ?>
        </label>
    </div>
</div>
