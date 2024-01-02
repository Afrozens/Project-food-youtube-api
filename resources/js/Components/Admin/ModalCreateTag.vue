<script lang="ts" setup>
import { ref, onMounted, onUnmounted, watch } from "vue";
// @ts-ignore - iconos sin typings
import TagArrowUpIcon from "vue-material-design-icons/TagArrowUp.vue";
import FormField from "../General/FormField.vue";
import TertiaryButton from "../ElementsPrimitive/TertiaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import Loader from "../General/Loader.vue";
import { toast } from "vue3-toastify";

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

const form = useForm({
    name: "",
});

const handleSend = () => {
    form.clearErrors();
    const path = route("admin.tags.store");
    form.post(path, {
        onSuccess: () => {
            toast("Has creado un tag con exito", {
                autoClose: 1000,
                position: "top-right",
                type: "success",
            });
        },
        onError: () => {
            toast("No se pudo crear un tag", {
                autoClose: 1000,
                position: "top-right",
                type: "error",
            });
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
            :disabled="form.processing"
            @click="close"
            class="fixed top-0 left-0 z-40 w-full h-full bg-gray-900 opacity-50"
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
                class="z-50 w-full px-4 py-5 max-w-[400px] fixed top-1/3 left-1/2 -translate-x-1/2 rounded-md"
            >
                <header
                    class="bg-[#4caf50] flex justify-start items-center gap-2 p-3 w-full rounded-t-md"
                >
                    <TagArrowUpIcon class="opacity-70" />
                    <span class="text-[20px] truncate opacity-90"
                        >Nuevo Tag</span
                    >
                </header>
                <div class="rounded-b-md w-full px-4 py-5 bg-white h-[160px]">
                    <form
                        @submit.prevent="handleSend"
                        class="w-full h-full flex-col flex justify-between items-center"
                    >
                        <FormField
                            class="mb-8"
                            type="text"
                            :label="$t('message.components.name')"
                            :is-required="true"
                            v-model="form.name"
                            :error="form.errors.name"
                        />

                        <TertiaryButton
                            @click.prevent="handleSend"
                            type="button"
                            :class="
                                form.processing ? 'bg-gray-200' : 'bg-primary'
                            "
                        >
                            <Loader v-show="form.processing" />
                            <span v-show="!form.processing"> Agregar</span>
                        </TertiaryButton>
                    </form>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
