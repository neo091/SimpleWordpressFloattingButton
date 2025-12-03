<?php

if (!defined('ABSPATH')) exit;

function simple_wp_floating_button_auto_display() {

    $auto = get_option('simple_wp_floating_button_auto', false);
    if (!$auto) return;

    $excluir_pages  = get_option('simple_wp_floating_button_excluir_pages', false);
    $excluir_single = get_option('simple_wp_floating_button_excluir_single', false);
    $excluir_home   = get_option('simple_wp_floating_button_excluir_home', false);

    // Condiciones de exclusión
    if (($excluir_pages && is_page()) ||
        ($excluir_single && is_single()) ||
        ($excluir_home && is_home())
    ) {
        return;
    }

    // URLs excluidas
    $excluidas_raw = get_option('simple_wp_floating_button_excluir', '');
    $excluidas = array_filter(array_map('trim', explode("\n", $excluidas_raw)));

    $url_actual = home_url($_SERVER['REQUEST_URI']);

    foreach ($excluidas as $exc) {
        if ($exc !== '' && strpos($url_actual, $exc) !== false) {
            return;
        }
    }

    echo simple_wp_floating_button_build_button();
}

add_action('wp_footer', 'simple_wp_floating_button_auto_display');

