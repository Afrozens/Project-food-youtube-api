<script lang="ts" setup>
import { computed } from "vue";
import { Head } from "@inertiajs/vue3";
import MessageTextIcon from "vue-material-design-icons/MessageText.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ChatAdminData, ChatContent } from "@/types/chat";
import ChatInDashboard from "@/Components/Dashboard/ChatInDashboard.vue";

const props = defineProps({
    user: Object,
    dataChat: Object,
});

const data = computed(() => {
    return props.user as ChatAdminData;
});

const chat = computed(() => {
    if (props.dataChat) {
        return props.dataChat.data as ChatContent[];
    }
});
</script>

<template>
    <Head :title="data.name" />

    <AuthenticatedLayout>
        <section
            class="min-h-screen w-full pl-4 pr-8 md:pl-16 md:pr-24 mt-8 overflow-x-hidden mb-5"
        >
            <header class="mb-4 w-full flex items-center justify-start gap-2">
                <MessageTextIcon :size="70" fillColor="#757575" />
                <span class="font-semibold text-3xl"
                    >Mensajes de {{ data.name }}</span
                >
            </header>
            <ChatInDashboard :dataChat="chat" :idAuthUser="data.id" />
        </section>
    </AuthenticatedLayout>
</template>
