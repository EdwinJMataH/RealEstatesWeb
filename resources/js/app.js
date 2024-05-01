import './bootstrap';
import '../css/app.css';
import Lara from '../css/presets/lara';
import 'primeicons/primeicons.css'

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import PrimeVue from 'primevue/config';
import Ripple from 'primevue/ripple';
import Toast from 'primevue/toast';
import ToastService from 'primevue/toastservice';
import StyleClass from 'primevue/styleclass';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(PrimeVue, {
                unstyled: true,
                pt: Lara,
                ripple: true
            })
            .use(ToastService)
            .use(ZiggyVue, Ziggy)
            .directive('ripple', Ripple)
            .directive('styleclass', StyleClass)
            .component('Toast', Toast)
            .mount(el);
    },
    // progress: {
    //     color: '#4B5563',
    // },
});
