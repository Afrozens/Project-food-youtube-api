<script lang="ts" setup>
import AvatarGenerate from "@/Components/General/AvatarGenerate.vue";
import { ChatAdminData } from "../../../types/chat";

defineProps<{
    data: ChatAdminData;
}>();
</script>

<template>
    <div class="flex gap-4 items-center">
        <div class="w-[48px] h-[48px]">
            <AvatarGenerate
                :is-rounded="true"
                size="40"
                :src="data.img_url ?? undefined"
                :name="data.name"
                class="w-12 h-12"
            />
        </div>
        <span class="font-medium text-base capitalize truncate">
            {{ data.name }}</span
        >
    </div>
</template>
