<script lang="ts" setup>
import InputError from "../ElementsPrimitive/InputError.vue";
import TextInput from "../ElementsPrimitive/TextInput.vue";

defineProps({
    label: String,
    type: String,
    id: {
        required: false,
        type: String,
    },
    modelValue: String,
    error: String,
    isRequired: {
        required: false,
        type: Boolean,
    },
});

defineEmits(["update:modelValue"]);
</script>

<template>
    <div class="w-full">
        <TextInput
            :type="type"
            :id="id ?? label"
            :label="label"
            :name="label"
            :modelValue="modelValue"
            @update:modelValue="$emit('update:modelValue', $event)"
            :is-required="isRequired"
            :required="isRequired"
            autofocus
        />

        <InputError class="mt-2" :message="error" />
    </div>
</template>
