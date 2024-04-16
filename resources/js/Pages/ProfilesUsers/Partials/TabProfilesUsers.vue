<script setup>
import { ref } from "vue";
import TableUsers from "./TableUsers.vue";
import TableProfiles from "./TableProfiles.vue";
const items = ref([
    {
        label: 'Usuarios',
        icon: 'pi pi-users',
        component: TableUsers
    },
    {
        label: 'Perfiles',
        icon: 'pi pi-user',
        component: TableProfiles,
    }

]);

</script>


<template>
    <div class="max-w-7xl mx-auto px-4 lg:px-8 min-h-96 ">
        <div class="rounded-lg p-6 lg:p-8 bg-white">
            <TabView lazy>
                <TabPanel v-for="item in items" :key="item.label">
                    <template #header>
                        <div class="flex items-center gap-2">
                            <span :class="item.icon" />
                            <span class="font-bold whitespace-nowrap">{{ item.label }}</span>
                        </div>
                    </template>
                    <component :is="item.component"></component>
                </TabPanel>
            </TabView>
        </div>
    </div>
</template>