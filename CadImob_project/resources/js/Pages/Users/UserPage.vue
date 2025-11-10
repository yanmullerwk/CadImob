<template>
    <Head title="Users"/>
    <v-app>
        <LayoutPaginas>
            <DefaultTable :headers="headers" :items="formatUsers" name-table="Tabela Usuarios" :route-name="routeName">
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
                </template>
            </DefaultTable>
        </LayoutPaginas>
    </v-app>
</template>
<script setup>
import LayoutPaginas from '@/Components/MyComps/LayoutPaginas.vue';
import { ref, defineProps} from "vue";
import { router, Head } from '@inertiajs/vue3';
import DefaultTable from '@/Components/MyComps/DefaultTable.vue';
import { comma } from 'postcss/lib/list';
import { computed } from 'vue';
import { data } from 'autoprefixer';

const showConfirm = ref(false)
const showSuccess = ref(false)
const currentItem = ref(null)
const routeName = 'users.index'
// props do controller
const props = defineProps({
  users: Object,
});

const headers = ref([
    { title: 'ID', key: 'id' },
    { title: 'Nome', key: 'name' },
    { title: 'E-mail', key: 'email' },
    { title: 'Perfil', key: 'profile' },
    { title: 'Ativo', key: 'activate'},
    { title: 'Ações', key: 'actions', sortable: false },
]);

function goToCreate(){
    router.get(route('user.create'));
}

function goToEdit(item){
    router.get(route('user.edit', item.id))
}

const formatUsers = computed(()=>({
    ...props.users,

    data: props.users.data.map(u => ({
        ...u,
        activate: formatActivate(u.activate),
        profile: formatProfile(u.profile)
    }))
}))

function formatProfile($profile){
    if($profile == "T"){
        return "Admin. TI"
    }else if($profile == "S"){
        return "Admin. Sistemas"
    }else{
        return "Atendente"
    }
}

function formatActivate($activate){
    if($activate == "S"){
        return "ATIVO"
    }else{
        return "DESATIVADO"
    }
}
</script>
