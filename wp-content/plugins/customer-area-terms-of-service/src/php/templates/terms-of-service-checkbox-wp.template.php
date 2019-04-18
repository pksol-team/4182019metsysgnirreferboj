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

<p class="cuar-tos-checkbox-form-register" style="margin-bottom: 15px;">
    <label for="cuar_tos_checkbox"> <input type="checkbox" id="cuar_tos_checkbox" name="<?php echo esc_attr($tos_field_name); ?>">
        <?php
        printf(__('By checking this box, you agree to our <a href="%s" target="_BLANK">terms of service</a> (required).', 'cuarts'),
            $tos_page_url);
        ?>
    </label>
</p>
