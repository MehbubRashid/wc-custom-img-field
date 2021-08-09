 * Class responsible for custom image field extension for woocommerce.
 * @author Mehbub Rashid <mehub.rabu@gmail.com>
 * 
 * Usage:
 * 1. Include the file and initialize the class
 * 2. Do action wc_custom_img_field_style_and_scripts where you want the field css and js to be enqueued.
 * 3. Make sure to change the textdomain according to your need.

```
array(
    'title'   => __( 'Dashboard Logo', 'textdomain' ),
    'type'    => 'image-upload',
    'id'      => 'dashboard_logo',
    'desc' => __('Upload the logo you want to display in dashboard.', 'textdomain'),
    'button_text' => __('Select Image', 'textdomain')
),
```