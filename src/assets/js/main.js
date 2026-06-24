import "../css/app.css";
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import './header-menu';
import './accordion';
import './carousel';

Alpine.plugin(collapse);
// Делаем Alpine доступным глобально (опционально, но полезно для WP)
window.Alpine = Alpine;

// Запускаем Alpine
Alpine.start();


