<?php

if (!defined('ABSPATH')) exit;

add_action('wp_ajax_simple_wp_floating_button_save_ajax_tabs_config_btn', 'simple_wp_floating_button_guardar_configuracion_tabs');
function simple_wp_floating_button_guardar_configuracion_tabs(){
    check_ajax_referer('simple_wp_floating_button_nonce', 'nonce');

    if(!isset($_POST['data'])) wp_send_json_error('Datos vacíos');

    parse_str($_POST['data'], $form_data); // convierte en array

    // Guardar opciones
    $options = get_option('simple_wp_floating_button_options', []);

    $options['color'] = $form_data['simple_wp_floating_button_color'] ?? '#007bff';
    $options['text'] = $form_data['simple_wp_floating_button_text'] ?? '';
    $options['position'] = $form_data['simple_wp_floating_button_position'] ?? 'center';
    $options['animation'] = $form_data['simple_wp_floating_button_animation'] ?? 'pulse';
    $options['url'] = $form_data['simple_wp_floating_button_url'] ?? '';
    $options['target'] = isset($form_data['simple_wp_floating_button_target']) ? 1 : 0;
    $options['auto'] = isset($form_data['simple_wp_floating_button_auto']) ? 1 : 0;

    update_option('simple_wp_floating_button_options', $options);

    wp_send_json_success();
}

add_action('wp_ajax_simple_wp_floating_button_save_ajax_tabs_config_svg', 'simple_wp_floating_button_guardar_configuracion_tabs_svg');
function simple_wp_floating_button_guardar_configuracion_tabs_svg(){
    check_ajax_referer('simple_wp_floating_button_nonce', 'nonce');

    if(!isset($_POST['data'])) wp_send_json_error('Datos vacíos');

    parse_str($_POST['data'], $form_data); // convierte en array

    // Guardar opciones
    $options = get_option('simple_wp_floating_button_options', []);
    $options['svg'] = $form_data['simple_wp_floating_button_svg'] ?? '';
    $options['icon_color'] = $form_data['simple_wp_floating_button_icon_color'] ?? '#000000';
    $options['icon_size'] = $form_data['simple_wp_floating_button_icon_size'] ?? 'mediano';

    update_option('simple_wp_floating_button_options', $options);

    wp_send_json_success();
}

add_action('wp_ajax_simple_wp_floating_button_save_ajax_tabs_config_exclude', 'simple_wp_floating_button_guardar_configuracion_tabs_exclude');
function simple_wp_floating_button_guardar_configuracion_tabs_exclude(){
    check_ajax_referer('simple_wp_floating_button_nonce', 'nonce');

    if(!isset($_POST['data'])) wp_send_json_error('Datos vacíos');

    parse_str($_POST['data'], $form_data); // convierte en array

    // Guardar opciones
    $options = get_option('simple_wp_floating_button_options', []);

    $options['excluir'] = $form_data['simple_wp_floating_button_excluir'] ?? '';
    $options['excluir_pages'] = isset($form_data['simple_wp_floating_button_excluir_pages']) ? 1 : 0;
    $options['excluir_single'] = isset($form_data['simple_wp_floating_button_excluir_single']) ? 1 : 0;
    update_option('simple_wp_floating_button_options', $options);

    wp_send_json_success();
}

// Registrar ajustes
function simple_wp_floating_button_register_settings() {

    register_setting('simple_wp_floating_button_options', 'simple_wp_floating_button_options', [
        'type'=>'array',
        'default'=> [
            'color' => '#1692b1',
            'text' => '',
            'position' => 'center',
            'animation' => 'pulse-halo',
            'svg' => '',
            'icon_color' => '#000000ff',
            'icon_size' => 'mediano',
            'url' => '',
            'target' => 0,
            'auto' => 0,
            'excluir' => '',
            'excluir_pages' => 0,
            'excluir_single' => 0,
        ],
        'sanitize_callback' => 'simple_wp_floating_button_sanitize_options',
    ]);
}
add_action('admin_init', 'simple_wp_floating_button_register_settings');

function simple_wp_floating_button_sanitize_options($input) {
    return [
        'color' => sanitize_hex_color($input['color'] ?? '#ff0000'),
        'text' => sanitize_text_field($input['text'] ?? ''),
        'position' => sanitize_text_field($input['position'] ?? 'center'),
        'animation' => sanitize_text_field($input['animation'] ?? 'pulse-halo'),
        'svg' => sanitize_text_field($input['svg'] ?? ''),
        'icon_color' => sanitize_hex_color($input['icon_color'] ?? '#000000ff'),
        'icon_size' => sanitize_text_field($input['icon_size'] ?? 'mediano'),
        'url' => esc_url_raw($input['url'] ?? ''),
        'target' => !empty($input['target']) ? 1 : 0,
        'auto' => !empty($input['auto']) ? 1 : 0,
        'excluir' => sanitize_textarea_field($input['excluir'] ?? ''),
        'excluir_pages' => !empty($input['excluir_pages']) ? 1 : 0,
        'excluir_single' => !empty($input['excluir_single']) ? 1 : 0,
    ];
}

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

