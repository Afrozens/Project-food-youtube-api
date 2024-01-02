<script lang="ts" setup>
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";
import Tag from "../../Components/Admin/Tag.vue";
// @ts-ignore - iconos sin typings
import VideoIcon from "vue-material-design-icons/Video.vue";
// @ts-ignore - iconos sin typings
import TagMultipleIcon from "vue-material-design-icons/TagMultiple.vue";
// @ts-ignore - iconos sin typings
import AccountMultipleIcon from "vue-material-design-icons/AccountMultiple.vue";

defineProps({
    total_tags: Number,
    total_videos: Number,
    total_admin: Number,
    total_users: Number,
});
</script>

<template>
    <Head title="Panel Administrativo" />

    <AuthenticatedLayout>
        <section
            class="w-full px-4 mt-10 gap-6 grid md:grid-cols-2 lg:px-60 place-items-center"
        >
            <Tag
                :icon="TagMultipleIcon"
                background="blue"
                :count="total_tags"
                title="Total Tags"
                :is-black="false"
            />
            <Tag
                :icon="VideoIcon"
                background="green"
                :count="total_videos"
                title="Total Videos"
                :is-black="false"
            />
            <Tag
                :icon="AccountMultipleIcon"
                background="blue"
                :count="total_users"
                title="Total Usuarios"
                :is-black="true"
            />
            <Tag
                :icon="AccountMultipleIcon"
                background="blue"
                :count="total_admin"
                title="Total Administradores"
                :is-black="true"
            />
        </section>
    </AuthenticatedLayout>
</template>
