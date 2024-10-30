<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              madeinthemes.com
 * @since             1.0.0
 * @package           Made_In_Icon_Widget
 *
 * @wordpress-plugin
 * Plugin Name:       Made in Icon Widget
 * Plugin URI:        madeinthemes.com
 * Description:       Add a widget to display an icon or image with title and description on a widget area.
 * Version:           1.0.0
 * Author:            Made in Themes
 * Author URI:        madeinthemes.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       made-in-icon-widget
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-made-in-icon-widget-activator.php
 */
function activate_made_in_icon_widget() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-made-in-icon-widget-activator.php';
	Made_In_Icon_Widget_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-made-in-icon-widget-deactivator.php
 */
function deactivate_made_in_icon_widget() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-made-in-icon-widget-deactivator.php';
	Made_In_Icon_Widget_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_made_in_icon_widget' );
register_deactivation_hook( __FILE__, 'deactivate_made_in_icon_widget' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-made-in-icon-widget.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_made_in_icon_widget() {

	$plugin = new Made_In_Icon_Widget();
	$plugin->run();

}
run_made_in_icon_widget();

/* CREATE WIDGET */
// Register and load the widget
function mit_icon_widget_load_widget() {
    register_widget( 'mit_icon_widget' );
}
add_action( 'widgets_init', 'mit_icon_widget_load_widget' );
 
// Creating the widget 
class mit_icon_widget extends WP_Widget {
 
	function __construct() {
		parent::__construct(
			// Base ID of your widget
			'mit_icon_widget', 
			 
			// Widget name will appear in UI
			__('Made in Themes - Icon Widget', 'made_in_business'), 
			 
			// Widget description
			array( 'description' => __( 'Displays icon or image with title and description', 'made_in_business' ), ) 
		);
	}
	 
	// Creating widget front-end 
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$description = apply_filters('widget_text', $instance['description']);
		$image = apply_filters( 'image_widget_image_url', esc_url( $instance['icon'] ));
		$display = $instance['display'];
		$icon_width = $instance['icon_width'];

		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		
		if($image) {
			if($display == 'image') {
				$img = "<div class='mit-icon-widget-icon mit-icon-widget-display-image'><center><img src='" . $image . "'></center></div>";
			}
			else {
				if(!$icon_width) {
					$icon_width = "70";
				}
				$img = "<div class='mit-icon-widget-icon mit-icon-widget-display-icon'><center><img width='" . $icon_width . "px' src='" . $image . "'></center></div>";
			}
			echo $img;
		}
		if ($title) {
			echo $args['before_title'] . "<center>" . $title . "</center>" . $args['after_title'];
		}
		if($description) {
			$desc = "<div class='mit-icon-widget-description'>" . $description . "</div>";
			echo $desc;
		}
	
		echo $args['after_widget'];
	}
		 
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'display' ] ) ) {
			$display = $instance[ 'display' ];
		}
		else {
			$display = "icon";
		}
		if ( isset( $instance[ 'icon' ] ) ) {
			$icon = $instance[ 'icon' ];
		}
		if ( isset( $instance[ 'icon_width' ] ) ) {
			$icon_width = $instance[ 'icon_width' ];
		}
		else {
			$icon_width = "70";
		}
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		if ( isset( $instance[ 'description' ] ) ) {
			$description = $instance[ 'description' ];
		}
		// Widget admin form
		?>
		<div id="widget-id-<?php echo $this->id; ?>">
			<p>
			<label for="<?php echo $this->get_field_id( 'display' ); ?>"><?php _e( 'Display:' ); ?></label> 
			<select onchange="choose_display(this);" name="<?php echo $this->get_field_name( 'display' );?>" id="<?php echo $this->get_field_id( 'display' ); ?>" class="<?php echo $this->id; ?>">
				<option value="icon" <?php if(esc_attr( $display ) == 'icon') { echo "selected='selected'"; }?>>Icon</option>
				<option value="image" <?php if(esc_attr( $display ) == 'image') { echo "selected='selected'"; }?>>Image</option>
			</select>
			</p>
			<div class="media-widget-control">
				<p class="blazersix-media-control"
					data-title="Choose an Image for the Widget"
					data-update-text="Update Image"
					data-target=".image-id"
					data-select-multiple="false">
					<label id="icon-label" for="<?php echo $this->get_field_id( 'icon' ); ?>" style="<?php if(esc_attr( $display ) == 'image') { echo "display:none"; }?>"><?php _e( 'Icon:' ); ?></label> 
					<label id="image-label" for="<?php echo $this->get_field_id( 'icon' ); ?>" style="<?php if(esc_attr( $display ) == 'icon') { echo "display:none"; }?>"><?php _e( 'Image:' ); ?></label> 
					
					<div class="media-widget-preview media_image">
						<div class="attachment-media-view">
							<?php if(empty($instance['icon'])) { ?>
							<div class="placeholder"><?php _e( 'No image selected' ); ?></div>
							<?php } else { ?>
							<img class="custom_media_image" src="<?php echo $instance['icon']; ?>" />
							<?php } ?>
						</div>
					</div>
					
					<input type="hidden" name="<?php echo $this->get_field_name( 'icon' ); ?>" id="<?php echo $this->get_field_id( 'icon' ); ?>" value="<?php echo esc_attr( $icon ); ?>" class="image-id custom_media_url">
					
					<p class="media-widget-buttons">
						<button type="button" id="<?php echo $this->id; ?>" class="button select-media not-selected custom_media_upload icon-update" style="<?php if(esc_attr( $display ) == 'image') { echo "display:none"; }?>"><?php _e( 'Add Icon' ); ?></button>
						<button type="button" id="<?php echo $this->id; ?>" class="button select-media not-selected custom_media_upload image-update" style="<?php if(esc_attr( $display ) == 'icon') { echo "display:none"; }?>"><?php _e( 'Add Image' ); ?></button>
					</p>			
				</p>
			</div>
			<p id="icon-width" style="<?php if(esc_attr( $display ) == 'image') { echo "display:none"; }?>">
				<label for="<?php echo $this->get_field_id( 'icon_width' ); ?>"><?php _e( 'Icon width in pixels:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'icon_width' ); ?>" name="<?php echo $this->get_field_name( 'icon_width' ); ?>" type="number" value="<?php echo esc_attr( $icon_width ); ?>" />
			</p>
			<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p> 
			<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Description:' ); ?></label> 
			<textarea class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" rows="5" cols="20"><?php echo esc_attr( $description ); ?></textarea>
			</p>
		</div>
		<?php 
	}
		 
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['display'] = ( ! empty( $new_instance['display'] ) ) ? strip_tags( $new_instance['display'] ) : '';
		$instance['icon'] = ( ! empty( $new_instance['icon'] ) ) ? strip_tags( $new_instance['icon'] ) : '';
		$instance['icon_width'] = ( ! empty( $new_instance['icon_width'] ) ) ? strip_tags( $new_instance['icon_width'] ) : '';
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['description'] = ( ! empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
		return $instance;
	}
} // Class wpb_widget ends here

function ctUp_wdScript(){
	wp_enqueue_media();
	wp_enqueue_script(
		'adsScript',
		plugin_dir_url( __FILE__ ) . 'assets/js/script.js',
		array( 'jquery' ),
		CHILD_THEME_VERSION,
		true
	);
}
add_action('admin_enqueue_scripts', 'ctUp_wdScript');