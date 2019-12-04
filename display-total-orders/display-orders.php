<?php
/**
 * Plugin Name: Display Woocommerce Order
 * Plugin URI: 
 * Description: Display total woocommerce order done till now.
 * Version: 1.0.0
 * Author: Priyaranjan
 * Author URI: ''
 *
 * @package Display-Woocommerce-Order
 */

/**
 * Description
 *
 * add additonal status by comma separated example [display_total_order_count status="completed,pending"]
 *
 * shortcode: [display_total_order_count] 
 * status is optional, by default display complete order count
 * add this shortcode anywhere to display order count
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!defined('DISPLAY_ORDER_COUNT')){
   define('DISPLAY_ORDER_COUNT',  plugin_dir_path( __FILE__ ));
}

function display_woocommerce_order_count( $atts, $content = null ) {
	$args = shortcode_atts( array(
		'status' => 'completed',
	), $atts );
	$statuses    = array_map( 'trim', explode( ',', $args['status'] ) );
	$orderCount = 0;
	foreach ( $statuses as $status ) {
		$oStatus=explode("-",$status);
		if ( $oStatus[0]!='wc' ) {
			$status = 'wc-' . $status;
		}
		$orderCount += wp_count_posts( 'shop_order' )->$status;
	}
	ob_start();
	$orderCount=number_format( $orderCount );
	echo '<p>' . sprintf( __( 'Units Sold: %s', 'woocommerce' ), $orderCount ) . '</p>';
	return ob_get_clean();
}
add_shortcode( 'display_total_order_count', 'display_woocommerce_order_count' );
