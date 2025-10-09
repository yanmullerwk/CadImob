<template>
  <v-card class="pa-6 " width="1000" elevation="8">
    <v-card-title>
       <div class="d-flex align-center">
          <Link :href="route('pessoas.index')">
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
          <slot name="title">
            <span class="text-h6 ml-2">{{ titleForm }}</span>
          </slot>
        </div>
        <br/>
    </v-card-title>
    <form @submit.prevent="submit">
      <v-row>
        <v-col>
          <v-text-field 
          v-model="form.nome" 
          label="Nome" 
          variant="solo"
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
          variant="solo" 
          @change="form.validate('cpf')"
          :disabled="isEdit"
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
            type="date" variant="solo"
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
          label="Sexo" :items="[
          { text: 'Masculino', value: 'Masculino' },
          { text: 'Feminino', value: 'Feminino' },
          { text: 'Outro', value: 'Outro' }
          ]"
          item-title="text"
          item-value="value"
          @change="form.validate('sexo')"
          variant="solo"
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
          label="Telefone (Opcional)" 
          variant="solo"
          @change="form.validate('telefone')"
          ></v-text-field>
          <div v-if="form.invalid('telefone')">
            {{ form.errors.telefone }}
        </div>
        </v-col>
        <v-col>
          <v-text-field 
          v-model="form.email" 
          label="E-mail (Opcional)" 
          type="email" 
          variant="solo"
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
  <v-dialog v-model="showSuccess" min-height="200" max-width="500">
      <v-card>
        <v-card-title class="text-h6">Sucesso!</v-card-title>
        <v-card-text>
          {{ isEdit 
          ? ('Pessoa foi editada com sucesso') 
          : ('Pessoa foi cadastrada com sucesso') }}
        </v-card-text>
        <v-card-actions>
          <Link :href="route('pessoas.index')">
            <v-btn color="secondary" @click="">voltar para tabela</v-btn>
          </Link>
          <v-btn color="primary" @click="showSuccess = false">{{ isEdit ? 'Continuar editando' : 'Continuar cadastrando' }}</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
</template> 

<script setup>
import { useForm } from 'laravel-precognition-vue-inertia';
import { Link, Head } from '@inertiajs/vue3';
import { ref, defineProps } from 'vue';

const showSuccess = ref(false)

const props = defineProps({
  pessoa: {
    type: Object,
    default: () => ({}), // vazio se for create
  },
  isEdit: {
    type: Boolean,
    default: false,
  },
  titleForm:{
      type: String,
      default: 'Formulario',
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
      showSuccess.value = true
    },
  })
}

</script>
