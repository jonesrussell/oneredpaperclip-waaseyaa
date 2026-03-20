import { createInertiaApp } from '@inertiajs/vue3';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import '../css/app.css';
import { initializeTheme } from './composables/useAppearance';
import { registerWebMCPTools } from './composables/useWebMCP';

const appName = import.meta.env.VITE_APP_NAME || 'One Red Paperclip';

const pages = import.meta.glob<DefineComponent>('./pages/**/*.vue');

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: async (name) => {
        const path = `./pages/${name}.vue`;
        const page = pages[path];
        if (!page) {
            throw new Error(`Page not found: ${path}`);
        }
        return (await page()).default;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on page load...
initializeTheme();
// Expose tools to AI/browser agents when WebMCP is available
registerWebMCPTools();
