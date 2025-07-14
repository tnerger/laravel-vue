
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import MainLayout from './Layouts/MainLayout.vue';
import { ZiggyVue } from 'ziggy';

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
        const page = pages[`./Pages/${name}.vue`];

        // Setze das Standard-Layout für alle Seiten
        page.default.layout = page.default.layout || MainLayout;
        return page;
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({
            render: () => h(App, props),
        });
        app.config.devtools = true;
        app.use(plugin);
        app.use(ZiggyVue);
        app.mount(el);
    }
});
