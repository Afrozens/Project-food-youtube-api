<script lang="ts" setup>
import { onMounted, reactive, ref } from "vue";
import { Head } from "@inertiajs/vue3";
import FoodVariantIcon from "vue-material-design-icons/FoodVariant.vue";
import FoodVariantOffIcon from "vue-material-design-icons/FoodVariantOff.vue";
import MagnifyIcon from "vue-material-design-icons/Magnify.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/ElementsPrimitive/PrimaryButton.vue";
import CustomSelect from "@/Components/ElementsPrimitive/CustomSelect.vue";

const props = defineProps({
    tags: Object,
});

const form = reactive({
    yes: ref([]),
    not: ref([]),
});

const handleSubmit = () => {};
</script>

<template>
    <Head title="Inicio" />

    <AuthenticatedLayout>
        <header
            class="px-14 w-full pb-14 py-20 bg-primary flex gap-4 items-center flex-col md:flex-row justify-between rounded-b-xl"
        >
            <div
                class="w-full flex-col self-center pb-4 md:pb-0 flex-grow gap-4 flex lg:flex-row justify-between"
            >
                <div class="relative w-full self-end">
                    <div
                        class="absolute inset-y-0 left-4 flex items-center pr-3 pointer-events-none z-40"
                    >
                        <FoodVariantIcon :size="30" fillColor="#4BB543" />
                    </div>
                    <CustomSelect
                        :model-value="form.yes"
                        @update:modelValue="form.yes = $event"
                        :options="tags && tags.data"
                        label="¿Qué debe contener?"
                        title="name"
                        :is-required="true"
                        :is-multiple="true"
                    />
                </div>
                <div class="relative w-full self-end">
                    <div
                        class="absolute inset-y-0 left-4 flex items-center pr-3 pointer-events-none z-40"
                    >
                        <FoodVariantOffIcon :size="30" fillColor="#FF000a" />
                    </div>
                    <CustomSelect
                        :model-value="form.not"
                        @update:modelValue="form.not = $event"
                        :options="tags && tags.data"
                        label="¿Qué no debe contener?"
                        title="name"
                        :is-required="true"
                        :is-multiple="true"
                    />
                </div>
            </div>
            <PrimaryButton
                @click.prevent="handleSubmit"
                class="w-28 h-10 bg-sky-500"
            >
                <MagnifyIcon />
                Buscar
            </PrimaryButton>
        </header>

        <section class="w-full"></section>
    </AuthenticatedLayout>
</template>
