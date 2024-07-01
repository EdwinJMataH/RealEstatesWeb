<script setup>
import { Head } from '@inertiajs/vue3';
import Tab from "@/Components/Tab.vue";
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { ref } from "vue";
import { EditPicture, EditPassword, EditProfile } from "./Partials/index.js";

const items = ref([
    {
        label: 'Generales',
        icon: 'pi pi-user',
        component: EditProfile
    },
    {
        label: 'Contraseña',
        icon: 'pi pi-shield',
        component: EditPassword,
    },
    {
        label: 'Imagen',
        icon: 'pi pi-image',
        component: EditPicture,
    }
]);

let title = ref('Perfil');

</script>

<template>
    <Head :title="title"/>

    <DashboardLayout>
        <template #title>{{ title }}</template>

        <template #content>
            <Tab :tabs="items" />
        </template>

    </DashboardLayout>
</template>

