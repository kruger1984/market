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

import { create, edit, show, destroy, index } from '@/routes/admin/params';
import { index as dashboardIndex } from '@/routes/admin/dashboard';
import { Param } from '@/types/param';

const props = defineProps<{
    params: Param[];
}>();

const handleDelete = (id: number) => {
    if (confirm('Are you sure you want to delete this Param?')) {
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
                title: 'Params',
                href: index(),
            },
        ],
    },
});
</script>

<template>
    <Head title="Params" />

    <div class="space-y-6 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Params</h1>
                <p class="text-sm text-muted-foreground">Manage params</p>
            </div>

            <Button as-child class="gap-2">
                <Link :href="create.url()">
                    <Plus class="h-4 w-4" />
                    Add param
                </Link>
            </Button>
        </div>

        <div class="rounded-md border bg-card">
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead class="w-20">ID</TableHead>
                        <TableHead>Title</TableHead>
                        <TableHead>Filter Type</TableHead>
                        <TableHead class="text-right">Actions</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <template v-if="params.length > 0">
                        <TableRow v-for="param in params" :key="param.id">
                            <TableCell class="font-medium">{{
                                param.id
                            }}</TableCell>
                            <TableCell
                                ><Link
                                    :href="show(param)"
                                    class="hover:underline"
                                    >{{ param.title }}</Link
                                ></TableCell
                            >
                            <TableCell class="text-muted-foreground">
                                <Link class="hover:underline">
                                    {{ param.filter_type_label }}
                                </Link>
                            </TableCell>
                            <TableCell class="text-right">
                                <div class="flex justify-end gap-2">
                                    <Button
                                        variant="outline"
                                        size="icon"
                                        as-child
                                    >
                                        <Link :href="show.url(param.id)">
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
                                        <Link :href="edit.url(param.id)">
                                            <Pencil
                                                class="h-4 w-4 text-blue-500"
                                            />
                                        </Link>
                                    </Button>
                                    <Button
                                        class="cursor-pointer"
                                        variant="outline"
                                        size="icon"
                                        @click="handleDelete(param.id)"
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
                                No params found.
                            </TableCell>
                        </TableRow>
                    </template>
                </TableBody>
            </Table>
        </div>
    </div>
</template>
