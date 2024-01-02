<script lang="ts" setup>
import { h, ref, onMounted } from "vue";
import vSelect from "vue-select";
// @ts-ignore - iconos sin typings
import ChevronDownIcon from "vue-material-design-icons/ChevronDown.vue";
// @ts-ignore - iconos sin typings
import CloseCircleIcon from "vue-material-design-icons/CloseCircle.vue";

const props = defineProps({
    options: Array,
    label: String,
    title: String,
    isRequired: {
        required: false,
        type: Boolean,
    },
    modelValue: Array,
    isMultiple: Boolean,
});

defineEmits(["update:modelValue"]);
const data = ref();

// @ts-ignore - select with default without type
vSelect.props.components.default = () => ({
    Deselect: {
        render: () =>
            h(CloseCircleIcon, {
                class: "btn-ghost ",
                fillColor: "#ffffff",
                size: 20,
            }),
    },
    OpenIndicator: {
        render: () => h(ChevronDownIcon),
    },
});

onMounted(() => {
    if (data.value && props.modelValue) {
        data.value.updateValue(props.modelValue);
    }
});
</script>

<template>
    <div class="relative w-full" v-if="props.modelValue">
        <vSelect
            :value="modelValue"
            @option:selected="$emit('update:modelValue', data.selectedValue)"
            @option:deselected="$emit('update:modelValue', data.selectedValue)"
            :options="options"
            :label="title"
            class="peer input-form-up pl-4 capitalize"
            :multiple="isMultiple"
            ref="data"
        >
            <template #selected-option="option">
                <span class="text-center px-2" :key="option">{{
                    option[title as string]
                }}</span>
            </template>
        </vSelect>
        <label
            class="hidden md:flex select-label-form-up left-4 bg-[#F3F4F6]"
            :for="label"
        >
            {{ label }}
            <b class="text-red-500">{{ isRequired ? " *" : "" }}</b>
        </label>
    </div>
</template>
