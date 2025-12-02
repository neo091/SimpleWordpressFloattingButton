<?php

if (!defined('ABSPATH')) exit;

function simple_wp_floating_button_auto_display() {

    if(!get_option('simple_wp_floating_button_auto')) return;
    if(get_option('simple_wp_floating_button_excluir_pages') && is_page()) return;
    if(get_option('simple_wp_floating_button_excluir_single') && is_single()) return;
    if(get_option('simple_wp_floating_button_excluir_single') && is_home()) return;

    $excluidas_raw = get_option('simple_wp_floating_button_excluir', '');
    $excluidas = array_filter(array_map('trim', explode("\n", $excluidas_raw)));

    $url_actual = home_url(add_query_arg([], $_SERVER['REQUEST_URI']));

    foreach ($excluidas as $exc) {
        if ($exc !== '' && strpos($url_actual, $exc) !== false) {
            return;
        }
    }

    echo simple_wp_floating_button_build_button();
}

add_action('wp_footer', 'simple_wp_floating_button_auto_display');
