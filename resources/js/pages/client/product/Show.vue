<script setup lang="ts">
import { computed, ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import ProductCard from '@/components/client/ProductCard.vue';
import ProductGallery from '@/components/client/ProductGallery.vue';
import { Button } from '@/components/ui/button';
import {
    Carousel,
    CarouselContent,
    CarouselItem,
} from '@/components/ui/carousel';
import {
    NumberField,
    NumberFieldContent,
    NumberFieldDecrement,
    NumberFieldIncrement,
    NumberFieldInput,
} from '@/components/ui/number-field';
import { show } from '@/routes/client/products';
import { BreadcrumbItem } from '@/types';
import { ParamProductGroup, ParamProductItem } from '@/types/param-product';
import { ProductShow } from '@/types/product';

const props = defineProps<{
    product: ProductShow;
    breadcrumbs: BreadcrumbItem[];
    paramProducts: ParamProductGroup[];
}>();

const uniqueParamGroups = computed(() =>
    props.paramProducts.map((group) => {
        const byValue = new Map<string, ParamProductItem>();

        for (const item of group.data) {
            const existing = byValue.get(item.value);
            if (!existing || item.product_id === props.product.id) {
                byValue.set(item.value, item);
            }
        }

        return {
            title: group.title,
            label: group.data[0]?.param?.label,
            items: Array.from(byValue.values()),
        };
    }),
);

const goToProduct = (item: ParamProductItem) => {
    if (item.product_id === props.product.id) {
        return;
    }

    router.visit(show(item.product_id).url);
};

const quantity = ref(1);
</script>

<template>
    <Head :title="product.title" />

    <div class="mx-auto max-w-6xl space-y-8 px-4 py-6 sm:px-6 lg:px-8">
        <div
            v-if="breadcrumbs.length > 1"
            class="border-b border-border pb-4 text-muted-foreground"
        >
            <Breadcrumbs :breadcrumbs="breadcrumbs" />
        </div>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
            <ProductGallery :product="product" />

            <div class="flex min-w-0 flex-col space-y-6 lg:col-span-5">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight sm:text-3xl">
                        {{ product.title }}
                    </h1>
                    <p class="mt-2 text-sm text-muted-foreground">
                        in stock:
                        <span class="font-medium text-foreground">
                            {{ product.qty }} units.
                        </span>
                    </p>
                </div>

                <div
                    class="flex items-baseline gap-3 border-y border-border py-4"
                >
                    <span class="text-3xl font-bold">
                        {{ product.price }} грн
                    </span>
                    <span
                        v-if="product.old_price"
                        class="text-lg text-muted-foreground line-through"
                    >
                        {{ product.old_price }} грн
                    </span>
                </div>

                <div v-if="uniqueParamGroups.length > 0" class="space-y-4">
                    <template
                        v-for="group in uniqueParamGroups"
                        :key="group.title ?? group.items[0]?.param_id"
                    >
                        <div v-if="group.items.length > 0" class="space-y-2">
                            <span
                                class="text-sm font-medium text-muted-foreground"
                            >
                                {{ group.title }}
                            </span>

                            <div class="flex flex-wrap gap-2">
                                <button
                                    v-for="item in group.items"
                                    :key="item.id"
                                    type="button"
                                    @click="goToProduct(item)"
                                    class="transition"
                                    :class="
                                        group.label === 'color'
                                            ? [
                                                  'h-7 w-7 cursor-pointer rounded-full border shadow-xs',
                                                  item.product_id === product.id
                                                      ? 'border-primary ring-2 ring-primary ring-offset-2'
                                                      : 'border-border opacity-80 hover:opacity-100',
                                              ]
                                            : [
                                                  'cursor-pointer rounded-md border px-3 py-1.5 text-sm',
                                                  item.product_id === product.id
                                                      ? 'border-primary bg-primary font-medium text-primary-foreground'
                                                      : 'border-border bg-background text-foreground hover:bg-muted',
                                              ]
                                    "
                                    :style="
                                        group.label === 'color'
                                            ? { backgroundColor: item.value }
                                            : undefined
                                    "
                                    :title="item.value"
                                >
                                    <span v-if="group.label !== 'color'">
                                        {{ item.value }}
                                    </span>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="flex flex-wrap items-center gap-4 pt-2">
                    <NumberField
                        v-model="quantity"
                        :min="1"
                        :max="product.qty || 99"
                        class="w-32"
                    >
                        <NumberFieldContent>
                            <NumberFieldDecrement />
                            <NumberFieldInput />
                            <NumberFieldIncrement />
                        </NumberFieldContent>
                    </NumberField>

                    <Button size="lg" class="flex-1 sm:min-w-44">
                        Order
                    </Button>
                </div>

                <template v-if="product.group_products.length > 0">
                    <h3 class="border-t border-border pt-4">
                        Related products
                    </h3>

                    <div>
                        <Carousel>
                            <CarouselContent>
                                <CarouselItem
                                    v-for="groupProduct in product.group_products"
                                    :key="groupProduct.id"
                                    class="basis-1/2"
                                >
                                    <ProductCard :product="groupProduct" />
                                </CarouselItem>
                            </CarouselContent>
                        </Carousel>
                    </div>
                </template>
            </div>
        </div>

        <div class="space-y-4 border-t border-border pt-8">
            <h2 class="text-xl font-semibold">Description</h2>
            <p
                v-if="product.description"
                class="leading-relaxed text-muted-foreground"
            >
                {{ product.description }}
            </p>
            <div
                v-if="product.content"
                class="prose prose-neutral dark:prose-invert max-w-none"
                v-html="product.content"
            />
        </div>
    </div>
</template>
