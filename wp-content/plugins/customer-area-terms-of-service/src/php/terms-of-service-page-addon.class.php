<?php
/*  Copyright 2013 MarvinLabs (contact@marvinlabs.com) */

require_once(CUAR_INCLUDES_DIR . '/core-classes/addon-page.class.php');

if ( !class_exists('CUAR_TermsOfServicePageAddOn')) :

    /**
     * Add-on to show the terms of service to the user in a page
     *
     * @author Vincent Prat @ MarvinLabs
     */
    class CUAR_TermsOfServicePageAddOn extends CUAR_AbstractPageAddOn
    {
        public function __construct()
        {
            parent::__construct('customer-terms-of-service');

            $this->set_page_parameters(990, array(
                    'slug'              => $this->get_slug(),
                    'hide_if_logged_in' => true,
                    'hide_in_menu'      => false,
                    'parent_slug'       => 'customer-home',
                    'requires_login'    => false,
                )
            );
        }

        public function run_addon($plugin)
        {
            parent::run_addon($plugin);

            if ( !is_admin()) {
                add_filter('the_content', array(&$this, 'wrap_content_into_entry_container'), 10);
            }
        }

        public function get_slug()
        {
            return 'terms-of-service';
        }

        public function get_label()
        {
            return __('Terms of service', 'cuarts');
        }

        public function get_title()
        {
            return __('Terms of service', 'cuarts');
        }

        public function get_hint()
        {
            return __('The page your users must agree before they can subscribe.', 'cuarts');
        }

        public function get_page_addon_path()
        {
            return CUARTS_INCLUDES_DIR;
        }

        public function get_page_url()
        {
            return parent::get_page_url();
        }

        /*------- TOOLS ---------------------------------------------------------------------------------------------------*/

        public function is_page_ready()
        {
            $content_post = get_post($this->get_page_id());

            return $content_post->post_status === 'publish' && !empty($content_post->post_content);
        }

        /*------- PAGE HANDLING ----------------------------------------------------------------------------------------*/

        /**
         * Wrap the WP Customer Area generated content into an entry container, for singular view content
         *
         * @param string $content
         *
         * @return string
         */
        public function wrap_content_into_entry_container($content)
        {
            if ( !cuar_is_customer_area_page(get_queried_object(), $this->get_slug())) {
                return $content;
            }

            if (empty($content)) {
                return '';
            }

            return '<div class="cuar-single-entry ml-sm mr-sm mt-sm">' . $content . '</div>';
        }
    }

    // Load the add-on
    new CUAR_TermsOfServicePageAddOn();

endif; // if (!class_exists('CUAR_TermsOfServicePageAddOn')) :