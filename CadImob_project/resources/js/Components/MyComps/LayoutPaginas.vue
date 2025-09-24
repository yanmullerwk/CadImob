<template>
    <v-layout>
        <v-navigation-drawer v-model='isDrawerOpen'>
            <v-list>
                <v-list-item prepend-icon="mdi-home-city-outline" class="text-h5">
                        CadImob
                </v-list-item>

            <!--colocar o link pra home-->
                <v-list-item prepend-icon="mdi-home" title="Home"></v-list-item>

            <!--vvv Aqui linka para table pessoas vvv-->
                <Link :href="route('pessoas.index')">
                    <v-list-item prepend-icon="mdi-clipboard-account-outline" title="Pessoas"></v-list-item>
                </Link>
            <!--^^^ Aqui linka para table pessoas ^^^^-->
        
                <v-list-item prepend-icon="mdi-home-group" title="Imóveis"></v-list-item>
                <v-list-item prepend-icon="mdi-card-account-details" title="Usuários"></v-list-item>
                <v-list-item prepend-icon="mdi-cog" title="Configurações"></v-list-item>
            </v-list>
        </v-navigation-drawer>
        <v-app-bar>
            <template v-slot:prepend>
                <v-app-bar-nav-icon @click = "isDrawerOpen = !isDrawerOpen"></v-app-bar-nav-icon>
            </template>
        </v-app-bar>
    <!--esse é o meu main com um card alinhado no centro da pagina-->
        <v-main>
            <v-container class="d-flex justify-center align-center" style="min-height: calc(100vh - 64px);">
                <slot/>
            </v-container>
        </v-main>
    </v-layout>
    
</template>
<script setup>
    import {ref} from 'vue';
    import { Link } from "@inertiajs/vue3";
    const isDrawerOpen = ref(false);
    
</script>