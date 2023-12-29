<script setup lang="ts">
import { onMounted, ref } from "vue";
import EmoticonOutlineIcon from "vue-material-design-icons/EmoticonOutline.vue";

defineProps({
    modelValue: String,
    label: String,
    id: {
        required: false,
        type: String,
    },
    isRequired: {
        required: false,
        type: Boolean,
    },
});

defineEmits(["update:modelValue"]);

const input = ref<HTMLInputElement | null>(null);

onMounted(() => {
    if (input.value?.hasAttribute("autofocus")) {
        input.value?.focus();
    }
});

defineExpose({ focus: () => input.value?.focus() });
</script>

<template>
    <div class="relative w-full gap-px flex flex-col">
        <textarea
            class="peer resize-y input-form-up w-full rounded-b-none pt-4 min-h-[150px] px-3 border-b-0"
            :required="isRequired"
            :value="modelValue"
            @input="
                $emit(
                    'update:modelValue',
                    ($event.target as HTMLInputElement).value
                )
            "
            ref="input"
        />
        <label
            class="label-form-up"
            :class="modelValue && 'has-value'"
            :for="label"
        >
            {{ label }}
            <b :class="modelValue && 'text-red-500'">{{
                isRequired ? " *" : ""
            }}</b></label
        >
        <div
            class="flex items-center w-full justify-between rounded-b-lg px-3 py-2 input-form-up border-t-0"
            style="border-top: 0"
        >
            <slot name="btn-left" />
            <div class="flex ps-0 space-x-1 rtl:space-x-reverse sm:ps-2">
                <slot name="btn-right" />
                <button
                    type="button"
                    class="inline-flex justify-center items-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 hover:opacity-60 transition-all"
                >
                    <EmoticonOutlineIcon />
                </button>
            </div>
        </div>
    </div>
</template>
