<script lang="ts" setup>
import { ref, watch, reactive } from "vue";
import { ClassicEditor } from "@ckeditor/ckeditor5-editor-classic";
import { Essentials } from "@ckeditor/ckeditor5-essentials";
import { Bold, Italic } from "@ckeditor/ckeditor5-basic-styles";
import { Link } from "@ckeditor/ckeditor5-link";
import { Paragraph } from "@ckeditor/ckeditor5-paragraph";
import { List } from "@ckeditor/ckeditor5-list";
import {
    Image,
    ImageCaption,
    ImageStyle,
    ImageToolbar,
    ImageUpload,
} from "@ckeditor/ckeditor5-image";
import { Heading } from "@ckeditor/ckeditor5-heading";
import InputError from "../ElementsPrimitive/InputError.vue";

const props = defineProps({
    modelValue: String,
    error: String,
});

const emit = defineEmits(["update:modelValue"]);

const editorConfig = reactive({
    plugins: [
        Essentials,
        Bold,
        Italic,
        List,
        Link,
        Paragraph,
        Heading,
        Image,
        ImageCaption,
        ImageStyle,
        ImageToolbar,
        ImageUpload,
    ],

    toolbar: {
        items: [
            "bold",
            "italic",
            "link",
            "undo",
            "numberedList",
            "bulletedList",
            "imageUpload",
            "heading",
            "redo",
            "undo",
        ],
    },
    image: {
        toolbar: [
            "imageTextAlternative",
            "|",
            "imageStyle:full",
            "imageStyle:side",
        ],
    },
});
const editor = ref(ClassicEditor);
const content = ref(props.modelValue);

watch(content, () => {
    if (content.value) {
        emit("update:modelValue", content.value);
    }
});
</script>

<template>
    <div class="w-full flex flex-col">
        <ckeditor :config="editorConfig" :editor="editor" v-model="content" />
        <InputError class="mt-2" :message="error" />
    </div>
</template>
