<?php
/**
 * Uninstall PWA Prompt Control for WP & AMP plugin.
 *
 * @package PWA_Prompt_Control
 * @author  Reviewshake
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit; // Exit if uninstall not called from WordPress.
}

/*
 * Only remove plugin data if the WP_UNINSTALL_PLUGIN constant is set to true in user's
 * wp-config.php. This is to prevent data loss when deleting the plugin from the backend
 * and to ensure only the site owner can perform this action.
 */
if ( defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	// Delete the plugin options.
	delete_option( 'pwapc_prompt_control_settings' );
}
