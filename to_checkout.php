<?php
/**
 * Plugin Name: To Checkout
 * Description: A Plugin For starter Wordpress
 * Plugin URI:  https://site.com
 * Version:     1.0.0
 * Author:      Mehrshad Darzi
 * Author URI:  https://site.com
 * License:     MIT
 * Text Domain: wp-to-checkout
 * Domain Path: /languages
 */

// use TO_CHECKOUT\Wp2chk_popup;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class TO_CHECKOUT {
	/**
	 * @var string
	 */
	public static $ENVIRONMENT = 'development';

	/**
	 * Use Template Engine
	 * if you want use template Engine Please add dir name
	 *
	 * @var string / dir name
	 * @status Core
	 */
	public static $Template_Engine = 'wp-to-checkout';

	/**
	 * Minimum PHP version required
	 *
	 * @var string
	 */
	private $min_php = '5.4.0';

	/**
	 * Use plugin's translated strings
	 *
	 * @var string
	 * @default true
	 */
	public static $use_i18n = true;

	/**
	 * List Of Class
	 * @var array
	 */
	public static $providers = array(
		'admin\Admin',
		'Front',
		'Ajax',
		'core\\Utility'
	);

	/**
	 * URL to this plugin's directory.
	 *
	 * @type string
	 * @status Core
	 */
	public static $plugin_url;

	/**
	 * Path to this plugin's directory.
	 *
	 * @type string
	 * @status Core
	 */
	public static $plugin_path;

	/**
	 * Path to this plugin's directory.
	 *
	 * @type string
	 * @status Core
	 */
	public static $plugin_version;

	/**
	 * Plugin instance.
	 *
	 * @see get_instance()
	 * @status Core
	 */
	protected static $_instance = null;

	/**
	 * Access this plugin’s working instance
	 *
	 * @wp-hook plugins_loaded
	 * @return  object of this class
	 * @since   2012.09.13
	 */
	public static function instance() {
		null === self::$_instance and self::$_instance = new self;
		return self::$_instance;
	}

	/**
	 * TO_CHECKOUT constructor.
	 */

	
	public function __construct() {


		/*
		 * Check Require Php Version
		 */
		if ( version_compare( PHP_VERSION, $this->min_php, '<=' ) ) {
			add_action( 'admin_notices', array( $this, 'php_version_notice' ) );
			return;
		}

		add_action( 'init', [$this, 'wpdocs_codex_preview_init'] );
		
		/*
		 * Define Variable
		 */
		$this->define_constants();

		/*
		 * include files
		 */
		$this->includes();

		/*
		 * init Wordpress hook
		 */
		$this->init_hooks();

		/*
		 * Plugin Loaded Action
		 */
		do_action( 'to_checkout_loaded' );
	}

    

	function wpdocs_codex_preview_init() {
		$labels = array(
			'name'                  => _x( 'WP2CHECKOUT Previews', 'Post type general name', 'textdomain' ),
			'singular_name'         => _x( 'WP2CHECKOUT Preview', 'Post type singular name', 'textdomain' ),
			'menu_name'             => _x( 'WP2CHECKOUT Preview', 'Admin Menu text', 'textdomain' ),
			'name_admin_bar'        => _x( 'wp2chk-preview', 'Add New on Toolbar', 'textdomain' ),
			'add_new'               => __( 'Add New', 'textdomain' ),
			'add_new_item'          => __( 'Add New Preview', 'textdomain' ),
			'new_item'              => __( 'New Preview', 'textdomain' ),
			'edit_item'             => __( 'Edit Preview', 'textdomain' ),
			'view_item'             => __( 'View Preview', 'textdomain' ),
			'all_items'             => __( 'All Previews', 'textdomain' ),
			'search_items'          => __( 'Search Previews', 'textdomain' ),
			'parent_item_colon'     => __( 'Parent Previews:', 'textdomain' ),
			'not_found'             => __( 'No previews found.', 'textdomain' ),
			'not_found_in_trash'    => __( 'No previews found in Trash.', 'textdomain' ),
			'featured_image'        => _x( 'Book Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain' ),
			'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
			'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
			'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
			'archives'              => _x( 'Preview archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
			'insert_into_item'      => _x( 'Insert into book', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain' ),
			'uploaded_to_this_item' => _x( 'Uploaded to this book', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain' ),
			'filter_items_list'     => _x( 'Filter books list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
			'items_list_navigation' => _x( 'Books list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain' ),
			'items_list'            => _x( 'Books list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain' ),
		);
	 
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'wp2chk-preview' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
		);
	 
		register_post_type( 'wp2chk-preview', $args );
	}
	
	/**
	 * Define Constant
	 */
	public function define_constants() {
		/*
		 * Get Plugin Data
		 */
		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}
		$plugin_data = get_plugin_data( __FILE__ );

		/*
		 * Set Plugin Version
		 */
		self::$plugin_version = $plugin_data['Version'];

		/*
		 * Set Plugin Url
		 */
		self::$plugin_url = plugins_url( '', __FILE__ );

		/*
		 * Set Plugin Path
		 */
		self::$plugin_path = plugin_dir_path( __FILE__ );
	}

	/**
	 * include Plugin Require File
	 */
	public function includes() {

		/*
		 * autoload plugin files
		 */
		
		include_once dirname( __FILE__ ) . '/inc/config/i18n.php';
		include_once dirname( __FILE__ ) . '/inc/config/install.php';
		include_once dirname( __FILE__ ) . '/inc/config/uninstall.php';
		include_once dirname( __FILE__ ) . '/inc/helper.php';
		include_once dirname( __FILE__ ) . '/inc/ajax.php';
		include_once dirname( __FILE__ ) . '/inc/front.php';
		include_once dirname( __FILE__ ) . '/inc/admin/admin.php';
		include_once dirname( __FILE__ ) . '/inc/admin/settings.php';
		include_once dirname( __FILE__ ) . '/inc/core/settingapi.php';
		include_once dirname( __FILE__ ) . '/inc/core/template.php';
		include_once dirname( __FILE__ ) . '/inc/core/utility.php';
		include_once dirname( __FILE__ ) . '/inc/core/wp_mail.php';
		include_once dirname( __FILE__ ) . '/inc/shortcode.php';
		include_once dirname( __FILE__ ) . '/inc/wp2chk_popup.php';

		/*
		 * Load List Of classes
		 */
		foreach ( self::$providers as $class ) {
			$class_object = '\TO_CHECKOUT\\' . $class;
			new $class_object;
		}

	}

	/**
	 * Used for regular plugin work.
	 *
	 * @wp-hook init Hook
	 * @return  void
	 */
	public function init_hooks() {

		/*
		 * Activation Plugin Hook
		 */
		register_activation_hook( __FILE__, array( '\TO_CHECKOUT\config\install', 'run_install' ) );

		/*
		 * Uninstall Plugin Hook
		 */
		register_deactivation_hook( __FILE__, array( '\TO_CHECKOUT\config\uninstall', 'run_uninstall' ) );

		/*
		 * Load i18n
		 */
		if ( self::$use_i18n === true ) {
			new \TO_CHECKOUT\config\i18n( 'wp-to-checkout' );
		}

		//Check $ENVIRONMENT Mode
		if ( self::$ENVIRONMENT == "development" ) {
			include_once dirname( __FILE__ ) . '/inc/core/debug.php';
			new \TO_CHECKOUT\core\debug();
		}

	}

	/**
	 * Show notice about PHP version
	 *
	 * @return void
	 */
	function php_version_notice() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$error = __( 'Your installed PHP Version is: ', 'wp-to-checkout' ) . PHP_VERSION . '. ';
		$error .= __( 'The <strong>WP Plugin</strong> plugin requires PHP version <strong>', 'wp-to-checkout' ) . $this->min_php . __( '</strong> or greater.', 'wp-to-checkout' );
		?>
        <div class="error">
            <p><?php printf( $error ); ?></p>
        </div>
		<?php
	}
	
	/**
	* Write WordPress Log
	*
	* @param $log
	*/
	public static function log($log)
	{
		if (true === WP_DEBUG) {
		    if (is_array($log) || is_object($log)) {
			error_log(print_r($log, true));
		    } else {
			error_log($log);
		    }
		}
	}
}

/**
 * Main instance of To_Checkout.
 *
 * @since  1.1.0
 */
function to_checkout() {
	return TO_CHECKOUT::instance();
}

// Global for backwards compatibility.
$GLOBALS['wp-to-checkout'] = to_checkout();

// add_action('enqueue_block_assets', 'wp2_checkout_block_assets');

if (!function_exists('wp2_checkout_block_assets')) {
    function wp2_checkout_block_assets()
    { // phpcs:ignore
        // 
		// wp_enqueue_style('wp2-checkout-bootstrap', plugins_url('/asset/public/css/bootstrap.min.css', __FILE__), null);
		// wp_enqueue_style('wp2-checkout-bootstrap', plugins_url('/asset/admin/css/buttons.css', __FILE__), null);
	}
}
