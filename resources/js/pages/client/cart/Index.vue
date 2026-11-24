<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Eye, Pencil, Plus, Trash2 } from '@lucide/vue';
import { Button } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';

import { destroy } from '@/routes/client/carts';
import { CartWithProductAndTotal } from '@/types/cart';

const props = defineProps<{
    carts: CartWithProductAndTotal[];
}>();

const handleDelete = (id: number) => {
    if (confirm('Are you sure you want to delete this Product from cart?')) {
        router.delete(destroy(id));
    }
};
</script>

<template>
    <Head title="Params" />

    <div class="space-y-6 p-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Cart</h1>
            <p class="text-sm text-muted-foreground">Manage cart items</p>
        </div>

        <div class="rounded-md border bg-card">
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead class="w-20">ID</TableHead>
                        <TableHead>Title</TableHead>
                        <TableHead>Qty</TableHead>
                        <TableHead>Total</TableHead>
                        <TableHead class="text-right">Actions</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <template v-if="carts.length > 0">
                        <TableRow v-for="cart in carts" :key="cart.id">
                            <TableCell class="font-medium">
                                {{ cart.product_id }}
                            </TableCell>
                            <TableCell class="font-medium">
                                {{ cart.product_title }}
                            </TableCell>
                            <TableCell class="font-medium">
                                {{ cart.qty }}
                            </TableCell>
                            <TableCell class="font-medium">
                                {{ cart.total_sum }}
                            </TableCell>

                            <TableCell class="text-right">
                                <div class="flex justify-end gap-2">
                                    <Button
                                        class="cursor-pointer"
                                        variant="outline"
                                        size="icon"
                                        @click="handleDelete(cart.id)"
                                    >
                                        <Trash2 class="h-4 w-4 text-red-500" />
                                    </Button>
                                </div>
                            </TableCell>
                        </TableRow>
                    </template>
                    <template v-else>
                        <TableRow>
                            <TableCell
                                colspan="4"
                                class="h-24 text-center text-muted-foreground"
                            >
                                Cart is empty.
                            </TableCell>
                        </TableRow>
                    </template>
                </TableBody>
            </Table>
        </div>
    </div>
</template>
