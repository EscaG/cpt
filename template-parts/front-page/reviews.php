<?php
$reviews_query = new WP_Query([
	'post_type'      => 'review',
	'posts_per_page' => -1,
	'post_status'    => 'publish',
	'orderby'        => 'date',
	'order'          => 'DESC'
]);


$total_reviews = $reviews_query->post_count;
?>
<section id="home-reviews">
	<h2 class="fl-text-[20px/36px] font-product font-medium text-center">Відгуки</h2>
	<div x-data="reviewsCarousel(<?= $total_reviews ?>)"
		x-init="init()"
		class="relative w-full max-w-7xl mx-auto py-8 select-none">

		<!-- Трек (с зонами для мыши/тача) -->
		<div class="overflow-hidden"
			:class="canScroll ? 'cursor-grab active:cursor-grabbing' : 'cursor-default'"
			@mousedown.prevent="startDrag"
			@mousemove="onDrag"
			@mouseup="endDrag"
			@mouseleave="endDrag"
			@touchstart.passive="startDrag"
			@touchmove.passive="onDrag"
			@touchend="endDrag">

			<!-- Сам трек -->
			<div x-ref="track"
				class="flex space-x-4 will-change-transform"
				:style="`transform: translate3d(${translateX}px, 0, 0); transition: ${isDragging || !canScroll ? 'none' : 'transform 0.5s cubic-bezier(0.25, 1, 0.5, 1)'};`"
				@transitionend="handleTransitionEnd">

				<?php while ($reviews_query->have_posts()) : $reviews_query->the_post();
					$image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
					if (!$image_url) continue;
				?>
					<div class="flex-shrink-0 w-[80%] sm:w-[45%] md:w-[calc(33.333%-10.66px)] lg:w-[calc(25%-12px)]">
						<div class="max-h-[430px] flex items-center justify-center ">
							<img src="<?= esc_url($image_url) ?>"
								alt="<?= esc_attr(get_the_title()) ?>"
								class="max-h-full w-auto object-contain rounded-lg pointer-events-none"
								draggable="false"
								loading="lazy">
						</div>
					</div>
				<?php endwhile;
				wp_reset_postdata(); ?>
			</div>
		</div>

		<!-- Кнопки управления -->
		<template x-if="canScroll">
			<div>
				<button @click="prev()" class="absolute cursor-pointer left-2 2xl:-left-10 top-3/7 -translate-y-1/2 bg-white/90 backdrop-blur hover:bg-white text-gray-800 p-3 rounded-full transition-all shadow-lg border border-gray-200 z-10">
					<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
					</svg>
				</button>
				<button @click="next()" class="absolute cursor-pointer right-2 2xl:-right-10 top-3/7 -translate-y-1/2 bg-white/90 backdrop-blur hover:bg-white text-gray-800 p-3 rounded-full transition-all shadow-lg border border-gray-200 z-10">
					<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
					</svg>
				</button>
			</div>
		</template>

		<!-- Точки -->
		<template x-if="canScroll">
			<div class="flex justify-center mt-6 space-x-2">
				<template x-for="i in realCount" :key="i">
					<button @click="goTo(i - 1)"
						:class="realIndex === (i - 1) ? 'bg-[#3E8E7E] w-8' : 'bg-gray-300 w-3 hover:bg-gray-400'"
						class="h-3 rounded-full transition-all duration-300">
					</button>
				</template>
			</div>
		</template>
	</div>
</section>