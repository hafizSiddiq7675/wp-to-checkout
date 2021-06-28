<?php

namespace TO_CHECKOUT;
use TO_CHECKOUT;

/*
 * Ajax Method wordpress
 */
class Ajax {

	/**
	 * Ajax constructor.
	 */
	public function __construct() {

		$list_function = array(
			'test'
		);

		foreach ( $list_function as $method ) {
			add_action( 'wp_ajax_' . $method, array( $this, $method ) );
			add_action( 'wp_ajax_nopriv_' . $method, array( $this, $method ) );
		}

	}

	/**
	 * Test Ajax Method
	 */
	public function test() {
		global $wpdb;
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			if ( isset( $_REQUEST['wp_reviews_score'] ) ) {


				//Show Result
				TO_CHECKOUT\core\utility::json_exit( array( 'state_request' => 'success' ) );
			}
		}
		die();
	}

}