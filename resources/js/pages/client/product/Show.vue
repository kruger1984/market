<script setup lang="ts">
import { computed, ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import { ProductShow } from '@/types/product';
import { BreadcrumbItem } from '@/types';
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import {
    NumberField,
    NumberFieldContent,
    NumberFieldDecrement,
    NumberFieldIncrement,
    NumberFieldInput,
} from '@/components/ui/number-field';
import { Dialog, DialogContent, DialogTitle } from '@/components/ui/dialog';
import { ChevronLeft, ChevronRight, Maximize2 } from 'lucide-vue-next';

const props = defineProps<{
    product: ProductShow;
    breadcrumbs: BreadcrumbItem[];
}>();

const quantity = ref(1);
const isGalleryOpen = ref(false);

const allImages = computed(() => {
    const urls = props.product.images.map((img) => img.url);
    if (
        props.product.preview_image_url &&
        !urls.includes(props.product.preview_image_url)
    ) {
        return [props.product.preview_image_url, ...urls];
    }
    return urls.length > 0 ? urls : [props.product.preview_image_url];
});

const activeIndex = ref(0);
const activeImage = computed(() => allImages.value[activeIndex.value] ?? '');

const prevImage = () => {
    activeIndex.value =
        (activeIndex.value - 1 + allImages.value.length) %
        allImages.value.length;
};

const nextImage = () => {
    activeIndex.value = (activeIndex.value + 1) % allImages.value.length;
};
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
            <div class="flex flex-col-reverse gap-4 sm:flex-row lg:col-span-7">
                <div
                    v-if="allImages.length > 1"
                    class="flex gap-3 overflow-x-auto sm:w-20 sm:shrink-0 sm:flex-col"
                >
                    <button
                        v-for="(url, index) in allImages"
                        :key="url"
                        type="button"
                        @click="activeIndex = index"
                        class="relative aspect-square w-16 shrink-0 overflow-hidden rounded-md border-2 transition sm:w-full"
                        :class="
                            activeIndex === index
                                ? 'border-primary ring-2 ring-primary/20'
                                : 'border-transparent opacity-70 hover:opacity-100'
                        "
                    >
                        <img
                            :src="url"
                            :alt="`${product.title} - ${index + 1}`"
                            class="h-full w-full object-cover"
                        />
                    </button>
                </div>

                <div
                    class="group relative aspect-square w-full overflow-hidden rounded-xl border border-border bg-muted/30"
                >
                    <img
                        :src="activeImage"
                        :alt="product.title"
                        @click="isGalleryOpen = true"
                        class="h-full w-full cursor-zoom-in object-contain transition-transform duration-300 group-hover:scale-105"
                    />
                    <button
                        type="button"
                        @click="isGalleryOpen = true"
                        class="absolute right-3 bottom-3 rounded-lg bg-background/80 p-2 text-foreground opacity-0 shadow-sm backdrop-blur-sm transition group-hover:opacity-100"
                        title="Открыть на весь экран"
                    >
                        <Maximize2 class="h-4 w-4" />
                    </button>
                </div>
            </div>

            <div class="flex flex-col space-y-6 lg:col-span-5">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight sm:text-3xl">
                        {{ product.title }}
                    </h1>
                    <p class="mt-2 text-sm text-muted-foreground">
                        В наличии:
                        <span class="font-medium text-foreground"
                            >{{ product.qty }} шт.</span
                        >
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

                <div v-if="product.params.length > 0" class="space-y-4">
                    <div
                        v-for="param in product.params"
                        :key="param.id"
                        class="space-y-2"
                    >
                        <span class="text-sm font-medium text-muted-foreground">
                            {{ param.title }}:
                        </span>
                        <div
                            v-if="param.values.length > 0"
                            class="flex flex-wrap gap-2"
                        >
                            <template
                                v-for="value in param.values"
                                :key="value"
                            >
                                <Label
                                    v-if="param.label === 'color'"
                                    :for="`param-${param.id}-${value}`"
                                    :style="{ backgroundColor: value }"
                                    class="block h-7 w-7 cursor-pointer rounded-full border border-border shadow-xs"
                                />
                                <Label
                                    v-else
                                    :for="`param-${param.id}-${value}`"
                                    class="cursor-pointer rounded-md border border-border px-3 py-1.5 text-sm font-normal hover:bg-muted"
                                >
                                    {{ value }}
                                </Label>
                            </template>
                        </div>
                    </div>
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
            </div>
        </div>

        <div class="space-y-4 border-t border-border pt-8">
            <h2 class="text-xl font-semibold">Описание</h2>
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

    <Dialog v-model:open="isGalleryOpen">
        <DialogContent
            class="max-w-4xl border-none bg-background/95 p-2 sm:p-6"
        >
            <DialogTitle class="sr-only">{{ product.title }}</DialogTitle>

            <div class="relative flex aspect-4/3 items-center justify-center">
                <img
                    :src="activeImage"
                    :alt="product.title"
                    class="max-h-[75vh] w-auto rounded-lg object-contain"
                />

                <template v-if="allImages.length > 1">
                    <Button
                        variant="secondary"
                        size="icon"
                        class="absolute left-2 rounded-full opacity-80 hover:opacity-100"
                        @click="prevImage"
                    >
                        <ChevronLeft class="h-5 w-5" />
                    </Button>
                    <Button
                        variant="secondary"
                        size="icon"
                        class="absolute right-2 rounded-full opacity-80 hover:opacity-100"
                        @click="nextImage"
                    >
                        <ChevronRight class="h-5 w-5" />
                    </Button>
                </template>
            </div>

            <div
                v-if="allImages.length > 1"
                class="text-center text-sm text-muted-foreground"
            >
                {{ activeIndex + 1 }} / {{ allImages.length }}
            </div>
        </DialogContent>
    </Dialog>
</template>
