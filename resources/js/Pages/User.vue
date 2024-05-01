<script setup>
import { Head } from '@inertiajs/vue3';
import { ref } from "vue";
import AuthLayout from '@/Layouts/AuthLayout.vue';
// import { TabProfilesUsers } from '@/Pages/ProfilesUsers/Partials';
import UserIndex from '@/Pages/ProfilesUsers/UserIndex.vue';

let title = ref('Usuarios');

</script>

<template>
    <Head :title="title"/>

    <AuthLayout>
        <template #title>{{ title }}</template>

        <template #content>
            <UserIndex/>
        </template>

    </AuthLayout>
</template>