<?php
/**
 * Plugin Name: Simple Wordpress Floating Button
 * Description: Simple Wordpress Floating Button Plugin to add a customizable floating button to your website.
 * Version: 1.2
 * Author: neo091
 * License: MIT
 * Text Domain: simple-wp-floating-button
 */

if (!defined('ABSPATH')) exit;

// Definir constantes
define('SIMPLE_WP_FLOATING_BUTTON_PATH', plugin_dir_path(__FILE__));
define('SIMPLE_WP_FLOATING_BUTTON_URL', plugin_dir_url(__FILE__));

// Cargar CSS
function mi_boton_enqueue_assets() {
    wp_enqueue_style('simple-wp-floating-button-style', SIMPLE_WP_FLOATING_BUTTON_URL . 'assets/css/style.css');
}
add_action('wp_enqueue_scripts', 'mi_boton_enqueue_assets');


function simple_wp_floating_button_enqueue_scripts($hook) {
    
    if($hook !== 'toplevel_page_simple-wp-floating-button-config') return; // solo en la página del plugin
    wp_enqueue_script('simple-wp-floating-button-ajax', plugin_dir_url(__FILE__) . 'assets/js/ajax-save.js', ['jquery'], null, true);
    wp_localize_script('simple-wp-floating-button-ajax', 'miBotonAjax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('simple_wp_floating_button_nonce')
    ]);
}

add_action('admin_enqueue_scripts', 'simple_wp_floating_button_enqueue_scripts');

// Incluir archivos
require_once SIMPLE_WP_FLOATING_BUTTON_PATH . 'public/shortcode.php';
require_once SIMPLE_WP_FLOATING_BUTTON_PATH . 'public/auto-display.php';
require_once SIMPLE_WP_FLOATING_BUTTON_PATH . 'admin/settings-page.php';
