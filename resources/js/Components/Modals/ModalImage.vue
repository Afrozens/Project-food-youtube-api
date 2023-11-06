<script lang="ts" setup>
import { computed, onMounted, onUnmounted, watch } from "vue";
import CameraFlipIcon from "vue-material-design-icons/CameraFlip.vue";
import CameraIcon from "vue-material-design-icons/Camera.vue";
import TertiaryButton from "../ElementsPrimitive/TertiaryButton.vue";

const props = withDefaults(
    defineProps<{
        show?: boolean;
        closeable?: boolean;
    }>(),
    {
        show: false,
        closeable: true,
    }
);

const emit = defineEmits(["close"]);

watch(
    () => props.show,
    () => {
        if (props.show) {
            document.body.style.overflow = "hidden";
        } else {
            document.body.style.overflow = "visible";
        }
    }
);

const close = () => {
    if (props.closeable) {
        emit("close");
    }
};

const closeOnEscape = (e: KeyboardEvent) => {
    if (e.key === "Escape" && props.show) {
        close();
    }
};

onMounted(() => document.addEventListener("keydown", closeOnEscape));

onUnmounted(() => {
    document.removeEventListener("keydown", closeOnEscape);
    document.body.style.overflow = "visible";
});
</script>

<template>
    <Teleport to="body">
        <div
            v-show="show"
            @click="close"
            class="fixed top-0 left-0 z-10 w-full h-full bg-gray-900 opacity-50"
        />
        <Transition
            enter-active-class="ease-out duration-300"
            enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            enter-to-class="opacity-100 translate-y-0 sm:scale-100"
            leave-active-class="ease-in duration-200"
            leave-from-class="opacity-100 translate-y-0 sm:scale-100"
            leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
            <div
                v-show="show"
                class="h-[478px] z-20 w-full px-4 py-5 max-w-lg absolute top-36 left-1/2 -translate-x-1/2"
            >
                <header
                    class="flex justify-start rounded-t-md items-center gap-4 px-4 py-1 h-[56px] w-full bg-primary"
                >
                    <CameraFlipIcon :size="40" fillColor="#ffffff" />

                    <span class="text-white text-lg capitalize"
                        >Cambiar imagen</span
                    >
                </header>
                <div
                    class="p-4 gap-4 justify-end items-start flex flex-col h-full bg-white rounded-b-md w-full"
                >
                    <!-- <div class="w-full h-72">
                        <img
                            :src="src"
                            alt="image of profile user"
                            class="bg-cover w-full h-full"
                        />
                    </div> -->
                    <label
                        for="changeImage"
                        class="flex transition-all hover:opacity-80 items-center gap-2 w-full"
                    >
                        <CameraIcon fillColor="#6B7280" class="self-start" />
                        <div class="w-full flex-grow">
                            <span class="cursor-text text-lg text-gray-500">
                                Seleccione una imagen
                            </span>
                            <hr
                                class="h-px bg-gray-500 w-full border-0 col-span-2"
                            />
                        </div>
                        <input type="file" id="changeImage" class="w-0 h-0" />
                    </label>
                    <TertiaryButton class="m-0 bg-green-500 w-full">
                        Actualizar
                    </TertiaryButton>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
