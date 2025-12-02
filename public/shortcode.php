<?php

if (!defined('ABSPATH')) exit;

function simple_wp_floating_button_build_button() {
    $color  = esc_attr(get_option('simple_wp_floating_button_color', '#ff0000'));
    $texto  = esc_html(get_option('simple_wp_floating_button_texto'));
    $svg    = get_option('simple_wp_floating_button_svg');
    $svg_icon_size = get_option('simple_wp_floating_button_icon_size', 'mediano');
    $svg_icon_color = get_option('simple_wp_floating_button_icon_color', '#000000ff');
    $url    = esc_url(get_option('simple_wp_floating_button_url'));
    $target = get_option('simple_wp_floating_button_target') ? ' target="_blank"' : '';
    $animation = get_option('simple_wp_floating_button_animation')  ?? 'pulse-halo';
    $position = get_option('simple_wp_floating_button_position', 'center');

    $contenido = "";

    // CLASES DEL BOTÓN
    $button_classes = ' simple-wp-floating-button-personalizado';
    if (trim($texto) === '') {
        $button_classes .= ' solo-icono';
    }

    // ICONO
    if ($svg) {
        $path = SIMPLE_WP_FLOATING_BUTTON_PATH . "assets/icons/" . $svg;
        if (file_exists($path)) {
            $contenido .= "<span class='simple-wp-floating-button-icono ". esc_attr($svg_icon_size)."' style='color:".$svg_icon_color."'> " . file_get_contents($path) . "</span>";
        }
    }

    // TEXTO
    if ($texto !== "") {
        $contenido .= "<span>$texto</span>";
    }

    // si no hay contenido → no mostrar nada
    if ($contenido === "") return "";

    // ENVOLVER EL BOTÓN SIEMPRE DENTRO DEL WRAPPER
    $wrapper_classes = 'simple-wp-floating-button-wrapper ' . $position . ' ' . $animation;
    $wrapper_style = "style='--swp-halo-color: $color;'";

    if ($url) {
        $button_html = "<a href='$url' class='".$button_classes."' $target style='background:$color;'>$contenido</a>";
    } else {
        $button_html = "<div class='".$button_classes."' style='background:$color;'>$contenido</div>";
    }

    return '<div class="'.$wrapper_classes.'" '.$wrapper_style.'>'.$button_html.'</div>';

}

function simple_wp_floating_button_shortcode() {
    return simple_wp_floating_button_build_button();
}

add_shortcode('simple_wp_floating_button', 'simple_wp_floating_button_shortcode');
