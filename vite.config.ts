import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import path from "path";
import vueI18n from "@intlify/vite-plugin-vue-i18n";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/js/src/app.js"],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        vueI18n({
            include: path.resolve("resources/js/src/locales/**"),
        }),
    ],
    server: {
        hmr: {
            host: "localhost",
        },
    },
    resolve: {
        alias: {
            "@": path.resolve("./resources/js/src"),
        },
    },
    optimizeDeps: {
        include: ["quill"],
    },
});
