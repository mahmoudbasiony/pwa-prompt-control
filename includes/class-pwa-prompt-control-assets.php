<?php
/**
 * The PWA_Prompt_Control_Assets class.
 *
 * @package PWA_Prompt_Control/
 * @author Mahmoud Basiony.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'PWA_Prompt_Control_Assets' ) ) :

	/**
	 * Frontend assets.
	 *
	 * Handles front-end styles and scripts.
	 *
	 * @since 1.0.0
	 */
	class PWA_Prompt_Control_Assets {
		/**
		 * The constructor.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 99999 );
			add_action( 'wp_enqueue_scripts', array( $this, 'styles' ), 20 );

		}

		/**
		 * Enqueues frontend scripts.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function scripts() {
			// Global frontend scripts.
			wp_enqueue_script(
				'pwapc_prompt_control_scripts',
				PWA_PROMPT_CONTROL_ROOT_URL . 'assets/dist/js/public/pwa-prompt-control-main.min.js',
				array(),
				PWA_PROMPT_CONTROL_PLUGIN_VERSION,
				true
			);

			// Get our plugin settings.
			$settings  = get_option( 'pwapc_prompt_control_settings', array() );
			$enable    = isset( $settings['enable'] ) ? $settings['enable'] : '';
			$frequency = isset( $settings['frequency'] ) ? $settings['frequency'] : 2;
			$capping   = isset( $settings['capping'] ) ? $settings['capping'] : 5;

			// Get the PWA for WP & AMP plugin settings.
			$pwa_for_wp_settings       = get_option( 'pwaforwp_settings', array() );
			$custom_add_to_home_banner = isset( $pwa_for_wp_settings['custom_add_to_home_setting'] ) ? $pwa_for_wp_settings['custom_add_to_home_setting'] : false;
			$enable_banner_for_desktop = isset( $pwa_for_wp_settings['enable_add_to_home_desktop_setting'] ) ? $pwa_for_wp_settings['enable_add_to_home_desktop_setting'] : false;

			// Localization variables.
			wp_localize_script(
				'pwapc_prompt_control_scripts',
				'pwapc_prompt_control_params',
				array(
					'enable'                    => (string) $enable,
					'frequency'                 => (int) $frequency,
					'capping'                   => (int) $capping,
					'custom_add_to_home_banner' => (bool) $custom_add_to_home_banner,
					'enable_banner_for_desktop' => (bool) $enable_banner_for_desktop,
				)
			);
		}

		/**
		 * Enqueue frontend styles.
		 *
		 * @since 1.0.0
		 */
		public function styles() {
			/*
			 * Global styles.
			 */
			wp_enqueue_style( 'pwapc_prompt_control_styles', PWA_PROMPT_CONTROL_ROOT_URL . 'assets/dist/css/public/pwa-prompt-control-styles.min.css', array(), PWA_PROMPT_CONTROL_PLUGIN_VERSION, 'all' );
		}
	}

	return new PWA_Prompt_Control_Assets();

endif;
