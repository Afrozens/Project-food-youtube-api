<script lang="ts" setup>
// @ts-ignore - iconos sin typings
import ChevronLeftIcon from "vue-material-design-icons/ChevronLeft.vue";
// @ts-ignore - iconos sin typings
import ChevronRightIcon from "vue-material-design-icons/ChevronRight.vue";

defineProps({
    length: Number,
    current: Number,
});

const emits = defineEmits(["next"]);

const handleNext = (page: number) => {
    emits("next", page);
};
</script>

<template>
    <nav class="mx-auto w-full flex justify-center items-center mb-4">
        <ul class="flex items-center -space-x-px h-10 text-base shadow-md">
            <li v-if="current && current > 1">
                <button
                    @click="handleNext((current as number) - 1)"
                    class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700"
                >
                    <ChevronLeftIcon />
                    <span class="md:hidden font-semibold text-lg"
                        >Anterior</span
                    >
                </button>
            </li>
            <li v-for="index in length" :key="index">
                <button
                    @click="handleNext(index)"
                    class="hidden md:flex items-center justify-center px-4 h-10 leading-tight font-medium border border-gray-300 hover:bg-gray-100 hover:text-gray-700"
                    :class="
                        current === index
                            ? 'bg-primary text-white'
                            : 'bg-white text-gray-600'
                    "
                >
                    {{ index }}
                </button>
            </li>

            <li v-if="current !== length">
                <button
                    @click="handleNext((current as number) + 1)"
                    class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700"
                >
                    <span class="md:hidden font-semibold text-lg"
                        >Siguiente</span
                    >
                    <ChevronRightIcon />
                </button>
            </li>
        </ul>
    </nav>
</template>
