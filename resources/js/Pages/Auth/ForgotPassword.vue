<script setup lang="ts">
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "../../Components/ElementsPrimitive/InputError.vue";
import PrimaryButton from "@/Components/ElementsPrimitive/PrimaryButton.vue";
import TextInput from "@/Components/ElementsPrimitive/TextInput.vue";
import { Head, useForm, Link } from "@inertiajs/vue3";

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
            <div>
                <TextInput
                    id="email"
                    type="email"
                    label="Email"
                    :is-required="true"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

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
