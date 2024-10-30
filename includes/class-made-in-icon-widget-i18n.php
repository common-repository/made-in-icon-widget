<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       madeinthemes.com
 * @since      1.0.0
 *
 * @package    Made_In_Icon_Widget
 * @subpackage Made_In_Icon_Widget/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Made_In_Icon_Widget
 * @subpackage Made_In_Icon_Widget/includes
 * @author     Made in Themes <hello@madeinthemes.com>
 */
class Made_In_Icon_Widget_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'made-in-icon-widget',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
