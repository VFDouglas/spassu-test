import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input  : [
                'resources/sass/app.scss',
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/livros.js',
                'resources/js/assuntos.js',
                'resources/js/autores.js',
            ],
            refresh: true,
        }),
    ],
    server : {
        host: '0.0.0.0',
        hmr : {
            host: 'localhost',
        },
    },
});
