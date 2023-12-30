<script lang="ts" setup>
import { Comment as CommentType } from "../../types/chat";

defineProps<{
    comment: CommentType;
}>();
</script>

<template>
    <li class="border border-gray-300 rounded-md py-2 px-4 flex flex-col gap-5">
        <header class="w-full flex gap-4 items-center justify-start">
            <img
                class="bg-cover rounded-full h-[40px] w-[40px]"
                :src="comment.img"
                :alt="comment.name"
            />
            <span>{{ comment.name }}</span>
        </header>

        <p
            class="mb-4 text-[14px] text-black opacity-60"
            v-html="comment.content"
        ></p>
    </li>
</template>
