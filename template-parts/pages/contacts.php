<?php ?>
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <!-- Левая колонка: Информация -->
    <div class="bg-gray-50 p-6 rounded-lg shadow-sm" id="contacts-info">
        <h1 class="text-3xl font-bold mb-4">Свяжитесь с нами</h1>
        <p class="mb-4">Мы находимся по адресу: ул. Примерная, 1</p>
        <a href="tel:+79990000000" class="text-blue-600 hover:underline">+7 (999) 000-00-00</a>
    </div>

    <!-- Правая колонка: Форма или Карта -->
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200" id="contacts-map-wrapper">
        <h2 class="text-xl font-semibold mb-4">Наша карта</h2>
        <!-- Сюда ваш JS из app.js может прикрепить Яндекс.Карту или Leaflet -->
        <div id="map" class="h-64 bg-gray-200 rounded flex items-center justify-center">
            Карта загрузится через JS
        </div>
    </div>
</div>
