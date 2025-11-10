<template>
    <v-card class="p-5 w-full rounded-lg">
    <v-card-title class="text-lg font-semibold mb-2">
      Acrescentar Averbação
    </v-card-title>

    <v-divider></v-divider>

    <v-form @submit.prevent="submit" class="mt-4  pr-5 pl-5 pb-6">
      <v-select 
          v-model="form.eventType"
          label="Evento" :items="[
          { text: 'Aumento Área Aonstruída', value: 'Aumento' },
          { text: 'Redução Área Construída', value: 'Reducao' },
          {text: 'Observação', value: 'Observacao'},
          { text: 'Cancelamento', value: 'Cancelamento'},
          { text: 'Reativação', value: 'Reativacao'},
          ]"
          item-title="text"
          item-value="value"
          :error-messages="form.errors.eventType"
          variant="solo"
          ></v-select>

      <!-- Medida -->
      <v-text-field
        v-model="form.measure"
        label="Medida"
        :error-messages="form.errors.measure"
        outlined
        dense
        clearable
      />

      <!-- Descrição -->
      <v-textarea
        v-model="form.description"
        label="Descrição"
        :error-messages="form.errors.description"
        outlined
        dense
        rows="3"
        clearable
      />

      <!-- Botões -->
      <div class="flex justify-end gap-2 mt-4">
        <v-btn color="grey" variant="text" @click="$inertia.visit(route('imoveis.edit', props.imovel.id))">
          Voltar
        </v-btn>

        <v-btn
          color="primary"
          :loading="form.processing"
          type="submit"
        >
          Salvar
        </v-btn>
      </div>
    </v-form>
  </v-card>

  <v-dialog v-model="showSuccess" min-height="200" max-width="500">
    <v-card>
      <v-card-title class="text-h6">Sucesso!</v-card-title>
      <v-card-text>
        Averbaçõa foi cadastrada com sucesso!
      </v-card-text>
      <v-card-actions>
        <Link :href="route('imoveis.edit', props.imovel.id)">
          <v-btn color="secondary">Voltar para edição</v-btn>
        </Link>
        <v-btn color="primary" @click="showSuccess = false">
          Continuar Cadastrando
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>

  <v-dialog v-model="showError" min-height="200" max-width="500">
    <v-card>
      <v-card-title class="text-h6">Falha</v-card-title>
      <v-card-text>
        {{ errorMessage }}
      </v-card-text>
      <v-card-actions>
        <v-btn color="secondary" @click="showError = false">
          Fechar
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script setup>
import { useForm } from 'laravel-precognition-vue-inertia'
import { defineProps, ref } from 'vue'
import { Link } from '@inertiajs/vue3'

const showSuccess = ref(false)
const showError = ref(false)
const errorMessage = ref('Ocorreu um erro ao processar o formulário.')

const props = defineProps({
  imovel: {
    type: Object,
    default: () => ({}),
  },
})

const form = useForm('post', route('averbacoes.store'), {
  imovel_id: props.imovel?.id ?? '',
  eventType: '',
  measure: '',
  description: '',
})

// função para enviar o formulário
const submit = () => {
  form.submit({
    preserveScroll: true,
    onSuccess: () => {
      if (!props.isEdit) form.reset()
      showSuccess.value = true
    },
    onError: (errors) => {
      // aqui você pode pegar a primeira mensagem de erro
      errorMessage.value = Object.values(errors).flat()[0] || 'Ocorreu um erro.'
      showError.value = true
    },
  })
}
</script>