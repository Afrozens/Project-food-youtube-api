<script setup lang="ts">
import { Head, Link, useForm } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import HCaptcha from "@/Components/HCaptcha.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const form = useForm({
    name: "",
    nickname: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => {
            form.reset("password", "password_confirmation");
        },
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <div class="mx-auto mb-4">
            <h2 class="typografy-main font-semibold justify-center text-center">
                {{ $t("message.register.title") }}
            </h2>
            <p class="paragraph font-light text-center">
                {{ $t("message.register.paragraph") }}
            </p>
        </div>

        <form
            @submit.prevent="submit"
            class="flex flex-col gap-4 justify-center items-center"
        >
            <div class="w-full">
                <TextInput
                    id="name"
                    type="text"
                    :label="$t('message.components.name')"
                    :is-required="true"
                    class="mt-1 block w-full"
                    v-model="form.name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="w-full">
                <TextInput
                    id="nickname"
                    type="text"
                    :label="$t('message.components.nickname')"
                    :is-required="true"
                    class="mt-1 block w-full"
                    v-model="form.nickname"
                />

                <InputError class="mt-2" :message="form.errors.nickname" />
            </div>

            <div class="w-full">
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    :label="$t('message.components.email')"
                    :is-required="true"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="w-full">
                <TextInput
                    id="password"
                    type="password"
                    :label="$t('message.components.password')"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    :is-required="true"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="w-full -mb-2">
                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    :label="$t('message.components.confirmPassword')"
                    :is-required="true"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <HCaptcha class="-my-4" />

            <PrimaryButton
                class="capitalize w-full mt-4"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                {{ $t("message.header.optionTwo") }}
            </PrimaryButton>
            <small class="text-extra-sm font-light px-4 text-center -mt-2">
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
            <h4 class="text-extra-md">{{ $t("message.register.alReady") }}</h4>
            <Link
                :href="route('login')"
                class="capitalize text-primary font-semibold hover:opacity-80 transition-opacity"
            >
                {{ $t("message.header.optionOne") }}
            </Link>
        </div>
    </GuestLayout>
</template>
