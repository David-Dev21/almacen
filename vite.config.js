import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js', // Asegúrate de que este archivo exista y sea tu punto de entrada
            ],
            refresh: true, // Esto permite recargar el navegador en modo desarrollo cuando hay cambios
        }),
    ],
    build: {
        outDir: 'public/build', // Carpeta de salida para los archivos compilados
        manifest: true, // Activa la generación de un archivo manifest.json, necesario para el trabajo con Vite y Laravel
    },
});
