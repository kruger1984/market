<script setup lang="ts">
import AppContent from '@/components/AppContent.vue';
import AppShell from '@/components/AppShell.vue';
import AppSidebarHeader from '@/components/AppSidebarHeader.vue';
import Cart from '@/components/cart/Cart.vue';
import ClientSidebar from '@/components/client/ClientSidebar.vue';
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
    <AppShell variant="sidebar">
        <ClientSidebar />
        <AppContent variant="sidebar" class="min-w-0 overflow-x-clip">
            <AppSidebarHeader :breadcrumbs="breadcrumbs">
                <template #actions>
                    <Cart />
                </template>
            </AppSidebarHeader>
            <slot />
        </AppContent>
    </AppShell>
</template>
