<script setup>
import { Head } from '@inertiajs/vue3';
import { ref } from "vue";
import AuthLayout from '@/Layouts/AuthLayout.vue';
import { TabProfilesUsers } from '@/Pages/ProfilesUsers/Partials';

let title = ref('Perfiles y Usuarios');

</script>

<template>
    <Head :title="title"/>

    <AuthLayout>
        <template #title>{{ title }}</template>



        <template #content>
            <TabProfilesUsers>
            </TabProfilesUsers>
        </template>

    </AuthLayout>
</template>