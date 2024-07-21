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

<input type="number" id="frequency" min="1" name="pwapc_prompt_control_settings[frequency]" value="<?php echo esc_attr( $frequency ); ?>">
