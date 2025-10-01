<template>
    <v-app>
        <LayoutPaginas>
            <BasePessoasForm :isEdit="true" :pessoa="pessoa" :titleForm="formName"/>
        </LayoutPaginas>
    </v-app>
</template>
<script setup>
import LayoutPaginas from '@/Components/MyComps/LayoutPaginas.vue';
import BasePessoasForm from '@/Components/MyComps/BasePessoasForm.vue';
const props = defineProps({
    pessoa: Object
});

const formName = "Editar"
</script>