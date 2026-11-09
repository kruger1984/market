<script setup lang="ts">
import { useEditor, EditorContent } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import { watch, onBeforeUnmount } from 'vue';
import { Button } from '@/components/ui/button';
import {
    Bold,
    Italic,
    List,
    ListOrdered,
    Heading2,
    Heading3,
    Quote,
    Undo,
    Redo,
} from 'lucide-vue-next';

const props = defineProps<{
    modelValue: string;
    disabled?: boolean;
}>();

const emit = defineEmits<{
    (e: 'update:modelValue', value: string): void;
}>();

const editor = useEditor({
    content: props.modelValue,
    editable: !props.disabled,
    extensions: [StarterKit],
    editorProps: {
        attributes: {
            class:
                'prose dark:prose-invert max-w-none min-h-[160px] p-3 text-sm focus:outline-none border-t rounded-b-md',
        },
    },
    onUpdate: ({ editor }) => {
        emit('update:modelValue', editor.getHTML());
    },
});

watch(
    () => props.modelValue,
    (value) => {
        if (editor.value && editor.value.getHTML() !== value) {
            editor.value.commands.setContent(value, { emitUpdate: false });
        }
    }
);

watch(
    () => props.disabled,
    (disabled) => {
        editor.value?.setEditable(!disabled);
    }
);

onBeforeUnmount(() => {
    editor.value?.destroy();
});
</script>

<template>
    <div
        class="rounded-md border bg-background transition-colors focus-within:ring-1 focus-within:ring-ring"
        :class="{ 'opacity-50 pointer-events-none': disabled }"
    >
        <!-- Toolbar -->
        <div v-if="editor" class="flex flex-wrap items-center gap-1 p-1 bg-muted/40 rounded-t-md">
            <Button
                type="button"
                variant="ghost"
                size="sm"
                class="h-8 w-8 p-0"
                :class="{ 'bg-muted text-accent-foreground': editor.isActive('bold') }"
                @click="editor.chain().focus().toggleBold().run()"
            >
                <Bold class="h-4 w-4" />
            </Button>

            <Button
                type="button"
                variant="ghost"
                size="sm"
                class="h-8 w-8 p-0"
                :class="{ 'bg-muted text-accent-foreground': editor.isActive('italic') }"
                @click="editor.chain().focus().toggleItalic().run()"
            >
                <Italic class="h-4 w-4" />
            </Button>

            <div class="h-4 w-[1px] bg-border mx-1" />

            <Button
                type="button"
                variant="ghost"
                size="sm"
                class="h-8 w-8 p-0"
                :class="{ 'bg-muted text-accent-foreground': editor.isActive('heading', { level: 2 }) }"
                @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
            >
                <Heading2 class="h-4 w-4" />
            </Button>

            <Button
                type="button"
                variant="ghost"
                size="sm"
                class="h-8 w-8 p-0"
                :class="{ 'bg-muted text-accent-foreground': editor.isActive('heading', { level: 3 }) }"
                @click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
            >
                <Heading3 class="h-4 w-4" />
            </Button>

            <div class="h-4 w-[1px] bg-border mx-1" />

            <Button
                type="button"
                variant="ghost"
                size="sm"
                class="h-8 w-8 p-0"
                :class="{ 'bg-muted text-accent-foreground': editor.isActive('bulletList') }"
                @click="editor.chain().focus().toggleBulletList().run()"
            >
                <List class="h-4 w-4" />
            </Button>

            <Button
                type="button"
                variant="ghost"
                size="sm"
                class="h-8 w-8 p-0"
                :class="{ 'bg-muted text-accent-foreground': editor.isActive('orderedList') }"
                @click="editor.chain().focus().toggleOrderedList().run()"
            >
                <ListOrdered class="h-4 w-4" />
            </Button>

            <Button
                type="button"
                variant="ghost"
                size="sm"
                class="h-8 w-8 p-0"
                :class="{ 'bg-muted text-accent-foreground': editor.isActive('blockquote') }"
                @click="editor.chain().focus().toggleBlockquote().run()"
            >
                <Quote class="h-4 w-4" />
            </Button>

            <div class="h-4 w-[1px] bg-border mx-1" />

            <Button
                type="button"
                variant="ghost"
                size="sm"
                class="h-8 w-8 p-0"
                :disabled="!editor.can().undo()"
                @click="editor.chain().focus().undo().run()"
            >
                <Undo class="h-4 w-4" />
            </Button>

            <Button
                type="button"
                variant="ghost"
                size="sm"
                class="h-8 w-8 p-0"
                :disabled="!editor.can().redo()"
                @click="editor.chain().focus().redo().run()"
            >
                <Redo class="h-4 w-4" />
            </Button>
        </div>

        <!-- Editor Content Area -->
        <EditorContent :editor="editor" />
    </div>
</template>
