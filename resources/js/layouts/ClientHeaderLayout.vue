<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import AppLogo from '@/components/AppLogo.vue';
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import Cart from '@/components/cart/Cart.vue';
import { index as homePage } from '@/routes/client/categories';
import type { BreadcrumbItem } from '@/types';

withDefaults(
    defineProps<{
        breadcrumbs?: BreadcrumbItem[];
    }>(),
    {
        breadcrumbs: () => [],
    },
);
</script>

<template>
    <div class="flex min-h-screen w-full flex-col">
        <header class="border-b border-border">
            <div
                class="mx-auto flex h-16 max-w-6xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8"
            >
                <div class="flex min-w-0 items-center gap-6">
                    <Link :href="homePage()" class="flex items-center gap-2">
                        <AppLogo />
                    </Link>
                    <Breadcrumbs
                        v-if="breadcrumbs.length > 0"
                        :breadcrumbs="breadcrumbs"
                        class="hidden md:flex"
                    />
                </div>
                <Cart />
            </div>
        </header>

        <main class="flex-1">
            <slot />
        </main>
    </div>
</template>
