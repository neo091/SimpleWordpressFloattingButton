<?php

if (!defined('ABSPATH')) exit;


add_action('wp_ajax_mi_boton_guardar_ajax', 'mi_boton_guardar_configuracion');
function mi_boton_guardar_configuracion(){
    check_ajax_referer('mi_boton_nonce', 'nonce');

    if(!isset($_POST['data'])) wp_send_json_error('Datos vacíos');

    parse_str($_POST['data'], $form_data); // convierte en array

    // Guardar opciones
    update_option('mi_boton_auto', isset($form_data['mi_boton_auto']) ? 1 : 0);
    update_option('mi_boton_excluir', $form_data['mi_boton_excluir'] ?? '');
    update_option('mi_boton_color', $form_data['mi_boton_color'] ?? '#007bff');
    update_option('mi_boton_texto', $form_data['mi_boton_texto'] ?? '');
    update_option('mi_boton_svg', $form_data['mi_boton_svg'] ?? '');
    update_option('mi_boton_icon_color', $form_data['mi_boton_icon_color'] ?? '#000000');
    update_option('mi_boton_icon_size', $form_data['mi_boton_icon_size'] ?? 'mediano');
    update_option('mi_boton_url', $form_data['mi_boton_url'] ?? '');
    update_option('mi_boton_target', isset($form_data['mi_boton_target']) ? 1 : 0);
    update_option('mi_boton_excluir_pages', isset($form_data['mi_boton_excluir_pages']) ? 1 : 0);
    update_option('mi_boton_excluir_single', isset($form_data['mi_boton_excluir_single']) ? 1 : 0);

    wp_send_json_success();
}

// Registrar ajustes
function mi_boton_register_settings() {
    register_setting('mi_boton_opciones', 'mi_boton_color');
    register_setting('mi_boton_opciones', 'mi_boton_texto');
    register_setting('mi_boton_opciones', 'mi_boton_svg');  // NUEVO
    register_setting("mi_boton_opciones", 'mi_boton_icon_color');  // NUEVO
    register_setting('mi_boton_opciones', 'mi_boton_icon_size');  // NUEVO
    register_setting('mi_boton_opciones', 'mi_boton_url');  // NUEVO
    register_setting('mi_boton_opciones', 'mi_boton_target');  // NUEVO
    register_setting('mi_boton_opciones', 'mi_boton_auto');
    register_setting('mi_boton_opciones', 'mi_boton_excluir');
    register_setting('mi_boton_opciones', 'mi_boton_excluir_pages');
    register_setting('mi_boton_opciones', 'mi_boton_excluir_single');
}
add_action('admin_init', 'mi_boton_register_settings');

// Menú admin
function mi_boton_admin_menu() {
    add_menu_page(
        'Configuración Mi Botón',
        'Mi Botón',
        'manage_options',
        'mi-boton-config',
        'mi_boton_settings_page',
        'dashicons-admin-customizer',
        80
    );
}
add_action('admin_menu', 'mi_boton_admin_menu');

// obtnener lista de iconos
function mi_boton_get_icon_list() {
    $svg_path = MI_BOTON_PATH . 'assets/icons/';
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
function mi_boton_settings_page() {

    $svg_list = mi_boton_get_icon_list();
    $value = get_option('mi_boton_icon_size', 'mediano');

?>
    <div class="wrap">
        <div class="">
            <h1>Configuración del Botón</h1>

        <form method="post" action="options.php">
            <?php settings_fields('mi_boton_opciones'); ?>

            <h2>Diseño del Botón Flotante</h2>
            
            <table class="form-table">

             <tr>
                    <th>Activar botón flotante:</th>
                    <td>
                        <input type="checkbox" name="mi_boton_auto"
                               value="1" <?php checked(get_option('mi_boton_auto'), 1); ?>>
                        Mostrar el botón flotante
                    </td>
                </tr>

                <tr>
                    <th>Color del botón:</th>
                    <td>
                        <input type="color" name="mi_boton_color"
                            value="<?php echo esc_attr(get_option('mi_boton_color', '#1394cfff')); ?>">
                    </td>
                </tr>

                <tr>
                    <th>Texto del botón:</th>
                    <td>
                        <input type="text" name="mi_boton_texto"
                               value="<?php echo esc_attr(get_option('mi_boton_texto', 'Haz clic aquí')); ?>"
                               style="width: 300px;">
                    </td>
                </tr>

                <tr>
                    <th>Icono SVG cargado:</th>
                    <td>
                        <select name="mi_boton_svg" style="width:300px;">
                            <option value="">— Ninguno —</option>
                            <?php foreach ($svg_list as $svg): ?>
                                <option value="<?php echo esc_attr($svg); ?>"
                                    <?php selected(get_option('mi_boton_svg'), $svg); ?>>
                                    <?php echo esc_html($svg); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Color del Icono:</th>
                    <td>
                        <input type="color" name="mi_boton_icon_color"
                            value="<?php echo esc_attr(get_option('mi_boton_icon_color', '#000000ff')); ?>">
                    </td>
                </tr>
                <tr>
                    <th>Icono Tamaño:</th>
                    <td>
                        <select name="mi_boton_icon_size">
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
                        <input type="text" name="mi_boton_url"
                               placeholder="https://tusitio.com"
                               value="<?php echo esc_attr(get_option('mi_boton_url')); ?>"
                               style="width:400px;">
                    </td>
                </tr>

                <tr>
                    <th>Abrir en nueva pestaña:</th>
                    <td>
                        <input type="checkbox" name="mi_boton_target" value="1"
                            <?php checked(get_option('mi_boton_target'), 1); ?>>
                        <label> Sí, abrir en otra pestaña</label>
                    </td>
                </tr>

            </table>

            <h2>Donde se verá</h2>

            <table class="form-table">

               

                <tr>
                    <th>Excluir Paginas:</th>
                    <td>
                        <input type="checkbox" name="mi_boton_excluir_pages"
                               value="1" <?php checked(get_option('mi_boton_excluir_pages'), 1); ?>>
                    </td>
                </tr>

                 <tr>
                    <th>Excluir Entradas:</th>
                    <td>
                        <input type="checkbox" name="mi_boton_excluir_single"
                               value="1" <?php checked(get_option('mi_boton_excluir_single'), 1); ?>>
                    </td>
                </tr>


                <tr>
                    <th>Excluir URLs espesifica:</th>
                    <td>
                        <textarea
                        name="mi_boton_excluir"
                        rows="6"
                        cols="60"
                        placeholder="/contacto 
https://tusitio.com"><?php echo esc_textarea(get_option('mi_boton_excluir')); ?></textarea>
                        <p class="description">Una URL por línea. Si coincide, el botón no aparece.</p>
                    </td>
                    
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <?php submit_button(); ?>
                        <span id="mi-boton-estado" style="margin-left:15px;"></span>
                    </td>
                </tr>

            </table>
            
        </form>
        </div>
    </div>
<?php
}
