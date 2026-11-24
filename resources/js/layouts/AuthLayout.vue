<script setup lang="ts">
import AuthLayout from '@/layouts/auth/AuthSimpleLayout.vue';
import { Toaster } from '@/components/ui/sonner';
import { usePage } from '@inertiajs/vue3';
import { watch } from 'vue';
import { toast } from 'vue-sonner';

const { title = '', description = '' } = defineProps<{
    title?: string;
    description?: string;
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
    <AuthLayout :title="title" :description="description">
        <slot />
    </AuthLayout>

    <Toaster />
</template>
