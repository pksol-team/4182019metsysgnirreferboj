<?php

/*  Copyright 2015 MarvinLabs (contact@marvinlabs.com) */

class CUAR_TermsOfServiceFormsHelper
{
    private static $CHECKBOX_FIELD_NAME = 'cuar-accept-tos';

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

        add_filter('registration_errors', array(&$this, 'validate_terms_of_service_register_checkbox'), 10, 3);
        add_action('user_register', array(&$this, 'save_terms_of_service_register_checkbox'), 10, 1);
        add_filter('wp_authenticate_user', array(&$this, 'validate_terms_of_service_after_login'), 10, 2);

        add_action('register_form', array(&$this, 'print_terms_of_service_checkbox'));
        add_action('login_form', array(&$this, 'print_terms_of_service_login_checkbox'));

    }

    /**
     * @return bool
     */
    private function is_tos_checkbox_checked()
    {
        return isset($_POST[self::$CHECKBOX_FIELD_NAME]) && $_POST[self::$CHECKBOX_FIELD_NAME] === 'on';
    }

    /**
     * @param bool $show
     */
    private function request_show_checkbox($show = true)
    {
        if ($show) {
            $_SESSION['show-' . self::$CHECKBOX_FIELD_NAME] = true;
        } else {
            unset($_SESSION['show-' . self::$CHECKBOX_FIELD_NAME]);
        }
    }

    /**
     * @return bool
     */
    private function should_show_checkbox()
    {
        $checkbox_session = 'show-' . self::$CHECKBOX_FIELD_NAME;

        return isset($_SESSION[$checkbox_session]) && $_SESSION[$checkbox_session] === true;
    }

    /*------- VALIDATION ---------------------------------------------------------------------------------------------*/

    /**
     * Make sure the checkbox has been check on the register form
     *
     * @param WP_Error $errors
     * @param string   $sanitized_user_login
     * @param string   $user_email
     *
     * @return mixed
     */
    public function validate_terms_of_service_register_checkbox($errors, $sanitized_user_login, $user_email)
    {
        if ( !$this->ts_addon->page_addon()->is_page_ready()) {
            return $errors;
        }

        if ( !$this->is_tos_checkbox_checked()) {
            $errors->add('cuar_tos_checkbox_error', __('You need to agree to our terms of service.', 'cuarts'));
        }

        return $errors;
    }

    /**
     * Save the user terms of service validation
     *
     * @param $user_id
     */
    public function save_terms_of_service_register_checkbox($user_id)
    {
        if ( !$this->ts_addon->page_addon()->is_page_ready()) {
            return;
        }

        $this->ts_addon->save_user_tos_agreement($user_id, $this->is_tos_checkbox_checked());
    }

    /**
     * Check if the user attempting to connect has already agreed the terms of service
     *
     * @param $user
     * @param $password
     *
     * @return WP_Error
     */
    public function validate_terms_of_service_after_login($user, $password)
    {
        if ( !$this->ts_addon->page_addon()->is_page_ready()) {
            return $user;
        }

        // Clear session variable for now
        $this->request_show_checkbox(false);

        // User is allowed to skip TOS agreement
        if ($this->ts_addon->can_current_user_skip_tos($user)) {
            return $user;
        }

        // No agreement, if user already agreed, then fine.
        if ($this->ts_addon->has_user_agreed_tos($user->ID)) {
            return $user;
        }

        // User has agreed manually on login
        if ($this->is_tos_checkbox_checked()) {
            $this->ts_addon->save_user_tos_agreement($user->ID, true);

            return $user;
        }

        // Else, return error + show checkbox on login form
        $this->request_show_checkbox(true);

        return new WP_Error('cuar_tos_checkbox_error',
            __('You need to agree our terms of service before logging in.', 'cuarts'));
    }

    /*------- DISPLAY ------------------------------------------------------------------------------------------------*/

    /**
     * Print a checkbox into register forms
     */
    public function print_terms_of_service_checkbox()
    {
        if ( !$this->ts_addon->page_addon()->is_page_ready()) {
            return;
        }

        $template_variant = class_exists('CUAR_LoginFormAddOn')
            ? ''
            : '-wp';

        $tos_page_url = $this->ts_addon->page_addon()->get_page_url();
        $tos_field_name = self::$CHECKBOX_FIELD_NAME;

        /** @noinspection PhpIncludeInspection */
        include($this->plugin->get_template_file_path(
            CUARTS_INCLUDES_DIR,
            array(
                'terms-of-service-checkbox' . $template_variant . '.template.php',
            ),
            'templates'));
    }

    /**
     * Print a checkbox into login forms
     */
    public function print_terms_of_service_login_checkbox()
    {
        if ( !$this->ts_addon->page_addon()->is_page_ready()) {
            return;
        }

        if ( !$this->should_show_checkbox()) {
            return;
        }

        $this->print_terms_of_service_checkbox();
    }

}