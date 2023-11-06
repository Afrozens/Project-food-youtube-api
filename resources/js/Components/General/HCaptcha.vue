<script lang="ts" setup>
import { inject, Ref } from "vue";
import VueHcaptcha from "@hcaptcha/vue3-hcaptcha";

const withTokenCaptcha = inject("withTokenCaptcha") as Ref<string>;
const onVerify = (token: string, eKey: string) => {
    console.log(token);
    withTokenCaptcha.value = token;
};
</script>

<template>
    <VueHcaptcha
        class="mt-4"
        sitekey="6e6f1f68-a32f-4121-a224-578dfab198bb"
        @verify="onVerify"
    />
</template>
