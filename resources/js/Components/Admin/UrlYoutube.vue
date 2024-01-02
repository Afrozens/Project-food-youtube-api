<script lang="ts" setup>
import { ref, inject, Ref } from "vue";
import LinkIcon from "vue-material-design-icons/Link.vue";
import PencilIcon from "vue-material-design-icons/Pencil.vue";
import CloseIcon from "vue-material-design-icons/CloseCircle.vue";
import TextInput from "../ElementsPrimitive/TextInput.vue";
import axios from "axios";
import TertiaryButton from "../ElementsPrimitive/TertiaryButton.vue";
import Loader from "../General/Loader.vue";
import { toast } from "vue3-toastify";

const props = defineProps({
    url: String,
    open: Boolean,
});

const urlCurrent = inject("urlCurrent") as Ref<string>;
const verifyUrl = inject("verifyUrl", null) as Ref<boolean> | null;
const videoId = inject("videoId") as Ref<string>;

const isSend = ref(props.open);
const error = ref("");
const isLoading = ref(false);
const success = ref(false);
const value = ref("");

const getVideoId = async () => {
    error.value = "";
    success.value = false;
    isLoading.value = true;
    if (value.value) {
        try {
            const path = route("admin.videos.youtube.info");
            const { data } = await axios.post(path, {
                url: value.value,
            });
            success.value = true;
            toast("URL de Youtube aceptable y actualizada", {
                autoClose: 1000,
                position: "top-right",
                type: "success",
            });
            urlCurrent.value = value.value;
            isSend.value = false;
            videoId.value = data.video_id;
            if (verifyUrl) {
                verifyUrl.value = true;
            }
        } catch (e) {
            if (e.response) {
                error.value = e.response.data.errors.url;
            } else {
                error.value = "Error en la comunicacion";
            }
            toast(error.value, {
                autoClose: 1000,
                position: "top-right",
                type: "error",
            });
        }
    }
    isLoading.value = false;
};
</script>

<template>
    <div v-if="!isSend" class="flex gap-2 text-lg items-center">
        <LinkIcon />
        {{ url }}
        <button
            type="button"
            @click="isSend = true"
            class="p-1 rounded-full transition-all hover:bg-[#fb8a004b] hover:opacity-80"
        >
            <PencilIcon fillColor="#FB8C00" />
        </button>
    </div>

    <div v-else class="flex gap-2 text-lg items-center">
        <button
            type="button"
            @click="isSend = false"
            class="p-1 rounded-full transition-all hover:bg-[#d750504b] hover:opacity-80"
        >
            <CloseIcon :size="30" fillColor="#d75050" />
        </button>
        <form @submit.prevent="getVideoId" class="w-full flex flex-col gap-2">
            <div class="w-full relative">
                <TextInput
                    v-model="value"
                    type="text"
                    :withSearch="true"
                    label="URL de Youtube"
                />
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    x="0px"
                    y="0px"
                    class="absolute left-3 top-1/2 -translate-y-1/2"
                    width="20"
                    height="20"
                    viewBox="0 0 48 48"
                >
                    <path
                        fill="#FF3D00"
                        d="M43.2,33.9c-0.4,2.1-2.1,3.7-4.2,4c-3.3,0.5-8.8,1.1-15,1.1c-6.1,0-11.6-0.6-15-1.1c-2.1-0.3-3.8-1.9-4.2-4C4.4,31.6,4,28.2,4,24c0-4.2,0.4-7.6,0.8-9.9c0.4-2.1,2.1-3.7,4.2-4C12.3,9.6,17.8,9,24,9c6.2,0,11.6,0.6,15,1.1c2.1,0.3,3.8,1.9,4.2,4c0.4,2.3,0.9,5.7,0.9,9.9C44,28.2,43.6,31.6,43.2,33.9z"
                    ></path>
                    <path fill="#FFF" d="M20 31L20 17 32 24z"></path>
                </svg>
            </div>
            <TertiaryButton
                @click.prevent="getVideoId"
                type="button"
                class="hover:scale-100"
                :class="isLoading ? 'bg-gray-200' : 'bg-green-600'"
            >
                <Loader v-show="isLoading" />
                <span v-show="!isLoading">
                    {{ open ? "Agregar" : "Actualizar" }}</span
                >
            </TertiaryButton>
        </form>
    </div>
</template>
