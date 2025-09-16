<template>
    <v-app>
        <LayoutPaginas :test="props.test"/>
        <!--é assimm que seria se eu definise um componente para tabela-->
        <!--Aqui vai os componentes de tabela-->
    </v-app>
</template>
<script setup>
    import LayoutPaginas from '@/Components/LayoutPaginas.vue';
    import { defineProps } from "vue";

    const props = defineProps ({
    test: Array,
})
</script>