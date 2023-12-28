<script setup lang="ts">
import { Head, useForm, Link } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import PrimaryButton from "@/Components/ElementsPrimitive/PrimaryButton.vue";
import FormField from "@/Components/General/FormField.vue";

defineProps<{
    status?: string;
}>();

const form = useForm({
    email: "",
});

const submit = () => {
    form.post(route("password.email"));
};
</script>

<template>
    <GuestLayout>
        <Head title="Forgot Password" />

        <div class="mb-4 text-extra-md text-gray-600">
            <h2 class="typografy-main font-semibold justify-center text-center">
                Forgot your password.
            </h2>
            <p class="paragraph font-light text-center">
                Just let us know your email address and we will email you a
                password reset link that will allow you to choose a new one.
            </p>
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="flex flex-col gap-4 mb-4">
            <FormField
                id="email"
                type="email"
                label="Email"
                :is-required="true"
                v-model="form.email"
                :error="form.errors.email"
            />

            <PrimaryButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Email Password Reset Link
            </PrimaryButton>
        </form>

        <h4 class="text-extra-md text-center">
            Back to
            <Link
                :href="route('login')"
                class="text-primary font-semibold hover:opacity-80 transition-opacity"
            >
                Login</Link
            >
        </h4>
    </GuestLayout>
</template>
