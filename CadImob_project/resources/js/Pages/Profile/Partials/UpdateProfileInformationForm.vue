<script setup>
import { ref } from 'vue'
import { Link, useForm } from '@inertiajs/vue3'
import LayoutPaginas from '@/Components/MyComps/LayoutPaginas.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import { computed } from 'vue'


const PROFILE_TI = 'T'

const props = defineProps({
  user: {
    type: Object,
    required: true,
  },
  userLoggedId: { // Nome da prop em camelCase no script
        type: [String, Number], // Assumindo que o ID é string ou number
        required: true,
    },
    userProfile: { // Nome da prop em camelCase no script
        type: [String, Number], // Assumindo que o perfil é string ou number
        required: true,
    },
})

const showEditOption = computed(() => {
    // Acessando as props usando "props."
    return props.userProfile == PROFILE_TI && props.userLoggedId != props.user.id;
});

     
// form já vem com dados do user
const form = useForm({
  name: props.user.name || '',
  email: props.user.email || '',
  cpf: props.user.cpf || '',
  profile: props.user.profile || '',
})




const showSuccess = ref(false)
const showError = ref(false)
const errorMessage = ref('')

const submit = () => {
  form.put(route('user.update', props.user.id), {
    onSuccess: () => {
      showSuccess.value = true
    },
    onError: (errors) => {
      showError.value = true
      errorMessage.value = Object.values(errors)[0] || 'Erro ao atualizar'
    },
  })
}
</script>

<template>
      <v-card
        width="1000"
        elevation="0"
      >
        <Link :href="route('users.index')">
          <v-btn
            icon
            rounded="circle"
            color="grey"
            size="small"
            class="mr-5 mb-4"
          >
            <v-icon>mdi-arrow-left</v-icon>
          </v-btn>
        </Link>

        <form @submit.prevent="submit" class="p-6 rounded-md">
          <!-- NOME -->
          <div>
            <InputLabel for="name" value="Nome" />
            <TextInput
              id="name"
              type="text"
              class="mt-1 block w-full border border-gray-300 rounded-md focus:border-indigo-500 focus:ring focus:ring-indigo-200"
              v-model="form.name"
              required
              autofocus
            />
            <InputError class="mt-2" :message="form.errors.name" />
          </div>

          <!-- EMAIL -->
          <div class="mt-4">
            <InputLabel for="email" value="Email" />
            <TextInput
              id="email"
              type="email"
              class="mt-1 block w-full border border-gray-300 text-grey-100"
              v-model="form.email"
              disabled
              required
            />
            <InputError class="mt-2" :message="form.errors.email" />
          </div>

          <!-- CPF -->
          <div class="mt-4">
            <InputLabel for="cpf" value="CPF" />
            <TextInput
              id="cpf"
              type="text"
              v-model="form.cpf"
              v-mask="'###.###.###-##'"
              required
              disabled
              class="mt-1 block w-full border border-gray-300 rounded-md focus:border-indigo-500 focus:ring focus:ring-indigo-200"
            />
            <InputError class="mt-2" :message="form.errors.cpf" />
          </div>

          <!-- PERFIL -->
          <div class="mt-4">
            <InputLabel value="Perfil" />

            <div v-if="showEditOption" class="flex flex-col gap-2 mt-2">
              <label class="flex items-center cursor-pointer text-base text-gray-600">
                <input
                  type="radio"
                  name="profile"
                  value="T"
                  v-model="form.profile"
                  class="mr-2 accent-indigo-600 focus:ring-indigo-500 border"
                />
                Administrador TI
              </label>

              <label class="flex items-center cursor-pointer text-base text-gray-600">
                <input
                  type="radio"
                  name="profile"
                  value="S"
                  v-model="form.profile"
                  class="mr-2 accent-indigo-600 focus:ring-indigo-500 border"
                />
                Administrador Sistema
              </label>

              <label class="flex items-center cursor-pointer text-base text-gray-600">
                <input
                  type="radio"
                  name="profile"
                  value="A"
                  v-model="form.profile"
                  class="mr-2 accent-indigo-600 focus:ring-indigo-500 border"
                />
                Atendente
              </label>
            </div>
            <div v-else>
                <label class="flex items-center cursor-pointer text-base text-gray-600">
                <input
                  type="radio"
                  name="profile"
                  value="T"
                  disabled
                  v-model="form.profile"
                  class="mr-2 accent-indigo-600 focus:ring-indigo-500 border"
                />
                Administrador TI
              </label>

              <label class="flex items-center cursor-pointer text-base text-gray-600">
                <input
                  type="radio"
                  name="profile"
                  value="S"
                  disabled
                  v-model="form.profile"
                  class="mr-2 accent-indigo-600 focus:ring-indigo-500 border"
                />
                Administrador Sistema
              </label>

              <label class="flex items-center cursor-pointer text-base text-gray-600">
                <input
                  type="radio"
                  name="profile"
                  value="A"
                  disabled
                  v-model="form.profile"
                  class="mr-2 accent-indigo-600 focus:ring-indigo-500 border"
                />
                Atendente
              </label>
            </div>

            <InputError class="mt-2" :message="form.errors.profile" />
          </div>

          <!-- BOTÕES -->
          <div class="mt-6 flex items-center justify-end">
            <PrimaryButton
              class="ms-4"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Atualizar
            </PrimaryButton>
          </div>
        </form>
      </v-card>

      <!-- Dialog de sucesso -->
      <v-dialog v-model="showSuccess" min-height="200" max-width="500">
        <v-card>
          <v-card-title class="text-h6">Sucesso!</v-card-title>
          <v-card-text>Usuário atualizado com sucesso.</v-card-text>
          <v-card-actions>
            <Link :href="route('users.index')">
              <v-btn color="secondary">Voltar</v-btn>
            </Link>
            <v-btn color="primary" @click="showSuccess = false">
              Continuar
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <!-- Dialog de erro -->
      <v-dialog v-model="showError" min-height="200" max-width="500">
        <v-card>
          <v-card-title class="text-h6">Erro</v-card-title>
          <v-card-text>{{ errorMessage }}</v-card-text>
          <v-card-actions>
            <v-btn color="secondary" @click="showError = false">Fechar</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
</template>
