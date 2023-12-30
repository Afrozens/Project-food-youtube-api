<script lang="ts" setup>
import { watch, onMounted, onUnmounted, ref } from "vue";
import { toast } from "vue3-toastify";
import CloseCircleOutlineIcon from "vue-material-design-icons/CloseCircleOutline.vue";
import InformationOutlineIcon from "vue-material-design-icons/InformationOutline.vue";
import { router } from "@inertiajs/vue3";
import Loader from "../General/Loader.vue";

const props = withDefaults(
    defineProps<{
        title: string;
        routeDelete: string;
        module: string;
        show?: boolean;
        closeable?: boolean;
        id: number;
    }>(),
    {
        inShow: null,
        show: false,
        closeable: true,
    }
);

const emit = defineEmits(["close"]);

const isLoading = ref(false);

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

const handleDelete = async () => {
    try {
        const path = route(props.routeDelete, {
            [props.module]: props.id,
        });

        router.visit(path, {
            method: "post",
            data: {
                _method: "delete",
            },
            preserveState: (page) => Object.keys(page.props.errors).length,
            onStart: () => {
                isLoading.value = true;
            },
            onError: () => {
                isLoading.value = false;
            },
            onFinish: () => {
                isLoading.value = false;
                toast(`El ${props.module} ha sido eliminado con exito`, {
                    autoClose: 1000,
                    position: "top-right",
                    type: "success",
                });
            },
        });
    } catch (error) {
        console.log(error);
    }
};

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
            @click="!isLoading && close"
            class="fixed top-0 left-0 z-40 w-full h-full bg-gray-700 opacity-30"
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
                class="fixed top-0 flex items-center justify-center left-0 z-50 p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full"
            >
                <div class="relative w-full max-w-md p-2 max-h-full">
                    <div class="relative bg-white p-2 rounded-lg shadow">
                        <button
                            @click="close"
                            :disabled="isLoading"
                            :class="{ 'opacity-25': isLoading }"
                            type="button"
                            class="hover:bg-[#c2bfbf32] transition-all rounded-full p-2"
                        >
                            <CloseCircleOutlineIcon />
                        </button>
                        <div class="p-6 text-center">
                            <InformationOutlineIcon
                                class="mx-auto flex items-center justify-center text-text-primary"
                                :size="60"
                            />
                            <h3
                                class="mb-5 text-extra-md font-medium text-text-primary"
                            >
                                {{ title }}
                            </h3>
                            <button
                                type="button"
                                @click="handleDelete"
                                :disabled="isLoading"
                                :class="{ 'bg-gray-200': isLoading }"
                                class="text-white bg-red-600 hover:bg-red-800 focus:ring-0 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2"
                            >
                                <Loader v-show="isLoading" />
                                <span v-show="!isLoading"> Si, confirmar </span>
                            </button>
                            <button
                                type="button"
                                @click="close"
                                :disabled="isLoading"
                                :class="{ 'bg-gray-200': isLoading }"
                                class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-0 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10"
                            >
                                <Loader v-show="isLoading" />
                                <span v-show="!isLoading"> No, cancelar</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
