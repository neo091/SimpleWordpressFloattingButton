<?php

if (!defined('ABSPATH')) exit;

function mi_boton_auto_display() {

    if(!get_option('mi_boton_auto')) return;
    if(get_option('mi_boton_excluir_pages') && is_page()) return;
    if(get_option('mi_boton_excluir_single') && is_single()) return;
    if(get_option('mi_boton_excluir_single') && is_home()) return;

    $excluidas_raw = get_option('mi_boton_excluir', '');
    $excluidas = array_filter(array_map('trim', explode("\n", $excluidas_raw)));

    $url_actual = home_url(add_query_arg([], $_SERVER['REQUEST_URI']));

    foreach ($excluidas as $exc) {
        if ($exc !== '' && strpos($url_actual, $exc) !== false) {
            return;
        }
    }

    echo mi_boton_build_button();
}

add_action('wp_footer', 'mi_boton_auto_display');
