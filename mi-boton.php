<?php
/**
 * Plugin Name: Mi Botón Personalizado
 * Description: Plugin que agrega un botón con shortcode y permite colocarlo automáticamente con opciones de configuración.
 * Version: 1.1
 * Author: Marcos
 */

if (!defined('ABSPATH')) exit;

// Definir constantes
define('MI_BOTON_PATH', plugin_dir_path(__FILE__));
define('MI_BOTON_URL', plugin_dir_url(__FILE__));

// Cargar CSS
function mi_boton_enqueue_assets() {
    wp_enqueue_style('mi-boton-style', MI_BOTON_URL . 'assets/css/style.css');
}
add_action('wp_enqueue_scripts', 'mi_boton_enqueue_assets');


function mi_boton_enqueue_scripts($hook) {
    
    if($hook !== 'toplevel_page_mi-boton-config') return; // solo en la página del plugin
    wp_enqueue_script('mi-boton-ajax', plugin_dir_url(__FILE__) . 'assets/js/ajax-save.js', ['jquery'], null, true);
    wp_localize_script('mi-boton-ajax', 'miBotonAjax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('mi_boton_nonce')
    ]);
}

add_action('admin_enqueue_scripts', 'mi_boton_enqueue_scripts');

// Incluir archivos
require_once MI_BOTON_PATH . 'public/shortcode.php';
require_once MI_BOTON_PATH . 'public/auto-display.php';
require_once MI_BOTON_PATH . 'admin/settings-page.php';
