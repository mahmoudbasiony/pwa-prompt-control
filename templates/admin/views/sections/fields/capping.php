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

<input type="number" id="capping" min="1" name="pwapc_prompt_control_settings[capping]" value="<?php echo esc_attr( $capping ); ?>">
