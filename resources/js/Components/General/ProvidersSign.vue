<script lang="ts" setup>
import SecondaryButton from "../ElementsPrimitive/SecondaryButton.vue";
defineProps({
    label: String,
});
</script>

<template>
    <div class="flex gap-2 w-full mb-4">
        <SecondaryButton type="button">
            <!-- google -->
            <a
                href="google-auth/redirect"
                class="w-full h-full flex items-center justify-center gap-4"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    x="0px"
                    y="0px"
                    width="32"
                    height="32"
                    viewBox="0 0 48 48"
                >
                    <path
                        fill="#FFC107"
                        d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"
                    ></path>
                    <path
                        fill="#FF3D00"
                        d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"
                    ></path>
                    <path
                        fill="#4CAF50"
                        d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"
                    ></path>
                    <path
                        fill="#1976D2"
                        d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"
                    ></path>
                </svg>
                <span class="text-extra-md">
                    {{ label }}
                </span>
            </a>
        </SecondaryButton>
        <SecondaryButton type="button">
            <!-- facebook -->
            <a
                href="facebook-auth/redirect"
                class="w-full h-full flex items-center justify-center gap-4"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="32"
                    height="32"
                    viewBox="0 0 16 16"
                >
                    <path
                        fill="#1976D2"
                        fill-rule="evenodd"
                        d="M12 5.5H9v-2a1 1 0 0 1 1-1h1V0H9a3 3 0 0 0-3 3v2.5H4V8h2v8h3V8h2l1-2.5z"
                        clip-rule="evenodd"
                    ></path>
                </svg>
                <span class="text-extra-md">
                    {{ label }}
                </span>
            </a>
        </SecondaryButton>
        <SecondaryButton type="button">
            <a
                href="disqus-auth/redirect"
                class="w-full h-full flex items-center justify-center gap-4"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    enable-background="new 0 0 24 24"
                    viewBox="0 0 24 24"
                    width="32"
                    height="32"
                >
                    <g fill="#2196f3">
                        <path
                            d="m12.339 9.013h-1.292v5.975h1.292c1.897 0 3.157-1.075 3.157-2.971v-.033c0-1.88-1.26-2.971-3.157-2.971z"
                        ></path>
                        <path
                            d="m12.438.25c-6.387 0-11.564 5.261-11.564 11.75 0 1.74.375 3.389 1.043 4.875l-1.917 4.77 4.962-.683c7.435 6.409 19.038 1.09 19.038-8.962 0-6.489-5.177-11.75-11.562-11.75zm6.313 11.716c0 3.39-2.405 5.909-6.526 5.909h-4.351v-11.75h4.417c4.089 0 6.461 2.418 6.461 5.808v.033z"
                        ></path>
                    </g>
                </svg>
                <span class="text-extra-md">
                    {{ label }}
                </span>
            </a>
        </SecondaryButton>
    </div>
</template>
