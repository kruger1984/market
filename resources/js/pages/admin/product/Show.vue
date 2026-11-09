<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { ArrowLeft, Pencil } from 'lucide-vue-next';
import { index, edit } from '@/routes/admin/products';
import { index as dashboardIndex } from '@/routes/admin/dashboard';
import type { Product } from '@/types/product';

const props = defineProps<{
    product: Product;
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: dashboardIndex(),
            },
            {
                title: 'Products',
                href: index(),
            },
            {
                title: 'Product details',
            },
        ],
    },
});
</script>

<template>
    <Head :title="`Product: ${product.title}`" />

    <div class="max-w-4xl space-y-6 p-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <Button variant="outline" size="icon" as-child>
                    <Link :href="index.url()">
                        <ArrowLeft class="h-4 w-4" />
                    </Link>
                </Button>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">
                        Product Details
                    </h1>
                    <p class="text-xs text-muted-foreground">
                        SKU: {{ product.sku }}
                    </p>
                </div>
            </div>

            <Button as-child class="gap-2">
                <Link :href="edit.url(product.id)">
                    <Pencil class="h-4 w-4" />
                    Edit
                </Link>
            </Button>
        </div>

        <div class="space-y-6 rounded-xl border bg-card p-6 shadow-sm">
            <!-- General Info Grid -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                <div>
                    <span class="text-sm font-medium text-muted-foreground"
                        >ID</span
                    >
                    <p class="mt-1 text-base font-semibold">{{ product.id }}</p>
                </div>
                <div>
                    <span class="text-sm font-medium text-muted-foreground"
                        >Title</span
                    >
                    <p class="mt-1 text-base font-semibold">
                        {{ product.title }}
                    </p>
                </div>
                <div>
                    <span class="text-sm font-medium text-muted-foreground"
                        >Category</span
                    >
                    <p class="mt-1 text-base font-semibold">
                        {{ product.category?.title ?? '-' }}
                    </p>
                </div>
            </div>

            <!-- Group & Stock Grid -->
            <div class="grid grid-cols-1 gap-6 border-t pt-6 sm:grid-cols-3">
                <div>
                    <span class="text-sm font-medium text-muted-foreground"
                        >Product Group</span
                    >
                    <p class="mt-1 text-base font-semibold">
                        {{ product.productGroup?.title ?? '-' }}
                    </p>
                </div>
                <div>
                    <span class="text-sm font-medium text-muted-foreground"
                        >Price</span
                    >
                    <p class="mt-1 text-base font-semibold text-emerald-600">
                        ${{ product.price }}
                    </p>
                </div>
                <div>
                    <span class="text-sm font-medium text-muted-foreground"
                        >Quantity</span
                    >
                    <p class="mt-1 text-base font-semibold">
                        {{ product.qty }}
                    </p>
                </div>
            </div>

            <!-- Description -->
            <div v-if="product.description" class="border-t pt-6">
                <span class="text-sm font-medium text-muted-foreground"
                    >Description</span
                >
                <p class="mt-1 text-sm leading-relaxed text-muted-foreground">
                    {{ product.description }}
                </p>
            </div>

            <!-- Rich Text Content -->
            <div v-if="product.content" class="border-t pt-6">
                <span class="text-sm font-medium text-muted-foreground"
                    >Content</span
                >
                <div
                    class="prose dark:prose-invert mt-2 max-w-none text-sm"
                    v-html="product.content"
                />
            </div>

            <!-- Images Gallery -->
            <div
                v-if="product.images && product.images.length > 0"
                class="space-y-2 border-t pt-6"
            >
                <span class="text-sm font-medium text-muted-foreground"
                    >Images</span
                >
                <div
                    class="grid grid-cols-2 gap-4 sm:grid-cols-4 md:grid-cols-5"
                >
                    <div
                        v-for="(image, index) in product.images"
                        :key="image.id ?? index"
                        class="aspect-square overflow-hidden rounded-lg border bg-muted"
                    >
                        <img
                            :src="image.url"
                            :alt="product.title"
                            class="h-full w-full object-cover transition-transform hover:scale-105"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
