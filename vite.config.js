import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                //'resources/css/app.css',
                //'resources/js/app.js'
                "resources/css/web/web.css",
                "resources/js/web/web.js",
                "resources/css/cliente/cliente.css",
                "resources/js/cliente/cliente.js",
                "resources/css/admin/admin.css",
                "resources/js/admin/admin.js",
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
