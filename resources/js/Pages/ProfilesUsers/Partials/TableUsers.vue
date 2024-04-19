<script setup>
import { ref } from "vue";
import Table from "@/Components/Table.vue";
import DialogNewUser from "./DialogNewUser.vue";

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
        field: "type",
        header: "Tipo",
    },
    {
        field: "status",
        header: "Estatus de cuenta",
    },
    {
        field: "invitation_date",
        header: "Fecha de Invitación",
    },
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
</script>

<template>
    <DialogNewUser
        :is_dialog_visible="is_dialog_new_user"
        @close:dialog="is_dialog_new_user = false"
    />
    <Table
        :columns="columns"
        :actions="actions"
        @open:dialog-new="is_dialog_new_user = true"
    />
</template>
