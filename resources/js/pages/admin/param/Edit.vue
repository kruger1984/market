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
import { update, index } from '@/routes/admin/params'; // Используем update
import { index as dashboardIndex } from '@/routes/admin/dashboard';
import type { Param } from '@/types/param';

interface FilterTypeOption {
    value: number;
    label: string;
}

const props = defineProps<{
    filterTypes: FilterTypeOption[];
    param: Param;
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Dashboard', href: dashboardIndex() },
            { title: 'Params', href: index() },
            { title: 'Edit' },
        ],
    },
});

const form = useForm<{
    title: string;
    filter_type: number | null;
}>({
    title: props.param.title,
    filter_type: props.param.filter_type ?? null,
});

const submit = () => {
    form.put(update.url(props.param.id));
};
</script>

<template>
    <Head :title="`Edit param`" />

    <div class="max-w-2xl space-y-6 p-6">
        <div class="flex items-center gap-4">
            <Button variant="outline" size="icon" as-child>
                <Link :href="index.url()">
                    <ArrowLeft class="h-4 w-4" />
                </Link>
            </Button>
            <h1 class="text-2xl font-bold tracking-tight">
                Edit param #{{ param.id }}
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
                    placeholder="Enter param title..."
                    :disabled="form.processing"
                />
                <p v-if="form.errors.title" class="text-sm text-red-500">
                    {{ form.errors.title }}
                </p>
            </div>

            <div class="space-y-2">
                <Label for="filter_type">Filter Type</Label>
                <Select
                    :model-value="
                        form.filter_type ? String(form.filter_type) : undefined
                    "
                    @update:model-value="
                        (val) => (form.filter_type = val ? Number(val) : null)
                    "
                    :disabled="form.processing"
                >
                    <SelectTrigger id="filter_type" class="w-full">
                        <SelectValue placeholder="Select filter type" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem
                                v-for="type in filterTypes"
                                :key="type.value"
                                :value="String(type.value)"
                            >
                                {{ type.label }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <p v-if="form.errors.filter_type" class="text-sm text-red-500">
                    {{ form.errors.filter_type }}
                </p>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <Button variant="outline" as-child>
                    <Link :href="index.url()">Cancel</Link>
                </Button>
                <Button type="submit" :disabled="form.processing">
                    {{ form.processing ? 'Saving...' : 'Update' }}
                </Button>
            </div>
        </form>
    </div>
</template>
