<script setup lang="ts">
import { computed, watch } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import ProductCard from '@/components/client/ProductCard.vue';
import { Badge } from '@/components/ui/badge';
import { useFilteredProducts } from '@/composables/useFilteredProducts'; // проверьте имя файла
import ClientLayout from '@/layouts/ClientLayout.vue';
import { index as categoryProductsIndex } from '@/routes/client/categories/products';
import type { Category } from '@/types/category';
import type { ParamWithValues } from '@/types/param';
import type { Product } from '@/types/product';

const props = defineProps<{
    products: Product[];
    params: ParamWithValues[];
    breadcrumbs: Category[];
    categoryChildren: Category[];
    category: Category;
}>();

const { filteredProducts, resetFilteredProducts } = useFilteredProducts();

defineOptions({
    layout: (h: any, page: any) => {
        const backendBreadcrumbs: Category[] = page.props.breadcrumbs ?? [];

        return h(
            ClientLayout,
            {
                breadcrumbs: backendBreadcrumbs.map((item) => ({
                    title: item.title,
                    href: categoryProductsIndex(item.id),
                })),
            },
            () => page,
        );
    },
});

watch(
    () => props.category.id,
    () => {
        resetFilteredProducts();
    },
);

const displayedProducts = computed(
    () => filteredProducts.value ?? props.products,
);
</script>

<template>
    <Head :title="category.title" />

    <div class="space-y-6 p-3">
        <h1 class="text-2xl font-bold tracking-tight">{{ category.title }}</h1>

        <div v-if="categoryChildren.length > 0" class="flex flex-wrap gap-2">
            <Badge
                v-for="child in categoryChildren"
                :key="child.id"
                variant="secondary"
                as-child
            >
                <Link :href="categoryProductsIndex(child)">
                    {{ child.title }}
                </Link>
            </Badge>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">
            <div class="lg:col-span-4">
                <div
                    v-if="displayedProducts.length > 0"
                    class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3"
                >
                    <ProductCard
                        v-for="product in displayedProducts"
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
        </div>
    </div>
</template>
