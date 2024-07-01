<script setup>
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';

defineProps({
    tabs: {
        type: Array,
        default: [],
        required: true
    },
});
</script>

<template>
    <TabView lazy :scrollable="true">
        <TabPanel v-for="item in tabs" :key="item.label">
            <template #header>
                <div class="flex items-center gap-2">
                    <span :class="item.icon" />
                    <span class="font-bold whitespace-nowrap">{{ item.label }}</span>
                </div>
            </template>
            <component :is="item.component"></component>
        </TabPanel>
    </TabView>
</template>
