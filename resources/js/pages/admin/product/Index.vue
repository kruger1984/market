<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Plus } from '@lucide/vue';
import { Button } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';

import { create, index } from '@/routes/admin/products';
import { index as dashboardIndex } from '@/routes/admin/dashboard';
import { Product } from '@/types/product';
import ProductTableItem from '@/components/admin/ProductTableItem.vue';

const props = defineProps<{
    products: Product[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: dashboardIndex(),
            },
            {
                title: 'Product',
                href: index(),
            },
        ],
    },
});
</script>

<template>
    <Head title="Products" />

    <div class="space-y-6 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Products</h1>
                <p class="text-sm text-muted-foreground">Manage products</p>
            </div>

            <Button as-child class="gap-2">
                <Link :href="create.url()">
                    <Plus class="h-4 w-4" />
                    Add product
                </Link>
            </Button>
        </div>

        <div class="rounded-md border bg-card">
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead class="w-20">ID</TableHead>
                        <TableHead>Image</TableHead>
                        <TableHead>Title</TableHead>
                        <TableHead>Product Group</TableHead>
                        <TableHead>Qty</TableHead>
                        <TableHead class="text-right">Actions</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <template v-if="products.length > 0">
                        <ProductTableItem
                            v-for="product in products"
                            :key="product.id"
                            :product="product"
                        />
                    </template>
                    <template v-else>
                        <TableRow>
                            <TableCell
                                colspan="6"
                                class="h-24 text-center text-muted-foreground"
                            >
                                No products found.
                            </TableCell>
                        </TableRow>
                    </template>
                </TableBody>
            </Table>
        </div>
    </div>
</template>
