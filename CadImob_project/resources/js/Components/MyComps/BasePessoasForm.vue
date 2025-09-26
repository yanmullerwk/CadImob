<template>
  <v-card class="pa-6 " width="1000" elevation="8">
    <form @submit.prevent="submit">
      <v-row>
        <v-col>
          <v-text-field 
          v-model="form.nome" 
          label="Nome" 
          variant="solo-filled"
          @change="form.validate('nome')" 
          required
          ></v-text-field>
          <div v-if="form.invalid('nome')">
            {{ form.errors.nome }}
        </div>
        </v-col>
        <v-col>
          <v-text-field 
          v-model="form.cpf" 
          label="CPF" 
          variant="solo-filled" 
          @change="form.validate('cpf')"
          required
          ></v-text-field>
          <div v-if="form.invalid('cpf')">
            {{ form.errors.cpf}}
        </div>
        </v-col>
      </v-row>

      <v-row>
        <v-col>
          <v-text-field 
            v-model="form.dataNascimento"
            label="Data Nascimento"
            type="date" variant="solo-filled"
            @change="form.validate('dataNascimento')"
            required
            ></v-text-field>
            <div v-if="form.invalid('dataNascimento')">
            {{ form.errors.dataNascimento }}
          </div>
        </v-col>
        <v-col>
          <v-select 
          v-model="form.sexo"
          label="Select" :items="[
          { text: 'Masculino', value: 'M' },
          { text: 'Feminino', value: 'F' },
          { text: 'Outro', value: 'O' }
          ]"
          item-title="text"
          item-value="value"
          @change="form.validate('sexo')"
          variant="solo-filled"
          ></v-select>
          <div v-if="form.invalid('sexo')">
            {{ form.errors.sexo }}
        </div>
        </v-col>
      </v-row>

      <v-row>
        <v-col>
          <v-text-field 
          v-model="form.telefone" 
          label="Telefone" 
          variant="solo-filled"
          @change="form.validate('telefone')"
          ></v-text-field>
          <div v-if="form.invalid('telefone')">
            {{ form.errors.telefone }}
        </div>
        </v-col>
        <v-col>
          <v-text-field 
          v-model="form.email" 
          label="E-mail" 
          type="email" 
          variant="solo-filled"
          @change="form.validate('email')"
          ></v-text-field>
          <div v-if="form.invalid('email')">
            {{ form.errors.email }}
        </div>
        </v-col>
      </v-row>
      <v-btn type="submit" color="primary" prepend-icon="mdi-plus">
        {{ isEdit ? 'Atualizar' : 'Cadastrar' }}
      </v-btn>
    </form>
  </v-card>
</template>

<script setup>
import { useForm } from 'laravel-precognition-vue-inertia';

const props = defineProps({
  pessoa: {
    type: Object,
    default: () => ({}), // vazio se for create
  },
  isEdit: {
    type: Boolean,
    default: false,
  },
})

// se for edição
const form = props.isEdit
  ? useForm('put', route('pessoas.update', props.pessoa.id), {
      nome: props.pessoa?.nome,
      cpf: props.pessoa?.cpf,
      dataNascimento: props.pessoa?.dataNascimento,
      sexo: props.pessoa?.sexo,
      telefone: props.pessoa?.telefone,
      email: props.pessoa?.email,
    })
  // se for criação
  : useForm('post', route('pessoas.store'), {
      nome: '',
      cpf: '',
      dataNascimento: '',
      sexo: '',
      telefone: '',
      email: '',
    })

const submit = () => {
  form.submit({
    preserveScroll: true,
    onSuccess: () => {
      if (!props.isEdit) {
        form.reset()
      }
    },
  })
}

</script>
