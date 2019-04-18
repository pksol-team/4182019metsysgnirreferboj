<?php
/*  Copyright 2013 MarvinLabs (contact@marvinlabs.com) */

require_once(CUAR_INCLUDES_DIR . '/core-classes/addon.class.php');

if ( !class_exists('CUAR_CollaborationAddOn')) :

    /**
     * Add-on to allow setting user groups or user roles as owner of a private content
     *
     * @author Vincent Prat @ MarvinLabs
     */
    class CUAR_CollaborationAddOn extends CUAR_AddOn
    {

        public function __construct()
        {
            parent::__construct('collaboration');
        }

        public function get_addon_name()
        {
            return __('Front-office publishing', 'cuarco');
        }

        public function run_addon($plugin)
        {
            $this->enable_licensing(CUARCO_STORE_ITEM_ID, CUARCO_STORE_ITEM_NAME, CUARCO_PLUGIN_FILE, CUARCO_PLUGIN_VERSION);
            $this->load_textdomain();

            if (is_admin())
            {
                add_filter('cuar/core/status/directories-to-scan', array(&$this, 'add_hook_discovery_directory'));
            }
        }

        public function add_hook_discovery_directory($dirs)
        {
            $dirs[CUARCO_PLUGIN_DIR] = $this->get_addon_name();

            return $dirs;
        }

        /*------- CONTENT CREATION --------------------------------------------------------------------------------------*/

        /**
         * @param string $post_type
         * @param string $title
         * @param string $content
         * @param array  $owners
         * @param string $post_status
         * @param null   $taxonomy
         * @param int    $category
         *
         * @return array|int|WP_Error
         */
        public function create_private_content($post_type, $title, $content, $owners, $post_status = 'publish', $taxonomy = null, $category = -1)
        {
            $errors = array();

            // Save private content (post first, then owner, then the rest)
            $post_data = apply_filters('cuar/private-content/collaboration/create-post/args?type=' . $post_type, array(
                'post_title'        => wp_strip_all_tags($title),
                'post_content'      => $content,
                'post_status'       => $post_status,
                'post_type'         => $post_type,
                'post_modified'     => current_time('mysql'),
                'post_modified_gmt' => current_time('mysql', 1),
                'ping_status'       => 'closed',
            ));

            $post_id = wp_insert_post($post_data);

            if (is_wp_error($post_id))
            {
                foreach ($post_id->get_error_messages() as $error)
                {
                    $errors[] = $error;
                }
            }
            else
            {
                /** @var CUAR_PostOwnerAddOn $po_addon */
                $po_addon = $this->plugin->get_addon('post-owner');
                $po_addon->save_post_owners($post_id, $owners);

                if ($taxonomy != null && $category > 0)
                {
                    wp_set_post_terms($post_id, $category, $taxonomy);
                }
            }

            return empty($errors) ? $post_id : $errors;
        }

        public function update_private_content($post_type, $post_id, $title, $content, $owners, $taxonomy = null, $category = -1)
        {
            $errors = array();

            // Save private content (post first, then owner, then the rest)
            $post_data = apply_filters('cuar/private-content/collaboration/update-post/args?type=' . $post_type, array(
                'ID'           => $post_id,
                'post_title'   => wp_strip_all_tags($title),
                'post_content' => $content,
            ));

            $post_id = wp_update_post($post_data, true);

            if (is_wp_error($post_id))
            {
                foreach ($post_id->get_error_messages() as $error)
                {
                    $errors[] = $error;
                }
            }
            else
            {
                /** @var CUAR_PostOwnerAddOn $po_addon */
                $po_addon = $this->plugin->get_addon('post-owner');
                $po_addon->save_post_owners($post_id, $owners);

                if ($taxonomy != null && $category > 0)
                {
                    wp_set_post_terms($post_id, $category, $taxonomy);
                }

                $post = get_post($post_id);

                do_action("cuar/private-content/collaboration/on-post-updated?type=" . $post_type, $post_id, $post, $owners, $errors);
            }

            return empty($errors) ? $post_id : $errors;
        }

        /*------- INITIALISATION ----------------------------------------------------------------------------------------*/

        /**
         * Load the translation file for current language.
         */
        public function load_textdomain()
        {
            $this->plugin->load_textdomain('cuarco', 'customer-area-collaboration');
        }

    }

// Make sure the addon is loaded
    new CUAR_CollaborationAddOn();

endif; // if (!class_exists('CUAR_CollaborationAddOn')) 
