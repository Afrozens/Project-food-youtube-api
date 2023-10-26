import "./bootstrap";
import "../css/app.css";

import { createApp, h, DefineComponent } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { createI18n } from "vue-i18n";
import { messages } from "./Lang/messages";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";
const i18n = createI18n({
    locale: "en",
    fallbackLocale: "en",
    messages,
});

createInertiaApp({
    title: (title) => `${appName} - ${title}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob<DefineComponent>("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(i18n)
            .use(ZiggyVue, Ziggy)
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
