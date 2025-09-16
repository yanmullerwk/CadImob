<template>
<v-navigation-drawer v-model='isDrawerOpen'>
    <v-list>
        <v-list-item prepend-icon="mdi-home-city-outline" class="text-h5">
                    CadImob
        </v-list-item>
        <v-list-item title="Home"></v-list-item>
        <Link :href="route('pessoas.index')">
            <v-list-item prepend-icon="mdi-account-cowboy-hat" title="Pessoas"></v-list-item>
        </Link>
        <v-list-item title="Imóveis"></v-list-item>
    </v-list>
  
</v-navigation-drawer>
    <v-app-bar>
        <template v-slot:prepend>
            <v-app-bar-nav-icon @click = "isDrawerOpen = !isDrawerOpen"></v-app-bar-nav-icon>
        </template>
    </v-app-bar>
</template>
<script setup>
    import {ref} from 'vue';
    import { Link } from "@inertiajs/vue3";
    const isDrawerOpen = ref(false);
</script>