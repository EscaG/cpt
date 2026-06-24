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
$price_html        = $product->get_price_html();           // Цена (если нужна)
$min_price = 0;
$max_price = 0;
$image_id = $product->get_image_id();

// Получаем URL картинки (доступны размеры: 'full', 'thumbnail', 'medium', 'large')
$image_url = wp_get_attachment_image_url($image_id, 'full');
// Получение массива блоков из программы курса
$modules = course_program_get_modules($post_id);
// Пример получения произвольного поля (например, "Длительность консультации")
// Если вы используете ACF, лучше использовать get_field('duration'), но это универсальный способ WP:
$duration          = get_field('course_duration', $post_id);
$format            = get_field('course_format', $post_id);
$sertificate       = get_field('course_certificate', $post_id);
$schedule_group    = get_field('course_schedule', $post_id);

$schedule_lecture  = $schedule_group['schedule_lecture'];
$schedule_practice = $schedule_group['schedule_practice'];
$schedule_duration = $schedule_group['schedule_duration'];
?>

<main class="custom-single-service-page">
	<div class="container">

		<a href="<?php echo home_url('/'); ?>" class="back-link">← Назад</a>

		<article>
			<h1 class="fl-text-[20px/36px] font-heading mb-7.5"><?php echo esc_html($title); ?></h1>
			<div class="flex flex-col-reverse xl:flex-row gap-8 xl:gap-20">
				<!-- ЛЕВАЯ КОЛОНКА: Основная информация -->
				<div class="">

					<div class="product-description">
						<?php echo apply_filters('the_content', $full_description); ?>
					</div>
					<?php if ($format) : ?>
						<div class="fl-my-[30px/70px] border border-[#3E8E7E] rounded-full px-6 py-3">
							<?php echo wp_kses_post($format) ?>
						</div>
					<?php endif; ?>
					<?php if ($schedule_group) : ?>
						<div class="schedule flex flex-wrap fl-gap-[2/12]">
							<?php if ($schedule_lecture) : ?>
								<div class="fl-p-[30px/50px] bg-[#DDEEE8] rounded-xl">
									<p><?php echo esc_html($schedule_lecture); ?></p>
								</div>
							<?php endif; ?>
							<?php if ($schedule_practice) : ?>
								<div class="fl-p-[30px/50px] bg-[#DDEEE8] rounded-xl">
									<p><?php echo esc_html($schedule_practice); ?></p>
								</div>
							<?php endif; ?>
							<?php if ($schedule_duration) : ?>
								<div class="fl-p-[30px/50px] bg-[#DDEEE8] rounded-xl">
									<p><?php echo esc_html($schedule_duration); ?></p>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					<?php if ($sertificate) : ?>
						<div class="fl-my-[30px/70px] border border-[#3E8E7E] rounded-full px-6 py-3">
							<?php echo wp_kses_post($sertificate) ?>
						</div>
					<?php endif; ?>

				</div>

				<!-- ПРАВАЯ КОЛОНКА (или нижняя): Картинка -->
				<aside class="service-sidebar">
					<?php if ($image_url) : ?>
						<img src="<?php echo esc_url($image_url); ?>"
							alt="<?php echo esc_attr($title); ?>"
							class="!fl-h-[140px/300px] !w-full rounded-2xl object-cover xl:!h-auto xl:w-auto inline-block">
					<?php endif; ?>
				</aside>
			</div>

			<?php if (! empty($modules)) : ?>
				<section>
					<h2 class="font-product font-medium text-center fl-text-[20px/32px] fl-mb-[30px/70px]">Програма курса</h2>

					<div class="fl-space-y-[20px/30px]">
						<?php foreach ($modules as $i => $module) : ?>
							<div class="fl-px-[16px/30px] fl-py-[20px/30px] shadow-sm/25">
								<div class="flex-">
									<h3 class="fl-text-[16px/24px] font-semibold text-[#4A4A4A] uppercase fl-mb-[20px/30px]">
										<?php echo esc_html($module['title']); ?>
									</h3>
									<?php if (! empty($module['description'])) : ?>
										<p class="fl-text-[16px/24px] text-[#4A4A4A]">
											<?php echo esc_html($module['description']); ?>
										</p>
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</section>
			<?php endif; ?>

			<?php
			if ($product->is_type('variable')) :
				// 1. Получаем данные всех активных вариаций товара
				$available_variations = $product->get_available_variations();

				$min_variation_name = '';
				$max_variation_name = '';

				$min_price = $product->get_variation_price('min');
				$max_price = $product->get_variation_price('max');

				// 2. Ищем, каким именно вариациям принадлежат эти цены
				foreach ($available_variations as $variation_data) {
					// Проверяем совпадение по минимальной цене
					if ($variation_data['display_price'] == $min_price && empty($min_variation_name)) {
						// imploding на случай, если атрибутов несколько, но если он один — выведет ровно его имя
						$min_variation_name = implode(', ', $variation_data['attributes']);
					}
					// Проверяем совпадение по максимальной цене
					if ($variation_data['display_price'] == $max_price && empty($max_variation_name)) {
						$max_variation_name = implode(', ', $variation_data['attributes']);
					}
				}

				// Если имена атрибутов вернулись в виде слагов (например, "1-month"), 
				// превращаем их в красивые названия ("1 месяц доступа")
				$min_label = term_exists($min_variation_name) ? get_term_by('slug', $min_variation_name, current(array_keys($product->get_variation_attributes())))->name : $min_variation_name;
				$max_label = term_exists($max_variation_name) ? get_term_by('slug', $max_variation_name, current(array_keys($product->get_variation_attributes())))->name : $max_variation_name;
			?>

				<div class="flex fl-gap-[30px/70px] fl-mb-[30px/50px] text-center">
					<!-- Вывод максимальной вариации (если цены отличаются) -->
					<?php if ($min_price !== $max_price) : ?>
						<div class="flex flex-1 flex-col sm:flex-row justify-between max-w-[500px] gap-6 px-7.5 py-5 border-b border-[#3E8E7E]">
							<p class="variation-title"><?php echo esc_html($max_label); ?>:</p>
							<p class="text-center"><?php echo wc_price($max_price); ?></p>
						</div>
					<?php endif; ?>
					<!-- Вывод минимальной вариации -->
					<div class="flex flex-1 flex-col sm:flex-row justify-between max-w-[500px] gap-6 px-7.5 py-5 border-b border-[#3E8E7E]">
						<p class="variation-title"><?php echo esc_html($min_label); ?>:</p>
						<p class="text-center"><?php echo wc_price($min_price); ?></p>
					</div>
				</div>

			<?php endif; ?>

			<a
				class="card-button green-btn text-nowrap"
				target="_blank"
				href="https://docs.google.com/forms/d/e/1FAIpQLSc9sq6sIQX9US4pw8fqzvsvPfgg8csWgy43Ce5SZNTYfSM-kg/viewform">
				Записатися
				<span class="ml-[7px] fl-mb-[-3px/-4px]" style="max-width: 24px; display: inline-block;">
					<?php echo get_inline_svg('calendar.svg', 'fl-w-[16px/24px] stroke-white'); ?>
				</span>
			</a>
		</article>
	</div>
</main>

<?php
get_footer();
?>