<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { ArrowLeft } from '@lucide/vue';
import { store, index } from '@/routes/admin/categories';
import {index as dashboardIndex} from "@/routes/admin/dashboard";
import {Category} from "@/types/category"


const props = defineProps<{
    categories?: Category[];
}>();

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
            {
                title: 'Create'
            }
        ],
    },
});

const form = useForm({
    title: '',
    parent_id: null as number | null,
});

const submit = () => {
    form.post(store.url());
};
</script>

<template>
    <Head title="Create category" />

    <div class="max-w-2xl space-y-6 p-6">
        <div class="flex items-center gap-4">
            <Button variant="outline" size="icon" as-child>
                <Link :href="index.url()">
                    <ArrowLeft class="h-4 w-4" />
                </Link>
            </Button>
            <h1 class="text-2xl font-bold tracking-tight">Create category</h1>
        </div>

        <form @submit.prevent="submit" class="space-y-4 rounded-xl border bg-card p-6 shadow-sm">
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

            <div class="space-y-2">
                <Label for="parent_id">Parent Category</Label>
                <Select
                    :model-value="form.parent_id ? String(form.parent_id) : undefined"
                    @update:model-value="(val) => (form.parent_id = val ? Number(val) : null)"
                    :disabled="form.processing"
                >
                    <SelectTrigger id="parent_id" class="w-full">
                        <SelectValue placeholder="Select parent category (optional)" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem value="none">
                                None (Root category)
                            </SelectItem>
                            <SelectItem
                                v-for="cat in categories"
                                :key="cat.id"
                                :value="String(cat.id)"
                            >
                                {{ cat.title }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <p v-if="form.errors.parent_id" class="text-sm text-red-500">
                    {{ form.errors.parent_id }}
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
