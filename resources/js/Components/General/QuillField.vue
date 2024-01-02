<script lang="ts" setup>
import { ref, onMounted, watch } from "vue";
import * as Quill from "quill";
import InputError from "../ElementsPrimitive/InputError.vue";

const props = defineProps({
    placeholder: String,
    modelValue: String,
    error: String,
});

const emit = defineEmits(["update:modelValue"]);

const quillRef = ref(null);
const content = ref(props.modelValue);

const modules = {
    toolbar: [
        ["bold", "italic", "underline", "strike"],
        ["blockquote", "code-block"],
        [{ header: 1 }, { header: 2 }],
        [{ list: "ordered" }, { list: "bullet" }],
        [{ script: "sub" }, { script: "super" }],
        [{ indent: "-1" }, { indent: "+1" }],
        [{ direction: "rtl" }],
        [{ size: ["small", false, "large", "huge"] }],
        [{ header: [1, 2, 3, 4, 5, 6, false] }],
        [{ color: [] }, { background: [] }],
        [{ font: [] }],
        [{ align: [] }],
        ["clean"],
        ["link", "image", "video"],
    ],
};

onMounted(() => {
    // @ts-ignore - new Quill without type
    const editor = new Quill(quillRef.value, {
        modules,
        placeholder: props.placeholder,
        theme: "snow",
    });

    editor.root.innerHTML = props.modelValue;

    editor.on("text-change", () => {
        content.value = editor.root.innerHTML;
    });
});

watch(content, () => {
    if (content.value) {
        emit("update:modelValue", content.value);
    }
});
</script>

<template>
    <div ref="quillRef" contentType="'html'"></div>
    <InputError class="mt-2" :message="error" />
</template>
