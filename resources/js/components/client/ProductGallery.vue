<script setup lang="ts">
import { computed, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import { ChevronLeft, ChevronRight, Maximize2 } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import {
    Carousel,
    CarouselContent,
    CarouselItem,
    CarouselNext,
    CarouselPrevious,
} from '@/components/ui/carousel';
import { Dialog, DialogContent, DialogTitle } from '@/components/ui/dialog';
import { ProductShow } from '@/types/product';

const props = defineProps<{
    product: ProductShow;
}>();

const isGalleryOpen = ref(false);
const activeIndex = ref(0);

const allImages = computed(() => {
    const urls = props.product.images.map((img) => img.url);

    if (
        props.product.preview_image_url &&
        !urls.includes(props.product.preview_image_url)
    ) {
        return [props.product.preview_image_url, ...urls];
    }

    return urls.length > 0
        ? urls
        : props.product.preview_image_url
          ? [props.product.preview_image_url]
          : [];
});

const activeImage = computed(() => allImages.value[activeIndex.value] ?? '');

watch(
    () => props.product.id,
    () => {
        activeIndex.value = 0;
        isGalleryOpen.value = false;
    },
);

const prevImage = () => {
    if (allImages.value.length === 0) return;

    activeIndex.value =
        (activeIndex.value - 1 + allImages.value.length) %
        allImages.value.length;
};

const nextImage = () => {
    if (allImages.value.length === 0) return;

    activeIndex.value = (activeIndex.value + 1) % allImages.value.length;
};

const isDesktop = ref(false);
let mediaQuery: MediaQueryList | null = null;

const updateIsDesktop = () => {
    isDesktop.value = mediaQuery?.matches ?? false;
};

onMounted(() => {
    mediaQuery = window.matchMedia('(min-width: 640px)');
    updateIsDesktop();
    mediaQuery.addEventListener('change', updateIsDesktop);
});

onBeforeUnmount(() => {
    mediaQuery?.removeEventListener('change', updateIsDesktop);
});
</script>

<template>
    <div
        class="flex flex-col-reverse gap-4 sm:flex-row sm:items-start lg:col-span-7"
    >
        <div v-if="allImages.length > 1" class="w-full sm:w-24 sm:shrink-0">
            <Carousel
                :key="isDesktop ? 'vertical' : 'horizontal'"
                :opts="{ align: 'start', dragFree: true }"
                :orientation="isDesktop ? 'vertical' : 'horizontal'"
                class="relative w-full"
            >
                <CarouselContent :class="isDesktop ? 'h-105' : ''">
                    <CarouselItem
                        v-for="(url, index) in allImages"
                        :key="url"
                        :class="isDesktop ? 'basis-1/5' : 'basis-1/4'"
                    >
                        <button
                            type="button"
                            @click="activeIndex = index"
                            class="relative aspect-square w-full overflow-hidden rounded-md border-2 transition"
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
                    </CarouselItem>
                </CarouselContent>
                <CarouselPrevious
                    :class="
                        isDesktop
                            ? 'top-2 left-1/2 -translate-x-1/2'
                            : 'top-1/2 left-2 -translate-y-1/2'
                    "
                />
                <CarouselNext
                    :class="
                        isDesktop
                            ? 'bottom-2 left-1/2 -translate-x-1/2'
                            : 'top-1/2 right-2 -translate-y-1/2'
                    "
                />
            </Carousel>
        </div>

        <div
            class="group relative aspect-square min-w-0 flex-1 overflow-hidden rounded-xl border border-border bg-muted/30"
        >
            <img
                v-if="activeImage"
                :src="activeImage"
                :alt="product.title"
                @click="isGalleryOpen = true"
                class="h-full w-full cursor-zoom-in object-contain transition-transform duration-300 group-hover:scale-105"
            />
            <button
                v-if="activeImage"
                type="button"
                @click="isGalleryOpen = true"
                class="absolute right-3 bottom-3 rounded-lg bg-background/80 p-2 text-foreground opacity-0 shadow-sm backdrop-blur-sm transition group-hover:opacity-100"
                title="Открыть на весь экран"
            >
                <Maximize2 class="h-4 w-4" />
            </button>
        </div>
    </div>

    <Dialog v-model:open="isGalleryOpen">
        <DialogContent
            class="max-w-4xl overflow-hidden border-none bg-background/95 p-2 sm:p-6"
        >
            <DialogTitle class="sr-only">{{ product.title }}</DialogTitle>

            <div
                class="relative flex aspect-4/3 w-full items-center justify-center overflow-hidden"
            >
                <img
                    v-if="activeImage"
                    :src="activeImage"
                    :alt="product.title"
                    class="max-h-[75vh] max-w-full rounded-lg object-contain"
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
