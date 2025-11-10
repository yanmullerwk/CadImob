<template>
  <Head title="Edição"/>
  <v-app>
    <LayoutPaginas>
      <div class="w-full flex justify-start">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full max-w-[1600px] mx-auto">
          <!-- Coluna 1 -->
          <BaseImoveisForm
            :isEdit="true"
            :pessoas="pessoas"
            :documents="documents"
            :imovel="imovel"
            :titleForm="formName"
          />

          <!-- Coluna 2 -->
          
          <ListaAverbacoes :imovel="imovel" :averbacoes="averbacoes"/>
          
        </div>
      </div>
    </LayoutPaginas>
  </v-app>
</template>

<script setup>
import LayoutPaginas from '@/Components/MyComps/LayoutPaginas.vue';
import BaseImoveisForm from '@/Components/MyComps/BaseImoveisForm.vue';
import { Head } from '@inertiajs/vue3';
import ListaAverbacoes from '@/Components/Averbacoes/ListaAverbacoes.vue';

const props = defineProps({
  pessoas: Array,
  imovel: Object,
  documents: Array,
  averbacoes: Object,
});

const formName = "Editar";
</script>
