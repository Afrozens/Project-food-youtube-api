<script lang="ts" setup>
import "vue-advanced-cropper/dist/style.css";
import { ref, onMounted, onUnmounted, watch, reactive } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { Cropper } from "vue-advanced-cropper";
import InputError from "../ElementsPrimitive/InputError.vue";
// @ts-ignore - iconos sin typings
import CameraFlipIcon from "vue-material-design-icons/CameraFlip.vue";
// @ts-ignore - iconos sin typings
import CameraIcon from "vue-material-design-icons/Camera.vue";
import TertiaryButton from "../ElementsPrimitive/TertiaryButton.vue";
import Loader from "../General/Loader.vue";

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

const { props: propsAuth } = usePage();

const form = useForm({
    image: null as File | null,
});

const emit = defineEmits(["close"]);

const isLoading = ref(false);
const fileValue = ref<File>();
const isError = ref("");
const previewData = ref("");
const allowedTypes = ["image/jpeg", "image/png", "image/bmp", "image/webp"];

const handleChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files) {
        const file = target.files[0];
        if (file) {
            if (allowedTypes.includes(file.type)) {
                fileValue.value = file;
                const reader = new FileReader();

                reader.onload = (e: ProgressEvent<FileReader>) => {
                    const path = e.target?.result as string;
                    previewData.value = path;
                };
                reader.readAsDataURL(file);
            } else {
                isError.value = "The image size exceeds the set size";
            }
        }
    }
};

const changeImage = ({ canvas }: { canvas: HTMLCanvasElement }) => {
    let dataURL = canvas.toDataURL("image/png");
    let blobBin = atob(dataURL.split(",")[1]);
    let array = [];
    for (let i = 0; i < blobBin.length; i++) {
        array.push(blobBin.charCodeAt(i));
    }
    let blob = new Blob([new Uint8Array(array)], { type: "image/png" });
    let url = URL.createObjectURL(blob);
    let name = `${url.split("/")[3]}.${blob.type.split("/")[1]}`;
    form.image = new File([blob], `${name}`);
};

const handleSend = () => {
    const path = route("dashboard.image");

    form.transform((data) => ({
        ...data,
        _method: "put",
    }));

    form.post(path, {
        onStart: () => {
            isLoading.value = true;
        },
        onError: () => {
            isLoading.value = false;
        },
        onFinish: () => {
            isLoading.value = false;
        },
    });
};

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
            :disabled="isLoading"
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
                class="z-20 w-full px-4 py-5 max-w-lg absolute top-36 left-1/2 -translate-x-1/2"
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
                    class="p-4 items-start justify-between flex flex-col h-full bg-white rounded-b-md w-full"
                >
                    <div
                        class="w-full flex-grow self-start"
                        :class="previewData ? 'h-72' : 'h-6'"
                    >
                        <Cropper
                            :src="previewData"
                            alt="image of profile user"
                            class="bg-cover w-full h-full"
                            @change="changeImage"
                            :stencil-props="{
                                aspectRatio: 12 / 12,
                            }"
                        />
                    </div>
                    <div class="w-full flex flex-col gap-2 mt-4">
                        <label
                            for="changeImage"
                            @click.stop="isError = ''"
                            class="flex cursor-pointer transition-all hover:opacity-80 items-center gap-2 w-full"
                        >
                            <CameraIcon
                                :fillColor="fileValue ? '#1976D2' : '#6B7280'"
                                class="self-start trasition-all"
                            />
                            <div class="w-full flex-grow">
                                <span
                                    class="cursor-pointer text-lg trasition-all"
                                    :class="
                                        fileValue
                                            ? 'text-primary'
                                            : 'text-gray-500'
                                    "
                                >
                                    {{
                                        fileValue?.name ??
                                        "Seleccione una imagen"
                                    }}
                                </span>
                                <hr
                                    class="h-px bg-gray-500 w-full border-0 col-span-2 trasition-all"
                                    :class="
                                        fileValue ? 'bg-primary' : 'bg-gray-500'
                                    "
                                />
                            </div>
                            <input
                                type="file"
                                id="changeImage"
                                class="w-0 h-0"
                                @change="handleChange"
                                accept="image/png, image/jpeg, image/bmp, image/webp"
                            />
                        </label>
                        <InputError class="mt-2" :message="isError" />
                        <TertiaryButton
                            :disabled="isLoading"
                            :class="{ 'bg-gray-200': isLoading }"
                            @click.prevent="handleSend"
                            class="m-0 bg-green-500 w-full text-center"
                        >
                            <Loader v-show="isLoading" />
                            <span v-show="!isLoading">Actualizar</span>
                        </TertiaryButton>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
