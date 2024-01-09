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
                Has olvidado tu contraseña
            </h2>
            <p class="paragraph font-light text-center">
                Indíquenos su dirección de correo electrónico y le enviaremos un
                que le permitirá elegir una nueva
            </p>
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="flex flex-col gap-4 mb-4">
            <FormField
                id="email"
                type="email"
                label="Correo eléctronico"
                :is-required="true"
                v-model="form.email"
                :error="form.errors.email"
            />

            <PrimaryButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Restablece la contraseña
            </PrimaryButton>
        </form>

        <h4 class="text-extra-md text-center">
            Vuelve a
            <Link
                :href="route('login')"
                class="text-primary font-semibold hover:opacity-80 transition-opacity"
            >
                Inicio de sesión</Link
            >
        </h4>
    </GuestLayout>
</template>
