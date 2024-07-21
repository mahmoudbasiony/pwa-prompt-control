<?php
/**
 * The PWA_Prompt_Control_Admin_Settings class.
 *
 * @package PWA_Prompt_Control/Admin
 * @author Mahmoud Basiony.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'PWA_Prompt_Control_Admin_Settings' ) ) :

	/**
	 * Admin menus.
	 *
	 * Adds menu and sub-menus pages.
	 *
	 * @since 1.0.0
	 */
	class PWA_Prompt_Control_Admin_Settings {
		/**
		 * The settings.
		 *
		 * @var array
		 */
		private $settings;

		/**
		 * The constructor.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function __construct() {
			// Get settings.
			$this->settings = get_option( 'pwapc_prompt_control_settings', array() );

			// Actions.
			add_action( 'admin_menu', array( $this, 'menu' ) );
			add_action( 'admin_init', array( $this, 'register_settings' ) );
		}

		/**
		 * Adds menu and sub-menus pages.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function menu() {
			add_menu_page(
				esc_html__( 'PWA Prompt Control', 'pwa-prompt-control' ),
				esc_html__( 'PWA Prompt Control', 'pwa-prompt-control' ),
				'manage_options',
				'pwa-prompt-control',
				array( $this, 'menu_page' ),
				'dashicons-admin-settings'
			);
		}

		/**
		 * Renders menu page content.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function menu_page() {
			include_once PWA_PROMPT_CONTROL_TEMPLATES_PATH . 'admin/settings.php';
		}

		/**
		 * Registers settings.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function register_settings() {
			register_setting( 'pwapc_prompt_control_settings', 'pwapc_prompt_control_settings' );

			add_settings_section(
				'pwapc_prompt_control_settings_section',
				esc_html__( 'PWA Prompt Control Settings', 'pwa-prompt-control' ),
				array( $this, 'pwapc_settings_section_callback' ),
				'pwa-prompt-control'
			);

			add_settings_field(
				'pwapc_enable',
				esc_html__( 'Enable', 'pwa-prompt-control' ),
				array( $this, 'settings_enable' ),
				'pwa-prompt-control',
				'pwapc_prompt_control_settings_section'
			);

			add_settings_field(
				'pwapc_frequency',
				esc_html__( 'Frequency', 'pwa-prompt-control' ),
				array( $this, 'settings_frequency' ),
				'pwa-prompt-control',
				'pwapc_prompt_control_settings_section'
			);

			add_settings_field(
				'pwapc_capping',
				esc_html__( 'Capping (minutes)', 'pwa-prompt-control' ),
				array( $this, 'settings_capping' ),
				'pwa-prompt-control',
				'pwapc_prompt_control_settings_section'
			);
		}

		/**
		 * Renders the settings section.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function pwapc_settings_section_callback() {
			echo esc_html__( 'Configure the PWA prompt control settings.', 'pwa-prompt-control' );
		}

		/**
		 * Renders the enable field.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function settings_enable() {
			$enable = isset( $this->settings['enable'] ) ? $this->settings['enable'] : '';

			include_once PWA_PROMPT_CONTROL_TEMPLATES_PATH . 'admin/views/sections/fields/enable.php';
		}

		/**
		 * Renders the scan frequency field.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function settings_frequency() {
			$frequency = isset( $this->settings['frequency'] ) ? $this->settings['frequency'] : 2;

			include_once PWA_PROMPT_CONTROL_TEMPLATES_PATH . 'admin/views/sections/fields/frequency.php';
		}

		/**
		 * Renders the capping field.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function settings_capping() {
			$capping = isset( $this->settings['capping'] ) ? $this->settings['capping'] : 5;

			include_once PWA_PROMPT_CONTROL_TEMPLATES_PATH . 'admin/views/sections/fields/capping.php';
		}
	}

	return new PWA_Prompt_Control_Admin_Settings();

endif;
