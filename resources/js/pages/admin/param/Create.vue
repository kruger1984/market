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
import { store, index } from '@/routes/admin/params';
import { index as dashboardIndex } from '@/routes/admin/dashboard';
import { FilterTypeOption } from '@/types/param';

const props = defineProps<{
    filterTypes: FilterTypeOption[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Dashboard', href: dashboardIndex() },
            { title: 'Params', href: index() },
            { title: 'Create' },
        ],
    },
});

const form = useForm({
    title: '',
    filter_type: null as number | null,
});

const submit = () => {
    form.post(store.url(), {
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <Head title="Create param" />

    <div class="max-w-2xl space-y-6 p-6">
        <div class="flex items-center gap-4">
            <Button variant="outline" size="icon" as-child>
                <Link :href="index.url()">
                    <ArrowLeft class="h-4 w-4" />
                </Link>
            </Button>
            <h1 class="text-2xl font-bold tracking-tight">Create param</h1>
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
                    {{ form.processing ? 'Saving...' : 'Create' }}
                </Button>
            </div>
        </form>
    </div>
</template>
