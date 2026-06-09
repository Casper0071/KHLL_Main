import '../css/app.css';
import './bootstrap';

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import intersect from './directives/intersect'  // Voeg deze import toe

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        return pages[`./Pages/${name}.vue`]
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })

        app.directive('intersect', intersect)  // Voeg deze regel toe

        app.use(plugin)
        app.mount(el)
    },
})
