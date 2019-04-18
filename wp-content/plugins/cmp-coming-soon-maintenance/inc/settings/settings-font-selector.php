<?php 
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

?>

<div class="table-wrapper theme-setup font-selector">
    <h3><?php _e('Customize Fonts', 'cmp-coming-soon-maintenance');?></h3>
    <table class="theme-setup">
    <tbody>
    <tr>
        <th><?php _e('Headings Font', 'cmp-coming-soon-maintenance');?></th>
        <td>
            <fieldset>
                <label for="niteoCS_font_headings_<?php echo esc_attr( $themeslug );?>"><?php _e('Font Family from ', 'cmp-coming-soon-maintenance');?><a href="https://fonts.google.com" target="_blank"><?php _e('Google Fonts', 'cmp-coming-soon-maintenance');?></a></label><br>
                <select id="niteoCS_font_headings_<?php echo esc_attr( $themeslug );?>" class="headings-google-font" name="niteoCS_font_headings_<?php echo esc_attr( $themeslug );?>">
                    <option value="<?php echo esc_attr( $heading_font['family'] ); ?>" selected="selected"><?php echo esc_html( $heading_font['family'] ); ?></option>
                </select>
            </fieldset>

            <fieldset>
                <label for="niteoCS_font_headings_variant_<?php echo esc_attr( $themeslug );?>"><?php _e('Variant', 'cmp-coming-soon-maintenance');?></label><br>
                <select id="niteoCS_font_headings_variant_<?php echo esc_attr( $themeslug );?>" class="headings-google-font-variant" name="niteoCS_font_headings_variant_<?php echo esc_attr( $themeslug );?>">
                    <option value="<?php echo esc_attr( $heading_font['variant'] ); ?>" selected="selected"><?php echo esc_html( $this->cmp_google_variant_title( $heading_font['variant'] ) ); ?></option>
                </select>
            </fieldset>

            <?php 
            if ( $this->cmp_selectedTheme() !== 'mercury' ) { ?>

            <fieldset>
                <label for="niteoCS_font_headings_size_<?php echo esc_attr( $themeslug );?>"><?php _e('Font Size', 'cmp-coming-soon-maintenance');?>: <span><?php echo esc_attr( $heading_font['size'] ); ?></span>px</label><br>
                <input type="range" id="niteoCS_font_headings_size_<?php echo esc_attr( $themeslug );?>" name="niteoCS_font_headings_size_<?php echo esc_attr( $themeslug );?>" min="10" max="75" step="1" value="<?php echo esc_attr( $heading_font['size'] ); ?>" data-css="font-size" data-type="heading" />
            </fieldset>
            <?php } ?>

            <fieldset>
                <label for="niteoCS_font_headings_spacing_<?php echo esc_attr( $themeslug );?>"><?php _e('Letter Spacing', 'cmp-coming-soon-maintenance');?>: <span><?php echo esc_attr( $heading_font['spacing'] ); ?></span>px</label><br>
                <input type="range" id="niteoCS_font_headings_spacing_<?php echo esc_attr( $themeslug );?>" name="niteoCS_font_headings_spacing_<?php echo esc_attr( $themeslug );?>" min="0" max="10" step="0.5" value="<?php echo esc_attr( $heading_font['spacing'] ); ?>" data-css="letter-spacing" data-type="heading" />
            </fieldset>

            <?php 
            // include theme animation settings
            if ( in_array( $this->cmp_selectedTheme(), $this->cmp_font_animation_themes() ) ) { ?>

                <fieldset>
                    <label for="niteoCS_heading_animation_<?php echo esc_attr( $themeslug );?>"><?php _e('Animation', 'cmp-coming-soon-maintenance');?></label><br>
                    <select id="niteoCS_heading_animation_<?php echo esc_attr( $themeslug );?>" name="niteoCS_heading_animation_<?php echo esc_attr( $themeslug );?>" class="heading-animation">
                        <option value="none" <?php if ( $niteoCS_heading_animation == 'none' ) { echo ' selected="selected"'; } ?>><?php _e('No animation', 'cmp-coming-soon-maintenance');?></option>
                        <option value="fadeInDown" <?php if ( $niteoCS_heading_animation == 'fadeInDown' ) { echo ' selected="selected"'; } ?>><?php _e('Fade In Down', 'cmp-coming-soon-maintenance');?></option>
                        <option value="fadeInUp" <?php if ( $niteoCS_heading_animation == 'fadeInUp' ) { echo ' selected="selected"'; } ?>><?php _e('Fade In Up', 'cmp-coming-soon-maintenance');?></option>
                        <option value="fadeInLeft" <?php if ( $niteoCS_heading_animation == 'fadeInLeft' ) { echo ' selected="selected"'; } ?>><?php _e('Fade In Left', 'cmp-coming-soon-maintenance');?></option>
                        <option value="fadeInRight" <?php if ( $niteoCS_heading_animation == 'fadeInRight' ) { echo ' selected="selected"'; } ?>><?php _e('Fade In Right', 'cmp-coming-soon-maintenance');?></option>
                    </select><br>
                </fieldset>
            <?php 
            } ?>

        </td>
    </tr>

    <tr>
        <th><?php _e('Content Font', 'cmp-coming-soon-maintenance');?></th>
        <td>

            <fieldset>
                <label for="niteoCS_font_content_<?php echo esc_attr( $themeslug );?>"><?php _e('Select Font Family from ', 'cmp-coming-soon-maintenance');?><a href="https://fonts.google.com" target="_blank">Google Fonts</a></label><br>
                <select id="niteoCS_font_content_<?php echo esc_attr( $themeslug );?>" class="content-google-font" name="niteoCS_font_content_<?php echo esc_attr( $themeslug );?>">
                    <option value="<?php echo esc_attr( $content_font['family'] ); ?>" selected="selected"><?php echo esc_html( $content_font['family'] ); ?></option>
                </select>
            </fieldset>

            <fieldset>
                <label for="niteoCS_font_content_variant_<?php echo esc_attr( $themeslug );?>"><?php _e('Variant', 'cmp-coming-soon-maintenance');?></label><br>
                <select id="niteoCS_font_content_variant_<?php echo esc_attr( $themeslug );?>" class="content-google-font-variant" name ="niteoCS_font_content_variant_<?php echo esc_attr( $themeslug );?>">
                    <option value="<?php echo esc_attr( $content_font['variant'] ); ?>" selected="selected"><?php echo esc_html( $this->cmp_google_variant_title( $content_font['variant'] ) ); ?></option>
                </select>
            </fieldset>

            <fieldset>
                <label for="niteoCS_font_content_size_<?php echo esc_attr( $themeslug );?>"><?php _e('Font Size', 'cmp-coming-soon-maintenance');?>: <span><?php echo esc_attr( $content_font['size'] ); ?></span>px</label><br>
                <input id="niteoCS_font_content_size_<?php echo esc_attr( $themeslug );?>" type="range" name="niteoCS_font_content_size_<?php echo esc_attr( $themeslug );?>" min="10" max="50" step="1" value="<?php echo esc_attr( $content_font['size'] ); ?>" data-css="font-size" data-type="content" />
            </fieldset>

            <fieldset>
                <label for="niteoCS_font_content_spacing_<?php echo esc_attr( $themeslug );?>"><?php _e('Letter Spacing', 'cmp-coming-soon-maintenance');?>: <span><?php echo esc_attr( $content_font['spacing'] ); ?></span>px</label><br>
                <input id="niteoCS_font_content_spacing_<?php echo esc_attr( $themeslug );?>" type="range" name="niteoCS_font_content_spacing_<?php echo esc_attr( $themeslug );?>" min="0" max="10" step="0.5" value="<?php echo esc_attr( $content_font['spacing'] ); ?>" data-css="letter-spacing" data-type="content" />
            </fieldset>

            <fieldset>
                <label for="niteoCS_font_content_lineheight_<?php echo esc_attr( $themeslug );?>"><?php _e('Line Height', 'cmp-coming-soon-maintenance');?>: <span><?php echo esc_attr( $content_font['line-height'] ); ?></span></label><br>
                <input id="niteoCS_font_content_lineheight_<?php echo esc_attr( $themeslug );?>" type="range" name="niteoCS_font_content_lineheight_<?php echo esc_attr( $themeslug );?>" min="1.3" max="3.0" step="0.1" value="<?php echo esc_attr( $content_font['line-height'] ); ?>" data-css="line-height" data-type="content" />
            </fieldset>
            <?php 
            // include theme animation settings
            if ( in_array( $this->cmp_selectedTheme(), $this->cmp_font_animation_themes() ) ) { ?>

                <fieldset>
                    <label for="niteoCS_content_animation_<?php echo esc_attr( $themeslug );?>"><?php _e('Select Animation', 'cmp-coming-soon-maintenance');?></label><br>
                    <select id="niteoCS_content_animation_<?php echo esc_attr( $themeslug );?>" name="niteoCS_content_animation_<?php echo esc_attr( $themeslug );?>" class="content-animation">
                        <option value="none" <?php if ( $niteoCS_content_animation == 'none' ) { echo ' selected="selected"'; } ?>><?php _e('No animation', 'cmp-coming-soon-maintenance');?></option>
                        <option value="fadeInDown" <?php if ( $niteoCS_content_animation == 'fadeInDown' ) { echo ' selected="selected"'; } ?>><?php _e('Fade In Down', 'cmp-coming-soon-maintenance');?></option>
                        <option value="fadeInUp" <?php if ( $niteoCS_content_animation == 'fadeInUp' ) { echo ' selected="selected"'; } ?>><?php _e('Fade In Up', 'cmp-coming-soon-maintenance');?></option>
                        <option value="fadeInLeft" <?php if ( $niteoCS_content_animation == 'fadeInLeft' ) { echo ' selected="selected"'; } ?>><?php _e('Fade In Left', 'cmp-coming-soon-maintenance');?></option>
                        <option value="fadeInRight" <?php if ( $niteoCS_content_animation == 'fadeInRight' ) { echo ' selected="selected"'; } ?>><?php _e('Fade In Right', 'cmp-coming-soon-maintenance');?></option>
                    </select><br>
                </fieldset>
            <?php 
            } ?>

            <p style="margin-bottom:0"><?php _e('Fonts preview', 'cmp-coming-soon-maintenance');?></p>
            <div id="font-example-wrapper">
                <h3 id="heading-example" class="animated <?php echo esc_attr($niteoCS_heading_animation);?>" style="font-size:<?php echo esc_attr( $heading_font['size'] );?>px;letter-spacing:<?php echo esc_attr( $heading_font['spacing'] );?>px">Hello, I am your Headings font!</h3>
                <p id="content-example" class="animated <?php echo esc_attr($niteoCS_content_animation);?>" style="font-size:<?php echo esc_attr( $content_font['size'] );?>px;letter-spacing:<?php echo esc_attr( $content_font['spacing']  );?>px;line-height:<?php echo esc_attr( $content_font['line-height'] );?>">And this is a long paragraph. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>

        </td>
        
    </tr>

    <?php echo $this->render_settings->submit(); ?>

    </tbody>
    </table>

</div>