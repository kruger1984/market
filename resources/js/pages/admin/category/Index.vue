<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Plus, Pencil, Trash2, Eye } from '@lucide/vue';
import { Button } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';

import { create, edit, show, destroy, index } from '@/routes/admin/categories';
import { index as dashboardIndex } from '@/routes/admin/dashboard';
import { Category } from '@/types/category';

const props = defineProps<{
    categories: Category[];
}>();

const handleDelete = (id: number) => {
    if (confirm('Are you sure you want to delete this category?')) {
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
                title: 'Categories',
                href: index(),
            },
        ],
    },
});
</script>

<template>
    <Head title="Categories" />

    <div class="space-y-6 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Categories</h1>
                <p class="text-sm text-muted-foreground">
                    Manage product categories
                </p>
            </div>

            <Button as-child class="gap-2">
                <Link :href="create.url()">
                    <Plus class="h-4 w-4" />
                    Add category
                </Link>
            </Button>
        </div>

        <div class="rounded-md border bg-card">
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead class="w-20">ID</TableHead>
                        <TableHead>Title</TableHead>
                        <TableHead>Parent Category</TableHead>
                        <TableHead class="text-right">Actions</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <template v-if="categories.length > 0">
                        <TableRow
                            v-for="category in categories"
                            :key="category.id"
                        >
                            <TableCell class="font-medium">{{
                                category.id
                            }}</TableCell>
                            <TableCell
                                ><Link
                                    :href="show(category)"
                                    class="hover:underline"
                                    >{{ category.title }}</Link
                                ></TableCell
                            >
                            <TableCell class="text-muted-foreground">
                                <Link
                                    v-if="category.category"
                                    :href="
                                        show.url({
                                            category: category.category.id,
                                        })
                                    "
                                    class="hover:underline"
                                >
                                    {{ category.category.title }}
                                </Link>
                                <span v-else>—</span>
                            </TableCell>
                            <TableCell class="text-right">
                                <div class="flex justify-end gap-2">
                                    <Button
                                        variant="outline"
                                        size="icon"
                                        as-child
                                    >
                                        <Link :href="show.url(category.id)">
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
                                        <Link :href="edit.url(category.id)">
                                            <Pencil
                                                class="h-4 w-4 text-blue-500"
                                            />
                                        </Link>
                                    </Button>
                                    <Button
                                        class="cursor-pointer"
                                        variant="outline"
                                        size="icon"
                                        @click="handleDelete(category.id)"
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
                                No categories found.
                            </TableCell>
                        </TableRow>
                    </template>
                </TableBody>
            </Table>
        </div>
    </div>
</template>
