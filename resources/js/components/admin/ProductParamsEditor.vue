<script setup lang="ts">
import { computed } from 'vue';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Plus, Trash2 } from 'lucide-vue-next';
import type { Param, ParamFormItem } from '@/types/param';

const props = withDefaults(
    defineProps<{
        params: Param[];
        processing?: boolean;
        errors?: Record<string, string>;
    }>(),
    {
        processing: false,
        errors: () => ({}),
    },
);

const modelValue = defineModel<ParamFormItem[]>({ required: true });

const emit = defineEmits<{
    (e: 'clear-error', field: string): void;
}>();

const getAvailableParams = (currentId: number | null) => {
    const selectedIds = modelValue.value
        .map((p) => p.id)
        .filter((id): id is number => id !== null && id !== currentId);

    return props.params.filter((param) => !selectedIds.includes(param.id));
};

const addParamRow = () => {
    modelValue.value.push({
        id: null,
        value: '',
    });
};

const removeParamRow = (index: number) => {
    modelValue.value.splice(index, 1);
};

const handleSelectUpdate = (index: number, val: string | undefined) => {
    modelValue.value[index].id = val ? Number(val) : null;
    emit('clear-error', `params.${index}.id`);
};

const handleInput = (index: number) => {
    emit('clear-error', `params.${index}.value`);
};
</script>

<template>
    <div class="space-y-3">
        <div class="flex items-center justify-between">
            <Label>Product Parameters</Label>
            <Button
                type="button"
                variant="outline"
                size="sm"
                class="gap-1.5 text-xs"
                @click="addParamRow"
                :disabled="processing"
            >
                <Plus class="h-3.5 w-3.5" />
                Add parameter
            </Button>
        </div>

        <div class="rounded-md border bg-card">
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead class="w-1/2">Param title</TableHead>
                        <TableHead class="w-1/2">Value</TableHead>
                        <TableHead class="w-12 text-right"></TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <template v-if="modelValue.length > 0">
                        <TableRow
                            v-for="(paramRow, index) in modelValue"
                            :key="index"
                        >
                            <!-- Parameter Selection -->
                            <TableCell class="align-top">
                                <Select
                                    :model-value="
                                        paramRow.id
                                            ? String(paramRow.id)
                                            : undefined
                                    "
                                    @update:model-value="
                                        (val) =>
                                            handleSelectUpdate(
                                                index,
                                                val ? String(val) : undefined,
                                            )
                                    "
                                    :disabled="processing"
                                >
                                    <SelectTrigger class="w-full">
                                        <SelectValue
                                            placeholder="Select parameter..."
                                        />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem
                                                v-for="param in getAvailableParams(
                                                    paramRow.id,
                                                )"
                                                :key="param.id"
                                                :value="String(param.id)"
                                            >
                                                {{ param.title }}
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                                <p
                                    v-if="errors[`params.${index}.id`]"
                                    class="mt-1 text-xs text-red-500"
                                >
                                    {{ errors[`params.${index}.id`] }}
                                </p>
                            </TableCell>

                            <!-- Parameter Value -->
                            <TableCell class="align-top">
                                <Input
                                    v-model="paramRow.value"
                                    placeholder="Enter value..."
                                    :disabled="processing"
                                    @input="handleInput(index)"
                                />
                                <p
                                    v-if="errors[`params.${index}.value`]"
                                    class="mt-1 text-xs text-red-500"
                                >
                                    {{ errors[`params.${index}.value`] }}
                                </p>
                            </TableCell>

                            <!-- Actions -->
                            <TableCell class="text-right align-top">
                                <Button
                                    type="button"
                                    variant="ghost"
                                    size="icon"
                                    class="h-9 w-9 text-muted-foreground hover:text-red-500"
                                    @click="removeParamRow(index)"
                                    :disabled="processing"
                                >
                                    <Trash2 class="h-4 w-4" />
                                </Button>
                            </TableCell>
                        </TableRow>
                    </template>
                    <template v-else>
                        <TableRow>
                            <TableCell
                                colspan="3"
                                class="h-20 text-center text-sm text-muted-foreground"
                            >
                                No parameters added yet. Click "Add parameter"
                                to specify attributes.
                            </TableCell>
                        </TableRow>
                    </template>
                </TableBody>
            </Table>
        </div>
    </div>
</template>
