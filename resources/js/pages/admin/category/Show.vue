<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { ArrowLeft, Pencil } from '@lucide/vue';
import { index, edit } from '@/routes/admin/categories';
import { Category } from '@/types/category';
import { index as dashboardIndex } from '@/routes/admin/dashboard';

const props = defineProps<{
    category: Category;
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: dashboardIndex(),
            },
            {
                title: 'Categories',
                href: index(),
            },
            {
                title: `Show category`,
            },
        ],
    },
});
</script>

<template>
    <Head :title="`Category: ${category.title}`" />

    <div class="max-w-2xl space-y-6 p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <Button variant="outline" size="icon" as-child>
                    <Link :href="index.url()">
                        <ArrowLeft class="h-4 w-4" />
                    </Link>
                </Button>
                <h1 class="text-2xl font-bold tracking-tight">
                    Category Details
                </h1>
            </div>

            <Button as-child class="gap-2">
                <Link :href="edit.url(category.id)">
                    <Pencil class="h-4 w-4" />
                    Edit
                </Link>
            </Button>
        </div>

        <div class="space-y-4 rounded-xl border bg-card p-6 shadow-sm">
            <div class="flex justify-between gap-4">
                <div>
                    <span class="text-sm text-muted-foreground">ID</span>
                    <p class="text-lg font-medium">{{ category.id }}</p>
                </div>
                <div>
                    <span class="text-sm text-muted-foreground">Title</span>
                    <p class="text-lg font-medium">{{ category.title }}</p>
                </div>
                <div>
                    <span class="text-sm text-muted-foreground">Category</span>
                    <p class="text-lg font-medium text-muted-foreground">
                        {{ category.category ? category.category.title : '-' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
