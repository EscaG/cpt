<?php ?>
<section class="home_advantages">
	<div class="container">
		<h2 class="secondary-heading font-medium fl-mb-[30px/70px]">Переваги навчання в Центрі</h2>

		<?php
		// 1. Настраиваем параметры запроса
		$args = array(
			'post_type'      => 'advantage', // Ваш тип записи
			'posts_per_page' => -1,            // Количество записей (-1 для всех)
			'orderby'        => 'date',
			'order'          => 'DESC',
		);

		// 2. Создаем новый объект запроса
		$specialists_query = new WP_Query($args);

		// 3. Проверяем, есть ли записи
		if ($specialists_query->have_posts()) :
		?>

			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 fl-gap-[3/6]">
				<?php
				// 4. Запускаем цикл
				while ($specialists_query->have_posts()) : $specialists_query->the_post();
				?>

					<!-- Карточка специалиста -->
					<div class="flex fl-gap-[3/6] bg-[#3E8E7E] rounded-xl overflow-hidden fl-px-[16px/20px] fl-py-[16px/30px]">

						<!-- Картинка -->
						<?php if (has_post_thumbnail()) : ?>
							<div class="flex-1 max-w-[76px] min-w-[40px] w-content">
								<?php
								// 'medium_large' - встроенный размер WordPress. 
								// Tailwind классы делают картинку адаптивной и добавляют эффект при наведении.
								the_post_thumbnail('medium_large', array(
									'class' => 'w-full h-auto rounded-sm'
								));
								?>
							</div>
						<?php endif; ?>

						<!-- Текст -->
						<div class="flex-4">
							<h3 class="text-xl text-white font-semibold fl-mb-[16px/24px]">
								<?php the_title(); ?>
							</h3>

							<!-- Краткое описание (если заполнено поле "Цитата" в админке) -->
							<p class="text-white">
								<?php echo get_the_excerpt() ?>
							</p>

						</div>
					</div>

				<?php
				// Конец цикла
				endwhile;
				?>
			</div>

		<?php
		else :
		?>
			<p class="text-center text-gray-500 text-lg">Переваги поки не додано.</p>
		<?php
		endif;

		// 5. ОБЯЗАТЕЛЬНО сбрасываем данные поста, чтобы не сломать другие циклы на странице
		wp_reset_postdata();
		?>

	</div>
</section>