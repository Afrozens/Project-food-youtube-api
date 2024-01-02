<script lang="ts" setup>
import { useMediaQuery } from "@vueuse/core";
import { Link, usePage } from "@inertiajs/vue3";
// @ts-ignore - iconos sin typings
import TagMultipleIcon from "vue-material-design-icons/TagMultiple.vue";
// @ts-ignore - iconos sin typings
import HomeIcon from "vue-material-design-icons/Home.vue";
// @ts-ignore - iconos sin typings
import AccountMultipleIcon from "vue-material-design-icons/AccountMultiple.vue";
// @ts-ignore - iconos sin typings
import MessageIcon from "vue-material-design-icons/Message.vue";
// @ts-ignore - iconos sin typings
import VideoIcon from "vue-material-design-icons/Video.vue";

const { props } = usePage();

defineProps({
    sizeSidebar: Boolean,
});

const isLargeScreen = useMediaQuery("(min-width: 750px)");

const emits = defineEmits(["close"]);

const close = () => {
    emits("close");
};
</script>

<template>
    <div
        v-if="!isLargeScreen"
        @click="close"
        v-show="sizeSidebar"
        class="fixed inset-0 z-[97] transform transition-all"
    >
        <div class="absolute inset-0 bg-gray-800 opacity-50" />
    </div>
    <aside
        class="fixed base-transition left-0 top-0 z-[98] h-screen md:flex flex-col pb-8 pt-4 bg-[#363636] border-r md:mt-0"
        :class="[
            !isLargeScreen && sizeSidebar && 'w-1/2',
            sizeSidebar ? 'md:w-60' : 'md:w-0 -left-48',
        ]"
    >
        <div
            v-if="sizeSidebar"
            class="flex flex-col justify-between base-transition flex-1 base-transition mt-12"
        >
            <nav class="mt-6">
                <Link :href="route('admin.home')" class="item-link-drawer">
                    <HomeIcon :size="25" />
                    <span class="mx-4 font-base base-transition">Inicio</span>
                </Link>

                <Link
                    class="item-link-drawer"
                    :href="route('admin.tags.index')"
                >
                    <TagMultipleIcon :size="25" />

                    <span class="mx-4 font-base base-transition">Tags</span>
                </Link>

                <Link
                    class="item-link-drawer"
                    :href="route('admin.videos.index')"
                >
                    <VideoIcon :size="25" />

                    <span class="mx-4 font-base base-transition">Videos</span>
                </Link>
                <Link
                    class="item-link-drawer"
                    :href="route('admin.users.index')"
                    v-if="props.auth.data.super"
                >
                    <AccountMultipleIcon :size="25" />

                    <span class="mx-4 font-base base-transition"
                        >Usuarios
                    </span>
                </Link>
                <Link
                    class="item-link-drawer"
                    :href="route('admin.chats.index')"
                >
                    <MessageIcon :size="25" />

                    <span class="mx-4 font-base base-transition">Mensajes</span>
                </Link>
            </nav>
        </div>
    </aside>
</template>
