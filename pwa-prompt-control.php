<?php
/**
 * Plugin Name: PWA Prompt Control for WP & AMP
 * Plugin URI:
 * Description: This addon for the PWA for WP & AMP plugin controls how often the custom add to header banner is displayed.
 * Version: 1.0.0
 * Author: Mahmoud Basiony
 * Author URI:
 * Requires at least: 5.4
 * Tested up to: 6.6
 *
 * Text Domain: pwa-prompt-control
 * Domain Path: /languages/
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package PWA_Prompt_Control
 * @author Mahmoud Basiony
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/*
 * Globals constants.
 */
define( 'PWA_PROMPT_CONTROL_PLUGIN_NAME', 'PWA Prompt Control for WP & AMP' );
define( 'PWA_PROMPT_CONTROL_PLUGIN_VERSION', '1.0.0' );
define( 'PWA_PROMPT_CONTROL_MIN_PHP_VER', '7.3' );
define( 'PWA_PROMPT_CONTROL_MIN_WP_VER', '5.4' );
define( 'PWA_PROMPT_CONTROL_ROOT_PATH', __DIR__ );
define( 'PWA_PROMPT_CONTROL_ROOT_URL', plugin_dir_url( __FILE__ ) );
define( 'PWA_PROMPT_CONTROL_TEMPLATES_PATH', __DIR__ . '/templates/' );

/**
 * Check if PWA for WP & AMP is active.
 *
 * @since 1.0.0
 *
 * @return void
 */
function pwapc_check_required_plugins() {
	if ( ! is_plugin_active( 'pwa-for-wp/pwa-for-wp.php' ) ) {
		add_action( 'admin_notices', 'pwapc_show_admin_notice' );
		deactivate_plugins( plugin_basename( __FILE__ ) );
	}
}
add_action( 'admin_init', 'pwapc_check_required_plugins' );

/**
 * Show admin notice if PWA for WP & AMP is not active.
 *
 * @since 1.0.0
 *
 * @return void
 */
function pwapc_show_admin_notice() {
	?>
	<div class="notice notice-error">
		<p><?php esc_html_e( 'PWA Prompt Control plugin requires the PWA for WP & AMP plugin to be installed and active.', 'pwa-prompt-control' ); ?></p>
	</div>
	<?php
}

if ( ! class_exists( 'PWA_Prompt_Control' ) ) :

	/**
	 * The main class.
	 *
	 * @since 1.0.0
	 */
	class PWA_Prompt_Control {
		/**
		 * Plugin version.
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		public $version = '1.0.0';

		/**
		 * The singelton instance of PWA_Prompt_Control.
		 *
		 * @since 1.0.0
		 *
		 * @var PWA_Prompt_Control
		 */
		private static $instance = null;

		/**
		 * Returns the singelton instance of PWA_Prompt_Control.
		 *
		 * Ensures only one instance of PWA_Prompt_Control is/can be loaded.
		 *
		 * @since 1.0.0
		 *
		 * @return PWA_Prompt_Control
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * The constructor.
		 *
		 * Private constructor to make sure it can not be called directly from outside the class.
		 *
		 * @since 1.0.0
		 */
		private function __construct() {
			$this->includes();
			$this->hooks();

			do_action( 'pwapc_prompt_control_loaded' );
		}

		/**
		 * Includes the required files.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function includes() {
			/*
			 * Back-end includes.
			 */
			if ( is_admin() ) {
				include_once PWA_PROMPT_CONTROL_ROOT_PATH . '/includes/admin/class-pwa-prompt-control-admin-notices.php';
				include_once PWA_PROMPT_CONTROL_ROOT_PATH . '/includes/admin/class-pwa-prompt-control-admin-settings.php';
			}

			include_once PWA_PROMPT_CONTROL_ROOT_PATH . '/includes/class-pwa-prompt-control-assets.php';
		}

		/**
		 * Plugin hooks.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function hooks() {
		}

		/**
		 * Activation hooks.
		 *
		 * @since   1.0.0
		 *
		 * @return void
		 */
		public static function activate() {
			// Nothing to do.
		}

		/**
		 * Deactivation hooks.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public static function deactivate() {
			// Nothing to do.
		}

		/**
		 * Uninstall hooks.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public static function uninstall() {
			include_once PWA_PROMPT_CONTROL_ROOT_PATH . 'uninstall.php';
		}
	}

	// Plugin hooks.
	register_activation_hook( __FILE__, array( 'PWA_Prompt_Control', 'activate' ) );
	register_deactivation_hook( __FILE__, array( 'PWA_Prompt_Control', 'deactivate' ) );
	register_uninstall_hook( __FILE__, array( 'PWA_Prompt_Control', 'uninstall' ) );

endif;

/**
 * Init plugin.
 *
 * @since 1.0.0
 */
function pwapc_prompt_control_init() {
	// Global for backwards compatibility.
	$GLOBALS['pwa_prompt_control'] = PWA_Prompt_Control::get_instance();
}

add_action( 'plugins_loaded', 'pwapc_prompt_control_init', 0 );
