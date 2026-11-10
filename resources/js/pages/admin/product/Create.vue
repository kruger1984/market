<script setup lang="ts">
import { ref } from 'vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { ArrowLeft, Plus, Trash2, Upload, X } from 'lucide-vue-next';
import { store, index } from '@/routes/admin/products';
import { index as dashboardIndex } from '@/routes/admin/dashboard';
import type { Category } from '@/types/category';
import Editor from '@/components/ui/editor/Editor.vue';
import { ProductGroup } from '@/types/product-group';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import type { Param, ParamFormItem } from '@/types/param';
import { ProductForm } from '@/types/product';
import ProductParamsEditor from '@/components/ProductParamsEditor.vue';

const props = defineProps<{
    categories: Category[];
    productGroups: ProductGroup[];
    params: Param[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Dashboard', href: dashboardIndex() },
            { title: 'Products', href: index() },
            { title: 'Create' },
        ],
    },
});

const form = useForm<ProductForm>({
    product: {
        title: '',
        sku: '',
        description: '',
        content: '',
        price: null,
        old_price: null,
        qty: 0,
        category_id: null,
        product_group_id: null,
    },
    images: [],
    params: [],
});

const imagePreviews = ref<string[]>([]);

const handleFileSelect = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (!target.files?.length) return;

    const files = Array.from(target.files);
    files.forEach((file) => {
        form.images.push(file);
        imagePreviews.value.push(URL.createObjectURL(file));
    });

    form.clearErrors('images');
    target.value = '';
};

const removeImage = (index: number) => {
    URL.revokeObjectURL(imagePreviews.value[index]);
    imagePreviews.value.splice(index, 1);
    form.images.splice(index, 1);
    form.clearErrors('images');
};

const getAvailableParams = (currentId: number | null) => {
    const selectedIds = form.params
        .map((p) => p.id)
        .filter((id): id is number => id !== null && id !== currentId);
    return props.params.filter((param) => !selectedIds.includes(param.id));
};

const addParamRow = () => {
    form.params.push({
        id: null,
        value: '',
    });
};

const removeParamRow = (index: number) => {
    form.params.splice(index, 1);
};

const submit = () => {
    form.post(store.url(), {
        onSuccess: () => {
            imagePreviews.value.forEach((url) => URL.revokeObjectURL(url));
            imagePreviews.value = [];
            form.reset();
        },
    });
};
</script>

