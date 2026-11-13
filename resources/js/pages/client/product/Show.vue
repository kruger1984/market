<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import ProductCard from '@/components/client/ProductCard.vue';
import type { Product } from '@/types/product';

defineProps<{
    products: Product[];
}>();

</script>

<template>
    <Head title="Каталог товаров" />

    <div class="space-y-6 p-3">
        <h1 class="text-2xl font-bold tracking-tight">Products</h1>

        <div
            v-if="products.length > 0"
            class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
        >
            <ProductCard
                v-for="product in products"
                :key="product.id"
                :product="product"
            />
        </div>

        <div
            v-else
            class="flex h-48 items-center justify-center rounded-lg border border-dashed text-muted-foreground"
        >
            There is no products.
        </div>
    </div>
</template>
