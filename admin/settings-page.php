<?php

if (!defined('ABSPATH')) exit;

add_action('wp_ajax_simple_wp_floating_button_save_ajax_tabs_config_btn', 'simple_wp_floating_button_guardar_configuracion_tabs');
function simple_wp_floating_button_guardar_configuracion_tabs(){
    check_ajax_referer('simple_wp_floating_button_nonce', 'nonce');

    if(!isset($_POST['data'])) wp_send_json_error('Datos vacíos');

    parse_str($_POST['data'], $form_data); // convierte en array

    // Guardar opciones
    update_option('simple_wp_floating_button_auto', isset($form_data['simple_wp_floating_button_auto']) ? 1 : 0);
    update_option('simple_wp_floating_button_color', $form_data['simple_wp_floating_button_color'] ?? '#007bff');
    update_option('simple_wp_floating_button_texto', $form_data['simple_wp_floating_button_texto'] ?? '');
    update_option('simple_wp_floating_button_position', $form_data['simple_wp_floating_button_position'] ?? 'center');
    update_option('simple_wp_floating_button_animation', $form_data['simple_wp_floating_button_animation'] ?? 'pulse');
    update_option('simple_wp_floating_button_url', $form_data['simple_wp_floating_button_url'] ?? '');
    update_option('simple_wp_floating_button_target', isset($form_data['simple_wp_floating_button_target']) ? 1 : 0);

    wp_send_json_success();
}

add_action('wp_ajax_simple_wp_floating_button_save_ajax_tabs_config_svg', 'simple_wp_floating_button_guardar_configuracion_tabs_svg');
function simple_wp_floating_button_guardar_configuracion_tabs_svg(){
    check_ajax_referer('simple_wp_floating_button_nonce', 'nonce');

    if(!isset($_POST['data'])) wp_send_json_error('Datos vacíos');

    parse_str($_POST['data'], $form_data); // convierte en array

    // Guardar opciones
    update_option('simple_wp_floating_button_svg', $form_data['simple_wp_floating_button_svg'] ?? '');
    update_option('simple_wp_floating_button_icon_color', $form_data['simple_wp_floating_button_icon_color'] ?? '#000000');
    update_option('simple_wp_floating_button_icon_size', $form_data['simple_wp_floating_button_icon_size'] ?? 'mediano');

    wp_send_json_success();
}

add_action('wp_ajax_simple_wp_floating_button_save_ajax_tabs_config_exclude', 'simple_wp_floating_button_guardar_configuracion_tabs_exclude');
function simple_wp_floating_button_guardar_configuracion_tabs_exclude(){
    check_ajax_referer('simple_wp_floating_button_nonce', 'nonce');

    if(!isset($_POST['data'])) wp_send_json_error('Datos vacíos');

    parse_str($_POST['data'], $form_data); // convierte en array

    // Guardar opciones
    update_option('simple_wp_floating_button_excluir_pages', isset($form_data['simple_wp_floating_button_excluir_pages']) ? 1 : 0);
    update_option('simple_wp_floating_button_excluir', $form_data['simple_wp_floating_button_excluir'] ?? '');
    update_option('simple_wp_floating_button_excluir_single', isset($form_data['simple_wp_floating_button_excluir_single']) ? 1 : 0);

    wp_send_json_success();
}

// Registrar ajustes
function simple_wp_floating_button_register_settings() {
    register_setting('simple_wp_floating_button_opciones', 'simple_wp_floating_button_color');
    register_setting('simple_wp_floating_button_opciones', 'simple_wp_floating_button_texto');
    register_setting('simple_wp_floating_button_opciones', 'simple_wp_floating_button_position');
    register_setting('simple_wp_floating_button_opciones', 'simple_wp_floating_button_animation');
    register_setting('simple_wp_floating_button_opciones', 'simple_wp_floating_button_svg');  // NUEVO
    register_setting("simple_wp_floating_button_opciones", 'simple_wp_floating_button_icon_color');  // NUEVO
    register_setting('simple_wp_floating_button_opciones', 'simple_wp_floating_button_icon_size');  // NUEVO
    register_setting('simple_wp_floating_button_opciones', 'simple_wp_floating_button_url');  // NUEVO
    register_setting('simple_wp_floating_button_opciones', 'simple_wp_floating_button_target');  // NUEVO
    register_setting('simple_wp_floating_button_opciones', 'simple_wp_floating_button_auto');
    register_setting('simple_wp_floating_button_opciones', 'simple_wp_floating_button_excluir');
    register_setting('simple_wp_floating_button_opciones', 'simple_wp_floating_button_excluir_pages');
    register_setting('simple_wp_floating_button_opciones', 'simple_wp_floating_button_excluir_single');
}
add_action('admin_init', 'simple_wp_floating_button_register_settings');

// Menú admin
function simple_wp_floating_button_admin_menu() {
    add_menu_page(
        'Simple WP Floating Button',
        'Simple WP FB',
        'manage_options',
        'simple-wp-floating-button-tabs',
        'simple_wp_floating_button_tabs_page',
        'dashicons-admin-customizer',
    );
}
add_action('admin_menu', 'simple_wp_floating_button_admin_menu');

// obtnener lista de iconos
function simple_wp_floating_button_get_icon_list() {
    $svg_path = SIMPLE_WP_FLOATING_BUTTON_PATH . 'assets/icons/';
    $icons = [];

    if (is_dir($svg_path)) {
        $files = scandir($svg_path);
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'svg') {
                $icons[] = $file;
            }
        }
    }

    return $icons;
}

function simple_wp_floating_button_tabs_page() {
    $title = 'Simple WP Floating Button';

    $svg_list = simple_wp_floating_button_get_icon_list();
    $value = get_option('simple_wp_floating_button_icon_size', 'mediano');
    $position = get_option('simple_wp_floating_button_position', 'center');
    $animation = get_option('simple_wp_floating_button_animation', 'pulse');

    
    require_once SIMPLE_WP_FLOATING_BUTTON_PATH . 'admin/tabs-page.php';
}

