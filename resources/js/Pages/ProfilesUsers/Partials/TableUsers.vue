<script setup>
import { ref, onMounted } from "vue";
import Table from "@/Components/Table.vue";
import DialogNewUser from "./DialogNewUser.vue";
import useUser from "@/Composables/useUser.js";
const { all, users } = useUser();

let is_dialog_new_user = ref(false);
const columns = [
    {
        field: "email",
        header: "Correo electrónico",
    },
    {
        field: "name",
        header: "Nombre",
    },
    {
        field: "profile",
        header: "Tipo de perfil",
    },
    {
        field: "permission",
        header: "Tipo de permiso",
    },
    // {
    //     field: "status",
    //     header: "Estatus de cuenta",
    // },
    // {
    //     field: "invitation_date",
    //     header: "Fecha de Invitación",
    // },
];

const editProduct = (prod) => {
    console.log(prod);
};
const confirmDeleteProduct = (prod) => {};

const actions = [
    {
        icon: "pi pi-pencil",
        color: "green",
        callback: editProduct,
    },
    {
        icon: "pi pi-trash",
        color: "red",
        callback: confirmDeleteProduct,
    },
];
onMounted(() => {
    all();
});
</script>

<template>
    <DialogNewUser
        :is_dialog_visible="is_dialog_new_user"
        @close:dialog="is_dialog_new_user = false"
    />
    <Table
        :data="users"
        :columns="columns"
        :actions="actions"
        @open:dialog-new="is_dialog_new_user = true"
    />
</template>
