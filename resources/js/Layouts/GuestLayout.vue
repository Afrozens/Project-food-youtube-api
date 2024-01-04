<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <section
        class="min-h-screen flex flex-col justify-between items-center bg-gray-100"
    >
        <header
            class="flex px-6 justify-between items-center w-full h-16 bg-header-background bg-cover bg-no-repeat object-cover bg-primary shadow-md"
        >
            <h3
                class="text-base md:text-lg text-white font-semibold capitalize"
            >
                Es Mediterraneo
            </h3>

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
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-transparent overflow-hidden"
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
