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

                    <v-btn 
                    color="info"
                    size="small"
                    class="mr-2"
                    @click="goToEdit(item)">
                        <v-icon small class="mr-2">mdi-pencil</v-icon>
                        Editar
                    </v-btn>
                    <v-btn 
                    color="error" 
                    size="small"
                    class="mr-2"
                    @click="deleteItem(item)">
                        <v-icon>mdi-delete</v-icon>
                        Deletar
                    </v-btn>
                </template>
            </DefaultTable>
        </LayoutPaginas>
    </v-app>
</template>
<script setup>
    import LayoutPaginas from '@/Components/MyComps/LayoutPaginas.vue';
    import { computed, defineProps, ref } from "vue";
    import { router, Link } from '@inertiajs/vue3';
    import DefaultTable from '@/Components/MyComps/DefaultTable.vue';

    //essas props vem la do controller
    const props = defineProps ({
    pessoas: Object,
    });

    const headers = ref([
        { title: 'ID', key: 'id' },
        { title: 'Nome', key: 'nome' },
        { title: 'cpf', key: 'cpf' },
        { title: 'Data Nasc.', key: 'dataNascimento' },
        { title: 'Sexo', key: 'sexo'},
        { title: 'Ações', key: 'actions', sortable: false },
    ]);
    
    function goToCreate(){
        router.get(route('pessoas.create'));
    }

    function goToEdit(item){
        router.get(route('pessoas.edit', item.id))
    }

    function deleteItem(item) {
    if (!confirm(`Tem certeza que deseja excluir?`)) return;

    router.delete(route('pessoas.destroy', item.id), {
        onSuccess: () => {
            alert('Item excluído com sucesso!');
        },
        onError: (errors) => {
            console.error(errors);
            alert('Erro ao excluir item.');
        }
    }); 
    }

</script>