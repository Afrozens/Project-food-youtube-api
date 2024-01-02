<script lang="ts" setup>
import { ref } from "vue";
import Loader from "./Loader.vue";
const isHidden = ref(false);

const lazyOptions = ref({
    src: "/img/banner-advertising.png",
    lifecycle: {
        loading: () => {
            isHidden.value = true;
        },
        loaded: () => {
            isHidden.value = false;
        },
    },
});
</script>

<template>
    <div class="w-full relative h-72 px-24 my-4">
        <img
            v-lazy="{
                src: lazyOptions.src,
                lifecycle: lazyOptions.lifecycle,
            }"
            alt="banner advertising"
            :class="[
                isHidden
                    ? ' animate-pulse blur-sm  opacity-50'
                    : ' animate-none blur-none bg-transparent opacity-100',
            ]"
            lazy="loading"
            class="bg-cover object-cover w-full h-full"
        />
        <Loader
            v-show="isHidden"
            class="absolute top-1/2 -translate-y-1/2 left-1/2 -translate-x-1/2"
        />
    </div>
</template>
