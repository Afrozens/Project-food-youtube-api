<script lang="ts" setup>
import { ref } from "vue";
import Dropdown from "@/Components/Dropdown.vue";
import changeLanguage from "@/Utils/changeLanguage";
</script>

<template>
    <div>
        <Dropdown>
            <template #trigger>
                <div
                    class="flex gap-1 items-center justify-center cursor-pointer hover:opacity-90 transition-all"
                >
                    <img
                        :src="
                            $i18n.locale === 'es'
                                ? '/icons/es.svg'
                                : '/icons/en.svg'
                        "
                        class="w-4 h-4"
                    />
                    <span class="text-extra-md text-white font-semibold">
                        {{ changeLanguage($i18n.locale) }}
                    </span>
                </div>
            </template>
            <template #content>
                <ul class="w-full">
                    <li
                        v-for="locale in $i18n.availableLocales"
                        :key="`locale-${locale} `"
                        class="cursor-pointer hover:bg-gray-100 transition-all p-2 rounded-lg"
                    >
                        <button
                            :value="locale"
                            @click="$i18n.locale = locale"
                            class="flex gap-1 items-center justify-center px-2"
                        >
                            <img
                                :src="
                                    locale === 'es'
                                        ? '/icons/es.svg'
                                        : '/icons/en.svg'
                                "
                                class="w-4 h-4"
                            />
                            {{ changeLanguage(locale) }}
                        </button>
                    </li>
                </ul>
            </template>
        </Dropdown>
    </div>
</template>
