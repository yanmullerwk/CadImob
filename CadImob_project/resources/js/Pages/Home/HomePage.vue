<template>
    <v-app>
        <LayoutPaginas>
            <h1 class="text-h4">Bem Vindo à CadIMob</h1>
        </LayoutPaginas>
    </v-app>
</template>
<script setup>

    import LayoutPaginas from '@/Components/MyComps/LayoutPaginas.vue';

   
    import { defineProps } from "vue";

    const props = defineProps ({
    test: Array,
})
</script>