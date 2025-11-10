<template>
  <v-app>
    <!-- Drawer lateral -->
    <v-navigation-drawer
      v-model="isDrawerOpen"
      app
      color="grey-lighten-4"
      width="260"
    >
      <v-list density="comfortable">
        <v-list-item prepend-icon="mdi-home-city-outline" title="CadImob" class="text-h6"></v-list-item>
        <v-divider></v-divider>

        <Link :href="route('home.index')" class="">
          <v-list-item prepend-icon="mdi-home" title="Home" class="hover:bg-gray-300 cursor-pointer transition">
          </v-list-item>
        </Link>

        <Link :href="route('pessoas.index')">
          <v-list-item prepend-icon="mdi-clipboard-account-outline" title="Pessoas" class="hover:bg-gray-300 cursor-pointer transition"></v-list-item>
        </Link>

        <Link :href="route('imoveis.index')">
          <v-list-item prepend-icon="mdi-home-group" title="Imóveis" class="hover:bg-gray-300 cursor-pointer transition"></v-list-item>
        </Link>

        <Link :href="route('users.index')">
          <v-list-item prepend-icon="mdi-card-account-details" title="Usuários" class="hover:bg-gray-300 cursor-pointer transition"></v-list-item>
        </Link>
        
        <Link :href="route('auditoria.index')">
          <v-list-item prepend-icon="mdi-cog" title="Auditorias" class="hover:bg-gray-300 cursor-pointer transition"></v-list-item>
        </Link>
        
      </v-list>
    </v-navigation-drawer>

    <!-- Top bar -->
    <v-app-bar app color="white" elevation="2" class="px-4" >
      <template #prepend>
        <v-app-bar-nav-icon
          @click="isDrawerOpen = !isDrawerOpen"
        ></v-app-bar-nav-icon>
      </template>

      <v-spacer></v-spacer>
      <UserMenu/>
    </v-app-bar>

    <!-- Conteúdo principal -->
    <v-main>
      <v-container
        fluid
        class="pa-2 d-flex justify-center align-center bg-grey-lighten-5"
        style="min-height: calc(100vh - 64px);"
      >
        <slot />
      </v-container>
    </v-main>
  </v-app>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import UserMenu from './UserMenu.vue'

const isDrawerOpen = ref(false)
</script>
