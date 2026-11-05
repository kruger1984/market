<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { ArrowLeft, Pencil } from '@lucide/vue';
import { index, edit } from '@/routes/admin/params';
import { index as dashboardIndex } from '@/routes/admin/dashboard';
import type { Param } from '@/types/param';

const props = defineProps<{
    param: Param;
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: dashboardIndex(),
            },
            {
                title: 'Params',
                href: index(),
            },
            {
                title: 'Param details',
            },
        ],
    },
});
</script>

<template>
    <Head :title="`Param: ${param.title}`" />

    <div class="max-w-2xl space-y-6 p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <Button variant="outline" size="icon" as-child>
                    <Link :href="index.url()">
                        <ArrowLeft class="h-4 w-4" />
                    </Link>
                </Button>
                <h1 class="text-2xl font-bold tracking-tight">Param Details</h1>
            </div>

            <Button as-child class="gap-2">
                <Link :href="edit.url(param.id)">
                    <Pencil class="h-4 w-4" />
                    Edit
                </Link>
            </Button>
        </div>

        <div class="rounded-xl border bg-card p-6 shadow-sm">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                <div>
                    <span class="text-sm font-medium text-muted-foreground"
                        >ID</span
                    >
                    <p class="mt-1 text-lg font-semibold">{{ param.id }}</p>
                </div>
                <div>
                    <span class="text-sm font-medium text-muted-foreground"
                        >Title</span
                    >
                    <p class="mt-1 text-lg font-semibold">{{ param.title }}</p>
                </div>
                <div>
                    <span class="text-sm font-medium text-muted-foreground"
                        >Filter Type</span
                    >
                    <p class="mt-1 text-lg font-semibold">
                        {{ param.filter_type_label ?? param.filter_type }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
