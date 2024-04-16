<script setup>
import Table from '@/Components/Table.vue';

const editProduct = (prod) => {
    console.log(prod);
};
const confirmDeleteProduct = (prod) => {
};

const columns =  [
    {
        field:  'name',
        header: 'Nombre'
    },
    {
        field:  'description',
        header: 'Descripción'
    },
    {
        field:  'Fecha de Modificación',
        header: 'image'
    },
    
];

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