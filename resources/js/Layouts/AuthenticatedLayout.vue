<script lang="ts" setup>
import { onMounted, ref } from "vue";
import HomeIcon from "vue-material-design-icons/Home.vue";
import ViewDashboardIcon from "vue-material-design-icons/ViewDashboard.vue";
import LogoutIcon from "vue-material-design-icons/Logout.vue";
import LanguageDropdown from "@/Components/Dropdown/LanguageDropdown.vue";
import AvatarGenerate from "@/Components/General/AvatarGenerate.vue";
import Dropdown from "@/Components/Dropdown/Dropdown.vue";
import { usePage, Link } from "@inertiajs/vue3";

const { props } = usePage();
const dataUser = ref();
onMounted(() => {
    if (props.auth) {
        dataUser.value = props.auth.user;
    }
});
</script>

<template>
    <section
        class="min-h-screen flex flex-col sm:justify-between items-center pt-6 sm:pt-0 bg-gray-100"
    >
        <header
            v-if="dataUser"
            class="flex px-6 justify-between items-center w-full h-16 bg-primary shadow-md"
        >
            <Link
                :href="route('index')"
                class="text-lg hover:opacity-80 cursor-pointer transition-all text-white font-semibold capitalize"
            >
                Es Mediterraneo
            </Link>

            <div class="flex items-center gap-4">
                <LanguageDropdown />
                <Dropdown>
                    <template #trigger>
                        <button
                            class="flex gap-1 hover:bg-gray-100/50 p-2 rounded-full items-center justify-center cursor-pointer hover:opacity-90 transition-all"
                        >
                            <AvatarGenerate
                                :is-rounded="true"
                                size="40"
                                :src="dataUser.img_url ?? undefined"
                                :name="dataUser.name"
                                class="w-10 h-10"
                            />
                        </button>
                    </template>
                    <template #content>
                        <div class="w-48 bg-white rounded-lg">
                            <div class="flex gap-2 p-4 justify-between">
                                <AvatarGenerate
                                    :is-rounded="true"
                                    size="40"
                                    :src="dataUser.img_url ?? undefined"
                                    :name="dataUser.name"
                                    class="w-10 h-10 flex-grow"
                                />
                                <div
                                    class="flex flex-col flex-grow justify-between"
                                >
                                    <span class="text-minus-base font-medium">{{
                                        dataUser.name
                                    }}</span>
                                    <span
                                        class="text-extra-md capitalize font-light"
                                        >{{
                                            dataUser.nickname.length > 0
                                                ? dataUser.nickname
                                                : "no tienes apodo"
                                        }}</span
                                    >
                                </div>
                            </div>
                            <hr class="h-px bg-gray-300 border-0 col-span-2" />
                            <ul class="flex flex-col gap-2">
                                <li class="w-full">
                                    <Link
                                        :href="route('dashboard')"
                                        as="button"
                                        class="flex w-full justify-between hover:bg-gray-100/50 gap-4 p-4 transition-all"
                                    >
                                        <ViewDashboardIcon />
                                        <span
                                            class="text-minus-base cursor-pointer flex-grow self-start font-light"
                                        >
                                            Panel
                                        </span>
                                    </Link>
                                </li>
                                <li class="w-full">
                                    <Link
                                        :href="route('index')"
                                        as="button"
                                        class="flex w-full justify-between hover:bg-gray-100/50 gap-4 p-4 transition-all"
                                    >
                                        <HomeIcon />
                                        <span
                                            class="text-minus-base cursor-pointer flex-grow self-start font-light"
                                        >
                                            Home
                                        </span>
                                    </Link>
                                </li>
                                <li class="w-full">
                                    <Link
                                        :href="route('logout')"
                                        method="post"
                                        as="button"
                                        class="flex w-full justify-between hover:bg-gray-100/50 gap-4 p-4 transition-all"
                                    >
                                        <LogoutIcon />
                                        <span
                                            class="text-minus-base cursor-pointer flex-grow self-start font-light"
                                        >
                                            Cerrar sesión
                                        </span>
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </template>
                </Dropdown>
            </div>
        </header>

        <main class="w-full min-h-screen bg-transparent overflow-hidden">
            <slot />
        </main>
    </section>
</template>
