<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>

<body
	<?php body_class(); ?>
	x-data="headerMenu">

	<header class="w-full bg-white/90 border-b border-gray-200 sticky top-0 z-50 py-2">
		<div class="container">
			<div class="flex gap-2 h-16 md:h-20 items-center justify-between relative">

				<!-- ЛОГО -->
				<div style="max-width: 200px; min-width: 50px;">
					<?php
					if (has_custom_logo()) {
						echo psc_get_clean_logo();
					} else {
						echo '<a href="' . esc_url(home_url('/')) . '">' . esc_html(get_bloginfo('name')) . '</a>';
					}
					?>
				</div>

				<!-- ДЕСКТОПНОЕ МЕНЮ -->
				<div class="flex md:gap-2 lg:gap-4">
					<div class="hidden md:flex md:items-center">
						<div>
							<?php
							wp_nav_menu(array(
								'theme_location'  => 'header-menu',
								'container'       => 'nav',
								'container_class' => 'animated-nav',
								'menu_class'      => 'flex fl-gap-1/4',
								'fallback_cb'     => false,
								'depth'           => 0,
							));
							?>
						</div>
					</div>
					<ul class="hidden min-[480px]:flex md:gap-2 gap-4 max-[768px]:mr-14">
						<li style="max-width: 50px;">
							<a href="/">
								<?php echo get_inline_svg('instagram.svg', 'fl-w-[32px/50px]'); ?>
							</a>
						</li>
						<li style="max-width: 50px;">
							<a href="/">
								<?php echo get_inline_svg('social.svg', 'fl-w-[32px/50px]'); ?>
							</a>
						</li>
						<li style="max-width: 50px;">
							<a href="/">
								<?php echo get_inline_svg('youtube.svg', 'fl-w-[32px/50px]'); ?>
							</a>
						</li>
					</ul>

				</div>


				<!-- БУРГЕР -->
				<div class="flex items-center md:hidden absolute right-0 top-1/2 -translate-y-1/2">
					<button
						@click="mobileMenuOpen = !mobileMenuOpen"
						type="button"
						class="inline-flex items-center justify-center p-2  focus:outline-none"
						aria-controls="mobile-menu"
						:aria-expanded="mobileMenuOpen">
						<span class="sr-only">Открыть главное меню</span>

						<!-- Контейнер для полосок -->
						<span class="relative block w-6 h-5">
							<!-- Верхняя полоска -->
							<span
								class="absolute left-0 h-[2px] w-6 bg-[#3E8E7E] rounded-md transition-all duration-300 ease-in-out origin-left"
								:class="mobileMenuOpen ? '-top-[4px] left-[6px]  h-[3px] w-[21px] rotate-40' : 'top-0'">
							</span>

							<!-- Средняя полоска -->
							<span
								class="absolute left-0 top-[9px] h-[2px] w-6 bg-[#3E8E7E] rounded-md transition-all duration-300 ease-in-out"
								:class="mobileMenuOpen ? 'opacity-0 scale-x-0' : 'opacity-100 scale-x-100'">
							</span>

							<!-- Нижняя полоска -->
							<span
								class="absolute left-0 h-[2px] w-6 bg-[#3E8E7E] rounded-md transition-all duration-300 ease-in-out origin-left"
								:class="mobileMenuOpen ? 'top-[22px] left-[6px] h-[3px] w-[21px] -rotate-40' : 'top-[18px]'">
							</span>
						</span>
					</button>
				</div>

			</div>
		</div>



	</header>


	<!-- МОБИЛЬНОЕ МЕНЮ (обёртка с x-show) -->
	<div
		x-show="mobileMenuOpen"
		x-cloak
		class="fixed inset-0 z-50 md:hidden"
		@keydown.escape.window="closeMenu()"
		style="display: none;">
		<!-- Затемнение фона — opacity transition без backdrop-blur во время анимации -->
		<div
			x-show="mobileMenuOpen"
			x-transition:enter="transition ease-out duration-300"
			x-transition:enter-start="opacity-0"
			x-transition:enter-end="opacity-100"
			x-transition:leave="transition ease-in duration-200"
			x-transition:leave-start="opacity-100"
			x-transition:leave-end="opacity-0"
			@click="closeMenu()"
			class="absolute inset-0 bg-black/50"
			style="will-change: opacity; -webkit-backface-visibility: hidden;"
			aria-hidden="true">
		</div>

		<!-- Панель меню — slide + opacity -->
		<div
			x-show="mobileMenuOpen"
			x-transition:enter="transition transform ease-out duration-300"
			x-transition:enter-start="translate-x-full opacity-90"
			x-transition:enter-end="translate-x-0 opacity-100"
			x-transition:leave="transition transform ease-in duration-200"
			x-transition:leave-start="translate-x-0 opacity-100"
			x-transition:leave-end="translate-x-full opacity-90"
			class="absolute right-0 top-0 h-screen w-full max-w-sm bg-white shadow-2xl flex flex-col"
			style="will-change: transform, opacity; -webkit-backface-visibility: hidden; -webkit-perspective: 1000;">

			<!-- Шапка меню -->
			<div class="flex justify-between p-2 border-b border-gray-100 bg-white shrink-0">
				<!-- ЛОГО -->
				<div style="max-width: 170px; min-width: 50px;">
					<?php
					if (has_custom_logo()) {
						echo psc_get_clean_logo();
					} else {
						echo '<a href="' . esc_url(home_url('/')) . '">' . esc_html(get_bloginfo('name')) . '</a>';
					}
					?>
				</div>
				<button
					@click="closeMenu()"
					class="p-2 rounded-full transition-colors"
					aria-label="Закрыть меню">
					<!-- Контейнер для полосок -->
					<span class="relative block w-6 h-5">
						<!-- Верхняя полоска -->
						<span
							class="absolute left-0 h-[2px] w-6 bg-[#3E8E7E] rounded-md transition-all duration-300 ease-in-out origin-left"
							:class="mobileMenuOpen ? '-top-[4px] left-[6px]  h-[3px] w-[21px] rotate-40' : 'top-0'">
						</span>

						<!-- Средняя полоска -->
						<span
							class="absolute left-0 top-[9px] h-[2px] w-6 bg-[#3E8E7E] rounded-md transition-all duration-300 ease-in-out"
							:class="mobileMenuOpen ? 'opacity-0 scale-x-0' : 'opacity-100 scale-x-100'">
						</span>

						<!-- Нижняя полоска -->
						<span
							class="absolute left-0 h-[2px] w-6 bg-[#3E8E7E] rounded-md transition-all duration-300 ease-in-out origin-left"
							:class="mobileMenuOpen ? 'top-[22px] left-[6px] h-[3px] w-[21px] -rotate-40' : 'top-[18px]'">
						</span>
					</span>
				</button>
			</div>

			<!-- Пункты меню -->
			<div class="flex-1 overflow-y-auto px-6 py-4">
				<?php
				wp_nav_menu(array(
					'theme_location'  => 'header-menu',
					'container'       => 'nav',
					'container_class' => 'mobile-menu',
					'fallback_cb'     => false,
				));
				?>
				<ul class="flex gap-4 justify-center mt-8">
					<li>
						<a href="/">
							<?php echo get_inline_svg('instagram.svg', 'w-[32px]'); ?>
						</a>
					</li>
					<li>
						<a href="/">
							<?php echo get_inline_svg('social.svg', 'w-[32px]'); ?>
						</a>
					</li>
					<li>
						<a href="/">
							<?php echo get_inline_svg('youtube.svg', 'w-[32px]'); ?>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
