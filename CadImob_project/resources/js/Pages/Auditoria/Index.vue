<template>
  <LayoutPaginas>
    <v-card class="auditoria-card w-full rounded-lg" max-width="1000">
      <v-card-title class="text-lg font-semibold">Registros de Auditoria</v-card-title>

      <!-- Filtros -->
      <div class="flex flex-wrap gap-4 mb-4">
        <v-text-field label="Usuário" v-model="filters.user" dense hide-details></v-text-field>
        <v-select
          :items="['created', 'updated', 'deleted']"
          label="Evento"
          v-model="filters.event"
          dense
          hide-details
        ></v-select>
        <v-text-field label="Tabela" v-model="filters.table" dense hide-details></v-text-field>
        <v-text-field type="date" label="Data" v-model="filters.date" dense hide-details></v-text-field>
        
        <div class="flex items-center gap-2">
          <v-btn color="primary" @click="applyFilters">Filtrar</v-btn>
          <v-btn color="secondary" variant="outlined" @click="clearFilters">Limpar</v-btn>
        </div>
      </div>

      <v-table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Usuário</th>
            <th>Evento</th>
            <th>Data e Hora</th>
            <th>Tabela</th>
            <th>ID Auditado</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="a in audits.data" :key="a.id">
            <td>{{ a.id }}</td>
            <td>{{ a.user?.name ?? '—' }}</td>
            <td>{{ formatEvent(a.event) }}</td>
            <td>{{ formatDate(a.created_at) }}</td>
            <td>{{ a.auditable_type.split('\\').pop() }}</td>
            <td>{{ a.auditable_id }}</td>
            <td>
              <v-btn small color="info" @click="viewDetails(a.id)">Detalhes</v-btn>
            </td>
          </tr>
        </tbody>
      </v-table>

      <v-pagination
        v-model="page"
        :length="audits.last_page"
        @update:modelValue="changePage"
        class="mt-4"
      />
    </v-card>
  </LayoutPaginas>
</template>

<style scoped>
.auditoria-card {
  padding: 20px !important;
}
</style>

<script setup>
import LayoutPaginas from '@/Components/MyComps/LayoutPaginas.vue'
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
  audits: Object,
  filters: Object
})

const filters = ref({ ...props.filters })
const page = ref(props.audits.current_page)

const applyFilters = () => {
  router.get(route('auditoria.index'), filters.value)
}

const clearFilters = () => {
  filters.value = { user: '', event: '', table: '', date: '' }
  router.get(route('auditoria.index'))
}

const changePage = (p) => {
  router.get(route('auditoria.index'), { ...filters.value, page: p })
}

const viewDetails = (id) => {
  router.get(route('auditoria.show', id))
}

const formatEvent = (e) => {
  return e === 'created' ? 'Criação' : e === 'updated' ? 'Alteração' : 'Exclusão'
}

const formatDate = (d) => new Date(d).toLocaleString('pt-BR')
</script>
