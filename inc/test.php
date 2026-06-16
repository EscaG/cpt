<?php 
			<!-- Обертка Alpine.js для управления состоянием (свернутые/развернутые месяцы) -->
			<div
				x-data="{ 
					openMonths: {}, 
					toggleMonth(month) {
						this.openMonths[month] = !this.openMonths[month];
					},
					isMonthOpen(month) {
							// По умолчанию первый месяц открыт, остальные закрыты (опционально)
						if (Object.keys(this.openMonths).length === 0) {
								return true; 
						}
						return !!this.openMonths[month];
					}
				}"
				class="max-w-4xl mx-auto px-4 py-12">

				<?php if ($events_query->have_posts()) : ?>
					<div class="space-y-2 ">
						<?php
						$current_month = '';

						while ($events_query->have_posts()) : $events_query->the_post();
							// Получаем сырую дату Ymd для логики
							$raw_date = get_field('event_date', false, false);
							// Форматируем для группировки (например: "Июнь 2026")
							$month = date_i18n('F', strtotime($raw_date));
							// Форматируем для красивого вывода дня (например: "15")
							$day_num = date_i18n('d.m', strtotime($raw_date));
							// $day_name = date_i18n('D', strtotime($raw_date)); // Пн, Вт и т.д.
						?>

							<div class="bg-white rounded-xl border border-gray-500 p-4">


								<?php if ($month !== $current_month) :
									$current_month = $month;
									// Создаем уникальный ID для Alpine
									$month_id = sanitize_title($month);
								?>
									<div class="pb-2 mb-4">
										<button
											@click="toggleMonth('<?php echo $month_id; ?>')"
											class="flex items-center justify-between w-full text-left group">
											<h2 class="fl-text-[20px/36px]">
												<?php echo ucfirst($month); ?>
											</h2>
											<!-- Иконка стрелки, вращающаяся через Alpine -->
											<svg
												class="w-6 h-6 text-gray-500 transform transition-transform duration-300"
												:class="{ 'rotate-180': isMonthOpen('<?php echo $month_id; ?>') }"
												fill="none" stroke="currentColor" viewBox="0 0 24 24">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
											</svg>
										</button>
									</div>
								<?php endif; ?>

								<!-- Карточка события (показывается/скрывается через Alpine) -->
								<div
									x-show="isMonthOpen('<?php echo $month_id; ?>')"
									x-transition:enter="transition ease-out duration-300"
									x-transition:enter-start="opacity-0 -translate-y-2"
									x-transition:enter-end="opacity-100 translate-y-0"
									class="flex p-2 ">
									<!-- Блок с контентом -->
									<p class="fl-text-[16px/24px] ">
										<span class="font-semibold"><?php echo $day_num; ?></span> - <?php the_title(); ?>
									</p>
								</div>
							</div>
						<?php endwhile; ?>
					</div>
					<?php wp_reset_postdata(); ?>
				<?php else : ?>
					<p class="text-gray-500 text-center py-12">На данный момент запланированных событий нет.</p>
				<?php endif; ?>

			</div>