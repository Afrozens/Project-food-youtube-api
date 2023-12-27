<script lang="ts" setup>
import { h, ref, watch } from "vue";
import vSelect from "vue-select";
import ChevronDownIcon from "vue-material-design-icons/ChevronDown.vue";
import CloseCircleIcon from "vue-material-design-icons/CloseCircle.vue";
import CustomCheckbox from "./CustomCheckbox.vue";

interface optionSelect {
    id: number;
    name: string;
}

defineProps({
    options: Array<optionSelect>,
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
</script>

<template>
    <div class="relative w-full">
        <vSelect
            :value="modelValue"
            @option:selected="$emit('update:modelValue', data.selectedValue)"
            @option:deselected="$emit('update:modelValue', data.selectedValue)"
            :options="options && options.map((option) => option.name)"
            :label="title"
            class="peer input-form-up pl-12 capitalize"
            :multiple="isMultiple"
            ref="data"
        >
            <template #no-options> No se encontraron ingredientes. </template>
            <template #option="option">
                <div
                    @click.prevent
                    class="flex gap-1 items-center"
                    :key="option.name"
                >
                    <CustomCheckbox
                        class="checkbox-parent"
                        :checked="
                            modelValue
                                ? modelValue?.includes(option.name)
                                : false
                        "
                    />
                    <span class="ml-2 text-minus-base font-medium capitalize">{{
                        option.name
                    }}</span>
                </div>
            </template>
            <template #selected-option="option">
                <span class="text-center ml-2" :key="option.name">{{
                    option.name
                }}</span>
            </template>
        </vSelect>
        <label
            class="hidden md:flex select-label-form-up left-14 bg-primary text-white"
            :for="label"
        >
            {{ label }}
            <b class="text-red-500">{{ isRequired ? " *" : "" }}</b>
        </label>
    </div>
</template>

<style scoped>
>>> {
    --vs-dropdown-option--active-bg: #f3f4f6;
    --vs-dropdown-option--active-color: #eeeeee;
    --vs-dropdown-option-padding: 1rem;
}
</style>
