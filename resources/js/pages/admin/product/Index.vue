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

import { create, destroy, edit, index, show } from '@/routes/admin/products';
import { index as dashboardIndex } from '@/routes/admin/dashboard';
import { Product } from '@/types/product';

const props = defineProps<{
    products: Product[];
}>();

const handleDelete = (id: number) => {
    if (confirm('Are you sure you want to delete this Product?')) {
        router.delete(destroy.url(id));
    }
};

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
                        <TableHead>Title</TableHead>
                        <TableHead>Product Group</TableHead>
                        <TableHead>Qty</TableHead>
                        <TableHead class="text-right">Actions</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <template v-if="products.length > 0">
                        <TableRow v-for="product in products" :key="product.id">
                            <TableCell class="font-medium">{{
                                product.id
                            }}</TableCell>
                            <TableCell
                                ><Link
                                    :href="show(product)"
                                    class="hover:underline"
                                    >{{ product.title }}</Link
                                ></TableCell
                            >
                            <TableCell class="text-muted-foreground">
                                {{ product.productGroup.title }}
                            </TableCell>
                            <TableCell class="text-muted-foreground">
                                {{ product.qty }}
                            </TableCell>

                            <TableCell class="text-right">
                                <div class="flex justify-end gap-2">
                                    <Button
                                        variant="outline"
                                        size="icon"
                                        as-child
                                    >
                                        <Link :href="show.url(product.id)">
                                            <Eye
                                                class="h-4 w-4 text-gray-500"
                                            />
                                        </Link>
                                    </Button>
                                    <Button
                                        variant="outline"
                                        size="icon"
                                        as-child
                                    >
                                        <Link :href="edit.url(product.id)">
                                            <Pencil
                                                class="h-4 w-4 text-blue-500"
                                            />
                                        </Link>
                                    </Button>
                                    <Button
                                        class="cursor-pointer"
                                        variant="outline"
                                        size="icon"
                                        @click="handleDelete(product.id)"
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
                                No products found.
                            </TableCell>
                        </TableRow>
                    </template>
                </TableBody>
            </Table>
        </div>
    </div>
</template>
