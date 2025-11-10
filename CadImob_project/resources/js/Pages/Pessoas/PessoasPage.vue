<template>
    <Head title="Pessoas"/>
    <v-app>
        <LayoutPaginas>
            <DefaultTable :headers="headers" :items="pessoasFormatadas" name-table="Tabela Pessoas" :route-name="routeName">
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
import { ref, defineProps, computed } from "vue";
import { router, Head } from '@inertiajs/vue3';
import DefaultTable from '@/Components/MyComps/DefaultTable.vue';

const showConfirm = ref(false)
const showSuccess = ref(false)
const currentItem = ref(null)
const routeName = 'pessoas.index'
// props do controller
const props = defineProps({
  pessoas: Object,
});

// Cria uma propriedade computada (reativa) chamada 'pessoasFormatadas'.
// Ela depende de 'props.pessoas' e será atualizada automaticamente
// sempre que o valor de 'props.pessoas' mudar (ex: ao paginar ou atualizar a lista).
const pessoasFormatadas = computed(() => ({
    //copia todas as propriedades originais do objeto 'props.pessoas'
    // Isso garante que a paginação (meta, links, etc.) continue funcionando normalmente.
  ...props.pessoas,

  
  // Agora reescrevemos apenas o campo 'data'
  // 'data' é o array com as pessoas vindas do back-end.
  // Usamos 'map' para percorrer cada pessoa e criar uma nova lista formatada.
  data: props.pessoas.data.map(p => ({
    // Espalhamos os dados originais da pessoa (id, nome, cpf, etc.)
    ...p,
    // Formatadores
    cpf: formatCPF(p.cpf),
    dataNascimento: formatData(p.dataNascimento)
  }))
}))

function formatCPF(cpf) {
  if (!cpf) return ''
  return cpf.replace(/^(\d{3})(\d{3})(\d{3})(\d{2})$/, '$1.$2.$3-$4')
}



function formatData(data) {
  if (!data) return ''
  const d = new Date(data)
  return d.toLocaleDateString('pt-BR', { timeZone: 'UTC' })
}

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

function openConfirm(item) {
    currentItem.value = item
    showConfirm.value = true
}

function deleteItem() {
    router.delete(route('pessoas.destroy', currentItem.value.id), {
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
