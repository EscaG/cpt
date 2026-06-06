<?php

function get_vite_asset_url($entry) {
    $manifest_path = get_template_directory() . '/dist/.vite/manifest.json';

    if (!file_exists($manifest_path)) {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            return 'http://psychological-support-center.local:5173/' . $entry; // Путь относительно origin
        }
        return get_template_directory_uri() . '/dist/' . $entry;
    }

    $manifest = json_decode(file_get_contents($manifest_path), true);

    if (isset($manifest[$entry])) {
        return get_template_directory_uri() . '/dist/' . $manifest[$entry]['file'];
    }

    return get_template_directory_uri() . '/dist/' . $entry;
}

function get_vite_css_url($entry) {
    $manifest_path = get_template_directory() . '/dist/.vite/manifest.json';

    if (!file_exists($manifest_path)) {
        return false;
    }

    $manifest = json_decode(file_get_contents($manifest_path), true);

    if (isset($manifest[$entry]['css']) && is_array($manifest[$entry]['css'])) {
        return get_template_directory_uri() . '/dist/' . $manifest[$entry]['css'][0];
    }

    return false;
}
