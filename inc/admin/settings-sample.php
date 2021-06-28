<?php

namespace TO_CHECKOUT\admin;
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
				'title' => __( 'Wp2Checkout', 'wp-to-checkout' )
			),
			array(
				'id'    => 'to_checkout_email_opt',
				'desc'  => __( 'Basic email settings', 'wp-to-checkout' ),
				'title' => __( 'Email', 'wp-to-checkout' )
			),
			array(
				'id'    => 'TO_CHECKOUT_opt',
				'title' => __( 'General', 'wp-to-checkout' )
			),
			array(
				'id'    => 'to_checkout_help',
				'title' => __( 'Help', 'wp-to-checkout' ),
				'save'  => false
			),
		);

		$fields = 
				array(
					'to_checkout_checkout_opt' 	=> array(
					array(
					'name' => 'aws_access_key_id',
					'label' => __('Aws Access Key ID', 'wp-to-checkout'),
					'type' => 'password',
					'default' => ''
					),
					array(
						'name' => 'associate_tag',
						'label' => __('Associate Tag', 'wp-to-checkout'),
						'type' => 'text',
						'default' => ''
					),
					array(
						'name'    => 'btn_shortcode',
						'label'   => __( 'Button Shortcode', 'wp-to-checkout' ),
						'type'    => 'textarea',
						'value' => '',
						'default' => '',
						'desc'    => ''
					),
				),

					'to_checkout_email_opt'     => array(
				array(
					'name'    => 'from_email',
					'label'   => __( 'From Email', 'wp-to-checkout' ),
					'type'    => 'text',
					'default' => get_option( 'admin_email' )
				),
				array(
					'name'    => 'from_name',
					'label'   => __( 'From Name', 'wp-to-checkout' ),
					'type'    => 'text',
					'default' => get_option( 'blogname' )
				),
				array(
					'name'         => 'email_logo',
					'label'        => __( 'Email Logo', 'wp-to-checkout' ),
					'type'         => 'file',
					'button_label' => 'choose logo image'
				),
				array(
					'name'    => 'email_body',
					'label'   => __( 'Email Body', 'wp-to-checkout' ),
					'type'    => 'wysiwyg',
					'default' => '<p>Hi, [fullname] </p> For Accept Your Reviews Please Click Bottom Link : <p> [link]</p>',
					'desc'    => 'Use This Shortcode :<br /> [fullname] : User Name <br /> [link] : Accept email link'
				),
				array(
					'name'    => 'email_footer',
					'label'   => __( 'Email Footer Text', 'wp-to-checkout' ),
					'type'    => 'wysiwyg',
					'default' => 'All rights reserved',
				)
			),
			'TO_CHECKOUT_opt' => array(
				array(
					'name'    => 'is_auth_ip',
					'label'   => __( 'IP Validation', 'wp-to-checkout' ),
					'type'    => 'select',
					'desc'    => 'Each user can only have one vote',
					'options' => array(
						'0' => 'No',
						'1' => 'yes'
					)
				),
				array(
					'name'    => 'email_auth',
					'label'   => __( 'Confirmation email', 'wp-to-checkout' ),
					'type'    => 'select',
					'desc'    => 'The user must click confirmation email',
					'options' => array(
						'0' => 'No',
						'1' => 'yes'
					)
				),
				array(
					'name'    => 'star_color',
					'label'   => __( 'Star Rating color', 'wp-to-checkout' ),
					'type'    => 'color',
					'default' => '#f2b01e'
				),
				array(
					'name'    => 'thanks_text',
					'label'   => __( 'Thanks you Text', 'wp-to-checkout' ),
					'type'    => 'wysiwyg',
					'default' => 'Thanks you for this vote.'
				),
				array(
					'name'    => 'error_ip',
					'label'   => __( 'Duplicate ip error', 'wp-to-checkout' ),
					'type'    => 'textarea',
					'default' => 'Each user can only have one vote'
				),
				array(
					'name'    => 'email_subject',
					'label'   => __( 'Email subject for Confirm', 'wp-to-checkout' ),
					'type'    => 'text',
					'default' => 'confirm your reviews',
					'desc'    => 'Use This Shortcode :</br> [fullname] : User Name<br /> [sitename] : Site Name',
				),
				array(
					'name'    => 'email_thanks_text',
					'label'   => __( 'Thanks Confirm Text', 'wp-to-checkout' ),
					'type'    => 'text',
					'default' => 'Thank You For Your Reviews.',
				),
			),
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
		);

		$this->setting = new SettingAPI();

		//set sections and fields
		$this->setting->set_sections( $sections );
		$this->setting->set_fields( $fields );

		//initialize them
		$this->setting->admin_init();
	}

}
