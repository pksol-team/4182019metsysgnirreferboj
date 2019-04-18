<?php

/*  Copyright 2015 MarvinLabs (contact@marvinlabs.com) */

class CUAR_TermsOfServiceAdminInterfaceHelper
{
    public static $OPTION_RESET_TOS = 'cuar_ts_reset_terms_of_service';

    /** @var CUAR_Plugin */
    private $plugin;

    /** @var CUAR_TermsOfServiceAddOn */
    private $ts_addon;

    /**
     * Constructor
     */
    public function __construct($plugin, $ts_addon)
    {
        $this->plugin = $plugin;
        $this->ts_addon = $ts_addon;

        if (is_admin())
        {
            add_action('add_meta_boxes', array(&$this, 'register_meta_box'));
            add_action('save_post', array(&$this, 'save_meta_box'));
        }
    }

    /*------- CUSTOMISATION OF THE PLUGIN SETTINGS PAGE -------------------------------------------------------------*/

    /**
     * Register the main metabox
     */
    public function register_meta_box($post)
    {
        if (!$this->is_currently_edited())
        {
            return;
        }

        add_meta_box(
            'cuar_terms_of_service_settings',
            __('Terms of Service settings', 'cuarts'),
            array(&$this, 'print_terms_of_service_meta_box'),
            'page',
            'side', 'high'
        );
    }

    /**
     * Print the metabox
     */
    public function print_terms_of_service_meta_box()
    {
        $tos_reset_field = self::$OPTION_RESET_TOS;
        $tos_roles_without_agreement = $this->get_roles_without_required_agreement();

        /** @noinspection PhpIncludeInspection */
        include($this->plugin->get_template_file_path(
            CUARTS_INCLUDES_DIR,
            array(
                'terms-of-service-admin-metabox.template.php',
            ),
            'templates'));
    }

    /**
     * Do meta box stuff on save post
     *
     * @param $post_ID
     */
    public function save_meta_box($post_ID)
    {
        if ($this->ts_addon->page_addon()->get_page_id() !== (int)$post_ID)
        {
            return;
        }

        if (!isset($_POST[self::$OPTION_RESET_TOS]) || $_POST[self::$OPTION_RESET_TOS] !== 'on')
        {
            return;
        }

        $this->ts_addon->reset_tos_agreement_for_all_users();
    }

    /*------- TOOLS ---------------------------------------------------------------------------------------------------*/

    public function is_currently_edited()
    {
        if (!isset($_GET['post']))
        {
            return false;
        }

        $post_id = $_GET['post'];
        $screen = get_current_screen();

        return $screen->id === 'page' && $this->ts_addon->page_addon()->get_page_id() === (int)$post_id;
    }

    public function get_roles_without_required_agreement()
    {
        global $wp_roles;
        if ( !isset($wp_roles)) $wp_roles = new WP_Roles();

        $all_roles = $wp_roles->role_objects;
        $agreement_needed = array();

        foreach ($all_roles as $role) {
            if ( !$role->has_cap(CUAR_TermsOfServiceAddOn::$SKIP_TOS_CAP)) $agreement_needed[] = $role->name;
        }

        return $agreement_needed;
    }
}