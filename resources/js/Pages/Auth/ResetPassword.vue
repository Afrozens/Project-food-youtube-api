<script setup lang="ts">
import { Head, useForm } from "@inertiajs/vue3";
import FormField from "@/Components/General/FormField.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/ElementsPrimitive/InputError.vue";
import InputLabel from "@/Components/ElementsPrimitive/InputLabel.vue";
import PrimaryButton from "@/Components/ElementsPrimitive/PrimaryButton.vue";
import TextInput from "@/Components/ElementsPrimitive/TextInput.vue";

const props = defineProps<{
    email: string;
    token: string;
}>();

const form = useForm({
    token: props.token,
    email: props.email,
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("password.store"), {
        onFinish: () => {
            form.reset("password", "password_confirmation");
        },
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Reset Password" />

        <form @submit.prevent="submit">
            <FormField
                id="email"
                type="email"
                :label="$t('message.components.email')"
                v-model="form.email"
                :is-required="true"
                :error="form.errors.email"
            />

            <FormField
                id="password"
                :label="$t('message.components.password')"
                type="password"
                v-model="form.password"
                :is-required="true"
                :error="form.errors.password"
            />

            <FormField
                id="password_confirmation"
                :label="$t('message.components.confirmPassword')"
                type="password"
                v-model="form.password_confirmation"
                :is-required="true"
                :error="form.errors.password_confirmation"
            />

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Reset Password
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
