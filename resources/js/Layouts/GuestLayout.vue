<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import LanguageDropdown from "@/Components/LanguageDropdown.vue";
</script>

<template>
    <section
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100"
    >
        <header
            class="flex px-6 justify-between absolute top-0 items-center w-full h-16 bg-primary shadow-md"
        >
            <h3 class="text-lg text-white font-semibold capitalize">
                Es Mediterraneo
            </h3>

            <div class="flex items-center gap-4">
                <LanguageDropdown />
                <Link
                    :href="route('login')"
                    class="text-extra-md font-bold text-white hover:opacity-80 transition-opacity capitalize"
                >
                    {{ $t("message.header.optionOne") }}
                </Link>
                <Link
                    :href="route('register')"
                    class="text-extra-md font-bold text-primary hover:opacity-90 transition-opacity p-2 bg-slate-50 rounded-lg capitalize"
                >
                    {{ $t("message.header.optionTwo") }}
                </Link>
            </div>
        </header>

        <article
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-transparent overflow-hidden"
        >
            <slot />
        </article>

        <footer
            class="absolute bottom-0 text-extra-sm gap-4 px-4 bg-[#000000b8] w-full h-12 flex justify-end items-center text-white"
        >
            <a href="#" class="footer-title">
                Copyright © 2023 Es Mediterraneo all rights reserved.
                <b>/</b>
            </a>
            <a href="#" class="footer-title"> Privacity <b>/</b> </a>
            <a href="#" class="footer-title">
                Terms and conditions of use <b>/</b>
            </a>
            <a href="#" class="footer-title">FAQ <b>/</b></a>
            <a href="#"> Contact </a>
        </footer>
    </section>
</template>
