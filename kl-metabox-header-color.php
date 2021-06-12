<?php
/*
Plugin Name: Metabox Header Color
Plugin URI: http://trepmal.com/plugins/metabox-header-color/
Description: Change the color for metabox headers
Author: Kailey Lampert
Version: 1.5
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

new KL_metaboxheadercolor();

class KL_metaboxheadercolor {

	function KL_metaboxheadercolor() {
		register_activation_hook( __FILE__, array( &$this, 'activate' ) );
		add_action( 'admin_head', array( &$this, 'metaboxheadercolor' ) );
		add_action( 'admin_menu', array( &$this, 'menu' ) );
	}
	function activate() { 
		add_option( 'kl-metabox-header-color',array( 'bg' => '#9df', 'tx' => '#666', 'sh' => '#fff' ) );
	}

	function metaboxheadercolor() {
		if ( isset( $_POST[ 'submitted' ] ) ) {	
			if ( is_array( $_POST[ 'hex_code' ] ) ) {
				check_admin_referer( 'kl-metabox-header-color_save' );
				update_option( 'kl-metabox-header-color', $_POST[ 'hex_code' ] );
			}
		}
		extract( get_option( 'kl-metabox-header-color' ) );
		?><style type="text/css">
		.widgets-sortables .widget-top, 
		.postbox h3, 
		.stuffbox h3, 
		.ui-sortable .postbox h3 { 
			background: <?php echo $bg; ?>; 
			color: <?php echo $tx; ?>; 
			text-shadow: 0 1px 0 <?php echo $sh; ?>;
		}
		#widget-list .widget-top {
			color: auto;
		}
		</style><?php
	}

	function menu() {

		$page = add_options_page( 'Metabox Header Color', 'Metabox Header Color', 'administrator', __FILE__, array( &$this, 'page' ) );
		add_action( 'admin_print_scripts-' . $page, array( &$this, 'scripts' ) );
		add_action( 'admin_print_styles-' . $page, array( &$this, 'styles' ) );

	}
	
	function scripts() {
		wp_enqueue_script( 'jquery' );
		wp_register_script( 'jquerycolorpicker', plugins_url( '/js/colorpicker.js', __FILE__ ), 'jquery' );
		wp_enqueue_script( 'jquerycolorpicker' );
		wp_register_script( 'klmetaboxheadercolorinit', plugins_url( 'js/init.js', __FILE__ ), 'jquerycolorpicker' );
		wp_enqueue_script( 'klmetaboxheadercolorinit' );
	}

	function styles() {
		wp_register_style( 'jquerycolorpicker', plugins_url( '/css/colorpicker.css', __FILE__ ), 'jquery' );
		wp_enqueue_style( 'jquerycolorpicker' );
	}

	function page() {
				
		$color = get_option( 'kl-metabox-header-color' );
		?>
		<div class="wrap">		
			<h2><?php _e( 'Choose Metabox Header Color'); ?></h2>
			<div class="metabox-holder">
				<div class="postbox ">
					<h3 class="hndle"><span><?php _e( 'Preview changes here'); ?></span></h3>
					<div class="inside">
						<form method="post" style="padding:10px;">
							<?php
								extract(get_option( 'kl-metabox-header-color' ) );
								wp_nonce_field( 'kl-metabox-header-color_save' );
							?>
							<p><label for="hex_code_bg">Background Color (hex) code: </label><input type="text" name="hex_code[bg]" id="hex_code_bg" value="<?php echo $bg; ?>" class="cpick" /></p>
							<p><label for="hex_code_tx">Text Color (hex) code: </label><input type="text" name="hex_code[tx]" id="hex_code_tx" value="<?php echo $tx; ?>" class="cpick"  /></p>
							<p><label for="hex_code_sh">Shadow Color (hex) code: </label><input type="text" name="hex_code[sh]" id="hex_code_sh" value="<?php echo $sh; ?>" class="cpick"  /></p>
							<p><input type="hidden" name="submitted" /><input type="submit" id="save" value="<?php _e( 'Save' ); ?>"/></p>
						</form>		
					</div>
				</div>
			</div>
			<p>Settings will be preserved if the plugin is deactivated. Settings will be removed if plugin is deleted.</p>
			<p>The colorpicker is by <a href="http://www.eyecon.ro/colorpicker/">eyecon</a></p>
		</div>
		<?php

	} // end function page	
} // end class KL_metaboxheadercolor