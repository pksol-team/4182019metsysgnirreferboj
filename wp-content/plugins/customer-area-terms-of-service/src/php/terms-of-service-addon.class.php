<?php
/*  Copyright 2013 MarvinLabs (contact@marvinlabs.com) */

require_once(CUAR_INCLUDES_DIR . '/core-classes/addon.class.php');

if ( !class_exists('CUAR_TermsOfServiceAddOn')) :

    /**
     * Add-on to send switch-users on some events
     *
     * @author Thomas Lartaud
     */
    class CUAR_TermsOfServiceAddOn extends CUAR_AddOn
    {

        private static $USER_META_AGREED_TO_TOS = 'cuar_ts_user_agreed';
        public static $SKIP_TOS_CAP = 'cuar_ts_skip_agreement';

        /** @var CUAR_TermsOfServiceAdminInterfaceHelper */
        private $admin_interface = null;

        /** @var CUAR_TermsOfServicePageAddOn */
        private $page_addon = null;

        public function __construct()
        {
            parent::__construct('terms-of-service');
        }

        public function get_addon_name()
        {
            return __('Terms Of Service', 'cuarts');
        }

        public function run_addon($plugin)
        {
            $this->enable_licensing(CUARTS_STORE_ITEM_ID, CUARTS_STORE_ITEM_NAME, CUARTS_PLUGIN_FILE, CUARTS_PLUGIN_VERSION);
            $this->load_textdomain();

            $this->page_addon = $this->plugin->get_addon('customer-terms-of-service');
            $this->admin_interface = new CUAR_TermsOfServiceAdminInterfaceHelper($plugin, $this);
            $this->forms = new CUAR_TermsOfServiceFormsHelper($plugin, $this);

            add_filter('cuar/core/permission-groups', array(&$this, 'get_configurable_capability_groups'));

            // Init the admin interface if needed
            if (is_admin()) {
                add_filter('cuar/core/status/directories-to-scan', array(&$this, 'add_hook_discovery_directory'));
            }
        }

        public function add_hook_discovery_directory($dirs)
        {
            $dirs[CUARTS_PLUGIN_DIR] = $this->get_addon_name();

            return $dirs;
        }

        public function admin_interface()
        {
            return $this->admin_interface;
        }

        public function page_addon()
        {
            return $this->page_addon;
        }

        /*------- INITIALISATIONS ----------------------------------------------------------------------------------------*/

        /**
         * Load the translation file for current language.
         */
        public function load_textdomain()
        {
            $this->plugin->load_textdomain('cuarts', 'customer-area-terms-of-service');
        }

        /*------- CAPABILITIES ------------------------------------------------------------------------------------------*/

        /**
         * @param $capability_groups
         *
         * @return mixed
         */
        public function get_configurable_capability_groups($capability_groups)
        {
            $capability_groups['cuar_general']['groups']['terms_of_service'] = array(
                'group_name'   => __('Terms of Service', 'cuarts'),
                'capabilities' => array(
                    self::$SKIP_TOS_CAP => __('Skip Terms of Service agreement', 'cuarts')
                )
            );

            return $capability_groups;
        }

        /**
         * @param $user
         *
         * @return bool
         */
        public function can_current_user_skip_tos($user)
        {
            return $user->has_cap(self::$SKIP_TOS_CAP);
        }

        /*------- TOS STATUS ---------------------------------------------------------------------------------------------*/

        /**
         * @param      $user_id
         * @param bool $has_agreed
         */
        public function save_user_tos_agreement($user_id, $has_agreed = true)
        {
            update_user_meta($user_id, self::$USER_META_AGREED_TO_TOS, $has_agreed === true ? 1 : 0);
        }

        /**
         * @param $user_id
         *
         * @return bool
         */
        public function has_user_agreed_tos($user_id)
        {
            return 1 === (int)get_user_meta($user_id, self::$USER_META_AGREED_TO_TOS, true);
        }

        /**
         * Reset TOS agreements for all users
         */
        public function reset_tos_agreement_for_all_users()
        {
            global $wpdb;
            $wpdb->query($wpdb->prepare("UPDATE {$wpdb->usermeta} SET meta_value = %s WHERE meta_key = %s",
                0, self::$USER_META_AGREED_TO_TOS));
        }
    }

    // Make sure the addon is loaded
    new CUAR_TermsOfServiceAddOn();

endif; // if (!class_exists('CUAR_TermsOfServiceAddOn'))
