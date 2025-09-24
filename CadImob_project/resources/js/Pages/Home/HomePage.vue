<template>
    <v-app>
        <LayoutPaginas/>
    </v-app>
</template>
<script setup>

    import LayoutPaginas from '@/Components/MyComps/LayoutPaginas.vue';
   
    import { defineProps } from "vue";

    const props = defineProps ({
    test: Array,
})
</script>