<?php ?>

<section id="home_calendar">
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