<?php
namespace TO_CHECKOUT\admin;
use TO_CHECKOUT;
use TO_CHECKOUT\admin\Settings;
class Admin {

	/**
	 * Admin Page slug
	 */
	public static $admin_page_slug;

	/**
	 * Admin_Page constructor.
	 */
	public function __construct() {
		/*
		 * Set Page slug Admin
		 */
		self::$admin_page_slug = 'wp-to-checkout';
		/*
		 * Setup Admin Menu
		 */
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		/*
		 * Register Script in Admin Area
		 */
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_assets' ) );
	}

	/**
	 * Admin Link
	 *
	 * @param $page
	 * @param array $args
	 * @return string
	 */
	public static function admin_link( $page, $args = array() ) {
		return add_query_arg( $args, admin_url( 'admin.php?page=' . $page ) );
	}

	/**
	 * If in Page in Admin
	 *
	 * @param $page_slug
	 * @return bool
	 */
	public static function in_page( $page_slug ) {
		global $pagenow;
		if ( $pagenow == "admin.php" and isset( $_GET['page'] ) and $_GET['page'] == $page_slug ) {
			return true;
		}

		return false;
	}

	/**
	 * Load assets file in admin
	 */
	public function admin_assets() {
		global $pagenow;

		//List Allow This Script
		if ( $pagenow == "admin.php" ) {

			// Get Plugin Version
			$plugin_version = TO_CHECKOUT::$plugin_version;
			if (defined('SCRIPT_DEBUG') and SCRIPT_DEBUG === true) {
			    $plugin_version = time();
			}
			
			
			wp_enqueue_style( 'wp-to-checkout', TO_CHECKOUT::$plugin_url . '/asset/admin/css/style.css', array(), $plugin_version, 'all' );
			wp_enqueue_style( 'wp-to-checkout-btn', TO_CHECKOUT::$plugin_url . '/asset/admin/css/buttons.css', array(), $plugin_version, 'all' );
			wp_enqueue_script( 'wp-to-checkout', TO_CHECKOUT::$plugin_url . '/asset/admin/js/script.js', array( 'jquery' ), $plugin_version, false );
			wp_localize_script('wp-to-checkout', 'to_checkout', array(
			    'ajax' => admin_url('admin-ajax.php'),
			));
		}

	}

	/**
	 * Set Admin Menu
	 */
	public function admin_menu() {
		
		add_menu_page( __( 'wp-to-checkout', 'wp-to-checkout' ), __( 'To Checkout', 'wp-to-checkout' ), 'manage_options', self::$admin_page_slug, array( $this, 'buttons_page' ), 'dashicons-cart', 8 );
		add_submenu_page( self::$admin_page_slug, 'Cart Buttons', 'Cart Buttons', 'manage_options', self::$admin_page_slug );
		add_submenu_page( self::$admin_page_slug, __( 'Setting Credentials', 'wp-to-checkout' ), __( 'Setting Credentials', 'wp-to-checkout' ), 'manage_options', 'setting-credentials-option', array( Settings::instance(), 'setting_page' ) );
		}

	/*
	 * Admin Page
	 */
	public function admin_page() {
		$simple_text = 'Hi';
		require_once TO_CHECKOUT::$plugin_path . '/inc/admin/views/default.php';
	}
	public function buttons_page() {
		ob_start();
        include_once(TO_CHECKOUT::$plugin_path.'/inc/admin/views/aq-buttons-list-table-class.php');
        $template = ob_get_contents();
    	ob_end_clean();

    echo '<div style="margin-right: 10px;">' . $template . '</div>';
	}
	

}
