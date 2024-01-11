<script lang="ts" setup>
import { computed, ref, watch } from "vue";
import { usePage, Link } from "@inertiajs/vue3";
// @ts-ignore - iconos sin typings
import HomeIcon from "vue-material-design-icons/Home.vue";
// @ts-ignore - iconos sin typings
import MenuIcon from "vue-material-design-icons/Menu.vue";
// @ts-ignore - iconos sin typings
import ViewDashboardIcon from "vue-material-design-icons/ViewDashboard.vue";
// @ts-ignore - iconos sin typings
import CogIcon from "vue-material-design-icons/Cog.vue";
// @ts-ignore - iconos sin typings
import LogoutIcon from "vue-material-design-icons/Logout.vue";
import Drawer from "@/Components/Admin/Drawer.vue";
import AvatarGenerate from "@/Components/General/AvatarGenerate.vue";
import Dropdown from "@/Components/Dropdown/Dropdown.vue";

const { props, url } = usePage();

const isOpen = ref(true);

const dataUser = computed(() => {
    if (props.auth) {
        return props.auth.data;
    }
});

function startsWithAdmin(url: string) {
    if (/^\/admin/.test(url) || /^\/chats/.test(url)) return true;
    return false;
}

const handleClose = () => {
    isOpen.value = false;
};

const isOpenCurrent = computed(() => {
    if (!startsWithAdmin(url)) return false;
    return isOpen.value;
});
</script>

<template>
    <section
        class="min-h-screen flex flex-col sm:justify-between items-center bg-gray-100"
    >
        <header
            v-if="dataUser"
            class="flex px-2 md:px-6 z-[99] fixed justify-between items-center w-full h-16"
            :class="
                startsWithAdmin(url)
                    ? 'bg-[#272727] shadow-md'
                    : url === '/'
                    ? 'bg-transparent'
                    : 'bg-header-background bg-cover bg-no-repeat object-cover bg-primary shadow-md'
            "
        >
            <div class="items-center flex">
                <button
                    v-if="startsWithAdmin(url)"
                    @click="isOpen = !isOpen"
                    class="hover:bg-[#cdcaca2f] transition-all rounded-full p-3 mr-1"
                >
                    <MenuIcon fillColor="#fff" />
                </button>
                <Link
                    :href="route('index')"
                    class="text-lg lg:text-xl hover:opacity-80 cursor-pointer transition-all text-white font-medium capitalize"
                >
                    Es Mediterraneo
                </Link>
            </div>

            <div class="flex items-center gap-4">
                <Dropdown>
                    <template #trigger>
                        <button
                            class="flex gap-1 hover:bg-gray-100/50 p-2 rounded-full items-center justify-center cursor-pointer hover:opacity-90 transition-all"
                        >
                            <AvatarGenerate
                                :is-rounded="true"
                                size="40"
                                :src="dataUser.img_path ?? undefined"
                                :name="dataUser.name"
                                class="w-10 h-10"
                            />
                        </button>
                    </template>
                    <template #content>
                        <div class="w-48 bg-white rounded-lg">
                            <div class="flex gap-2 p-4 justify-between">
                                <div class="rounded-full h-10 w-10">
                                    <AvatarGenerate
                                        :is-rounded="true"
                                        size="40"
                                        :src="dataUser.img_path ?? undefined"
                                        :name="dataUser.name"
                                        class="w-10 h-10 flex-grow"
                                    />
                                </div>
                                <div
                                    class="flex flex-col flex-grow justify-between"
                                >
                                    <span
                                        class="text-minus-base break-all font-medium"
                                        >{{ dataUser.name }}</span
                                    >
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
                                        class="flex w-full justify-between hover:bg-gray-100/50 gap-2 p-2 transition-all"
                                    >
                                        <ViewDashboardIcon />
                                        <span
                                            class="text-minus-base cursor-pointer flex-grow self-start font-light"
                                        >
                                            Panel
                                        </span>
                                    </Link>
                                </li>
                                <li class="w-full" v-if="dataUser.admin">
                                    <Link
                                        :href="route('admin.home')"
                                        as="button"
                                        class="flex w-full justify-between hover:bg-gray-100/50 gap-2 p-2 transition-all"
                                    >
                                        <CogIcon />
                                        <span
                                            class="text-minus-base cursor-pointer flex-grow self-start font-light"
                                        >
                                            Panel Administrativo
                                        </span>
                                    </Link>
                                </li>
                                <li class="w-full">
                                    <Link
                                        :href="route('index')"
                                        as="button"
                                        class="flex w-full justify-between hover:bg-gray-100/50 gap-2 p-2 transition-all"
                                    >
                                        <HomeIcon />
                                        <span
                                            class="text-minus-base cursor-pointer flex-grow self-start font-light"
                                        >
                                            Inicio
                                        </span>
                                    </Link>
                                </li>
                                <li class="w-full">
                                    <Link
                                        :href="route('logout')"
                                        method="post"
                                        as="button"
                                        class="flex w-full justify-between hover:bg-gray-100/50 gap-2 p-2 transition-all"
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

        <main
            class="w-full min-h-[calc(100vh-64px)] base-transition bg-transparent overflow-x-hidden"
            :class="[
                isOpenCurrent && 'md:ml-[240px] md:px-24',
                url === '/' ? 'mt-0' : 'mt-[64px]',
            ]"
        >
            <slot class="overflow-x-hidden" />
            <Drawer
                @close="handleClose"
                v-if="startsWithAdmin(url)"
                :sizeSidebar="isOpenCurrent"
            />
        </main>
    </section>
</template>
