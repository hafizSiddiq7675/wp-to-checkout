<?php

namespace TO_CHECKOUT\admin;

use TO_CHECKOUT\admin\Settings as AdminSettings;
use TO_CHECKOUT\core\SettingAPI;

/**
 * Class Settings
 * @see https://github.com/tareq1988/wordpress-settings-api-class
 */
class Settings {

	/**
	 * Plugin Option name
	 */
	public $setting;

	/**
	 * The single instance of the class.
	 */
	protected static $_instance = null;

	/**
	 * Main Instance.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Admin_Setting_Api constructor.
	 */
	public function __construct() {
		/**
		 * Set Admin Setting
		 */
		add_action( 'admin_init', array( $this, 'init_option' ) );
	}

	/**
	 * Display the plugin settings options page
	 */
	public function setting_page() {
		echo '<div class="wrap">';
		settings_errors();

		// $this->setting->show_navigation();
		// $this->setting->show_forms();
		$this->setting->show_navigation();
		$this->setting->show_forms();

		echo '</div>';
	}


	/**
	 * Registers settings section and fields
	 */
	public function init_option() {
		
		$sections = array(
			array(
				'id'    => 'to_checkout_checkout_opt',
				'desc'  => __( 'WP2 Checkout AWS', 'wp-to-checkout' ),
				'title' => __( 'AWS Amazon Credentials', 'wp-to-checkout' )
			),
			// array(
			// 	'id'    => 'to_checkout_help',
			// 	'desc'  => __( 'Help', 'wp-to-checkout' ),
			// 	'title' => __( 'Help', 'wp-to-checkout' )
			// ),
			
		);

		$fields = 
			array(
					'to_checkout_checkout_opt' 	=> array(
					array(
					'name' => 'aws_access_key_id',
					'label' => __('Aws Access Key ID', 'wp-to-checkout'),
					'type' => 'text',
					'default' => ''
					),
					array(
						'name' => 'associate_tag',
						'label' => __('Associate Tag', 'wp-to-checkout'),
						'type' => 'text',
						'default' => ''
					),
					
					array(
						'name'    => 'wp2locale',
						'label'   => __( 'Locale', 'wp-to-checkout' ),
						'type' => 'select',
						'id' => 'wp2locale',
						'options' => [
							"https://www.amazon.com.au/gp/aws/cart/add.html" => "Australia",
							"https://www.amazon.com.br/gp/aws/cart/add.html" => "Brazil",
							"https://www.amazon.ca/gp/aws/cart/add.html" => "Canada",
							"https://www.amazon.fr/gp/aws/cart/add.html" => "France",
							"https://www.amazon.de/gp/aws/cart/add.html" => "Germany",
							"https://www.amazon.in/gp/aws/cart/add.html" => "India",
							"https://www.amazon.it/gp/aws/cart/add.html" => "Italy",
							"https://www.amazon.co.jp/gp/aws/cart/add.html" => "Japan",
							"https://www.amazon.com.mx/gp/aws/cart/add.html" => "Mexico",
							"https://www.amazon.nl/gp/aws/cart/add.html" => "Netherlands",
							"https://www.amazon.pl/gp/aws/cart/add.html" => "Poland",
							"https://www.amazon.sg/gp/aws/cart/add.html" => "Singapore",
							"https://www.amazon.sa/gp/aws/cart/add.html" => "Saudi Arabia",
							"https://www.amazon.es/gp/aws/cart/add.html" => "Spain",
							"https://www.amazon.se/gp/aws/cart/add.html" => "Sweden",
							"https://www.amazon.com.tr/gp/aws/cart/add.html" => "Turkey",
							"https://www.amazon.ae/gp/aws/cart/add.html" => "United Arab Emirates",
							"https://www.amazon.co.uk/gp/aws/cart/add.html" => "United Kingdom",
							"https://www.amazon.com/gp/aws/cart/add.html" => "United States",
						],
					),
				),
				// end  of tocheckout fields

			// Help Fields
			'to_checkout_help'           => array(
				array(
					'name'  => 'html_help_shortcode',
					'label' => 'ShortCode List',
					'desc'  => 'You Can using bottom shortcode in wordpress : <br /><br />
 <table border="0" class="widefat">
  <tr>
 <td> [reviews-form]</td>
 <td>For Show Review Form</td>
</tr>
 <tr>
 <td>[reviews-insurance]</td>
 <td>List Of insurance With Rating Averag e.g : [reviews-insurance order="DESC"]</td>
</tr>
<tr>
 <td>[reviews-list]</td>
 <td>List Of Review For Custom insurance . e.g : [reviews-list insurance_id=10 order="ASC" number="50"]</td>
</tr>
</table>
',
					'type'  => 'html'
				),
				array(
					'name'  => 'html_help_custom template',
					'label' => 'Custom Template',
					'desc'  => 'for Custom Template according to your theme style : <br /> <br />
 <table border="0" class="widefat">
  <tr>
  <td>Copy `template` folder to root dir theme and rename folder to `wp-reviews`. then change your html code. :)</td>
  </tr>
  </table>
',
					'type'  => 'html'
				),
			)
			// end of help fields
		);

		$this->setting = new SettingAPI();

		//set sections and fields
		$this->setting->set_sections( $sections );
		$this->setting->set_fields( $fields );

		//initialize them
		$this->setting->admin_init();
	}

}

