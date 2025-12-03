<?php

if (!defined('ABSPATH')) exit;

function simple_wp_floating_button_build_button() {

    $options = get_option('simple_wp_floating_button_options', []);
    $color  = isset($options['color']) ? esc_attr($options['color']) : '#1692b1';
    $text  = $options['text'] ?? '';
    $svg   = $options['svg'] ?? '';
    $svg_icon_color = $options['icon_color'] ?? '#000000';
    $svg_icon_size  = $options['icon_size'] ?? 'mediano';
    $position = isset($options['position']) ? esc_attr($options['position']) : 'center';
    $animation = isset($options['animation']) ? esc_attr($options['animation']) : 'pulse-halo';
    $url = isset($options['url']) ? esc_url($options['url']) : '';
    $target = (isset($options['target']) && $options['target']) ? "target='_blank' rel='noopener'" : '';


    $contenido = "";

    // CLASES DEL BOTÓN
    $button_classes = ' simple-wp-floating-button';
    if (trim($text) === '') {
        $button_classes .= ' solo-icono';
    }

    $svg_content = '';
    // ICONO svg
    if ($svg) {

        $path = SIMPLE_WP_FLOATING_BUTTON_PATH . "assets/icons/" . $svg;

        if (file_exists($path)) {
            $svg_content = wp_cache_get($svg, 'simple_wp_floating_button_svg_icons');

            if (!$svg_content) {
                $svg_content = file_get_contents($path);
                wp_cache_set($svg, $svg_content, 'simple_wp_floating_button_svg_icons', 3600);
            }

            $contenido .= "<span class='simple-wp-floating-button-icono $svg_icon_size' style='color:$svg_icon_color'>$svg_content</span>";
        }
    }

    // TEXTO
    if ($text !== "") {
        $contenido .= "<span>$text</span>";
    }

    // si no hay contenido → no mostrar nada
    if ($contenido === "") return "";

    // ENVOLVER EL BOTÓN SIEMPRE DENTRO DEL WRAPPER
    $wrapper_classes = "simple-wp-floating-button-wrapper $position $animation";
    $wrapper_style = "style='--swp-halo-color: $color;'";

    if ($url) {
        $button_html = "<a href='$url' class='$button_classes' $target style='background:$color;'>$contenido</a>";
    } else {
        $button_html = "<div class='$button_classes' style='background:$color;'>$contenido</div>";
    }

    return sprintf(
        "<div class='%s' %s>%s</div>",
        esc_attr($wrapper_classes),
        $wrapper_style,
        $button_html
    );


}
