<script setup lang="ts">
import { Head, Link, useForm } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import CustomCheckbox from "@/Components/ElementsPrimitive/CustomCheckbox.vue";
import PrimaryButton from "@/Components/ElementsPrimitive/PrimaryButton.vue";
import FormField from "@/Components/General/FormField.vue";
import ProvidersSign from "@/Components/General/ProvidersSign.vue";

defineProps<{
    canResetPassword?: boolean;
    status?: string;
}>();

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => {
            form.reset("password");
        },
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <div class="mx-auto mb-4">
            <h2
                class="capitalize typografy-main font-semibold justify-center text-center"
            >
                Iniciar sesión para continuar
            </h2>
            <p class="paragraph font-light text-center">
                Proporcione sus credenciales de acceso para disfrutar de
                contenidos exclusivos
            </p>
        </div>

        <ProvidersSign label="loguearse" />
        <hr class="h-px bg-gray-300 mb-4 border-0 col-span-2 opacity-80" />
        <form
            @submit.prevent="submit"
            class="flex flex-col justify-center items-center"
        >
            <FormField
                id="email"
                label="Correo elétronico"
                :is-required="true"
                type="email"
                v-model="form.email"
                :error="form.errors.email"
            />

            <FormField
                class="mt-4 mb-2"
                id="password"
                label="Contraseña"
                type="password"
                :is-required="true"
                v-model="form.password"
                :error="form.errors.password"
            />

            <Link
                v-if="canResetPassword"
                :href="route('password.request')"
                class="hover:underline transition-all hover:opacity-80 self-end text-xs text-gray-600 hover:text-gray-900 rounded-md focus:outline-none"
            >
                ¿Ha olvidado su contraseña?
            </Link>

            <div class="block relative self-start">
                <label class="flex items-center relative w-fit">
                    <CustomCheckbox :checked="form.remember" />
                    <span
                        class="ml-2 text-sm text-gray-600 cursor-pointer transition-all hover:opacity-90 hover:underline"
                    >
                        Recúerdame
                    </span>
                </label>
            </div>

            <PrimaryButton
                :class="{ 'opacity-25': form.processing }"
                class="mb-2 w-full mt-4 capitalize"
                :disabled="form.processing"
            >
                Loguearse
            </PrimaryButton>
        </form>
        <div class="flex gap-2 items-center justify-center mt-4">
            <h4 class="text-extra-md">¿No tienes una cuenta?</h4>
            <Link
                :href="route('register')"
                class="capitalize text-primary font-semibold hover:opacity-80 transition-opacity"
            >
                Registrarse
            </Link>
        </div>
    </GuestLayout>
</template>
