<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ShoppingCart } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import {
    Card,
    CardContent,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { show as productShow } from '@/routes/client/products';
import { index as categoryProductsIndex } from '@/routes/client/categories/products';
import type { Product } from '@/types/product';

defineProps<{
    product: Product;
}>();
</script>

<template>
    <Card
        class="flex flex-col overflow-hidden transition-shadow hover:shadow-md"
    >
        <Link
            :href="productShow(product)"
            class="relative aspect-square overflow-hidden bg-muted"
        >
            <img
                v-if="product.preview_image_url"
                :src="product.preview_image_url"
                :alt="product.title"
                class="h-full w-full object-cover transition-transform duration-300 hover:scale-105"
            />
            <div
                v-else
                class="flex h-full w-full items-center justify-center text-sm text-muted-foreground"
            >
                No photo
            </div>

            <Badge
                v-if="product.old_price && product.old_price > product.price"
                variant="destructive"
                class="absolute top-2 left-2"
            >
                Discount
            </Badge>
        </Link>

        <CardHeader class="pb-2">
            <p v-if="product.category" class="text-xs text-muted-foreground">
                <Link
                    :href="categoryProductsIndex(product.category)"
                    class="hover:underline"
                >
                    {{ product.category.title }}
                </Link>
            </p>
            <CardTitle class="line-clamp-2 text-base">
                <Link :href="productShow(product)" class="hover:underline">
                    {{ product.title }}
                </Link>
            </CardTitle>
        </CardHeader>

        <CardContent class="mt-auto pt-0">
            <div class="flex items-baseline gap-2">
                <span class="text-lg font-bold"> {{ product.price }} ₴ </span>
                <span
                    v-if="product.old_price"
                    class="text-sm text-muted-foreground line-through"
                >
                    {{ product.old_price }} ₴
                </span>
            </div>
        </CardContent>

        <CardFooter class="pt-0">
            <Button class="w-full gap-2" :disabled="product.qty <= 0">
                <ShoppingCart class="h-4 w-4" />
                To Cart
            </Button>
        </CardFooter>
    </Card>
</template>
