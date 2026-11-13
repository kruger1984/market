<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Folder } from 'lucide-vue-next';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { index as categoriesIndex } from '@/routes/client/categories';
import { index as categoryProductsIndex } from '@/routes/client/categories/products';
import type { Category } from '@/types/category';

defineProps<{
    categories: Category[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Categories',
                href: categoriesIndex(),
            },
        ],
    },
});
</script>

<template>
    <Head title="Categories" />

    <div class="space-y-6 p-3">
        <h1 class="text-2xl font-bold tracking-tight">Categories</h1>

        <div
            v-if="categories.length > 0"
            class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
        >
            <Link
                v-for="category in categories"
                :key="category.id"
                :href="categoryProductsIndex(category)"
            >
                <Card class="h-full transition-shadow hover:shadow-md">
                    <CardHeader class="flex flex-row items-center gap-3">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-md bg-muted"
                        >
                            <Folder class="h-5 w-5 text-muted-foreground" />
                        </div>
                        <CardTitle class="text-base">
                            {{ category.title }}
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p class="text-sm text-muted-foreground">
                            Open products
                        </p>
                    </CardContent>
                </Card>
            </Link>
        </div>

        <div
            v-else
            class="flex h-48 items-center justify-center rounded-lg border border-dashed text-muted-foreground"
        >
            There are no categories.
        </div>
    </div>
</template>
