<script setup lang="ts">
import { computed } from "vue";

const emit = defineEmits(["update:checked"]);

const props = defineProps<{
    checked: boolean;
    value?: any;
}>();

const proxyChecked = computed({
    get() {
        return props.checked;
    },

    set(val) {
        emit("update:checked", val);
    },
});
</script>

<template>
    <label class="container w-5">
        <input type="checkbox" :value="value" v-model="proxyChecked" />
        <svg viewBox="0 0 64 64" height="1em" width="1em">
            <path
                d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16"
                pathLength="575.0541381835938"
                class="path"
            ></path>
        </svg>
    </label>
</template>

<style scoped>
.container {
    cursor: pointer;
}

.container input {
    display: none;
}

.container svg {
    overflow: visible;
}

.path {
    fill: none;
    stroke: black;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
    transition: stroke-dasharray 0.5s ease, stroke-dashoffset 0.5s ease;
    stroke-dasharray: 241 9999999;
    stroke-dashoffset: 0;
}

.container input:checked ~ svg .path {
    stroke-dasharray: 70.5096664428711 9999999;
    stroke-dashoffset: -262.2723388671875;
}
</style>
