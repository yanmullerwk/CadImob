<template>
    <LayoutPaginas>
        <BaseImoveisForm :title-form="nomeForm" :pessoas="pessoas"/>
    </LayoutPaginas>
</template>
<script setup>
import BaseImoveisForm from '@/Components/MyComps/BaseImoveisForm.vue';
import LayoutPaginas from '@/Components/MyComps/LayoutPaginas.vue';
import { defineProps } from 'vue';
const nomeForm = "Cadastrar Imovel"
const props = defineProps({
    pessoas: Array,
})
</script>