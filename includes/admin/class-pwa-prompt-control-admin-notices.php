<?php
/**
 * The PWA_Prompt_Control_Admin_Notices class.
 *
 * @package PWA_Prompt_Control/Admin
 * @author Mahmoud Basiony.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'PWA_Prompt_Control_Admin_Notices' ) ) :

	/**
	 * Handles admin notices.
	 *
	 * @since 1.0.0
	 */
	class PWA_Prompt_Control_Admin_Notices {
		/**
		 * Notices array.
		 *
		 * @var array
		 */
		public $notices = array();

		/**
		 * The constructor.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function __construct() {
			add_action( 'admin_notices', array( $this, 'admin_notices' ) );
			add_action( 'wp_loaded', array( $this, 'hide_notices' ) );
		}

		/**
		 * Adds slug keyed notices (to avoid duplication).
		 *
		 * @since 1.0.0
		 *
		 * @param string $slug        Notice slug.
		 * @param string $class       CSS class.
		 * @param string $message     Notice body.
		 * @param bool   $dismissible Allow/disallow dismissing the notice. Default value false.
		 *
		 * @return void
		 */
		public function add_admin_notice( $slug, $class, $message, $dismissible = false ) {
			$this->notices[ $slug ] = array(
				'class'       => esc_attr( $class ),
				'message'     => esc_html( $message ),
				'dismissible' => $dismissible,
			);
		}

		/**
		 * Displays the notices.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function admin_notices() {
			// Exit if user has no privilges.
			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}

			// Basic checks.
			$this->check_environment();

			// Display the notices collected so far.
			foreach ( (array) $this->notices as $notice_key => $notice ) {
				echo '<div class="' . esc_attr( $notice['class'] ) . '" style="position:relative;">';

				if ( $notice['dismissible'] ) {
					echo '<a href="' . esc_url( wp_nonce_url( add_query_arg( 'pwa-prompt-control-hide-notice', $notice_key ), 'pwapc_prompt_control_hide_notices_nonce', '_pwapc_prompt_control_notice_nonce' ) ) . '" class="woocommerce-message-close notice-dismiss" style="position:absolute;right:1px;padding:9px;text-decoration:none;"></a>';
				}

				echo '<p>' . wp_kses( $notice['message'], array( 'a' => array( 'href' => array() ) ) ) . '</p>';

				echo '</div>';
			}
		}

		/**
		 * Handles all the basic checks.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function check_environment() {
			$show_phpver_notice = get_option( 'pwapc_prompt_control_show_phpver_notice' );
			$show_wpver_notice  = get_option( 'pwapc_prompt_control_show_wpver_notice' );

			if ( empty( $show_phpver_notice ) ) {
				if ( version_compare( phpversion(), PWA_PROMPT_CONTROL_MIN_PHP_VER, '<' ) ) {
					/* translators: 1) int version 2) int version */
					$message = esc_html__( 'PWA Prompt Control for WP & AMP - The minimum PHP version required for this plugin is %1$s. You are running %2$s.', 'pwa-prompt-control' );
					$this->add_admin_notice( 'phpver', 'error', sprintf( $message, PWA_PROMPT_CONTROL_MIN_PHP_VER, phpversion() ), true );
				}
			}

			if ( empty( $show_wpver_notice ) ) {
				global $wp_version;

				if ( version_compare( $wp_version, PWA_PROMPT_CONTROL_MIN_WP_VER, '<' ) ) {
					/* translators: 1) int version 2) int version */
					$message = esc_html__( 'PWA Prompt Control for WP & AMP - The minimum WordPress version required for this plugin is %1$s. You are running %2$s.', 'pwa-prompt-control' );
					$this->add_admin_notice( 'wpver', 'notice notice-warning', sprintf( $message, PWA_PROMPT_CONTROL_MIN_WP_VER, $wp_version ), true );
				}
			}
		}

		/**
		 * Hides any admin notices.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function hide_notices() {
			if ( isset( $_GET['pwa-prompt-control-hide-notice'] ) && isset( $_GET['_pwapc_prompt_control_notice_nonce'] ) ) {
				if ( ! wp_verify_nonce( $_GET['_pwapc_prompt_control_notice_nonce'], 'pwapc_prompt_control_hide_notices_nonce' ) ) {
					wp_die( esc_html__( 'Action failed. Please refresh the page and retry.', 'pwa-prompt-control' ) );
				}

				$notice = sanitize_text_field( $_GET['pwa-prompt-control-hide-notice'] );

				switch ( $notice ) {
					case 'phpver':
						update_option( 'pwapc_prompt_control_show_phpver_notice', 'no' );
						break;
					case 'wpver':
						update_option( 'pwapc_prompt_control_show_wpver_notice', 'no' );
						break;
				}
			}
		}
	}

	new PWA_Prompt_Control_Admin_Notices();

endif;
