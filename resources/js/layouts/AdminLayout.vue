<script setup lang="ts">
import AdminSidebarLayout from '@/layouts/admin/AdminSidebarLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { Toaster } from '@/components/ui/sonner';
import { watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import 'vue-sonner/style.css';

const { breadcrumbs = [] } = defineProps<{
    breadcrumbs?: BreadcrumbItem[];
}>();

const page = usePage();

watch(
    () => page.props.flash,
    (flash: any) => {
        if (flash?.success) {
            toast.success(flash.success);
        }
        if (flash?.error) {
            toast.error(flash.error);
        }
    },
    { deep: true, immediate: true },
);
</script>

<template>
    <AdminSidebarLayout :breadcrumbs="breadcrumbs">
        <slot />
    </AdminSidebarLayout>
    <Toaster />
</template>
