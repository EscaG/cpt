import { defineConfig } from 'vite';
import { resolve } from 'path';
import liveReload from "vite-plugin-live-reload";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({

	plugins: [
		liveReload(['**/*.php', 'templates/**/*.php', 'inc/**/*.php']),
		tailwindcss(),
	],
	server: {
		host: true, // Замените на реальный домен вашего сайта в LocalWP
		port: 5173,
		cors: true, // Разрешаем WordPress загружать скрипты с localhost:5173
		hmr: {
			protocol: 'ws',
			host: '192.168.0.125'
		}
	},
	build: {
		manifest: true,
		outDir: resolve(__dirname, 'dist'),
		emptyOutDir: true,
		rollupOptions: {
			input: {
				main: resolve(__dirname, 'src/assets/js/main.js'),
				style: resolve(__dirname, 'src/assets/css/app.css'),
			},
			output: {
				entryFileNames: `assets/[name].[hash].js`,
				chunkFileNames: `assets/[name].[hash].js`,
				assetFileNames: `assets/[name].[hash].[ext]`
			}
		}
	},
});
