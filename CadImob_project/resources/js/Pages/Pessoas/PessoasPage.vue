<template>
    <v-app>
        <LayoutPaginas >
            <DefaultTable :headers="headers" :items="pessoas" name-table="Tabela Pessoas">
                <template #actions>
                    <!--Usa aqule slot pra por esse botão-->
                    <v-btn color="primary" prepend-icon="mdi-plus" @click="goToCreate">
                        Cadastrar
                    </v-btn>
                </template>
                <template #item-actions="{ item }">
                    <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
                    <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
                </template>
            </DefaultTable>
        </LayoutPaginas>
    </v-app>
</template>
<script setup>
    import LayoutPaginas from '@/Components/LayoutPaginas.vue';
    import { defineProps, ref } from "vue";
    import { router } from '@inertiajs/vue3';
    import DefaultTable from '@/Components/MyComps/DefaultTable.vue';

    const props = defineProps ({
    pessoas: Array,
    });
    
    const headers = ref([
        { title: 'ID', key: 'id' },
        { title: 'Nome', key: 'nome' },
        { title: 'Email', key: 'email' },
        { title: 'Ações', key: 'actions', sortable: false },
    ]);

    function goToCreate(){
        router.get(route('pessoas.create'));
    }

</script>