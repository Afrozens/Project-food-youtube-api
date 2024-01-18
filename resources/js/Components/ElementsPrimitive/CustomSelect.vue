<script lang="ts" setup>
import { h, ref, computed } from "vue";
import Fuse from "fuse.js";
import vSelect from "vue-select";
// @ts-ignore - iconos sin typings
import ChevronDownIcon from "vue-material-design-icons/ChevronDown.vue";
// @ts-ignore - iconos sin typings
import CloseCircleIcon from "vue-material-design-icons/CloseCircle.vue";
import CustomCheckbox from "./CustomCheckbox.vue";
import { HasOrExcept } from "@/types/video";

interface optionSelect {
    id: number;
    name: string;
}

const props = defineProps<{
    options: Array<optionSelect>;
    label: string;
    title: string;
    modelValue: Array<HasOrExcept>;
    isMultiple: boolean;
    withWhite?: boolean;
    isRequired?: boolean;
}>();

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

const value = computed(() => {
    if (data.value && props.modelValue.length > 0) {
        data.value.updateValue(props.modelValue);
        return props.modelValue;
    }
    return props.modelValue;
});

const fuseSearch = (options: HasOrExcept[], search: string) => {
    const fuse = new Fuse(options, {
        keys: ["name"],
        shouldSort: true,
        threshold: 0.3,
    });
    return search.length
        ? fuse.search(search).map(({ item }) => item)
        : // @ts-ignore - fuse sin typings
          fuse.list;
};
</script>

<template>
    <div class="relative w-full mb-2 md:mb-0" v-if="value">
        <vSelect
            :filter="fuseSearch"
            :value="value"
            @option:selected="
                $emit(
                    'update:modelValue',
                    data.selectedValue.map((value: HasOrExcept) => value)
                )
            "
            @option:deselected="
                $emit(
                    'update:modelValue',
                    data.selectedValue.map((value: HasOrExcept) => value)
                )
            "
            :options="options"
            :label="title"
            class="peer input-form-up pl-12 capitalize"
            :multiple="isMultiple"
            ref="data"
        >
            <template #no-options> No se encontraron ingredientes. </template>
            <template #option="option: HasOrExcept">
                <div :key="option.id" class="flex gap-1 items-center">
                    <CustomCheckbox
                        class="checkbox-parent"
                        :checked="
                            value
                                ? value.some((item) => item.id === option.id)
                                : false
                        "
                    />
                    <span class="ml-2 text-minus-base font-medium capitalize">{{
                        option.name
                    }}</span>
                </div>
            </template>
            <template #selected-option="option: HasOrExcept">
                <span class="text-center ml-2" :key="option.id">{{
                    option.name
                }}</span>
            </template>
        </vSelect>
        <label
            class="flex select-label-form-up left-14"
            :class="
                withWhite ? 'bg-[#F3F4F6] text-black' : 'bg-primary text-white'
            "
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
