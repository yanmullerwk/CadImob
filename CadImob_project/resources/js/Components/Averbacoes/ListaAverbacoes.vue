<template>
  <v-card class="p-4 rounded-lg shadow-sm" elevation="8">
    <div class="pa-4">
        <div class="flex justify-between items-center mb-4">
          <v-card-title>
            Averbações
          </v-card-title>
          <v-btn color="black" variant="tonal" @click="goToCreate" class="flex items-center gap-2">
            <v-icon>mdi-plus</v-icon>
            Cadastrar
          </v-btn>
        </div>
      <!-- Topo com botão -->
      

      <!-- Corpo do card -->
      <div class="m-4 grid gap-4">
        <v-card
          v-for="av in averbacoes.data"
          :key="av.id"
          class="p-4"
        >
          <div class="flex justify-between border-l-4 border-red-500">
            <div class="p-4">
              <p class="font-semibold">{{formatEventType(av.eventType) }}</p>
              <p class="text-sm text-gray-600">{{ av.description }}</p>
              <p class="text-xs text-gray-500">Medida: {{ av.measure ?? '—' }}</p>
            </div>
            <p class="text-xs text-gray-400">{{ av.data}}</p>
          </div>
        </v-card>
      </div>

      <!-- Paginação -->
      <div class="flex justify-center mt-4">
        <v-pagination
          v-model="page"
          :length="averbacoes.last_page"
          @update:model-value="goToPage"
        />
      </div>
    </div>
  </v-card>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import { ref, } from 'vue';
import { defineProps } from 'vue';

const props = defineProps({
  imovel: { type: Object, required: true },
  averbacoes: { type: Object, required: true },
});

const formatEventType = (type) => {
  switch(type){
    case "Aumento": return "Aumento Área Construída"
    case "Reducao": return "Redução Área Construída"
    case "Observacao": return "Observação"
    case "Cancelamento": return "Cancelamento"
    case "Reativacao": return "Reativação"
    default: return type;
  }
}

const page = ref(props.averbacoes.current_page);

const goToCreate = () => {
  router.get(route('averbacao.create', props.imovel.id));
};

const goToPage = (p) => {
  router.get(route('imoveis.edit', props.imovel.id), { page: p }, { preserveScroll: true });
};
</script>
