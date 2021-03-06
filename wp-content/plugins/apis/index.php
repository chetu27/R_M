<?php

/**
 * @wordpress-plugin
 * Plugin Name:       FBAG APIS
 * Plugin URI:        FBAG APIS
 * Description:       Plugin to change Api format to custom formatting
 * Version:           1.0.0
 * Author:            Chetu
 * Author URI:        chetu.com
 * License:           GPL-2.0+
 * Text Domain:       fbag
 * Domain Path:       /languages 
 */

require_once plugin_dir_path(__FILE__).'includes/class-get-product.php'; 

add_action('rest_api_init', 'add_custom_api_request');
function add_custom_api_request()
{
    register_rest_route('custom-api', '/getProductList', array(
        'methods' 	=> 'GET',
        'callback' 	=> 'getProductList',
        'permission_callback' => '__return_true'
    ));

    register_rest_route('custom-api', '/getProductById', array(
        'methods'   => 'GET',
        'callback'  => 'getProductById',
        'permission_callback' => '__return_true'
    ));

    register_rest_route('custom-api', '/productInsert', array(
        'methods'   => 'POST',
        'callback'  => 'productInsert',
        'permission_callback' => '__return_true'
    ));

    register_rest_route('custom-api', '/productDelete', array(
        'methods'   => 'GET',
        'callback'  => 'productDelete',
        'permission_callback' => '__return_true'
    ));

    register_rest_route('custom-api', '/searchAutoComplete', array(
        'methods'   => 'GET',
        'callback'  => 'searchAutoComplete',
        'permission_callback' => '__return_true'
    ));

    register_rest_route('custom-api', '/productAvailable', array(
        'methods' 	=> 'GET',
        'callback' 	=> 'productAvailable',
        'permission_callback' => '__return_true'
    ));   
    register_rest_route('custom-api', '/productByBarcode', array(
        'methods'   => 'GET',
        'callback'  => 'productByBarcode',
        'permission_callback' => '__return_true'
    ));
}
