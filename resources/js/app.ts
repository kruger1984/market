import { createInertiaApp } from '@inertiajs/vue3';
import { initializeTheme } from '@/composables/useAppearance';
import AdminLayout from '@/layouts/AdminLayout.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';
import ClientHeaderLayout from '@/layouts/ClientHeaderLayout.vue';
import ClientLayout from '@/layouts/ClientLayout.vue';
import RootLayout from '@/layouts/RootLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { initializeFlashToast } from '@/lib/flashToast';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const clientHeaderPages = ['client/category/Index', 'client/product/Show'];

void createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    layout: (name) => {
        if (name.startsWith('auth/')) {
            return [RootLayout, AuthLayout];
        }
        if (name.startsWith('settings/')) {
            return [RootLayout, AdminLayout, SettingsLayout];
        }
        if (name.startsWith('admin/')) {
            return [RootLayout, AdminLayout];
        }
        if (clientHeaderPages.includes(name)) {
            return [RootLayout, ClientHeaderLayout];
        }

        return [RootLayout, ClientLayout];
    },
    withApp: (app) => {
        app.directive('focus', {
            mounted: (el: HTMLElement, shouldFocus) => {
                if (shouldFocus.value !== false) {
                    el.focus();
                }
            },
        });
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on page load...
initializeTheme();

// This will listen for flash toast data from the server...
initializeFlashToast();
