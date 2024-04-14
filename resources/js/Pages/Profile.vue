<script setup>
import { Head } from '@inertiajs/vue3';
import { ref } from "vue";
import AuthLayout from '@/Layouts/AuthLayout.vue';
import { UpdatePassword, UpdatePicture, UpdateProfile } from '@/Pages/Profiles/Partials';

let title = ref('Perfil');

</script>

<template>
    <Head :title="title"/>

    <AuthLayout>
        <template #title>{{ title }}</template>

        <template #content>
            <UpdateProfile></UpdateProfile>

            <UpdatePassword></UpdatePassword>

            <UpdatePicture></UpdatePicture>
        </template>

    </AuthLayout>
</template>