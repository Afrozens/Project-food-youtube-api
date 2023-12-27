<script lang="ts" setup>
import { ref } from "vue";

const props = withDefaults(
    defineProps<{
        src?: string | undefined;
        name: string;
        isRounded: boolean;
        size: string;
    }>(),
    {
        src: undefined,
        name: "",
        size: "40",
        isRounded: false,
    }
);

const withError = ref(false);
const isHidden = ref(false);

const lazyOptions = ref({
    src: props.src,
    lifecycle: {
        loading: () => {
            isHidden.value = true;
        },
        error: () => {
            withError.value = true;
        },
        loaded: () => {
            isHidden.value = false;
        },
    },
});

const colors = [
    "#001219",
    "#005f73",
    "#0a9396",
    "#94d2bd",
    "#e9d8a6",
    "#ee9b00",
    "#ca6702",
    "#bb3e03",
    "#ae2012",
    "#9b2226",
];
let color: string;
if (typeof props.name === "string") {
    color = colors[props.name.charCodeAt(0) % colors.length];
}

let nameSplit: any = props.name.split(" ");

nameSplit = nameSplit.map((name: string) => name.replace(/[^a-zA-Z0-9]/g, ""));

nameSplit = nameSplit.filter(
    (name: string | undefined) => name !== "" && name !== undefined
);

if (nameSplit.length === 1) {
    nameSplit = nameSplit[0][0];
} else {
    nameSplit = nameSplit[0][0] + nameSplit[1][0];
}
</script>

<template>
    <div
        v-if="src && !withError"
        :class="size && `w-[${size}px] h-[${size}px]`"
        class="self-start parent transition rounded-md select-none relative"
    >
        <img
            v-lazy="{
                src: lazyOptions.src,
                lifecycle: lazyOptions.lifecycle,
            }"
            :alt="name"
            class="h-full w-full bg-gray-100/50 transition object-cover"
            :class="[
                isRounded ? 'rounded-full' : 'rounded-[20%]',
                isHidden
                    ? ' animate-pulse blur-sm  opacity-50'
                    : ' animate-none blur-none bg-transparent opacity-100',
            ]"
            lazy="loading"
        />
    </div>

    <div
        v-else
        :style="{ backgroundColor: color }"
        class="relative parent self-start"
        :class="[
            size && `w-[${size}px] h-[${size}px]`,
            isRounded ? 'rounded-full' : 'rounded-md',
        ]"
    >
        <p
            class="flex h-full items-center justify-center text-2xl font-bold text-white"
        >
            {{ nameSplit }}
        </p>
    </div>
</template>

<style scoped>
.parent:hover .btn {
    visibility: visible;
    opacity: 1;
}

.btn {
    visibility: hidden;
    opacity: 0;
}
</style>
