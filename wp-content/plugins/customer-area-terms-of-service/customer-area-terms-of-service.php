<?php
/*
	Plugin Name: 	WP Customer Area - Terms Of Service
	Description: 	Force users to agree to terms of service
	Plugin URI: 	http://wp-customerarea.com
	Version: 		1.0.2
	Author: 		MarvinLabs
	Author URI: 	http://www.marvinlabs.com
	Text Domain: 	cuarts
	Domain Path: 	/languages
*/

/*  Copyright 2013 MarvinLabs (contact@marvinlabs.com) */

//------------------------------------------------------------
// Main plugin detection stuff

include(dirname(__FILE__) . '/libs/cuar/cuar_commons.php');
if (cuar_is_main_plugin_missing()) return;

// End of main plugin detection stuff
//------------------------------------------------------------

define('CUARTS_STORE_ITEM_NAME', 'Customer Area – Terms Of Service');
define('CUARTS_STORE_ITEM_ID', 220692);
define('CUARTS_PLUGIN_VERSION', '1.0.2');

define('CUARTS_PLUGIN_DIR', WP_PLUGIN_DIR . '/customer-area-terms-of-service');
define('CUARTS_PLUGIN_URL', plugins_url() . '/customer-area-terms-of-service');
define('CUARTS_LANGUAGE_DIR', 'customer-area-terms-of-service/languages');
define('CUARTS_INCLUDES_DIR', CUARTS_PLUGIN_DIR . '/src/php');
define('CUARTS_PLUGIN_FILE', CUARTS_PLUGIN_DIR . '/customer-area-terms-of-service.php');


// Load the addon
include_once(CUARTS_INCLUDES_DIR . '/helpers/tos-forms-helper.class.php');
include_once(CUARTS_INCLUDES_DIR . '/helpers/tos-admin-interface-helper.class.php');

include_once(CUARTS_INCLUDES_DIR . '/terms-of-service-page-addon.class.php');
include_once(CUARTS_INCLUDES_DIR . '/terms-of-service-addon.class.php');
