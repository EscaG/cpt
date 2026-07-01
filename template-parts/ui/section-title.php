<?php

/**
 * Компонент: Заголовок секции
 *
 * Ожидаемые переменные (передаются через $args):
 *  - $label  string  Текст заголовка (по умолчанию: 'Заголовок')
 *  - $font   string  Шрифт заголовка (по умолчанию: 'font-heading')
 *  - $classes  string  Дополнительные классы для стилизации
 *  - $weight string  Толщина шрифта (по умолчанию: 'font-medium')
 */

$label   = $args['label']   ?? 'Заголовок';
$font    = $args['font']    ?? 'font-heading';
$weight  = $args['weight']  ?? 'font-medium';
$classes = $args['classes'] ?? '';
?>

<h2
	class="fl-text-[20px/36px] text-center <?= esc_attr($font) ?> <?= esc_attr($weight) ?> <?= esc_attr($classes) ?>">
	<?php echo esc_html($label); ?>
</h2>