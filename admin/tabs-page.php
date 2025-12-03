<main>
    <h1 style="margin-left:10px;"><?php echo $title;?></h1>
      <div class="tabs">
        <div class="tab-container">
          <div id="tab4" class="tab">
            <a href="#tab4">Pestaña 4</a>
            <div class="tab-content">
              <h2>Titulo 4</h2>
              <p>Lorem ipsum ...</p>
            </div>
          </div>
          <div id="tab3" class="tab">
            <a href="#tab3">Ocultar en</a>
            <div class="tab-content">
              <h2>Donde quieres ocultar el botón</h2>

            <form id="btn-exclude" method="post" action="options.php">
              <table class="form-table">

                <tr>
                    <th>Oculatar en Páginas:</th>
                    <td>
                        <input type="checkbox" name="simple_wp_floating_button_excluir_pages"
                               value="1" <?php checked(get_option('simple_wp_floating_button_excluir_pages'), 1); ?>>
                    </td>
                </tr>

                 <tr>
                    <th>Oculatar en Entradas:</th>
                    <td>
                        <input type="checkbox" name="simple_wp_floating_button_excluir_single"
                               value="1" <?php checked(get_option('simple_wp_floating_button_excluir_single'), 1); ?>>
                    </td>
                </tr>


                <tr>
                    <th>Oculatar en URLs espesífica:</th>
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
                        <div id="simple-wp-floating-button-estado" style="margin-left:15px;"></div>
                    </td>
                </tr>

            </table>
            </form>
            </div>
          </div>
          <div id="tab2" class="tab">
            <a href="#tab2">Icono</a>
            <div class="tab-content">
              <h2>Configuración del Icono</h2>
              <form id="btn-svg" method="post" action="options.php">

                <table class="form-table">
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

                <tr>
                    <th></th>
                    <td>
                        <input type="submit" value="Guardar Icono" id="save-svg-btn" class="button button-secondary">
                        <div id="simple-wp-floating-button-estado" style="margin-left:15px;"></div>
                    </td>
                </tr>
            </table>

              </form>
            </div>
          </div>
          <div id="tab1" class="tab">
            <a href="#tab1">Botón</a>
            <div class="tab-content">
              <h2>Configuración del Botón</h2>
              <form id="btn-settings" method="post" action="options.php">
                <?php settings_fields('simple_wp_floating_button_opciones'); ?>

                <table class="form-table">
                <tr>
                <th>Activar Botón flotante:</th>
                <td>
                    <input type="checkbox" name="simple_wp_floating_button_auto" value="1" <?php checked(get_option('simple_wp_floating_button_auto'), 1); ?>>
                        Mostrar el Botón flotante
                    </td>
                </tr>

                <tr>
                    <th>Color del Botón:</th>
                    <td>
                        <input type="color" name="simple_wp_floating_button_color"
                            value="<?php echo esc_attr(get_option('simple_wp_floating_button_color', '#1394cfff')); ?>">
                    </td>
                </tr>

                <tr>
                    <th>Texto del Botón:</th>
                    <td>
                        <input type="text" name="simple_wp_floating_button_texto"
                               value="<?php echo esc_attr(get_option('simple_wp_floating_button_texto', 'Haz clic aquí')); ?>"
                               style="width: 300px;">
                    </td>
                </tr>

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

                <tr>
                    <th>Posición:</th>
                    <td>
                        <select name="simple_wp_floating_button_position">
                            <option value="left" <?php selected($position, 'left'); ?>>Izquierda</option>
                            <option value="center" <?php selected($position, 'center'); ?>>Centro</option>
                            <option value="right" <?php selected($position, 'right'); ?>>Derecha</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th>Animación:</th>
                    <td>
                        <select name="simple_wp_floating_button_animation">
                            <option value="pulse" <?php selected($animation, 'pulse'); ?>>Pulse</option>
                            <option value="pulse-halo" <?php selected($animation, 'pulse-halo'); ?>>Pulse Halo</option>
                            <option value="float" <?php selected($animation, 'float'); ?>>Float</option>
                            <option value="spin" <?php selected($animation, 'spin'); ?>>Spin</option>
                            <option value="bounce" <?php selected($animation, 'bounce'); ?>>Bounce</option>
                            <option value="no-animation" <?php selected($animation, 'no-animation'); ?>>Ninguna</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th></th>
                    <td>
                        <?php submit_button(); ?>
                        <div id="simple-wp-floating-button-estado" style="margin-left:15px;"></div>
                    </td>
                </tr>
              </table>


              </form>
              
              

            </div>
          </div>
        </div>
      </div>
    </main>