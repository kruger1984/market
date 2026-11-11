<script setup lang="ts">
import { computed, ref } from 'vue';
import axios from 'axios';
import { destroy, edit, show } from '@/routes/admin/products';
import { store, index } from '@/routes/admin/products/children';
import {
    ChevronRight,
    Eye,
    Loader2,
    Pencil,
    Trash2,
    PlusSquareIcon,
} from 'lucide-vue-next';
import { TableCell, TableRow } from '@/components/ui/table';
import { Link, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import type { Product } from '@/types/product';

const props = withDefaults(
    defineProps<{
        product: Product;
        level?: number;
    }>(),
    {
        level: 0,
    },
);

const emit = defineEmits<{
    (e: 'delete-child', id: number): void;
}>();

const isOpen = ref(false);
const isLoading = ref(false);
const children = ref<Product[]>([]);
const isLoaded = ref(false);

const hasChildren = computed(() => {
    if (isLoaded.value) {
        return children.value.length > 0;
    }
    return props.product.has_children;
});

const toggleChildren = async () => {
    if (isOpen.value) {
        isOpen.value = false;
        return;
    }

    if (!isLoaded.value) {
        isLoading.value = true;
        try {
            const response = await axios.get(index.url(props.product.id));
            children.value = response.data;
            isLoaded.value = true;
        } catch (error) {
            console.error('Failed to load children products:', error);
        } finally {
            isLoading.value = false;
        }
    }

    isOpen.value = true;
};

const handleDelete = (id: number) => {
    if (confirm('Are you sure you want to delete this Product?')) {
        router.delete(destroy.url(id), {
            preserveScroll: true,
            onSuccess: () => {
                emit('delete-child', id);
            },
        });
    }
};

const handleChildDeleted = (childId: number) => {
    children.value = children.value.filter((item) => item.id !== childId);

    if (children.value.length === 0) {
        props.product.has_children = false;
        isOpen.value = false;
        isLoaded.value = false;
    }
};
</script>

<template>
    <TableRow :class="{ 'bg-muted/30': level > 0 }">
        <TableCell class="font-medium">
            <div
                class="flex items-center gap-1"
                :style="{ paddingLeft: `${level * 1.5}rem` }"
            >
                <Button
                    v-if="hasChildren"
                    variant="ghost"
                    size="icon"
                    class="h-6 w-6 p-0"
                    :disabled="isLoading"
                    @click="toggleChildren"
                >
                    <Loader2
                        v-if="isLoading"
                        class="h-4 w-4 animate-spin text-muted-foreground"
                    />
                    <ChevronRight
                        v-else
                        class="h-4 w-4 text-gray-500 transition-transform duration-200"
                        :class="{ 'rotate-90': isOpen }"
                    />
                </Button>
                <span v-else-if="level > 0" class="inline-block w-6"></span>

                <span>{{ product.id }}</span>
            </div>
        </TableCell>

        <TableCell class="font-medium">
            <img
                v-if="product.preview_image_url"
                class="h-10 w-10 rounded object-cover"
                :src="product.preview_image_url"
                :alt="product.title"
            />
        </TableCell>

        <TableCell>
            <Link
                :href="show.url(product.id)"
                class="font-medium hover:underline"
            >
                {{ product.title }}
            </Link>
        </TableCell>

        <TableCell class="text-muted-foreground">
            {{ product.productGroup?.title ?? '-' }}
        </TableCell>

        <TableCell class="text-muted-foreground">
            {{ product.qty }}
        </TableCell>

        <TableCell class="text-right">
            <div class="flex justify-end gap-2">
                <Button variant="outline" size="icon" as-child>
                    <Link :href="store.url(product.id)">
                        <PlusSquareIcon class="h-4 w-4 text-green-600" />
                    </Link>
                </Button>
                <Button variant="outline" size="icon" as-child>
                    <Link :href="show.url(product.id)">
                        <Eye class="h-4 w-4 text-gray-500" />
                    </Link>
                </Button>

                <Button variant="outline" size="icon" as-child>
                    <Link :href="edit.url(product.id)">
                        <Pencil class="h-4 w-4 text-blue-500" />
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

    <template v-if="isOpen && children.length > 0">
        <ProductTableItem
            v-for="child in children"
            :key="child.id"
            :product="child"
            :level="level + 1"
            @delete-child="handleChildDeleted"
        />
    </template>
</template>
