<script setup lang="ts">
import { computed, reactive } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import AppLogo from '@/components/AppLogo.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { index as homePage } from '@/routes/client/categories';
import { index as categoryProductsIndex } from '@/routes/client/categories/products';
import type { Category } from '@/types/category';
import type { ParamWithValues } from '@/types/param';
import axios from 'axios';
import { useFilteredProducts } from '@/composables/useFilteredProducts';
import { Product } from '@/types/product';

interface FiltersState {
    integer: {
        from: Record<number, number | string>;
        to: Record<number, number | string>;
    };
    select: Record<number, string>;
    checkbox: Record<number, string[]>;
}

const page = usePage<{
    params: ParamWithValues[];
    category: Category;
}>();

const params = computed(() => page.props.params ?? []);
const category = computed(() => page.props.category);

const filters = reactive<FiltersState>({
    integer: {
        from: {},
        to: {},
    },
    select: {},
    checkbox: {},
});

const toggleItem = (arr: string[], value: string): void => {
    const index = arr.indexOf(value);
    if (index === -1) {
        arr.push(value);
    } else {
        arr.splice(index, 1);
    }
};

const setFilter = (param: ParamWithValues, value: string): void => {
    if (!filters.checkbox[param.id]) {
        filters.checkbox[param.id] = [];
    }
    toggleItem(filters.checkbox[param.id], value);

    if (filters.checkbox[param.id].length === 0) {
        delete filters.checkbox[param.id];
    }
};

const isChecked = (paramId: number, value: string): boolean => {
    return filters.checkbox[paramId]?.includes(value) ?? false;
};

const clean = (obj: Record<number, number | string>): void => {
    Object.keys(obj).forEach((key) => {
        const numKey = Number(key);
        if (
            obj[numKey] === '' ||
            obj[numKey] === null ||
            obj[numKey] === undefined
        ) {
            delete obj[numKey];
        }
    });
};

const { setFilteredProducts } = useFilteredProducts();
const applyFilters = async (): Promise<void> => {
    clean(filters.integer.from);
    clean(filters.integer.to);

    const { data } = await axios.get<Product[]>(
        categoryProductsIndex(category.value.id).url,
        {
            params: filters,
        },
    );

    setFilteredProducts(data);
};
</script>

<template>
    <Sidebar collapsible="offcanvas" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="homePage()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent class="px-4 py-2">
            <template v-for="param in params" :key="param.id">
                <div
                    v-if="param.filter_type === 3"
                    class="mb-4 border-b border-border pb-4"
                >
                    <h3 class="mb-3 text-sm font-medium">{{ param.title }}</h3>

                    <div class="space-y-2">
                        <div
                            v-for="value in param.param_values"
                            :key="value"
                            class="flex items-center space-x-2"
                        >
                            <Checkbox
                                :id="`param-${param.id}-${value}`"
                                :model-value="isChecked(param.id, value)"
                                @update:model-value="setFilter(param, value)"
                            />
                            <Label
                                v-if="param.label === 'color'"
                                :for="`param-${param.id}-${value}`"
                                :style="{ backgroundColor: value }"
                                class="block h-4 w-8 cursor-pointer rounded border border-border"
                            />
                            <Label
                                v-else
                                :for="`param-${param.id}-${value}`"
                                class="cursor-pointer text-sm font-normal"
                            >
                                {{ value }}
                            </Label>
                        </div>
                    </div>
                </div>

                <div
                    v-if="param.filter_type === 1"
                    class="mb-4 border-b border-border pb-4"
                >
                    <h3 class="mb-3 text-sm font-medium">{{ param.title }}</h3>

                    <div class="flex items-center gap-2">
                        <Input
                            v-model="filters.integer.from[param.id]"
                            type="number"
                            placeholder="От"
                            class="h-8"
                        />
                        <Input
                            v-model="filters.integer.to[param.id]"
                            type="number"
                            placeholder="До"
                            class="h-8"
                        />
                    </div>
                </div>
            </template>
        </SidebarContent>

        <SidebarFooter v-if="params.length > 0" class="p-4">
            <Button class="w-full" @click="applyFilters"> Фильтр </Button>
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
