<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { ShoppingCart } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import {
    NumberField,
    NumberFieldContent,
    NumberFieldDecrement,
    NumberFieldIncrement,
    NumberFieldInput,
} from '@/components/ui/number-field';
import type { Product, ProductShow } from '@/types/product';
import type { Cart } from '@/types/cart';
import { store, update } from '@/routes/client/carts';

interface CartMutationResponse {
    id: number;
    product_id: number;
    qty: number;
    carts_total_sum: number;
}

type CartProduct = Pick<Product, 'id' | 'qty'> & {
    cart?: Cart | null;
};

const props = defineProps<{
    product: CartProduct | ProductShow;
}>();

const page = usePage();

const cart = ref<Partial<Cart> | null>(props.product.cart ?? null);
const quantity = ref<number>(props.product.cart?.qty ?? 1);
const isSubmitting = ref<boolean>(false);

const hasInCart = computed<boolean>(() => Boolean(cart.value?.id));

watch(
    () => props.product.cart,
    (nextCart) => {
        cart.value = nextCart ?? null;
        quantity.value = nextCart?.qty ?? 1;
    },
);

function storeCart() {
    router.post(
        store(),
        { product_id: props.product.id, qty: 1 },
        {
            preserveScroll: true,
            onStart: () => (isSubmitting.value = true),
            onFinish: () => (isSubmitting.value = false),
        },
    );
}

function updateCart(): void {
    const cartId = cart.value?.id;

    if (!cartId || isSubmitting.value) {
        return;
    }

    router.patch(
        update(cartId),
        { qty: quantity.value },
        {
            preserveScroll: true,
            onStart: () => (isSubmitting.value = true),
            onFinish: () => (isSubmitting.value = false),
        },
    );
}
</script>

<template>
    <div class="w-full space-y-2">
        <Button
            v-if="!hasInCart"
            class="w-full cursor-pointer gap-2"
            :disabled="product.qty <= 0 || isSubmitting"
            @click="storeCart"
        >
            <ShoppingCart class="h-4 w-4" />
            To Cart
        </Button>

        <div v-else class="flex items-center gap-4 pt-2">
            <NumberField
                v-model="quantity"
                :min="1"
                :max="product.qty || 99"
                :disabled="isSubmitting"
            >
                <NumberFieldContent>
                    <NumberFieldDecrement />
                    <NumberFieldInput />
                    <NumberFieldIncrement />
                </NumberFieldContent>
            </NumberField>

            <Button
                size="lg"
                class="cursor-pointer"
                :disabled="isSubmitting"
                @click="updateCart"
            >
                Update
            </Button>
        </div>
    </div>
</template>
