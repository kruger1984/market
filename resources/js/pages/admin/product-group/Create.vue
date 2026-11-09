<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { ArrowLeft } from '@lucide/vue';
import { store, index } from '@/routes/admin/product-groups';
import { index as dashboardIndex } from '@/routes/admin/dashboard';
import { ProductGroup } from '@/types/product-group';

const props = defineProps<{
    productGroup: ProductGroup[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: dashboardIndex(),
            },
            {
                title: 'Product Groups',
                href: index(),
            },
            {
                title: 'Create',
            },
        ],
    },
});

const form = useForm({
    title: '',
});

const submit = () => {
    form.post(store.url());
};
</script>

<template>
    <Head title="Create product group" />

    <div class="max-w-2xl space-y-6 p-6">
        <div class="flex items-center gap-4">
            <Button variant="outline" size="icon" as-child>
                <Link :href="index.url()">
                    <ArrowLeft class="h-4 w-4" />
                </Link>
            </Button>
            <h1 class="text-2xl font-bold tracking-tight">
                Create product group
            </h1>
        </div>

        <form
            @submit.prevent="submit"
            class="space-y-4 rounded-xl border bg-card p-6 shadow-sm"
        >
            <div class="space-y-2">
                <Label for="title">Title</Label>
                <Input
                    id="title"
                    v-model="form.title"
                    placeholder="Enter category title..."
                    :disabled="form.processing"
                />
                <p v-if="form.errors.title" class="text-sm text-red-500">
                    {{ form.errors.title }}
                </p>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <Button variant="outline" as-child>
                    <Link :href="index.url()">Cancel</Link>
                </Button>
                <Button type="submit" :disabled="form.processing">
                    {{ form.processing ? 'Saving...' : 'Create' }}
                </Button>
            </div>
        </form>
    </div>
</template>
