<script setup lang="ts">
import { Head, Link, useForm } from "@inertiajs/vue3";
import Checkbox from "@/Components/Checkbox.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import CustomCheckbox from "@/Components/CustomCheckbox.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import HCaptcha from "@/Components/HCaptcha.vue";
import TextInput from "@/Components/TextInput.vue";

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
                {{ $t("message.login.title") }}
            </h2>
            <p class="paragraph font-light text-center">
                {{ $t("message.login.subTitle") }}
            </p>
        </div>

        <form
            @submit.prevent="submit"
            class="flex flex-col justify-center items-center"
        >
            <div class="relative mb-2 w-full">
                <TextInput
                    id="email"
                    :label="$t('message.components.email')"
                    :is-required="true"
                    type="email"
                    v-model="form.email"
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4 mb-2 w-full">
                <TextInput
                    id="password"
                    :label="$t('message.components.password')"
                    type="password"
                    :is-required="true"
                    v-model="form.password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>
            <Link
                v-if="canResetPassword"
                :href="route('password.request')"
                class="hover:underline transition-all hover:opacity-80 self-end text-xs text-gray-600 hover:text-gray-900 rounded-md focus:outline-none"
            >
                {{ $t("message.login.forgot") }}
            </Link>

            <div class="block relative self-start">
                <label class="flex items-center relative w-fit">
                    <CustomCheckbox />
                    <span
                        class="ml-2 text-sm text-gray-600 cursor-pointer transition-all hover:opacity-90 hover:underline"
                    >
                        {{ $t("message.login.remember") }}
                    </span>
                </label>
            </div>

            <HCaptcha />

            <PrimaryButton
                :class="{ 'opacity-25': form.processing }"
                class="mb-2 w-full mt-4 capitalize"
                :disabled="form.processing"
            >
                {{ $t("message.header.optionOne") }}
            </PrimaryButton>

            <small class="text-extra-sm font-light px-4 text-center">
                For added security, you must complete the verification
                <a
                    href="https://www.hcaptcha.com/"
                    class="font-semibold hover:opacity-80 transition-all hover:underline"
                >
                    hCaptcha
                </a>
                before logging in.
            </small>
        </form>
        <div class="flex gap-2 items-center justify-center mt-4">
            <h4 class="text-extra-md">{{ $t("message.login.dont") }}</h4>
            <Link
                :href="route('register')"
                class="capitalize text-primary font-semibold hover:opacity-80 transition-opacity"
            >
                {{ $t("message.header.optionTwo") }}
            </Link>
        </div>
    </GuestLayout>
</template>
