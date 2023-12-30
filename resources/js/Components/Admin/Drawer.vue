<script lang="ts" setup>
import { useMediaQuery } from "@vueuse/core";
import TagMultipleIcon from "vue-material-design-icons/TagMultiple.vue";
import HomeIcon from "vue-material-design-icons/Home.vue";
import AccountMultipleIcon from "vue-material-design-icons/AccountMultiple.vue";
import MessageIcon from "vue-material-design-icons/Message.vue";
import VideoIcon from "vue-material-design-icons/Video.vue";

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
        class="fixed inset-0 transform transition-all"
    >
        <div class="absolute inset-0 bg-gray-800 opacity-50" />
    </div>
    <aside
        class="fixed base-transition left-0 top-0 z-20 h-screen md:flex flex-col pb-8 pt-4 bg-[#363636] border-r md:mt-0"
        :class="[
            !isLargeScreen && sizeSidebar && 'w-1/2',
            sizeSidebar ? 'md:w-60' : 'md:w-0 -left-48',
        ]"
    >
        <Transition>
            <div
                v-if="sizeSidebar"
                class="flex flex-col justify-between flex-1 base-transition mt-12"
            >
                <nav class="mt-6">
                    <a class="item-link-drawer" href="#">
                        <HomeIcon :size="25" />
                        <span class="mx-4 font-base base-transition"
                            >Inicio</span
                        >
                    </a>

                    <a class="item-link-drawer" href="#">
                        <TagMultipleIcon :size="25" />

                        <span class="mx-4 font-base base-transition">Tags</span>
                    </a>

                    <a class="item-link-drawer" href="#">
                        <VideoIcon :size="25" />

                        <span class="mx-4 font-base base-transition"
                            >Videos</span
                        >
                    </a>
                    <a class="item-link-drawer" href="#">
                        <AccountMultipleIcon :size="25" />

                        <span class="mx-4 font-base base-transition"
                            >Usuarios</span
                        >
                    </a>
                    <a class="item-link-drawer" href="#">
                        <MessageIcon :size="25" />

                        <span class="mx-4 font-base base-transition"
                            >Mensajes</span
                        >
                    </a>
                </nav>
            </div>
        </Transition>
    </aside>
</template>
