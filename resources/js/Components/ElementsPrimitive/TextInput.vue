<script setup lang="ts">
import { onMounted, ref } from "vue";
// @ts-ignore - iconos sin typings
import EyeIcon from "vue-material-design-icons/Eye.vue";
// @ts-ignore - iconos sin typings
import EyeOffIcon from "vue-material-design-icons/EyeOff.vue";

const props = defineProps({
    modelValue: String,
    label: String,
    type: String,
    id: {
        required: false,
        type: String,
    },
    isRequired: {
        required: false,
        type: Boolean,
    },
    withSearch: {
        required: false,
        type: Boolean,
    },
});

defineEmits(["update:modelValue"]);

const input = ref<HTMLInputElement | null>(null);
const currentType = ref();

onMounted(() => {
    if (input.value?.hasAttribute("autofocus")) {
        input.value?.focus();
    }
});

defineExpose({ focus: () => input.value?.focus() });

const handlePassword = () => {
    if (input.value) {
        input.value.type =
            input.value.type === props.type ? "text" : "password";
        currentType.value = input.value.type;
    }
};
</script>

<template>
    <div class="relative w-full">
        <input
            class="peer input-form-up px-3"
            :required="isRequired"
            :type="type"
            :class="[id === 'password' && 'pr-12', withSearch && 'pl-10']"
            :value="modelValue"
            @input="
                $emit(
                    'update:modelValue',
                    ($event.target as HTMLInputElement).value
                )
            "
            ref="input"
        />
        <button
            v-show="
                id === 'password' ||
                id === 'password_confirmation' ||
                id === 'password_current'
            "
            type="button"
            class="absolute top-1/2 hover:scale-110 transition-all active:scale-95 -translate-y-1/2 right-4"
            @click="handlePassword"
        >
            <EyeIcon v-show="currentType === type" />
            <EyeOffIcon v-show="currentType !== type" />
        </button>
        <label
            class="label-form-up"
            :class="[modelValue && 'has-value', withSearch && 'left-10']"
            :for="label"
        >
            {{ label }}
            <b :class="modelValue && 'text-red-500'">{{
                isRequired ? " *" : ""
            }}</b></label
        >
    </div>
</template>
