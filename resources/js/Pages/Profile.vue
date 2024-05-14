<script setup>
import { Head } from '@inertiajs/vue3';
import { ref } from "vue";
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { UpdatePassword, UpdatePicture, UpdateProfile } from '@/Pages/Profiles/Partials';

let title = ref('Perfil');

</script>

<template>
    <Head :title="title"/>

    <DashboardLayout>
        <template #title>{{ title }}</template>

        <template #content>
            <UpdateProfile></UpdateProfile>

            <UpdatePassword></UpdatePassword>

            <UpdatePicture></UpdatePicture>
        </template>

    </DashboardLayout>
</template>