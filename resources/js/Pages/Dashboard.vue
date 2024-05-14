<script setup>
import { Head } from '@inertiajs/vue3';
import { ref } from "vue";
import DashboardLayout from '@/Layouts/DashboardLayout.vue';

let title = ref('Dashboard');

</script>

<template>
    <Head :title="title"/>

    <DashboardLayout>
        <template #title>{{ title }}</template>

        <template #content>
            ESTE ES EL Dashboard

        </template>

    </DashboardLayout>
</template>