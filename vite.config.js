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
		host: 'psychological-support-center.local', // Замените на реальный домен вашего сайта в LocalWP
		origin: 'http://psychological-support-center.local',
		port: 5173,
		cors: true, // Разрешаем WordPress загружать скрипты с localhost:5173
		hmr: {
			protocol: 'ws',
			host: 'localhost'
		}
	},
	build: {
		manifest: true,
		outDir: resolve(__dirname, 'dist'),
		emptyOutDir: true,
		rollupOptions: {
			input: {
				main: resolve(__dirname, 'src/main.js'),
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
