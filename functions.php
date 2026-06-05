<?php

function psc_enqueue_assets() {
    $theme_uri = get_template_directory_uri();
    $theme_dir = get_template_directory();
    $manifest_path = $theme_dir . '/dist/.vite/manifest.json';

    if (file_exists($manifest_path)) {
        // РЕЖИМ ПРОДАКШЕНА
        $manifest = json_decode(file_get_contents($manifest_path), true);

        if (isset($manifest['src/app.css'])) {
            wp_enqueue_style(
                'psc-style',
                $theme_uri . '/dist/' . $manifest['src/app.css']['file'],
                array(),
                wp_get_theme()->get('Version')
            );
        }

        if (isset($manifest['src/main.js'])) {
            wp_enqueue_script(
                'psc-script',
                $theme_uri . '/dist/' . $manifest['src/main.js']['file'],
                array(),
                wp_get_theme()->get('Version'),
                true
            );
        }
    } else {
        // РЕЖИМ РАЗРАБОТКИ
        $vite_dev_url = 'http://localhost:5173';

        wp_enqueue_script('vite-hmr-client', $vite_dev_url . '/@vite/client', array(), null, false);
        wp_enqueue_script('psc-script-dev', $vite_dev_url . '/src/main.js', array('vite-hmr-client'), null, true);
    }
}
add_action('wp_enqueue_scripts', 'psc_enqueue_assets');

// Фильтр для добавления type="module" к скриптам Vite
function psc_add_module_type_to_script($tag, $handle, $src) {
    if (in_array($handle, array('vite-hmr-client', 'psc-script-dev'))) {
        $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
    }
    return $tag;
}
add_filter('script_loader_tag', 'psc_add_module_type_to_script', 10, 3);

// Регистрируем области для меню при инициализации темы
add_action( 'after_setup_theme', 'my_custom_theme_menus' );

function my_custom_theme_menus() {
    register_nav_menus( array(
        'header-menu' => __( 'Главное меню в шапке', 'my-theme' ),
        // При желании можно добавить и другие, например:
        // 'footer-menu' => __( 'Меню в подвале', 'my-theme' ),
    ) );
}

require get_template_directory() . '/inc/vite.php';

function my_theme_enqueue_scripts() {
    $css_url = get_vite_css_url('assets/src/js/main.js');
    if ($css_url) {
        wp_enqueue_style('my-theme-styles', $css_url, [], null);
    }

    $js_url = get_vite_asset_url('assets/src/js/main.js');
    wp_enqueue_script('my-theme-scripts', $js_url, [], null, true);
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_scripts');

