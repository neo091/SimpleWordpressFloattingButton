<?php

if (!defined('ABSPATH')) exit;


add_action('wp_ajax_simple_wp_floating_button_guardar_ajax', 'simple_wp_floating_button_guardar_configuracion');
function simple_wp_floating_button_guardar_configuracion(){
    check_ajax_referer('simple_wp_floating_button_nonce', 'nonce');

    if(!isset($_POST['data'])) wp_send_json_error('Datos vacíos');

    parse_str($_POST['data'], $form_data); // convierte en array

    // Guardar opciones
    update_option('simple_wp_floating_button_auto', isset($form_data['simple_wp_floating_button_auto']) ? 1 : 0);
    update_option('simple_wp_floating_button_excluir', $form_data['simple_wp_floating_button_excluir'] ?? '');
    update_option('simple_wp_floating_button_color', $form_data['simple_wp_floating_button_color'] ?? '#007bff');
    update_option('simple_wp_floating_button_texto', $form_data['simple_wp_floating_button_texto'] ?? '');
    update_option('simple_wp_floating_button_svg', $form_data['simple_wp_floating_button_svg'] ?? '');
    update_option('simple_wp_floating_button_icon_color', $form_data['simple_wp_floating_button_icon_color'] ?? '#000000');
    update_option('simple_wp_floating_button_icon_size', $form_data['simple_wp_floating_button_icon_size'] ?? 'mediano');
    update_option('simple_wp_floating_button_url', $form_data['simple_wp_floating_button_url'] ?? '');
    update_option('simple_wp_floating_button_target', isset($form_data['simple_wp_floating_button_target']) ? 1 : 0);
    update_option('simple_wp_floating_button_excluir_pages', isset($form_data['simple_wp_floating_button_excluir_pages']) ? 1 : 0);
    update_option('simple_wp_floating_button_excluir_single', isset($form_data['simple_wp_floating_button_excluir_single']) ? 1 : 0);

    wp_send_json_success();
}

// Registrar ajustes
function simple_wp_floating_button_register_settings() {
    register_setting('simple_wp_floating_button_opciones', 'simple_wp_floating_button_color');
    register_setting('simple_wp_floating_button_opciones', 'simple_wp_floating_button_texto');
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
        'Configuración Mi Botón',
        'Mi Botón',
        'manage_options',
        'simple-wp-floating-button-config',
        'simple_wp_floating_button_settings_page',
        'dashicons-admin-customizer',
        80
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


// Página de configuración
function simple_wp_floating_button_settings_page() {

    $svg_list = simple_wp_floating_button_get_icon_list();
    $value = get_option('simple_wp_floating_button_icon_size', 'mediano');

?>
    <div class="wrap">
        <div class="">
            <h1>Configuración del Botón</h1>

        <form method="post" action="options.php">
            <?php settings_fields('simple_wp_floating_button_opciones'); ?>

            <h2>Diseño del Botón Flotante</h2>
            
            <table class="form-table">

             <tr>
                    <th>Activar botón flotante:</th>
                    <td>
                        <input type="checkbox" name="simple_wp_floating_button_auto"
                               value="1" <?php checked(get_option('simple_wp_floating_button_auto'), 1); ?>>
                        Mostrar el botón flotante
                    </td>
                </tr>

                <tr>
                    <th>Color del botón:</th>
                    <td>
                        <input type="color" name="simple_wp_floating_button_color"
                            value="<?php echo esc_attr(get_option('simple_wp_floating_button_color', '#1394cfff')); ?>">
                    </td>
                </tr>

                <tr>
                    <th>Texto del botón:</th>
                    <td>
                        <input type="text" name="simple_wp_floating_button_texto"
                               value="<?php echo esc_attr(get_option('simple_wp_floating_button_texto', 'Haz clic aquí')); ?>"
                               style="width: 300px;">
                    </td>
                </tr>

                <tr>
                    <th>Icono SVG cargado:</th>
                    <td>
                        <select name="simple_wp_floating_button_svg" style="width:300px;">
                            <option value="">— Ninguno —</option>
                            <?php foreach ($svg_list as $svg): ?>
                                <option value="<?php echo esc_attr($svg); ?>"
                                    <?php selected(get_option('simple_wp_floating_button_svg'), $svg); ?>>
                                    <?php echo esc_html($svg); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Color del Icono:</th>
                    <td>
                        <input type="color" name="simple_wp_floating_button_icon_color"
                            value="<?php echo esc_attr(get_option('simple_wp_floating_button_icon_color', '#000000ff')); ?>">
                    </td>
                </tr>
                <tr>
                    <th>Icono Tamaño:</th>
                    <td>
                        <select name="simple_wp_floating_button_icon_size">
                            <option value="pequeno" <?php selected($value, 'pequeno'); ?>>Pequeño</option>
                            <option value="mediano" <?php selected($value, 'mediano'); ?>>Mediano</option>
                            <option value="grande" <?php selected($value, 'grande'); ?>>Grande</option>
                        </select>
                        <p class="description">Tamaño del icono</p>
                    </td>
                </tr>

            </table>

            <h2>Enlace</h2>
            <table class="form-table">

                <tr>
                    <th>URL del botón:</th>
                    <td>
                        <input type="text" name="simple_wp_floating_button_url"
                               placeholder="https://tusitio.com"
                               value="<?php echo esc_attr(get_option('simple_wp_floating_button_url')); ?>"
                               style="width:400px;">
                    </td>
                </tr>

                <tr>
                    <th>Abrir en nueva pestaña:</th>
                    <td>
                        <input type="checkbox" name="simple_wp_floating_button_target" value="1"
                            <?php checked(get_option('simple_wp_floating_button_target'), 1); ?>>
                        <label> Sí, abrir en otra pestaña</label>
                    </td>
                </tr>

            </table>

            <h2>Donde se verá</h2>

            <table class="form-table">

               

                <tr>
                    <th>Excluir Paginas:</th>
                    <td>
                        <input type="checkbox" name="simple_wp_floating_button_excluir_pages"
                               value="1" <?php checked(get_option('simple_wp_floating_button_excluir_pages'), 1); ?>>
                    </td>
                </tr>

                 <tr>
                    <th>Excluir Entradas:</th>
                    <td>
                        <input type="checkbox" name="simple_wp_floating_button_excluir_single"
                               value="1" <?php checked(get_option('simple_wp_floating_button_excluir_single'), 1); ?>>
                    </td>
                </tr>


                <tr>
                    <th>Excluir URLs espesifica:</th>
                    <td>
                        <textarea
                        name="simple_wp_floating_button_excluir"
                        rows="6"
                        cols="60"
                        placeholder="/contacto 
https://tusitio.com"><?php echo esc_textarea(get_option('simple_wp_floating_button_excluir')); ?></textarea>
                        <p class="description">Una URL por línea. Si coincide, el botón no aparece.</p>
                    </td>
                    
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <?php submit_button(); ?>
                        <span id="simple-wp-floating-button-estado" style="margin-left:15px;"></span>
                    </td>
                </tr>

            </table>
            
        </form>
        </div>
    </div>
<?php
}
