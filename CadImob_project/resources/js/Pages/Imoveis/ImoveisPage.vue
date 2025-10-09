<template>
    <Head title="Imoveis"/>
    <v-app>
        <LayoutPaginas>
            <DefaultTable :headers="headers" :items="imoveis" name-table="Tabela Imoveis">
                <template #actions>
                    <!-- Botão de cadastrar -->
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
                        @click="openConfirm(item)">
                        <v-icon>mdi-delete</v-icon>
                        Deletar
                    </v-btn>
                </template>
            </DefaultTable>

            <!-- Dialogo de confirmação -->
            <v-dialog v-model="showConfirm" max-width="400">
                <v-card>
                    <v-card-title class="text-h6">Confirmar exclusão</v-card-title>
                    <v-card-text>
                        Tem certeza que deseja excluir o item <b>{{ currentItem?.nome }}</b>?
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn text @click="showConfirm = false">Cancelar</v-btn>
                        <v-btn color="red" @click="deleteItem">Excluir</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>

            <!-- Dialogo de sucesso -->
            <v-dialog v-model="showSuccess" max-width="400">
                <v-card>
                    <v-card-title class="text-h6">Sucesso!</v-card-title>
                    <v-card-text>
                        O item foi excluído com sucesso.
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" @click="showSuccess = false">Ok</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </LayoutPaginas>
    </v-app>
</template>
<script setup>
import LayoutPaginas from '@/Components/MyComps/LayoutPaginas.vue';
import { ref, defineProps} from "vue";
import { router, Head } from '@inertiajs/vue3';
import DefaultTable from '@/Components/MyComps/DefaultTable.vue';

const showConfirm = ref(false)
const showSuccess = ref(false)
const currentItem = ref(null)


const props = defineProps({
    imoveis: Object
})

const headers = ref([
    { title: 'ins. municipal', key: 'id' },
    { title: 'Tipo', key: 'tipo' },
    { title: 'Logradouro', key: 'logradouro' },
    { title: 'Numero', key: 'numero'},
    { title: 'Bairro', key: 'bairro'},
    { title: 'Complemento', key: 'complemento'},
    { title: 'Contribuinte', key: 'contribuinte_id'},
    { title: 'Ações', key: 'actions', sortable: false },
]);


function goToCreate(){
    router.get(route('imoveis.create'));
}

function goToEdit(item){
    router.get(route('imoveis.edit', item.id))
}

function openConfirm(item) {
    currentItem.value = item
    showConfirm.value = true
}

function deleteItem() {
    router.delete(route('imoveis.destroy', currentItem.value.id), {
        onSuccess: () => {
            showConfirm.value = false
            showSuccess.value = true
        },
        onError: (errors) => {
            console.error(errors)
            alert('Erro ao excluir item.')
        }
    }); 
}
</script>