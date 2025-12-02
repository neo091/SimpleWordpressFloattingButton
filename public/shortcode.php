<?php

if (!defined('ABSPATH')) exit;

function mi_boton_build_button() {
    $color  = esc_attr(get_option('mi_boton_color', '#ff0000'));
    $texto  = esc_html(get_option('mi_boton_texto'));
    $svg    = get_option('mi_boton_svg');
    $svg_icon_size = get_option('mi_boton_icon_size', 'mediano');
    $svg_icon_color = get_option('mi_boton_icon_color', '#000000ff');
    $url    = esc_url(get_option('mi_boton_url'));
    $target = get_option('mi_boton_target') ? ' target="_blank"' : '';

    $contenido = "";

    $classes = 'mi-boton-personalizado';
    if (trim($texto) === '') {
        $classes .= ' solo-icono'; // clase para botón circular
    }

    // SVG PRIORIDAD MÁXIMA
    if ($svg) {
        $path = MI_BOTON_PATH . "assets/icons/" . $svg;
        if (file_exists($path)) {
            $contenido .= "<span class='mi-boton-icono ". esc_attr($svg_icon_size)."' style='color:".$svg_icon_color."'> " . file_get_contents($path) . "</span>";
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

function mi_boton_shortcode() {
    return mi_boton_build_button();
}

add_shortcode('mi_boton', 'mi_boton_shortcode');
