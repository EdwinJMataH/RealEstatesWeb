<script setup>
import { Head } from '@inertiajs/vue3';
import { ref } from "vue";
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
// import { TabProfilesUsers } from '@/Pages/ProfilesUsers/Partials';
import UserIndex from '@/Pages/ProfilesUsers/UserIndex.vue';

let title = ref('Usuarios');

</script>

<template>
    <Head :title="title"/>

    <DashboardLayout>
        <template #title>{{ title }}</template>

        <template #content>
            <UserIndex/>
        </template>

    </DashboardLayout>
</template>