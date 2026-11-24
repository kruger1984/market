<script setup lang="ts">
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { ShoppingCart } from 'lucide-vue-next';
import { index } from '@/routes/client/carts';
import type { User } from '@/types';

const props = defineProps<{
    user?: User | null;
}>();

const page = usePage();

const currentUser = computed(() => {
    return (
        props.user ?? (page.props.auth?.user as User | null | undefined) ?? null
    );
});

const cartsProductCount = computed(
    () => currentUser.value?.carts_product_count ?? 0,
);
</script>

<template>
    <Link :href="index()" class="group relative inline-flex items-center">
        <ShoppingCart
            class="h-5 w-5 cursor-pointer transition-colors group-hover:text-primary"
        />
        <span
            v-if="cartsProductCount > 0"
            class="absolute -top-1 -right-1 flex h-4 min-w-4 translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-primary px-1 text-[10px] leading-none font-semibold text-primary-foreground ring-2 ring-background"
        >
            {{ cartsProductCount }}
        </span>
    </Link>
</template>
