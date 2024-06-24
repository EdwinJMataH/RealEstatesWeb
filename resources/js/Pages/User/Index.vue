<script setup>
import { Head } from '@inertiajs/vue3';
import { ref } from "vue";
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import TableUsers from "./Partials/TableUsers.vue";

let title = ref('Usuarios');

</script>

<template>
    <Head :title="title"/>

    <DashboardLayout>
        <template #title>{{ title }}</template>

        <template #content>
            <TableUsers />
        </template>

    </DashboardLayout>
</template>

