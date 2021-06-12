<?php
/*
Plugin Name: Metabox Header Color
Plugin URI: http://trepmal.com/plugins/metabox-header-color/
Description: Change the color for metabox headers
Author: Kailey Lampert
Version: 1.6.1
Author URI: http://kaileylampert.com/
*/
/*
    Copyright (C) 2011  Kailey Lampert

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

$metabox_header_color = new Metabox_Header_Color();

class Metabox_Header_Color {

	function __construct() {
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		add_action( 'admin_head',           array( $this, 'metaboxheadercolor' ) );
		add_action( 'admin_menu',           array( $this, 'menu' ) );
	}
	function activate() {
		add_option( 'kl-metabox-header-color', [
			'bg' => '#9df',
			'tx' => '#666',
			'sh' => '#fff'
		], 'no' );
	}

	function metaboxheadercolor() {

		$hex_codes = get_option( 'kl-metabox-header-color', [] );

		if ( isset( $_POST[ 'submitted' ] ) ) {
			if ( is_array( $_POST[ 'hex_code' ] ) ) {
				check_admin_referer( 'kl-metabox-header-color_save' );

				$hex_codes = $_POST['hex_code'];
				$hex_codes = array_intersect_key( $hex_codes, [ 'bg' => true, 'tx' => true, 'sh' => true ] );
				$hex_codes = array_map( 'sanitize_hex_color', $hex_codes );

				update_option( 'kl-metabox-header-color', $hex_codes );
			}
		}

		?><style type="text/css">
		.widgets-sortables .widget-top,
		.postbox-header {
			background: <?php echo esc_html( $hex_codes['bg'] ); ?>;
			color: <?php echo esc_html( $hex_codes['tx'] ); ?>;
			text-shadow: 0 1px 0 <?php echo esc_html( $hex_codes['sh'] ); ?>;
		}
		.postbox-header span,
		.postbox-header h2 {
			color: <?php echo esc_html( $hex_codes['tx'] ); ?>;
		}
		</style><?php
	}

	function menu() {
		add_options_page( 'Metabox Header Color', 'Metabox Header Color', 'administrator', __FILE__, array( $this, 'page' ) );
	}

	function page() {

		wp_enqueue_script( 'metabox_header_color', plugins_url( 'js/init.js', __FILE__ ), [ 'wp-color-picker' ] );

		$color = get_option( 'kl-metabox-header-color', [] );
		?>
		<div class="wrap">
			<h2><?php esc_html_e( 'Choose Metabox Header Color' ); ?></h2>
			<div class="metabox-holder">
				<div class="postbox">
				<div class="postbox-header"><h2 class="hndle ui-sortable-handle"><?php esc_html_e( 'Preview changes here'); ?></h2></div>

					<div class="inside">
						<form method="post" style="padding:10px;">
							<input type="hidden" name="submitted" />
							<?php
								extract(get_option( 'kl-metabox-header-color' ) );
								wp_nonce_field( 'kl-metabox-header-color_save' );
							?>
							<p><label for="hex_code_bg">Background Color: </label>
								<input type="text" name="hex_code[bg]" id="hex_code_bg" value="<?php echo esc_attr( $color['bg'] ); ?>" /></p>
							<p><label for="hex_code_tx">Text Color: </label>
								<input type="text" name="hex_code[tx]" id="hex_code_tx" value="<?php echo esc_attr( $color['tx'] ); ?>"  /></p>
							<p><label for="hex_code_sh">Shadow Color: </label>
								<input type="text" name="hex_code[sh]" id="hex_code_sh" value="<?php echo esc_attr( $color['sh'] ); ?>"  /></p>
							<?php submit_button( __('Save'), 'primary' ); ?>
						</form>
					</div>
				</div>
			</div>
			<p>Settings will be preserved if the plugin is deactivated. Settings will be removed if plugin is deleted.</p>
		</div>
		<?php

	} // end function page

} // end class
