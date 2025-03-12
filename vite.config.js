import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    // server: {
    //     host: '192.168.0.105', // Usa tu dirección IP local
    //     port: 5173,           // Puerto predeterminado de Vite
    //     strictPort: true,     // Asegura que el puerto no cambie
    // },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
