<script setup>
import Table from '@/Components/Table.vue';
const columns =  [
    {
        field:  'email',
        header: 'Correo electrónico',
    },
    {
        field:  'name',
        header: 'Nombre'
    },
    {
        field:  'type',
        header: 'Tipo'
    },
    {
        field:  'status',
        header: 'Estatus de cuenta'
    },
    {
        field:  'invitation_date',
        header: 'Fecha de invitación'
    },
    
];

const editProduct = (prod) => {
    console.log(prod);
};
const confirmDeleteProduct = (prod) => {
};
const actions =  [
    {
        icon:  'pi pi-pencil',
        color: 'green',
        callback: editProduct
    },
    {
        icon:  'pi pi-trash',
        color: 'red',
        callback: confirmDeleteProduct
    },
    
];



</script>


<template>
    <Table :columns="columns" :actions="actions"/>
</template>