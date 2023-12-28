<script setup lang="ts">
import { ref, provide } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import FormField from "@/Components/General/FormField.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/ElementsPrimitive/InputError.vue";
import HCaptcha from "@/Components/General/HCaptcha.vue";
import PrimaryButton from "@/Components/ElementsPrimitive/PrimaryButton.vue";
import TextInput from "@/Components/ElementsPrimitive/TextInput.vue";
import ProvidersSign from "@/Components/General/ProvidersSign.vue";

const form = useForm({
    name: "",
    nickname: "",
    email: "",
    password: "",
    password_confirmation: "",
});
const withTokenCaptcha = ref();
const errorCaptcha = ref();

const submit = () => {
    if (withTokenCaptcha) {
        form.post(route("register"), {
            onFinish: () => {
                form.reset("password", "password_confirmation");
            },
        });
    } else {
        errorCaptcha.value = "Error in hCaptcha, try again";
    }
};

provide("withTokenCaptcha", withTokenCaptcha);
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

        <ProvidersSign :label="$t('message.header.optionTwo')" />
        <hr class="h-px bg-gray-300 mb-4 border-0 col-span-2 opacity-80" />
        <form
            @submit.prevent="submit"
            class="flex flex-col gap-4 justify-center items-center"
        >
            <div class="w-full flex-col md:flex-row flex gap-4 items-center">
                <FormField
                    id="name"
                    type="text"
                    :label="$t('message.components.name')"
                    :is-required="true"
                    v-model="form.name"
                    :error="form.errors.name"
                />

                <FormField
                    id="nickname"
                    type="text"
                    :label="$t('message.components.nickname')"
                    :is-required="true"
                    v-model="form.nickname"
                    :error="form.errors.nickname"
                />
            </div>

            <FormField
                id="email"
                type="email"
                v-model="form.email"
                :label="$t('message.components.email')"
                :is-required="true"
                :error="form.errors.email"
            />

            <FormField
                id="password"
                type="password"
                :label="$t('message.components.password')"
                v-model="form.password"
                :is-required="true"
                :error="form.errors.password"
            />

            <FormField
                class="-mb-2"
                id="password_confirmation"
                type="password"
                v-model="form.password_confirmation"
                :label="$t('message.components.confirmPassword')"
                :is-required="true"
                :error="form.errors.password_confirmation"
            />

            <HCaptcha class="-my-4" />

            <InputError class="mt-2" :message="errorCaptcha" />

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
