import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import Components from "unplugin-vue-components/vite";
import { PrimeVueResolver } from "unplugin-vue-components/resolvers";
import AutoImport from 'unplugin-auto-import/vite';
export default defineConfig({
    plugins: [
        laravel({
            input: "resources/js/app.js",
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
        AutoImport({
            imports: [
              'vue', // Auto-import Vue Composition API functions (ref, reactive, etc.)
            {
                'pinia': [
                  'storeToRefs' // Auto-import storeToRefs from pinia
                ],
            },
            ],
            dts: true, // Generates a TypeScript declaration file
        }),
        Components({
            resolvers: [PrimeVueResolver()],
        }),
    ],
});
