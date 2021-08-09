<?php 

/**
 * Class responsible for custom image field extension for woocommerce.
 * @author Mehbub Rashid <mehub.rabu@gmail.com>
 * 
 * Usage:
 * 1. Include the file and initialize the class
 * 2. Do action wc_custom_img_field_style_and_scripts where you want the field css and js to be enqueued.
 * 3. Make sure to change the textdomain according to your need.
 */
class Woosa_WC_Image_field {

    // Register hooks
    public function __construct() {
        // Add custom woocommerce field type
		add_action( 'woocommerce_admin_field_image-upload', array($this, 'image_field_html') );

		// Add css necessary for the field
		add_action( 'wc_custom_img_field_style_and_scripts', array($this, 'image_field_style_and_scripts') );
    }

	/**
	 * Add css and js script.
	 *
	 * @param string $handle
	 * @return void
	 */
	public function image_field_style_and_scripts( $handle ) {
		wp_enqueue_style( 'wc-custom-img-field', plugin_dir_url( __FILE__ ) . 'style.css', array(), null );
		wp_enqueue_script( 'wc-custom-img-field', plugin_dir_url( __FILE__ ) . 'script.js', array('jquery'), null, true );

		$translations = array(
			'select_image' => __('Select Image', 'woo-sales-agent'),
		);
		wp_localize_script( 'wc-custom-img-field', 'wc_custom_img_field', $translations );
	}


	/**
	 * Render the html of our custom image upload field
	 *
	 * @return void
	 */
	public function image_field_html($value) {
		// Custom attribute handling.
		$custom_attributes = array();

		if ( ! empty( $value['custom_attributes'] ) && is_array( $value['custom_attributes'] ) ) {
			foreach ( $value['custom_attributes'] as $attribute => $attribute_value ) {
				$custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
			}
		}

		// Description handling
		$field_description = WC_Admin_Settings::get_field_description( $value );
        $description       = $field_description['description'];
        $tooltip_html      = $field_description['tooltip_html'];

		$option_value = $value['value'];
		
		$default = array(
			'button_text' => __( 'Upload Image', 'woo-sales-agent' )
		);
		$value = wp_parse_args( $value, $default );
		?> 
		<tr valign="top">
			<th scope="row" class="titledesc">
				<label for="<?php echo esc_attr( $value['id'] ); ?>"><?php echo esc_html( $value['title'] ); ?> <?php echo $tooltip_html; // WPCS: XSS ok. ?></label>
			</th>
			<td class="forminp forminp-<?php echo esc_attr( sanitize_title( $value['type'] ) ); ?>">
			<input
				name="<?php echo esc_attr( $value['id'] ); ?>"
				id="<?php echo esc_attr( $value['id'] ); ?>"
				type="hidden"
				style="<?php echo esc_attr( $value['css'] ); ?>"
				value="<?php echo esc_attr( $option_value ); ?>"
				class="<?php echo esc_attr( $value['class'] ); ?>"
				placeholder="<?php echo esc_attr( $value['placeholder'] ); ?>"
				<?php echo implode( ' ', $custom_attributes ); // WPCS: XSS ok. ?>
			/>
			<?php echo esc_html( $value['suffix'] ); ?> 
			
			<!-- Upload button -->
			<button class="button primary img-upload-btn<?php echo $option_value ? '' : ' visible'; ?>">
				<?php echo esc_html( $value['button_text'] ); ?>
			</button>

			<!-- Selected image -->
			<div class="uploaded-img<?php echo $option_value ? ' visible' : ''; ?>">
				<button class="button primary img-delete-icon">
					<i class="dashicons dashicons-trash"></i>
				</button>
				<img src="<?php echo esc_url( $option_value ); ?>" alt="">
			</div>
			<?php echo $description; // WPCS: XSS ok. ?>
							
			</td>	
		</tr>
		<?php
	}
}

?>