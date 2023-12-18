<script lang="ts" setup>
import { onMounted } from "vue";
import FoodVariantIcon from "vue-material-design-icons/FoodVariant.vue";
import FoodVariantOffIcon from "vue-material-design-icons/FoodVariantOff.vue";
import MagnifyIcon from "vue-material-design-icons/Magnify.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/ElementsPrimitive/PrimaryButton.vue";
import CustomSelect from "@/Components/ElementsPrimitive/CustomSelect.vue";

const props = defineProps({
    tags: Object,
});

onMounted(() => {
    console.log(props.tags.data);
});
</script>

<template>
    <AuthenticatedLayout>
        <div
            class="px-14 w-full h-24 pb-14 py-20 bg-primary flex gap-4 items-center justify-between rounded-b-xl"
        >
            <div
                class="w-full flex-col self-center flex-grow gap-4 flex lg:flex-row justify-between"
            >
                <div class="relative w-full self-end">
                    <div
                        class="absolute inset-y-0 left-4 flex items-center pr-3 pointer-events-none z-40"
                    >
                        <FoodVariantIcon :size="30" fillColor="#4BB543" />
                    </div>
                    <CustomSelect
                        :options="tags.data[name]"
                        label="¿Qué debe contener?"
                        title="yes_ingredient"
                        :is-required="true"
                        :is-multiple="true"
                    >
                    </CustomSelect>
                </div>
                <div class="relative w-full self-end">
                    <div
                        class="absolute inset-y-0 left-4 flex items-center pr-3 pointer-events-none z-40"
                    >
                        <FoodVariantOffIcon :size="30" fillColor="#FF000a" />
                    </div>
                    <CustomSelect
                        label="¿Qué no debe contener?"
                        title="not_ingredient"
                        :is-required="true"
                        :is-multiple="true"
                    >
                    </CustomSelect>
                </div>
            </div>
            <PrimaryButton class="w-28 h-10 bg-sky-500">
                <MagnifyIcon />
                Buscar
            </PrimaryButton>
        </div>
    </AuthenticatedLayout>
</template>
