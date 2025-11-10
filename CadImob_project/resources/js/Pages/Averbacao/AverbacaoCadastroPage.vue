<template>
    <v-app>
        <LayoutPaginas>
            <AverbacoesForms :imovel="imovel"/>
        </LayoutPaginas>
    </v-app>
</template>
<script setup>
import LayoutPaginas from '@/Components/MyComps/LayoutPaginas.vue';
import AverbacoesForms from '@/Components/Averbacoes/AverbacoesForms.vue';
import { defineProps } from 'vue';
const props = defineProps({
    imovel: {
        type: Object,
        required: true,
    }
})
</script>
