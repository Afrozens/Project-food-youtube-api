<script lang="ts" setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
// @ts-ignore - iconos sin typings
import LockIcon from "vue-material-design-icons/Lock.vue";
import FormField from "../General/FormField.vue";
import PrimaryButton from "../ElementsPrimitive/PrimaryButton.vue";
import Loader from "../General/Loader.vue";

const passwordInput = ref<HTMLInputElement | null>(null);
const currentPasswordInput = ref<HTMLInputElement | null>(null);

const formPassword = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
});

const handleSubmitPassword = () => {
    formPassword.put(route("password.update"), {
        preserveScroll: true,
        onSuccess: () => {
            formPassword.reset();
            toast("Has cambiado la contraseña con éxito", {
                autoClose: 1800,
                position: "top-right",
                type: "success",
            });
        },
        onError: () => {
            if (formPassword.errors.password) {
                formPassword.reset("password", "password_confirmation");
                passwordInput.value?.focus();
            }
            if (formPassword.errors.current_password) {
                formPassword.reset("current_password");
                currentPasswordInput.value?.focus();
            }
            toast("No se ha podido cambiar la contraseña", {
                autoClose: 1800,
                position: "top-right",
                type: "error",
            });
        },
    });
};
</script>

<template>
    <div class="bg-white h-[406px] w-full lg:w-[470px] rounded-md">
        <!-- update password -->
        <form
            @submit.prevent="handleSubmitPassword"
            class="w-full h-full flex flex-col justify-end p-4"
        >
            <h3
                class="flex gap-2 mb-10 typografy-medium font-medium text-gray-700 capitalize"
            >
                <LockIcon />
                Cambiar Contraseña
            </h3>

            <FormField
                class="mb-8"
                id="password"
                label="Actual contraseña"
                type="password"
                v-model="formPassword.current_password"
                :is-required="true"
                :message="formPassword.errors.current_password"
            />
            <FormField
                class="mb-8"
                id="password"
                label="Contraseña"
                type="password"
                v-model="formPassword.password"
                :is-required="true"
                :error="formPassword.errors.password"
            />

            <FormField
                class="mb-8"
                id="password_confirmation"
                label="Confirma contraseña"
                type="password"
                v-model="formPassword.password_confirmation"
                :is-required="true"
                :error="formPassword.errors.password_confirmation"
            />
            <PrimaryButton
                type="submit"
                :class="{ 'bg-gray-200': formPassword.processing }"
                class="mb-2 bg-primary self-end w-full mt-4 capitalize text-center"
                :disabled="formPassword.processing"
            >
                <Loader v-show="formPassword.processing" />
                <span v-show="!formPassword.processing">Actualizar</span>
            </PrimaryButton>
        </form>
    </div>
</template>
