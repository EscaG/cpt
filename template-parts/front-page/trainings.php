<?php
function get_deepest_product_cat($cats)
{
	if (!$cats || is_wp_error($cats)) return null;
	$deepest = null;
	$max_depth = -1;
	foreach ($cats as $cat) {
		$depth = count(get_ancestors($cat->term_id, 'product_cat'));
		if ($depth > $max_depth) {
			$max_depth = $depth;
			$deepest = $cat;
		}
	}
	return $deepest ?: $cats[0];
}

// Получаем все КОРНЕВЫЕ категории товаров (parent = 0)
$parent_cats = get_terms([
	'taxonomy'   => 'product_cat',
	'hide_empty' => true, // только те, в которых есть товары
	'parent'     => 0,
]);

// === СОРТИРОВКА: psychologists всегда первая ===
if (!empty($parent_cats) && !is_wp_error($parent_cats)) {
	usort($parent_cats, function ($a, $b) {
		// Если $a - psychologists, она идёт первой (возвращаем -1)
		if ($a->slug === 'psychologists') return -1;
		// Если $b - psychologists, она идёт первой (возвращаем 1)
		if ($b->slug === 'psychologists') return 1;
		// Остальные категории остаются в исходном порядке (возвращаем 0)
		return 0;
	});
}


// Опционально: стили по slug. Если slug нет в списке — подставятся значения по умолчанию.
$styles_map = [
	'psychologists' => ['card' => 'green-card',        'btn' => 'inherit-green-btn'],
	'business'      => ['card' => 'blue-card',         'btn' => 'inherit-blue-btn'],
];
$default_style = ['card' => 'blue-card', 'btn' => 'inherit-blue-btn'];
?>

<section id="home_training" class="font-ui">
	<div class="container">
		<h2 class="fl-text-[20px/36px] text-center font-product font-medium fl-mb-[30px/50px]">
			Навчальні програми
		</h2>


		<?php if (empty($parent_cats) || is_wp_error($parent_cats)) return; ?>

		<?php foreach ($parent_cats as $parent_cat) :

			$slug = $parent_cat->slug;
			$style = $styles_map[$slug] ?? $default_style;

			$query = new WP_Query([
				'post_type'      => 'product',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'orderby'        => 'menu_order',
				'order'          => 'ASC',
				'tax_query'      => [[
					'taxonomy' => 'product_cat',
					'field'    => 'term_id',
					'terms'    => $parent_cat->term_id,
				]],
			]);


			if (!$query->have_posts()) continue;
		?>

			<h3 class="fl-text-[14px/24px] fl-mb-[30px/50px]">
				Напрямки консультування &rarr;
				<span class="font-medium"><?= esc_html($parent_cat->name) ?></span>
			</h3>

			<div class="product-wrapper">
				<?php while ($query->have_posts()) : $query->the_post();
					$cat = get_deepest_product_cat(get_the_terms(get_the_ID(), 'product_cat'));
					$type_meets = get_the_terms(get_the_ID(), 'product_feature');
					$course_duration = get_field('course_duration', get_the_ID());
					$lecture_type = get_field('lecture', get_the_ID());
					$cat_image = '';
					if ($cat) {
						$thumb_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
						if ($thumb_id) $cat_image = wp_get_attachment_url($thumb_id);
					}
				?>
					<div class="product-card <?= esc_attr($style['card']) ?>">
						<h3 class="card-title"><?php the_title(); ?></h3>

						<?php if (has_excerpt()) : ?>
							<div class="flex-1 fl-mb-[10px/30px]">
								<?php echo apply_filters('the_content', get_the_excerpt()); ?>
							</div>
						<?php endif; ?>

						<div class="category-wrapper">
							<div class="flex flex-wrap gap-[30px] items-center">
								<?php if ($cat && $lecture_type) : ?>
									<div>
										<span><?= esc_html($lecture_type) ?></span>
									</div>
								<?php endif; ?>


								<!-- Вывод особенностей с картинками -->
								<?php if ($type_meets && !is_wp_error($type_meets)) : ?>
									<?php foreach ($type_meets as $term) :
										// Получаем ID картинки из ACF поля термина
										$feature_image_id = get_term_meta($term->term_id, 'icon_meet', true);
										$feature_image_url = $feature_image_id ? wp_get_attachment_image_url($feature_image_id, 'thumbnail') : '';
									?>
										<div class="feature-item">
											<?php if ($feature_image_url) : ?>
												<img src="<?php echo esc_url($feature_image_url); ?>"
													alt="<?php echo esc_attr($term->name); ?>"
													class="feature-image inline-block">
											<?php endif; ?>
											<span class="feature-name"><?php echo esc_html($term->name); ?></span>
										</div>
									<?php endforeach; ?>
								<?php endif; ?>


								<div class="">
									<?php if ($cat && $cat_image) : ?>
										<img src="<?= esc_url($cat_image) ?>" alt="<?= esc_attr($cat->name) ?>" class="fl-w-[16px/24px] h-auto inline-block">
									<?php endif; ?>
									<span><?= esc_html($cat->name) ?></span>
								</div>
								<?php if ($cat && $course_duration) : ?>
									<div>
										<span style="max-width: 24px; display: inline-block;">
											<?php echo get_inline_svg('calendar.svg', 'fl-w-[16px/24px] inline-block stroke-[#3E8E7E] mt-[-5px]'); ?>
										</span>
										<span class="inline-block">
											<?= esc_html($course_duration) ?>
										</span>
									</div>
								<?php endif; ?>
							</div>
						</div>

						<div class="btn-wrapper">
							<a href="<?php the_permalink(); ?>" class="card-button <?= esc_attr($style['btn']) ?> text-nowrap">
								Детальніше
								<span class="ml-[7px] fl-mb-[-3px/-4px]" style="max-width: 24px; display: inline-block;">
									<?php echo get_inline_svg('circle-arrow-right.svg', 'fl-w-[16px/24px]'); ?>
								</span>
							</a>
							<a
								class="card-button blue-btn text-nowrap"
								target="_blank"
								href="https://docs.google.com/forms/d/e/1FAIpQLSc9sq6sIQX9US4pw8fqzvsvPfgg8csWgy43Ce5SZNTYfSM-kg/viewform">
								Записатися
								<span class="ml-[7px] fl-mb-[-3px/-4px]" style="max-width: 24px; display: inline-block;">
									<?php echo get_inline_svg('calendar.svg', 'fl-w-[16px/24px] stroke-white'); ?>
								</span>
							</a>
						</div>
					</div>
				<?php endwhile;
				wp_reset_postdata(); ?>
			</div>

		<?php endforeach; ?>
	</div>
</section>