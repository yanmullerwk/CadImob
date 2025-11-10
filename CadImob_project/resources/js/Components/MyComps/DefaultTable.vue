<template>
  <v-container> <!--Esse card to usando muito-->
    <v-card class="pa-6 " max-width="1500" elevation="8">
      <v-card-title class="d-flex">
        <slot name="title">
          <span class="text-h6">{{ nameTable }}</span>
        </slot>
        <v-spacer></v-spacer>
        <!--area para o botão de cadastro-->
        <slot name="actions"></slot>
      </v-card-title>
      <template v-slot:text>
          <v-text-field
            v-model="search"
            label="Search"
            prepend-icon="mdi-magnify"
            variant="solo"
            hide-details
            single-line
          ></v-text-field>
      </template>
      <v-data-table 
      :headers="headers" 
      :items="items.data" 
      class="elevation-1"
      :items-per-page="10"
      :search="search"
      hide-default-footer>
      
        <template v-slot:item.situacao="{item}">
          <div>
            <slot name="item-situacao" :item="item">
              <div class="flex items-center justify-center gap-1">
                <v-icon v-if="item.situacao == 'ATIVO'" color="green" size="x-small">
                mdi-circle
              </v-icon>
              <v-icon v-else color="red" size="x-small">
                mdi-circle
              </v-icon>
              {{ item.situacao }} 
              </div>
            </slot>
          </div>
        </template>

        <!--area para o botão dos items-->
        <template v-slot:item.actions="{ item }">
          <div class="flex space-x-2">
            <slot name="item-actions" :item="item"></slot>
          </div>
        </template>

        <!--aqui é a paginação-->
        <template v-slot:bottom>
          <v-pagination
            v-model="items.current_page"
            :length="items.last_page"
            rounded="circle"
            @update:model-value="goToPage"
          ></v-pagination>
        </template>
      </v-data-table>
    </v-card>
  </v-container>
</template>

<script setup>
  import { defineProps, ref } from 'vue';
  import { router } from '@inertiajs/vue3';
  //props para table default

  //pesquisa
  const search = ref('');

  const props = defineProps({
    items: {
      type: Object,
      required: true,
    },
    headers:{
      type: Array,
      required: true,
    },
    nameTable:{
      type: String,
      default: 'Tabela',
    },
    routeName: { 
      type: String,
      required: true }
  });

  const goToPage = (page) => {
  router.get(route(props.routeName, { page }))
  }
</script>