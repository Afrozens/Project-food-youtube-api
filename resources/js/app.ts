import "./bootstrap";
import "../css/app.css";
import "vue-select/dist/vue-select.css";
import "vue3-toastify/dist/index.css";
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";

import { createApp, h, DefineComponent } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import VueLazyLoad from "vue3-lazyload";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob<DefineComponent>("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(VueLazyLoad, {})
            .use(ZiggyVue, Ziggy)
            .mount(el);
    },
    progress: {
        color: "#1976D2",
    },
});
