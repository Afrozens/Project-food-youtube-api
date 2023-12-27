<script lang="ts" setup>
defineProps({
    label: String,
    isRequired: Boolean,
    modelValue: String,
    error: String,
    type: String,
});
</script>

<template>
    <div>
        <TextInput
            :label="label"
            :is-required="true"
            v-model="formInformation.email"
            type="email"
            autofocus
        />

        <InputError class="mt-2" :message="formInformation.errors.email" />
    </div>
</template>