<template>
    <Head title="Create product" />

    <div class="max-w-4xl space-y-6 p-6">
        <div class="flex items-center gap-4">
            <Button variant="outline" size="icon" as-child>
                <Link :href="index.url()">
                    <ArrowLeft class="h-4 w-4" />
                </Link>
            </Button>
            <h1 class="text-2xl font-bold tracking-tight">Create product</h1>
        </div>

        <form
            @submit.prevent="submit"
            class="space-y-6 rounded-xl border bg-card p-6 shadow-sm"
        >
            <!-- Title -->
            <div class="space-y-2">
                <Label for="title">Title</Label>
                <Input
                    id="title"
                    v-model="form.product.title"
                    placeholder="Enter product title..."
                    :disabled="form.processing"
                    @update:model-value="form.clearErrors('product.title')"
                />
                <p
                    v-if="form.errors['product.title']"
                    class="text-sm text-red-500"
                >
                    {{ form.errors['product.title'] }}
                </p>
            </div>

            <!-- Article & Category Grid -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="space-y-2">
                    <Label for="sku">SKU</Label>
                    <Input
                        id="sku"
                        v-model="form.product.sku"
                        placeholder="e.g. ART-10023"
                        :disabled="form.processing"
                        @update:model-value="form.clearErrors('product.sku')"
                    />
                    <p
                        v-if="form.errors['product.sku']"
                        class="text-sm text-red-500"
                    >
                        {{ form.errors['product.sku'] }}
                    </p>
                </div>

                <div class="space-y-2">
                    <Label for="category_id">Category</Label>
                    <Select
                        :model-value="
                            form.product.category_id
                                ? String(form.product.category_id)
                                : undefined
                        "
                        @update:model-value="
                            (val) => {
                                form.product.category_id = val
                                    ? Number(val)
                                    : null;
                                form.clearErrors('product.category_id');
                            }
                        "
                        :disabled="form.processing"
                    >
                        <SelectTrigger id="category_id" class="w-full">
                            <SelectValue placeholder="Select category" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
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
                    <p
                        v-if="form.errors['product.category_id']"
                        class="text-sm text-red-500"
                    >
                        {{ form.errors['product.category_id'] }}
                    </p>
                </div>
                <div class="space-y-2">
                    <Label for="category_id">Product Group</Label>
                    <Select
                        :model-value="
                            form.product.product_group_id
                                ? String(form.product.product_group_id)
                                : undefined
                        "
                        @update:model-value="
                            (val) => {
                                form.product.product_group_id = val
                                    ? Number(val)
                                    : null;
                                form.clearErrors('product.product_group_id');
                            }
                        "
                        :disabled="form.processing"
                    >
                        <SelectTrigger id="product_group_id" class="w-full">
                            <SelectValue placeholder="Select product group" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectItem
                                    v-for="group in productGroups"
                                    :key="group.id"
                                    :value="String(group.id)"
                                >
                                    {{ group.title }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                    <p
                        v-if="form.errors['product.product_group_id']"
                        class="text-sm text-red-500"
                    >
                        {{ form.errors['product.product_group_id'] }}
                    </p>
                </div>
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <Label for="description">Description</Label>
                <Textarea
                    id="description"
                    v-model="form.product.description"
                    placeholder="Product description..."
                    rows="4"
                    :disabled="form.processing"
                    @update:model-value="
                        form.clearErrors('product.description')
                    "
                />
                <p
                    v-if="form.errors['product.description']"
                    class="text-sm text-red-500"
                >
                    {{ form.errors['product.description'] }}
                </p>
            </div>

            <!-- Content (Editor) -->
            <div class="space-y-2">
                <Label for="content">Content</Label>
                <Editor
                    id="content"
                    v-model="form.product.content"
                    :disabled="form.processing"
                    @update:model-value="form.clearErrors('product.content')"
                />
                <p
                    v-if="form.errors['product.content']"
                    class="text-sm text-red-500"
                >
                    {{ form.errors['product.content'] }}
                </p>
            </div>

            <!-- Prices & Quantity Grid -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div class="space-y-2">
                    <Label for="price">Price</Label>
                    <Input
                        id="price"
                        type="number"
                        step="0.01"
                        min="0"
                        :model-value="form.product.price ?? undefined"
                        @update:model-value="
                            (val) => {
                                form.product.price =
                                    val !== '' && val !== undefined
                                        ? Number(val)
                                        : null;
                                form.clearErrors('product.price');
                            }
                        "
                        placeholder="0.00"
                        :disabled="form.processing"
                    />
                    <p
                        v-if="form.errors['product.price']"
                        class="text-sm text-red-500"
                    >
                        {{ form.errors['product.price'] }}
                    </p>
                </div>

                <div class="space-y-2">
                    <Label for="old_price">Old Price (Optional)</Label>
                    <Input
                        id="old_price"
                        type="number"
                        step="0.01"
                        min="0"
                        :model-value="form.product.old_price ?? undefined"
                        @update:model-value="
                            (val) => {
                                form.product.old_price =
                                    val !== '' && val !== undefined
                                        ? Number(val)
                                        : null;
                                form.clearErrors('product.old_price');
                            }
                        "
                        placeholder="0.00"
                        :disabled="form.processing"
                    />
                    <p
                        v-if="form.errors['product.old_price']"
                        class="text-sm text-red-500"
                    >
                        {{ form.errors['product.old_price'] }}
                    </p>
                </div>

                <div class="space-y-2">
                    <Label for="qty">Quantity</Label>
                    <Input
                        id="qty"
                        type="number"
                        min="0"
                        v-model.number="form.product.qty"
                        placeholder="0"
                        :disabled="form.processing"
                        @update:model-value="form.clearErrors('product.qty')"
                    />
                    <p
                        v-if="form.errors['product.qty']"
                        class="text-sm text-red-500"
                    >
                        {{ form.errors['product.qty'] }}
                    </p>
                </div>
            </div>

            <!-- Images Upload Section -->
            <div class="space-y-2">
                <Label>Images</Label>

                <div
                    class="grid grid-cols-2 gap-4 sm:grid-cols-4 md:grid-cols-5"
                >
                    <!-- Preview Cards -->
                    <div
                        v-for="(src, index) in imagePreviews"
                        :key="index"
                        class="group relative aspect-square overflow-hidden rounded-lg border bg-muted"
                    >
                        <img
                            :src="src"
                            alt="Preview"
                            class="h-full w-full object-cover transition-transform group-hover:scale-105"
                        />
                        <button
                            type="button"
                            @click="removeImage(index)"
                            class="absolute top-1 right-1 rounded-full bg-black/60 p-1 text-white hover:bg-black/90"
                        >
                            <X class="h-4 w-4" />
                        </button>
                    </div>

                    <!-- Dropzone Input Button -->
                    <label
                        class="flex aspect-square cursor-pointer flex-col items-center justify-center rounded-lg border border-dashed transition-colors hover:bg-accent"
                        :class="{
                            'pointer-events-none opacity-50': form.processing,
                        }"
                    >
                        <Upload class="h-6 w-6 text-muted-foreground" />
                        <span class="mt-2 text-xs text-muted-foreground"
                            >Upload</span
                        >
                        <input
                            type="file"
                            multiple
                            accept="image/*"
                            class="hidden"
                            @change="handleFileSelect"
                            :disabled="form.processing"
                        />
                    </label>
                </div>

                <p v-if="form.errors.images" class="text-sm text-red-500">
                    {{ form.errors.images }}
                </p>
            </div>

            <!-- Parameters Section -->
            <<ProductParamsEditor
                v-model="form.params"
                :params="props.params"
                :processing="form.processing"
                :errors="form.errors"
                @clear-error="
                    (field) =>
                        form.clearErrors(field as keyof typeof form.errors)
                "
            />

            <!-- Action Buttons -->
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
