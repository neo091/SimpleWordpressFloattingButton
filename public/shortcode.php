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

    $contenido = "";

    $classes = ' simple-wp-floating-button-personalizado';
    if (trim($texto) === '') {
        $classes .= ' solo-icono'; // clase para botón circular
    }

    // SVG PRIORIDAD MÁXIMA
    if ($svg) {
        $path = SIMPLE_WP_FLOATING_BUTTON_PATH . "assets/icons/" . $svg;
        if (file_exists($path)) {
            $contenido .= "<span class='simple-wp-floating-button-icono ". esc_attr($svg_icon_size)."' style='color:".$svg_icon_color."'> " . file_get_contents($path) . "</span>";
        }
    }

    // Texto (si existe)
    if ($texto !== "") {
        $contenido .= "<span>$texto</span>";
    }

    // Envolver en enlace si hay URL
    if ($url && $contenido!=="") {
        return "<a href='$url' class='".$classes."' $target style='background:$color;'>$contenido</a>";
    }

    if($contenido==="") return ""; // Si no hay contenido, no mostrar nada  


    return "<div class='".$classes."' style='background:$color;'>$contenido</div>";
}

function simple_wp_floating_button_shortcode() {
    return simple_wp_floating_button_build_button();
}

add_shortcode('simple_wp_floating_button', 'simple_wp_floating_button_shortcode');
