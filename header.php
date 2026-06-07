<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>

<body
	<?php body_class(); ?>
	x-data="headerMenu"
>

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
				<div class="hidden md:flex md:items-center">
					<?php
					wp_nav_menu(array(
						'theme_location'  => 'header-menu',
						'container'       => 'nav',
						'container_class' => 'animated-nav',
						'menu_class'      => 'flex fl-gap-4/6',
						'fallback_cb'     => false,
						'depth'           => 0,
					));
					?>
				</div>

				<!-- БУРГЕР -->
				<div class="flex items-center md:hidden absolute right-0 top-1/2 -translate-y-1/2">
					<button
						@click="openMenu()"
						type="button"
						class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 transition-colors"
						aria-controls="mobile-menu"
						:aria-expanded="mobileMenuOpen">
						<span class="sr-only">Открыть главное меню</span>
						<svg width="24" height="24" x-show="!mobileMenuOpen" x-cloak class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
						</svg>
						<svg width="24" height="24" x-show="mobileMenuOpen" x-cloak class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
						</svg>
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
			style="will-change: transform, opacity; -webkit-backface-visibility: hidden; -webkit-perspective: 1000;"
		>
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
					<svg class="h-6 w-6" width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
					</svg>
				</button>
			</div>

			<!-- Пункты меню -->
			<div class="flex-1 overflow-y-auto px-6 py-4">
				<?php
				wp_nav_menu(array(
					'theme_location' => 'header-menu',
					'container'      => 'nav',
					'container_class'=> 'mobile-menu',
					'fallback_cb'    => false,
				));
				?>
			</div>
		</div>
	</div>
