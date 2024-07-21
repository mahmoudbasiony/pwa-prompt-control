<?php
/**
 * Settings.
 *
 * @package PWA_Prompt_Control/Templates/Admin
 * @author  Mahmoud Basiony.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Available tabs.
$plugin_tabs = array( 'general' );

// Current tab.
$plugin_tab = isset( $_GET['tab'] ) && in_array( $_GET['tab'], $plugin_tabs, true ) ? sanitize_text_field( $_GET['tab'] ) : 'general';

?>

<div class="wrap pwa-prompt-control" id="pwa-prompt-control">
	<nav class="nav-tab-wrapper wpblc-nav-tab-wrapper">
		<a href="admin.php?page=pwa-prompt-control&tab=general" class="nav-tab <?php echo 'general' === $plugin_tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Settings', 'pwa-prompt-control' ); ?></a>
	</nav>

	<div class="pwa-prompt-control-inside-tabs">
		<div class="inside tab tab-content <?php echo esc_attr( $plugin_tab ); ?>" id="pwapc-tab-<?php echo esc_attr( $plugin_tab ); ?>">
			<?php require_once 'settings-' . $plugin_tab . '.php'; ?>
		</div>
	</div>
</div>
