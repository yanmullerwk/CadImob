<template>
    <Head title="Edição"/>
    <v-app>
        <LayoutPaginas>
            <BaseImoveisForm :isEdit="true" :pessoas="pessoas" :imovel="imovel" :titleForm="formName"/>
        </LayoutPaginas>
    </v-app>
</template>
<script setup>
import LayoutPaginas from '@/Components/MyComps/LayoutPaginas.vue';
import BaseImoveisForm from '@/Components/MyComps/BaseImoveisForm.vue';
import { Head } from '@inertiajs/vue3';
const props = defineProps({
    pessoas: Array,
    imovel: Object
});

const formName = "Editar"
</script>