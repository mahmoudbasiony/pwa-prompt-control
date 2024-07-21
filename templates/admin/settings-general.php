<?php
/**
 * Settings - General.
 *
 * @var array $settings - The plugin settings array
 *
 * @package PWA_Prompt_Control/Templates/Admin
 * @author Mahmoud Basiony.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// General settings.
$settings = get_option( 'pwapc_prompt_control_settings', array() );
?>

	<div class="pwa-prompt-control-general wrap">
		<form action="options.php" method="post">
			<?php
			settings_fields( 'pwapc_prompt_control_settings' );
			do_settings_sections( 'pwa-prompt-control' );
			submit_button( 'Save Settings' );
			?>
		</form>
	</div>
