<?php get_header(); ?>

<main class="font-body">

	<!-- Вступ -->
	<section id="home_introduction" class="fl-pt-[50px/100px]">
		<div class="container">
			<div class="flex flex-col md:flex-row 2xl:fl-gap-[10px/240px] md:fl-gap-[10px/100px]">
				<div class="flex-3">
					<h1 class="font-heading fl-text-[22px/55px] font-semibold fl-mb-[20px/30px]">Центр Психологічних Технологій</h1>
					<p class="fl-text-[16px/24px] fl-mb-[30px/100px]">Складне стає зрозумілим</p>
					<div class="wide-element bg-[#DDEEE8] fl-py-[16px/30px] rounded-r-full font-body fl-text-[16px/28px] fl-mb-[30px/50px]">
						<p>Психологія для професійного розвитку</p>
						<p>Психологія для бізнесу</p>
					</div>
					<div class="flex gap-4">
						<a href="<?php echo esc_url(home_url('/courses')); ?>" class="link-button green-btn">
							Наші послуги
							<span class="fl-ml-[10px/20px]" style="max-width: 30px; display: inline-block;">
								<?php echo get_inline_svg('arrow-right.svg', ' fl-w-[18px/30px] icon-in-button inline-block'); ?>
							</span>
						</a>
						<a href="<?php echo esc_url(home_url('/courses')); ?>" class="link-button white-btn">
							Зв’язатися <span class="hidden sm:inline">з нами</span>
						</a>
					</div>
				</div>
				<div class="hidden md:block flex-2">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/img/intro.png" alt="intro" class="w-full h-auto">
				</div>
			</div>
		</div>
	</section>

	<!-- Про нас -->
	<section id="home_about">
		<div class="container">
			<h2 class="hidden md:block secondary-heading font-medium fl-mb-[20px/70px]">Про нас</h2>
			<div class="flex fl-gap-[4/20] flex-col-reverse md:flex-row">
				<div class="flex-1 fl-text-[16px/24px] ">
					<p class="fl-mb-[20px/30px]"><span class="font-medium">Центр Психологічних Технологій</span> – це простір, де психологія перестає бути абстрактною і стає зрозумілою, структурованою та прикладною.
						Ми навчаємо бачити психологічні процеси, працювати з ними системно та застосовувати психологічні інструменти у практиці й бізнесі.</p>
					<p>Наша робота ґрунтується на поєднанні глибини психологічних підходів і чітких технологій їх використання.</p>
				</div>
				<h2 class="md:hidden secondary-heading font-medium">Про нас</h2>
				<div class="flex flex-1 gap-2">
					<div class="flex-1">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/img/about_1.png" alt="intro" class="w-full h-auto">
					</div>
					<div class="flex-1">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/img/about_2.png" alt="intro" class="w-full h-auto">
					</div>
					<div class="flex-1">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/img/about_3.png" alt="intro" class="w-full h-auto">
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Наші цінності -->
	<section id="home_values" class="bg-[#F1FAF7] text-center fl-py-[20px/50px]">
		<div class="container">
			<h2 class="secondary-heading">Наші цінності</h2>
			<ul class="flex flex-col md:flex-row md:fl-gap-[10px/80px] xl:fl-gap-[50px/130px]">
				<li class="flex-1 fl-pt-[30px/70px]">
					<div class="m-auto fl-mb-[16px/30px] w-max" style="max-width: 90px;">
						<?php echo get_inline_svg('values_gear.svg', 'fl-w-[40px/90px] icon-in-button'); ?>
					</div>
					<h3 class="fl-text-[16px/24px] fl-mb-[16px/20px] font-semibold">Знання мають працювати</h3>
					<p class="fl-text-[16px/18px] fl-mb-[16px/20px]">Працюємо з тими знаннями, які дають результат.</p>
					<p class="fl-text-[16px/18px] fl-mb-[16px/20px]">Усі методи та підходи, що ми передаємо, мають чітке функціональне призначення та реальний вплив.</p>
				</li>
				<li class="flex-1 fl-pt-[30px/70px]">
					<div class="m-auto fl-mb-[16px/30px] w-max" style="max-width: 90px;">
						<?php echo get_inline_svg('values_bar.svg', 'fl-w-[40px/90px] icon-in-button'); ?>
					</div>
					<h3 class="fl-text-[16px/24px] fl-mb-[16px/20px] font-semibold">Системний підхід</h3>
					<p class="fl-text-[16px/18px] fl-mb-[16px/20px]">Бачимо людину, команду й організацію як цілісну систему.</p>
					<p class="fl-text-[16px/18px] fl-mb-[16px/20px]">Це дозволяє знаходити причини, а не латати наслідки, і будувати рішення, які працюють довгостроково</p>
				</li>
				<li class="flex-1 fl-pt-[30px/70px]">
					<div class="m-auto fl-mb-[16px/30px] w-max" style="max-width: 90px;">
						<?php echo get_inline_svg('values_up.svg', 'fl-w-[40px/90px] icon-in-button'); ?>
					</div>
					<h3 class="fl-text-[16px/24px] fl-mb-[16px/20px] font-semibold">Розвиток</h3>
					<p class="fl-text-[16px/18px] fl-mb-[16px/20px]">Підтримуємо не швидкі рішення, а стійке зростання.</p>
					<p class="fl-text-[16px/18px] fl-mb-[16px/20px]">Розвиток як процес, що ґрунтується на усвідомленні, дисципліні та готовності змінюватися</p>
				</li>
			</ul>
		</div>
	</section>

	<!-- Переваги навчання в Центрі -->
	<section id="home_adv">
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
	<section class="home_calendar">
		<div class="container">
			<h2 class="secondary-heading font-medium fl-mb-[30px/50px]">Календар подій</h2>

			<?php
			$today = date('Ymd');
			$events_query = new WP_Query([
				'post_type'      => 'event',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'meta_key'       => 'event_date',
				'orderby'        => 'meta_value',
				'order'          => 'ASC',
				'meta_query'     => [[
					'key'     => 'event_date',
					'value'   => $today,
					'compare' => '>='
				]]
			]);
			?>

			<div x-data="accordion" class="max-w-4xl mx-auto">
				<?php if ($events_query->have_posts()) : ?>
					<?php
					$grouped_events = [];
					while ($events_query->have_posts()) : $events_query->the_post();
						$raw_date  = get_field('event_date', false, false);
						$timestamp = strtotime($raw_date);
						$month_key = date('Y-m', $timestamp);

						if (!isset($grouped_events[$month_key])) {
							$grouped_events[$month_key] = [
								'name'   => date_i18n('F', $timestamp),
								'events' => []
							];
						}

						$grouped_events[$month_key]['events'][] = [
							'day'   => date_i18n('d.m', $timestamp),
							'title' => get_the_title(),
							'url'   => get_permalink()
						];
					endwhile;
					wp_reset_postdata();
					?>

					<div class="space-y-4" x-ref="monthsContainer">
						<?php foreach ($grouped_events as $month_key => $month_data) :
							$month_id = sanitize_title($month_data['name'] . '-' . $month_key);
						?>
							<div class="bg-white rounded-xl border border-[#4A4A4A]  fl-px-[20px/50px] transition-all duration-300"
								:class="isMonthOpen('<?php echo esc_attr($month_id); ?>') ? 'py-[25px]' : 'py-[10px]'"
								data-month-id="<?php echo esc_attr($month_id); ?>">

								<button @click="toggleMonth('<?php echo esc_attr($month_id); ?>')"
									class="flex items-center justify-between w-full">
									<h2 class="fl-text-[20px/36px]"><?php echo ucfirst($month_data['name']); ?></h2>
									<svg class="w-6 h-6 text--[#4A4A4A] transform transition-transform duration-300"
										:class="{ 'rotate-180': isMonthOpen('<?php echo esc_attr($month_id); ?>') }"
										fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
									</svg>
								</button>

								<!-- Используем x-collapse вместо x-show -->
								<div
									x-collapse
									x-collapse.duration.300ms
									x-show="isMonthOpen('<?php echo esc_attr($month_id); ?>')"
									class="divide-y divide-gray-100">

									<?php foreach ($month_data['events'] as $event) : ?>
										<div class="p-1">
											<p class="fl-text-[16px/24px]">
												<span class="font-semibold"><?php echo $event['day']; ?></span>
												— <?php echo $event['title']; ?>
											</p>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>

				<?php else : ?>
					<p class="text-gray-500 text-center py-12">На даний час запланований подій немає.</p>
				<?php endif; ?>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>