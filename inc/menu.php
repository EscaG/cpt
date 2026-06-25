<?php
add_filter('nav_menu_link_attributes', 'add_alpine_menu_attributes', 10, 4);
function add_alpine_menu_attributes($atts, $item, $args, $depth)
{
	// Применяем только к нашим меню (и десктопному, и мобильному)
	if ($args->theme_location !== 'header-menu') {
		return $atts;
	}

	$parsed = parse_url($item->url);
	$path = !empty($parsed['path']) ? $parsed['path'] : '/';
	$hash = isset($parsed['fragment']) ? '#' . $parsed['fragment'] : '';

	$safe_path = esc_attr($path);
	$safe_hash = esc_attr($hash);

	if ($hash) {
		$atts['x-bind:class'] = "isActive('{$safe_path}', '{$safe_hash}') 
            ? 'active-link' 
            : 'hover:text-[#3E8E7E]'";
	} else {
		$atts['x-bind:class'] = "isActive('{$safe_path}', '') 
            ? 'active-link' 
            : (isParentActive('{$safe_path}') 
                ? 'text-blue-400 underline' 
                : 'hover:text-[#3E8E7E]')";
	}

	return $atts;
}
