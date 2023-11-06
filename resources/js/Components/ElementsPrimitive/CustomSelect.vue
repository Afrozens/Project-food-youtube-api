<script lang="ts" setup>
import { h, ref } from "vue";
import vSelect from "vue-select";
import ChevronDownIcon from "vue-material-design-icons/ChevronDown.vue";
import CloseCircleIcon from "vue-material-design-icons/CloseCircle.vue";
import Checkbox from "./Checkbox.vue";
import CustomCheckbox from "./CustomCheckbox.vue";

defineProps({
    options: Array,
    label: String,
    title: String,
    isRequired: {
        required: false,
        type: Boolean,
    },
    modelValue: String,
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
            @option:selected="$emit('update:modelValue', data.selectedValue[0])"
            :options="options"
            :label="title"
            class="peer input-form-up pl-12 capitalize"
            :multiple="isMultiple"
            ref="data"
        >
            <template #no-options> No se encontraron ingredientes. </template>
            <template #option="option">
                <div class="flex gap-1 items-center">
                    <CustomCheckbox
                        class="checkbox-parent"
                        :checked="
                            data.selectedValue.includes(
                                option[Object.keys(option)[0]]
                            )
                        "
                    />
                    <span class="ml-2 text-minus-base font-medium capitalize">{{
                        option[Object.keys(option)[0]]
                    }}</span>
                </div>
            </template>
        </vSelect>
        <label
            class="select-label-form-up left-14 bg-primary text-white"
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
    --vs-dropdown-option-padding: 0.8rem;
}
</style>
