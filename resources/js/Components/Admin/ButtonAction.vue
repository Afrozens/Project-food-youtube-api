<script lang="ts" setup>
import { Dropdown, Menu, MenuItem } from "ant-design-vue";
// @ts-ignore - iconos sin typings
import SettingsHelperIcon from "vue-material-design-icons/SettingsHelper.vue";
</script>

<template>
    <Dropdown :trigger="['click']" placement="bottomLeft">
        <button
            :type="'button'"
            class="font-medium rounded-lg hover:bg-[#a7a5a524] transition-all text-sm w-12 pl-5 py-2.5 mb-2"
        >
            <SettingsHelperIcon
                class="rotate-90 text-center flex items-center justify-center hover:text-white"
                fillColor="000"
                :size="25"
            />
        </button>
        <template #overlay>
            <Menu
                class="bg-white divide-y divide-gray-100 rounded-lg shadow w-40 text-sm text-gray-700 flex flex-col text-start"
            >
                <slot name="item-action" />
            </Menu>
        </template>
    </Dropdown>
</template>
