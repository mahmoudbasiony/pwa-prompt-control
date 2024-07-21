<?php
/**
 * Settings - Admin - Views - Sections - Fields.
 *
 * @package PWA_Prompt_Control/Templates/Admin/Views/Sections/Fields
 * @author Mahmoud Basiony.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

<input type="checkbox" id="enable" name="pwapc_prompt_control_settings[enable]" <?php checked( $enable, 'on' ); ?>>
<label for="enable"><?php esc_html_e( 'Enable', 'pwa-prompt-control' ); ?></label>