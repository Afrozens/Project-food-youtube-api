<script setup lang="ts">
import { ref, onMounted } from "vue";
import { Head, useForm, usePage } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import AccountEditIcon from "vue-material-design-icons/AccountEdit.vue";
import CameraFlipIcon from "vue-material-design-icons/CameraFlip.vue";
import AccountIcon from "vue-material-design-icons/Account.vue";
import LockIcon from "vue-material-design-icons/Lock.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "@/Components/ElementsPrimitive/TextInput.vue";
import PrimaryButton from "@/Components/ElementsPrimitive/PrimaryButton.vue";
import TertiaryButton from "@/Components/ElementsPrimitive/TertiaryButton.vue";
import ModalImage from "@/Components/Modals/ModalImage.vue";
import InputError from "@/Components/ElementsPrimitive/InputError.vue";

const { props } = usePage();
const dataUser = ref();
const showChangeImage = ref<boolean>(false);
const passwordInput = ref<HTMLInputElement | null>(null);
const currentPasswordInput = ref<HTMLInputElement | null>(null);
const user = usePage().props.auth.user;

const closeChangeImage = () => {
    showChangeImage.value = false;
};
onMounted(() => {
    if (props.auth) {
        dataUser.value = props.auth.user;
    }
});

const formPassword = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
});

const formInformation = useForm({
    name: user.name,
    email: user.email,
    nickname: user.nickname,
});

const handleSubmitInformation = () => {
    formInformation.patch(route("profile.update"), {
        onSuccess: () => {
            toast("Has cambiado tu perfil con éxito", {
                autoClose: 1800,
                position: "top-right",
                type: "success",
            });
        },
        onError: () => {
            toast("No se ha podido cambiar el perfil.", {
                autoClose: 1800,
                position: "top-right",
                type: "error",
            });
        },
    });
};

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
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <article
            v-if="dataUser"
            class="py-4 w-full bg-cover flex flex-col bg-fixed px-8 lg:px-24 gap-8 bg-no-repeat bg-center bg-black-background min-h-screen"
        >
            <!-- Change image profile -->
            <div
                class="mx-auto parent-button relative flex hover:bg-[#202020b2] transition-all items-center justify-center rounded-full w-[150px] h-[150px] bg-transparent shadow-2xl"
            >
                <AccountIcon
                    class="child-button transition-all"
                    :size="120"
                    fillColor="222222"
                    v-if="!dataUser.img_url"
                />
                <img
                    v-else
                    :src="dataUser.img_url"
                    alt="profile image of user"
                    class="w-full h-full rounded-full bg-cover"
                />
                <button
                    @click="showChangeImage = true"
                    class="absolute child-two-button top-1/2 justify-center items-center -translate-y-1/2 w-14 hidden h-14 rounded-full border border-white p-6 hover:bg-[#202020b2] transition-all"
                >
                    <CameraFlipIcon fillColor="#ffffff" />
                </button>
            </div>
            <div class="flex flex-col gap-5 lg:flex-row justify-between">
                <div class="bg-white h-[406px] w-full lg:w-[470px] rounded-md">
                    <!-- Update data profile -->
                    <form
                        @submit.prevent="handleSubmitInformation"
                        class="w-full h-full flex flex-col justify-end p-4"
                    >
                        <h3
                            class="flex gap-2 mb-10 typografy-medium font-medium text-gray-700 capitalize"
                        >
                            <AccountEditIcon />
                            Actualizar datos
                        </h3>
                        <div class="relative mb-8 w-full">
                            <TextInput
                                label="Nombre"
                                :is-required="true"
                                v-model="formInformation.name"
                                type="text"
                                autofocus
                            />

                            <InputError
                                class="mt-2"
                                :message="formInformation.errors.name"
                            />
                        </div>
                        <div class="relative mb-8 w-full">
                            <TextInput
                                label="Apodo"
                                :is-required="true"
                                v-model="formInformation.nickname"
                                type="text"
                                autofocus
                            />

                            <InputError
                                class="mt-2"
                                :message="formInformation.errors.nickname"
                            />
                        </div>
                        <div class="relative mb-8 w-full">
                            <TextInput
                                label="Email"
                                :is-required="true"
                                v-model="formInformation.email"
                                type="email"
                                autofocus
                            />

                            <InputError
                                class="mt-2"
                                :message="formInformation.errors.email"
                            />
                        </div>
                        <PrimaryButton
                            :class="{
                                'opacity-25': formInformation.processing,
                            }"
                            class="mb-2 self-end w-full mt-4 capitalize"
                            :disabled="formInformation.processing"
                        >
                            Actualizar
                        </PrimaryButton>
                    </form>
                </div>
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
                        <div class="relative mb-8 w-full">
                            <TextInput
                                id="password_current"
                                :label="'Actual Contraseña'"
                                ref="currentPasswordInput"
                                v-model="formPassword.current_password"
                                :is-required="true"
                                type="password"
                                autofocus
                            />

                            <InputError
                                class="mt-2"
                                :message="formPassword.errors.current_password"
                            />
                        </div>
                        <div class="relative mb-8 w-full">
                            <TextInput
                                id="password"
                                ref="passwordInput"
                                v-model="formPassword.password"
                                :label="'Contraseña'"
                                :is-required="true"
                                type="password"
                                autofocus
                            />

                            <InputError
                                class="mt-2"
                                :message="formPassword.errors.password"
                            />
                        </div>
                        <div class="relative mb-8 w-full">
                            <TextInput
                                id="password_confirmation"
                                v-model="formPassword.password_confirmation"
                                :label="'Confirma contraseña'"
                                :is-required="true"
                                type="password"
                                autofocus
                            />

                            <InputError
                                class="mt-2"
                                :message="
                                    formPassword.errors.password_confirmation
                                "
                            />
                        </div>
                        <PrimaryButton
                            type="submit"
                            :class="{ 'opacity-25': formPassword.processing }"
                            class="mb-2 self-end w-full mt-4 capitalize"
                            :disabled="formPassword.processing"
                        >
                            Actualizar
                        </PrimaryButton>
                    </form>
                </div>
            </div>
            <div
                class="w-full flex flex-col gap-4 mx-auto self-center lg:px-14"
            >
                <div class="w-full h-[400px] bg-white rounded-md py-8 px-6">
                    <h4
                        class="text-minus-base normal-case font-semibold text-center"
                    >
                        No hay comentarios
                    </h4>
                </div>
                <div class="h-[150px] w-full bg-white rounded-md p-4">
                    <form class="w-full h-full">
                        <div class="relative mb-8 w-full">
                            <TextInput
                                :label="'Comments'"
                                :is-required="true"
                                type="text"
                                autofocus
                            />
                        </div>
                        <div
                            class="self-end w-full flex gap-4 justify-center items-center"
                        >
                            <TertiaryButton class="bg-green-600">
                                Comentar</TertiaryButton
                            >
                            <TertiaryButton class="bg-red-600">
                                Restaurar</TertiaryButton
                            >
                        </div>
                    </form>
                </div>
            </div>
        </article>
        <ModalImage :show="showChangeImage" @close="closeChangeImage" />
    </AuthenticatedLayout>
</template>

<style scoped>
.parent-button:hover .child-button {
    opacity: 0.5;
}

.parent-button:hover .child-two-button {
    display: flex;
}
</style>
