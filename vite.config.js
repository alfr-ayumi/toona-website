import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    
    // === TAMBAHKAN BAGIAN INI ===
    css: {
        preprocessorOptions: {
            scss: {
                api: 'modern-compiler', 
                silenceDeprecations: [
                    'import', 
                    'global-builtin', 
                    'color-functions', 
                    'if-function', 
                    'mixed-decls'
                ],
            },
        },
    },
    // ============================
});