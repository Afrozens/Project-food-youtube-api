<script setup lang="ts">
import { Link, usePage } from "@inertiajs/vue3";
import { startsWithVideosHas, startWithGuest } from "@/Utils/urlUtils";

const { url } = usePage();
</script>

<template>
    <section
        class="min-h-screen flex flex-col justify-between items-center bg-gray-100"
    >
        <header
            class="flex px-2 md:px-6 z-[99] absolute justify-between items-center w-full h-16"
            :class="
                url === '/' || startsWithVideosHas(url)
                    ? 'bg-transparent'
                    : 'bg-header-background bg-cover bg-no-repeat object-cover bg-primary shadow-md'
            "
        >
            <Link
                :href="route('index')"
                class="text-lg lg:text-xl hover:opacity-80 cursor-pointer transition-all text-white font-medium capitalize"
            >
                Es Mediterraneo
            </Link>

            <div class="flex items-center gap-4">
                <Link
                    :href="route('login')"
                    class="hidden md:block text-extra-md font-bold text-white hover:opacity-80 transition-opacity capitalize"
                >
                    Loguearse
                </Link>
                <Link
                    :href="route('register')"
                    class="text-extra-md font-bold text-primary hover:opacity-90 transition-opacity p-2 bg-slate-50 rounded-lg capitalize"
                >
                    Registrarse
                </Link>
            </div>
        </header>

        <article
            :class="[
                url === '/' || startsWithVideosHas(url)
                    ? 'mt-0 min-h-screen'
                    : 'mt-[64px] min-h-[calc(100vh-64px)]',
                startWithGuest(url)
                    ? 'w-full sm:max-w-md  flex flex-col justify-center mt-6 px-6 py-4 bg-transparent overflow-hidden  -mb-12'
                    : 'w-full base-transition bg-transparent overflow-x-hidden',
            ]"
        >
            <slot />
        </article>

        <footer
            class="grid grid-cols-2 place-items-center py-2 md:py-0 md:flex-row text-extra-sm gap-4 px-4 bg-header-background bg-cover bg-no-repeat object-cover bg-primary w-full md:h-12 md:flex md:justify-end items-center text-white"
        >
            <a href="#" class="footer-title">
                Copyright © 2023 Es Mediterraneo todos los derechos reservados.
                <b class="hidden md:block">/</b>
            </a>
            <a href="#" class="footer-title">
                Privacidad <b class="hidden md:block">/</b>
            </a>
            <a
                href="#"
                class="place-self-start md:place-self-center footer-title"
            >
                Términos y condiciones de uso <b class="hidden md:block">/</b>
            </a>
            <a href="#" class="col-start-2 footer-title"
                >FAQ <b class="hidden md:block">/</b></a
            >
            <a href="#" class="col-start-2"> Contacto </a>
        </footer>
    </section>
</template>
