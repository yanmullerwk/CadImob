<template>
<v-card class="pa-6" width="1000" elevation="8">
    <v-card-title>
      <div class="d-flex align-center">
        <Link :href="route('imoveis.index')">
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
          <v-select 
            v-model="form.tipo"
            label="Tipo"
            :items="[
              { text: 'Casa', value: 'Casa' },
              { text: 'Apartamento', value: 'Apartamento' },
              { text: 'Terreno', value: 'Terreno' }
            ]"
            item-title="text"
            item-value="value"
            @change="form.validate('tipo')"
            variant="solo"
            required
          ></v-select>
          <div v-if="form.invalid('tipo')">
            {{ form.errors.tipo }}
          </div>
        </v-col>

        <v-col>
          <v-text-field 
            v-model="form.areaEdificacao"
            label="Área da Edificação (m²)"
            variant="solo"
            type="number"
            min="0"
            @change="form.validate('areaEdificacao')"
          ></v-text-field>
          <div v-if="form.invalid('areaEdificacao')">
            {{ form.errors.areaEdificacao }}
          </div>
        </v-col>
    </v-row>

    <v-row>
        <v-col>
          <v-text-field 
            v-model="form.areaTerreno" 
            label="Área do Terreno (m²)" 
            variant="solo" 
            type="number"
            min="0"
            @change="form.validate('areaTerreno')"
          ></v-text-field>
          <div v-if="form.invalid('areaTerreno')">
            {{ form.errors.areaTerreno }}
          </div>
        </v-col>

        <v-col>
          <v-text-field 
            v-model="form.logradouro"
            label="Logradouro"
            variant="solo"
            @change="form.validate('logradouro')"
            required
          ></v-text-field>
          <div v-if="form.invalid('logradouro')">
            {{ form.errors.logradouro }}
          </div>
        </v-col>
    </v-row>

    <v-row>
        <v-col>
          <v-text-field 
            v-model="form.numero" 
            label="Número" 
            variant="solo"
            @change="form.validate('numero')"
            required
          ></v-text-field>
          <div v-if="form.invalid('numero')">
            {{ form.errors.numero }}
          </div>
        </v-col>
        <v-col>
          <v-text-field 
            v-model="form.bairro" 
            label="Bairro" 
            variant="solo"
            @change="form.validate('bairro')"
            required
          ></v-text-field>
          <div v-if="form.invalid('bairro')">
            {{ form.errors.bairro }}
          </div>
        </v-col>
    </v-row>
      
    <v-row>
        <v-col>
            <v-text-field 
            v-model="form.complemento" 
            label="Complemento" 
            variant="solo"
            @change="form.validate('complemento')"
          ></v-text-field>
          <div v-if="form.invalid('complemento')">
            {{ form.errors.complemento }}
          </div>
        </v-col>
        <v-col>
          <v-select
            v-model="form.contribuinte_id"
            label="Contribuinte"
            :items="props.pessoas"
            item-title="nome"
            item-value="id"
            variant="solo"
            required
            @change="form.validate('contribuinte_id')"
          ></v-select>
          <div v-if="form.invalid('contribuinte_id')">
            {{ form.errors.contribuinte_id }}
          </div>
        </v-col>
    </v-row>
    <v-btn type="submit" color="primary" prepend-icon="mdi-plus">
        {{ isEdit ? 'Salvar' : 'Cadastrar' }}
    </v-btn>
    </form>
</v-card>

  <v-dialog v-model="showSuccess" min-height="200" max-width="500">
    <v-card>
      <v-card-title class="text-h6">Sucesso!</v-card-title>
      <v-card-text>
        {{ isEdit 
          ? 'Imóvel foi editado com sucesso!' 
          : 'Imóvel foi cadastrado com sucesso!' }}
      </v-card-text>
      <v-card-actions>
        <Link :href="route('imoveis.index')">
          <v-btn color="secondary">Voltar para tabela</v-btn>
        </Link>
        <v-btn color="primary" @click="showSuccess = false">
          {{ isEdit ? 'Continuar editando' : 'Continuar cadastrando' }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup>
import { useForm } from 'laravel-precognition-vue-inertia';
import { Link, Head } from '@inertiajs/vue3';
import { ref, defineProps } from 'vue';

const showSuccess = ref(false);

const props = defineProps({
  imovel: {
    type: Object,
    default: () => ({}),
  },
  isEdit: {
    type: Boolean,
    default: false,
  },
  titleForm: {
    type: String,
    default: 'Formulário',
  },
  pessoas: {
    type: Array,
    default: () => [],
  },
});

// se for edição
const form = props.isEdit
  ? useForm('put', route('imoveis.update', props.imovel.id), {
      tipo: props.imovel?.tipo || '',
      areaTerreno: props.imovel?.areaTerreno || '',
      areaEdificacao: props.imovel?.areaEdificacao || '',
      logradouro: props.imovel?.logradouro || '',
      numero: props.imovel?.numero || '',
      bairro: props.imovel?.bairro || '',
      complemento: props.imovel?.complemento || '',
      contribuinte_id: props.imovel?.contribuinte_id || '',
    })
  // se for criação
  : useForm('post', route('imoveis.store'), {
      tipo: '',
      areaTerreno: '',
      areaEdificacao: '',
      logradouro: '',
      numero: '',
      bairro: '',
      complemento: '',
      contribuinte_id: '',
      situacao: 'ATIVA',
    });

const submit = () => {
  form.submit({
    preserveScroll: true,
    onSuccess: () => {
      if (!props.isEdit) {
        form.reset();
      }
      showSuccess.value = true;
    },
  });
};
</script>
