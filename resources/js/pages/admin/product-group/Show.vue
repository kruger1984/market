<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { ArrowLeft, Pencil } from '@lucide/vue';
import { index, edit } from '@/routes/admin/product-groups';
import { ProductGroup } from '@/types/product-group';
import { index as dashboardIndex } from '@/routes/admin/dashboard';

const props = defineProps<{
    productGroup: ProductGroup;
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: dashboardIndex(),
            },
            {
                title: 'Product Groups',
                href: index(),
            },
            {
                title: `Show productGroup`,
            },
        ],
    },
});
</script>

<template>
    <Head :title="`ProductGroup: ${productGroup.title}`" />

    <div class="max-w-2xl space-y-6 p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <Button variant="outline" size="icon" as-child>
                    <Link :href="index.url()">
                        <ArrowLeft class="h-4 w-4" />
                    </Link>
                </Button>
                <h1 class="text-2xl font-bold tracking-tight">
                    ProductGroup Details
                </h1>
            </div>

            <Button as-child class="gap-2">
                <Link :href="edit.url(productGroup.id)">
                    <Pencil class="h-4 w-4" />
                    Edit
                </Link>
            </Button>
        </div>

        <div class="space-y-4 rounded-xl border bg-card p-6 shadow-sm">
            <div class="flex justify-between gap-4">
                <div>
                    <span class="text-sm text-muted-foreground">ID</span>
                    <p class="text-lg font-medium">{{ productGroup.id }}</p>
                </div>
                <div>
                    <span class="text-sm text-muted-foreground">Title</span>
                    <p class="text-lg font-medium">{{ productGroup.title }}</p>
                </div>
            </div>
        </div>
    </div>
</template>
