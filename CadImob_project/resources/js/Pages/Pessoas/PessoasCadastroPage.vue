<template>
    <v-app>
        <LayoutPaginas>
            <BasePessoasForm :title-form="nomeForm"/>
        </LayoutPaginas>
    </v-app>
</template>

<script setup>
import LayoutPaginas from '@/Components/MyComps/LayoutPaginas.vue';
import BasePessoasForm from '@/Components/MyComps/BasePessoasForm.vue';
const nomeForm = "Cadastrar pessoa"

</script>