<?php

/**
 * Шаблон одиночной страницы товара (услуги)
 * 100% кастомный вывод через объект $product
 */

get_header();

// 1. Получаем ID текущего поста
$post_id = get_the_ID();

// 2. Получаем объект продукта WooCommerce
$product = wc_get_product($post_id);

// Если это не продукт WooCommerce, выводим стандартное сообщение
if (! $product) {
	echo '<p>Услуга не найдена.</p>';
	get_footer();
	return;
}

// 3. Извлекаем "сырые" данные для полного контроля
$title             = $product->get_name();
$full_description  = $product->get_description();          // Большое поле редактора
$short_description = $product->get_short_description();    // Поле "Краткое описание"
$price_html        = $product->get_price_html();           // Цена (если нужна)

// Пример получения произвольного поля (например, "Длительность консультации")
// Если вы используете ACF, лучше использовать get_field('duration'), но это универсальный способ WP:
$duration          = get_post_meta($post_id, 'consultation_duration', true);
$format            = get_post_meta($post_id, 'consultation_format', true);
?>

<main class="custom-single-service-page">
	<div class="container">

		<a href="<?php echo home_url('/'); ?>" class="back-link">← Назад к списку услуг</a>

		<article class="service-details-wrapper">

			<!-- ЛЕВАЯ КОЛОНКА: Основная информация -->
			<div class="service-main-info">
				<h1 class="service-title"><?php echo esc_html($title); ?></h1>

				<!-- Блок с мета-данными (длительность, формат) -->
				<?php if ($duration || $format) : ?>
					<div class="service-meta-tags">
						<?php if ($duration) : ?>
							<span class="meta-tag">⏱ <?php echo esc_html($duration); ?></span>
						<?php endif; ?>
						<?php if ($format) : ?>
							<span class="meta-tag">💻 <?php echo esc_html($format); ?></span>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<!-- ПОЛНОЕ ОПИСАНИЕ (То, что в большом редакторе) -->
				<!-- apply_filters нужен, чтобы работали абзацы <p>, жирный текст и т.д. -->
				<div class="prose prose-sm max-w-none">
					<?php echo apply_filters('the_content', $full_description); ?>
				</div>
			</div>

			<!-- ПРАВАЯ КОЛОНКА (или нижняя): Краткое описание и действие -->
			<aside class="service-sidebar">

				<!-- КРАТКОЕ ОПИСАНИЕ (То, что в маленьком поле внизу товара) -->
				<?php if ($short_description) : ?>
					<div class="service-short-description-box">
						<h3>О консультации</h3>
						<?php echo wpautop($short_description); ?>
					</div>
				<?php endif; ?>

				<!-- Цена (если вы ее указываете в товаре) -->
				<?php if ($price_html) : ?>
					<div class="service-price">
						<?php echo $price_html; ?>
					</div>
				<?php endif; ?>

				<!-- МЕСТО ДЛЯ ВАШЕЙ БУДУЩЕЙ КНОПКИ -->
				<div class="service-action-area">
					<!-- Пока здесь заглушка. Позже вы вставите сюда свою кнопку или форму -->
					<button class="custom-book-btn" disabled>Кнопка записи (скоро)</button>
				</div>

			</aside>

		</article>
	</div>
</main>

<?php
get_footer();
?>