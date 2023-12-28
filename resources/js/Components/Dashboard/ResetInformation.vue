<script lang="ts" setup>
import { PageProps } from "../../types/index";
import { useForm, usePage } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import AccountEditIcon from "vue-material-design-icons/AccountEdit.vue";
import FormField from "../General/FormField.vue";
import PrimaryButton from "../ElementsPrimitive/PrimaryButton.vue";
import Loader from "../General/Loader.vue";

const { props } = usePage<PageProps>();

const formInformation = useForm({
    name: props.auth.data.name,
    email: props.auth.data.email,
    nickname: props.auth.data.nickname,
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
</script>

<template>
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

            <FormField
                class="mb-8"
                id="name"
                type="text"
                :label="$t('message.components.name')"
                :is-required="true"
                v-model="formInformation.name"
                :error="formInformation.errors.name"
            />

            <FormField
                class="mb-8"
                id="nickname"
                type="text"
                :label="$t('message.components.nickname')"
                :is-required="true"
                v-model="formInformation.nickname"
                :error="formInformation.errors.nickname"
            />

            <FormField
                class="mb-8"
                id="email"
                type="email"
                v-model="formInformation.email"
                :label="$t('message.components.email')"
                :is-required="true"
                :error="formInformation.errors.email"
            />

            <PrimaryButton
                :class="{
                    'bg-gray-200': formInformation.processing,
                }"
                class="mb-2 self-end w-full mt-4 capitalize"
                :disabled="formInformation.processing"
            >
                <Loader v-show="formInformation.processing" />
                <span v-show="!formInformation.processing">Actualizar</span>
            </PrimaryButton>
        </form>
    </div>
</template>
