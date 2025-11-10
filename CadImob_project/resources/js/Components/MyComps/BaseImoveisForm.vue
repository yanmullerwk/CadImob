<template>
<v-card class="pa-6 w-full rounded-lg" max-width="1000" elevation="8">
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
      <div v-if="isEdit" class="flex justify-end">
        <v-btn color="green" prepend-icon="mdi-file-download-outline" @click="generateReport" class="ml-1">
          Gerar relatorio
        </v-btn>
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
          <div class="-mt-5 text-sm text-red-500" v-if="form.invalid('tipo')">
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
            step="0.01"
            @change="form.validate('areaEdificacao')"
            :disabled="form.tipo === 'Terreno'"
          ></v-text-field>
          <div class="-mt-5 text-sm text-red-500" v-if="form.invalid('areaEdificacao')">
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
            step="0.01"
            min="0"
            @change="form.validate('areaTerreno')"
            :disabled="form.tipo === 'Apartamento'"
          ></v-text-field>
          <div class="-mt-5 text-sm text-red-500" v-if="form.invalid('areaTerreno')">
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
          <div class="-mt-5 text-sm text-red-500" v-if="form.invalid('logradouro')">
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
            type="number"
            @change="form.validate('numero')"
            required
          ></v-text-field>
          <div class="-mt-5 text-sm text-red-500" v-if="form.invalid('numero')">
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
          <div class="-mt-5 text-sm text-red-500" v-if="form.invalid('bairro')">
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
          <div class="-mt-5 text-sm text-red-500" v-if="form.invalid('complemento')">
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
          <div class="-mt-5 text-sm text-red-500" v-if="form.invalid('contribuinte_id')">
            {{ form.errors.contribuinte_id }}
          </div>
        </v-col>
    </v-row>
    <v-row v-if="props.isEdit"> 
      <v-file-input v-if="documents.length > 0"
      v-model="formFiles.documents" 
      label="File input" 
      accept=".jpg, .jpeg, .png, .pdf" 
      show-size 
      multiple
      >
      </v-file-input>
    </v-row>
    <v-row v-else> 
      <v-file-input  
      v-model="form.documents" 
      label="File input" 
      accept=".jpg, .jpeg, .png, .pdf" 
      show-size 
      multiple
      >
      </v-file-input>
    </v-row>
    <div class="mt-0 text-sm text-red" v-for="(message,index) in errorMessages" :key="index">
      {{ message }}
    </div>

    <!-- aqui vao os documents-->
     <v-row v-if="isEdit && props.documents.length > 0">
          <v-col>
              <p class="text-subtitle-1 mb-2">Documentos Anexados</p>
    
              <ul class="pl-5">
                <li v-for="doc in props.documents" :key="doc.id">
                  <v-card class="h-10 pa-1 text-sm d-flex justify-space-between align-center rounded-md shadow-sm mt-2 mb-2" >
                    <div>
                      {{ doc.nomeArquivo }}
                    </div>

                    <div>
                      <!-- Link correto para rota de download -->
                       <a
                        :href="route('documents.download', doc.id)"
                        method="get"
                        as="button"
                        >
                        <v-btn icon color="primary" variant="none">
                          <v-icon>mdi-download</v-icon>
                        </v-btn>
                      </a>
                      <Link
                      :href="route('documents.destroy', doc.id)"
                      method="delete"
                      as="button"
                      preserve-scroll
                      >
                        <v-btn icon color="error" variant="none">
                          <v-icon>mdi-delete</v-icon>
                        </v-btn>
                      </Link>
                    </div>
                  </v-card>
                </li>
              </ul>

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
import { useForm } from 'laravel-precognition-vue-inertia';
import { Link } from '@inertiajs/vue3';
import { ref, defineProps, watch } from 'vue';

const showSuccess = ref(false);
const showError = ref(false);
const errorMessage = ref('Ocorreu um erro ao processar o formulário.');


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
  documents: { 
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
      documents: [],
    });

const formFiles = ref(null);

if(props.isEdit){
  formFiles.value = useForm('post', route('documents.upload', props.imovel.id),{
  documents: [],
})
}

watch(() => form.tipo, (novoTipo) => {
  if (novoTipo === 'Terreno') {
    form.areaEdificacao = 0
  } else if (novoTipo === 'Apartamento') {
    form.areaTerreno = 0
  }
})





const submit = () => {
  form.submit({
    preserveScroll: true,
    onSuccess: () => {
      if (!props.isEdit) {  
        form.reset();
        form.documents = [];
        showSuccess.value = true; // <-- Adicionado para mostrar sucesso no cadastro
       }else{
        showSuccess.value = true;
        // Só submete novos arquivos se houver algum
        if (formFiles.value.documents.length > 0) {
            formFiles.value.submit({
              onSuccess: () => {
              formFiles.value.reset();
            }
          })
        }
      }   
    },
      onError: (errors) => {
       // aqui você pode pegar a primeira mensagem de erro
      errorMessage.value = Object.values(errors).flat()[0] || 'Ocorreu um erro.'
      showError.value = true
    },
  });
};

const maxFiles = 5;
const sizeFile = 3072000;
const errorMessages = ref([]);

// Este watch valida o NÚMERO TOTAL de arquivos
watch(() => form.documents, (files) => {
  errorMessages.value = []
    // Validação de total
   if (files.length > maxFiles) {
       errorMessages.value.push(`Você pode anexar no máximo ${maxFiles} arquivos!`);
    }

    // Validação de tamanho individual
    files.forEach(file => {
      if (file.size > sizeFile) {
        errorMessages.value.push(`O arquivo "${file.name}" excede o limite de ${(sizeFile / 1024 / 1024).toFixed(0)} MB.`);
      }
    });
}, { deep: true });

function generateReport(){
  window.open(route('report.individual', props.imovel.id), '_blank');
}
</script>
