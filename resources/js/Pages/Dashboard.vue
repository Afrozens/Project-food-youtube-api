<script setup lang="ts">
import { ref, onMounted, computed } from "vue";
import { Head, usePage } from "@inertiajs/vue3";
import ResetPassword from "@/Components/Dashboard/ResetPassword.vue";
import ResetInformation from "@/Components/Dashboard/ResetInformation.vue";
// @ts-ignore - iconos sin typings
import CameraFlipIcon from "vue-material-design-icons/CameraFlip.vue";
// @ts-ignore - iconos sin typings
import AccountIcon from "vue-material-design-icons/Account.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ChatInDashboard from "@/Components/Dashboard/ChatInDashboard.vue";
import ModalImage from "@/Components/Modals/ModalImage.vue";
import { ChatContent } from "@/types/chat";

const { props } = usePage();

const propsDefine = defineProps({
    chatCollection: Object,
});

const dataUser = ref();
const showChangeImage = ref<boolean>(false);

const closeChangeImage = () => {
    showChangeImage.value = false;
};
onMounted(() => {
    if (props.auth) {
        dataUser.value = props.auth.data;
    }
});

const chatData = computed(() => {
    if (propsDefine.chatCollection) {
        return propsDefine.chatCollection.data as ChatContent[];
    }
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <article
            v-if="dataUser"
            class="py-4 w-full bg-cover flex flex-col bg-fixed px-8 lg:px-24 gap-8 bg-no-repeat bg-center bg-black-background min-h-screen bg-black"
        >
            <!-- Change image profile -->
            <h2 class="text-2xl text-center font-extrabold text-white">
                Cambia tu imagen de perfil
            </h2>
            <div
                class="mx-auto my-6 parent-button relative flex hover:bg-[#202020b2] transition-all items-center justify-center rounded-full w-[170px] h-[170px] bg-transparent shadow-2xl"
            >
                <img
                    v-if="dataUser.img_path.length > 0"
                    :src="dataUser.img_path"
                    alt="profile image of user"
                    class="w-full h-full rounded-full bg-cover"
                />
                <AccountIcon
                    class="child-button transition-all"
                    :size="120"
                    fillColor="#6b7280"
                    v-else
                />
                <button
                    @click="showChangeImage = true"
                    class="absolute child-two-button top-1/2 justify-center items-center -translate-y-1/2 w-14 hidden h-14 rounded-full border border-white p-6 hover:bg-[#202020b2] transition-all"
                >
                    <CameraFlipIcon fillColor="#ffffff" />
                </button>
            </div>
            <div class="flex flex-col gap-5 lg:flex-row justify-between">
                <!-- Change profile information / password -->
                <ResetInformation />
                <ResetPassword />
            </div>
            <!-- Chat in comments -->
            <ChatInDashboard
                v-if="chatData && !dataUser.admin"
                :data-chat="chatData"
            />
        </article>
        <!-- Modal for change image profile -->
        <ModalImage :show="showChangeImage" @close="closeChangeImage" />
    </AuthenticatedLayout>
</template>

<style scoped>
.parent-button:hover .child-button {
    opacity: 0.5;
}

.parent-button:hover .child-two-button {
    display: flex;
}
</style>
