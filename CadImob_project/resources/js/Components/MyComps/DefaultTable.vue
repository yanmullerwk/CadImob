<template>
  <v-container> <!--Esse card to usando muito-->
    <v-card class="pa-6 " width="1000" elevation="8">
      <v-card-title class="d-flex">
        <slot name="title">
          <span class="text-h6">{{ nameTable }}</span>
        </slot>
        <v-spacer></v-spacer>
        <!--area para o botão de cadastro-->
        <slot name="actions"></slot>
      </v-card-title>
      <v-data-table :headers="headers" :items="items" class="elevation-1">
        <!--area para o botão dos items-->
        <template v-slot:item.actions="{ item }">
          <slot name="item-actions" :item="item"></slot>
        </template>
      </v-data-table>
    </v-card>
  </v-container>
</template>

<script setup>
  //props para table default
  const props = defineProps({
    items: {
      type: Array,
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
  });
</script>