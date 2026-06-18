<?php ?>

<section id="home_training" class="font-ui">

	<div class="container">
		<h2 class="fl-text-[20px/36px] text-center font-product font-medium fl-mb-[30px/50px]">Навчальні програми</h2>
		<h3 class="fl-text-[14px/24px] fl-mb-[30px/50px]">
			Напрямки консультування &#8594; <span class="font-medium">Психологам</span>
		</h3>



		<div class="product-wrapper">
			<?php
			// 2. Настраиваем запрос ТОЛЬКО для категории "business"
			$args_psychologists = array(
				'post_type'      => 'product',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'orderby'        => 'menu_order',
				'order'          => 'ASC',
				'tax_query'      => array(
					array(
						'taxonomy' => 'product_cat',
						'field'    => 'slug',
						'terms'    => 'psychologists', // Ярлык вашей категории
					),
				),
			);

			$query_psychologists = new WP_Query($args_psychologists);

			if ($query_psychologists->have_posts()) :
				while ($query_psychologists->have_posts()) : $query_psychologists->the_post();

					// Получаем категории товара
					$psychologists_cats = get_the_terms($query_psychologists->get_id(), 'product_cat');
					$psychologists_cat_image = '';
					$psychologists_cat = null;

					if ($psychologists_cats && ! is_wp_error($psychologists_cats)) {

						// --- НАЧАЛО ИСПРАВЛЕНИЯ ---
						// Ищем самую вложенную (дочернюю) категорию
						$max_depth = -1;

						foreach ($psychologists_cats as $cat) {
							// get_ancestors возвращает массив ID всех родителей текущей категории
							$ancestors = get_ancestors($cat->term_id, 'product_cat');
							$depth = count($ancestors);

							// Если текущая категория вложена глубже, чем предыдущая найденная, сохраняем её
							if ($depth > $max_depth) {
								$max_depth = $depth;
								$psychologists_cat = $cat;
							}
						}

						// Страховка: если у товара вообще нет вложенных категорий (только корневая), берем первую
						if (!$psychologists_cat) {
							$psychologists_cat = $psychologists_cats[0];
						}
						// --- КОНЕЦ ИСПРАВЛЕНИЯ ---

						// Получаем изображение най deepest (дочерней) категории
						$thumb_id = get_term_meta($psychologists_cat->term_id, 'thumbnail_id', true);
						if ($thumb_id) {
							$psychologists_cat_image = wp_get_attachment_url($thumb_id);
						}
					}

					// Дальше ваш код вывода...
			?>

					<!-- ВАША ВЕРСТКА КАРТОЧКИ ТОВАРА -->
					<div class="product-card green-card">
						<h3 class="card-title">
							<?php the_title(); ?>
						</h3>

						<?php if (has_excerpt()) : ?>
							<div class="flex-1 fl-mb-[10px/30px]">
								<?php
								$short_desc = get_the_excerpt();
								echo apply_filters('the_content', $short_desc);
								?>
							</div>
						<?php endif; ?>
						<div class="category-wrapper">
							<div class="flex gap-[10px]">
								<?php if ($psychologists_cat_image) : ?>
									<img
										src="<?= esc_url($psychologists_cat_image) ?>"
										alt="<?= esc_attr($psychologists_cat->name) ?>"
										class="fl-w-[16px/24px]">
									<span><?= esc_attr($psychologists_cat->name) ?></span>
								<?php endif; ?>
							</div>
						</div>
						<div class="btn-wrapper">
							<a href="<?php the_permalink(); ?>" class="card-button inherit-green-btn text-nowrap">
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
									<?php echo get_inline_svg('calendar.svg', 'fl-w-[16px/24px]'); ?>
								</span>
							</a>
						</div>
					</div>
					<!-- КОНЕЦ ВЕРСТКИ КАРТОЧКИ -->

			<?php
				endwhile;
				wp_reset_postdata(); // Сбрасываем данные после первого цикла!
			else :
				echo '<p>Услуг пока нет.</p>';
			endif;
			?>
		</div>


		<h3 class="font-body fl-text-[14px/24px] fl-mb-[30px/50px]">
			Напрямки консультування &#8594; <span class="font-medium">Бізнесу</span>
		</h3>

		<div class="product-wrapper">
			<?php
			// 2. Настраиваем запрос ТОЛЬКО для категории "business"
			$args_business = array(
				'post_type'      => 'product',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'orderby'        => 'menu_order',
				'order'          => 'ASC',
				'tax_query'      => array(
					array(
						'taxonomy' => 'product_cat',
						'field'    => 'slug',
						'terms'    => 'business', // Ярлык вашей категории
					),
				),
			);

			$query_business = new WP_Query($args_business);

			if ($query_business->have_posts()) :
				while ($query_business->have_posts()) : $query_business->the_post();

					// Получаем категории товара
					$business_cats = get_the_terms($query_business->get_id(), 'product_cat');
					$business_cat_image = '';
					$business_cat = null;

					if ($business_cats && ! is_wp_error($business_cats)) {

						// --- НАЧАЛО ИСПРАВЛЕНИЯ ---
						// Ищем самую вложенную (дочернюю) категорию
						$max_depth = -1;

						foreach ($business_cats as $cat) {
							// get_ancestors возвращает массив ID всех родителей текущей категории
							$ancestors = get_ancestors($cat->term_id, 'product_cat');
							$depth = count($ancestors);

							// Если текущая категория вложена глубже, чем предыдущая найденная, сохраняем её
							if ($depth > $max_depth) {
								$max_depth = $depth;
								$business_cat = $cat;
							}
						}

						// Страховка: если у товара вообще нет вложенных категорий (только корневая), берем первую
						if (!$business_cat) {
							$business_cat = $business_cats[0];
						}
						// --- КОНЕЦ ИСПРАВЛЕНИЯ ---

						// Получаем изображение най deepest (дочерней) категории
						$thumb_id = get_term_meta($business_cat->term_id, 'thumbnail_id', true);
						if ($thumb_id) {
							$business_cat_image = wp_get_attachment_url($thumb_id);
						}
					}

					// Дальше ваш код вывода...
			?>

					<!-- ВАША ВЕРСТКА КАРТОЧКИ ТОВАРА (такая же, но данные другие) -->
					<div class="product-card blue-card">
						<h3 class="card-title">
							<?php the_title(); ?>
						</h3>
						<?php if (has_excerpt()) : ?>
							<div class="flex-1 fl-mb-[10px/30px]">
								<?php
								$short_desc = get_the_excerpt();
								echo apply_filters('the_content', $short_desc);
								?>
							</div>
						<?php endif; ?>
						<div class="category-wrapper">
							<div class="flex gap-[10px]">
								<?php if ($business_cat_image) : ?>
									<img
										src="<?= esc_url($business_cat_image) ?>"
										alt="<?= esc_attr($business_cat->name) ?>"
										class="fl-w-[16px/24px]">
									<span><?= esc_attr($business_cat->name) ?></span>
								<?php endif; ?>
							</div>
						</div>
						<div class="btn-wrapper">
							<a href="<?php the_permalink(); ?>" class="card-button inherit-blue-btn text-nowrap">
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
									<?php echo get_inline_svg('calendar.svg', 'fl-w-[16px/24px]'); ?>
								</span>
							</a>
						</div>
					</div>
					<!-- КОНЕЦ ВЕРСТКИ КАРТОЧКИ -->

			<?php
				endwhile;
				wp_reset_postdata(); // Сбрасываем данные после второго цикла!
			else :
				echo '<p>Услуг пока нет.</p>';
			endif;
			?>
		</div>
	</div>
</section>