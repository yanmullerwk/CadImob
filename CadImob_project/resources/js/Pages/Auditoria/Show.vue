<template>
    <LayoutPaginas>
    <v-card class="detalhes-auditoria rounded-lg shadow-md">
    <v-card-title class="flex w-full justify-center items-center text-lg font-semibold">
        <Link :href="route('auditoria.index')">
            <v-btn 
            icon 
            rounded="circle"
            color="grey" 
            size="small" 
            class="mr-5"
            >
              <v-icon>mdi-arrow-left</v-icon>
            </v-btn>
          </Link>
          Detalhes da Auditoria
    </v-card-title>

    <v-divider class="mb-4" />

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div><strong>ID:</strong> {{ audit.id }}</div>
      <div><strong>Usuário:</strong> {{ audit.user?.name ?? '—' }}</div>
      <div><strong>Evento:</strong> {{ formatEvent(audit.event) }}</div>
      <div><strong>Data:</strong> {{ formatDate(audit.created_at) }}</div>
      <div><strong>Tabela:</strong> {{ audit.auditable_type.split('\\').pop() }}</div>
      <div><strong>ID Auditado:</strong> {{ audit.auditable_id }}</div>
      <div><strong>IP:</strong> {{ audit.ip_address }}</div>
      <div><strong>URL:</strong> {{ audit.url }}</div>
    </div>

    <v-divider class="my-4" />

    <div>
      <strong>Dados Anteriores:</strong>
      <pre>{{ audit.old_values }}</pre>
    </div>

    <div class="mt-4">
      <strong>Dados Novos:</strong>
      <pre>{{ audit.new_values }}</pre>
    </div>
  </v-card>
    </LayoutPaginas>
</template>
<style scoped>
.detalhes-auditoria {
  padding: 20px !important;
}
</style>
<script setup>
import LayoutPaginas from '@/Components/MyComps/LayoutPaginas.vue'
import { defineProps } from 'vue'
import { Link } from '@inertiajs/vue3';
const props = defineProps({ audit: Object })

const formatEvent = (e) => e === 'created' ? 'Criação' : e === 'updated' ? 'Alteração' : 'Exclusão'
const formatDate = (d) => new Date(d).toLocaleString('pt-BR')
</script>
