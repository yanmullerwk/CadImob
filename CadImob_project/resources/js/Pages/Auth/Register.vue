<script setup>

import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage} from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    cpf: '',
    profile: '',
    activate: 'S',
});

const page = usePage()
const userProfile = page.props.auth.user.profile
const showSuccess = ref(false)
const showError = ref(false)

const submit = () => {
    form.post(route('user.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
        onSuccess: () => {
        form.reset()
        showSuccess.value = true
        },
        onError: (errors) => {
        // aqui você pode pegar a primeira mensagem de erro
        errorMessage.value = Object.values(errors).flat()[0] || 'Ocorreu um erro.'
        showError.value = true
    },
    });
};
</script>

<template>
    <v-card class="pa-6 rounded-lg" color="grey-lighten-4" width="1000" elevation="8">
        <Link :href="route('pessoas.index')">
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
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <!-- EMAIL -->
            <div class="mt-4">
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full border border-gray-300 rounded-md focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    v-model="form.email"
                    required
                    autocomplete="username"
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
                    class="mt-1 block w-full border border-gray-300 rounded-md focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                />
                <InputError class="mt-2" :message="form.errors.cpf" />
            </div>

            <!-- PERFIL -->
            <div v-if="userProfile!=='S'" class="mt-4">
                <InputLabel value="Profile" />
                
                <div class="flex flex-col gap-2 mt-2">
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

                <InputError class="mt-2" :message="form.errors.profile" />
            </div>
            <div v-else class="mt-4">
                <!-- Se for perfil S, mostra só opção de Atendente -->
                <InputLabel value="Profile" />
                <label class="flex items-center cursor-pointer text-base text-gray-600 mt-2">
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

            <!-- SENHA -->
            <div class="mt-4">
                <InputLabel for="password" value="Senha" />
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full border border-gray-300 rounded-md focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <!-- CONFIRMAR SENHA -->
            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirmar senha" />
                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full border border-gray-300 rounded-md focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <!-- BOTÕES -->
            <div class="mt-4 flex items-center justify-end">
                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Cadastrar
                </PrimaryButton>
            </div>
        </form>
    </v-card>
    <v-dialog v-model="showSuccess" min-height="200" max-width="500">
    <v-card>
      <v-card-title class="text-h6">Sucesso!</v-card-title>
      <v-card-text>
       Pessoa foi cadastrada com sucesso
      </v-card-text>
      <v-card-actions>
        <Link :href="route('pessoas.index')">
          <v-btn color="secondary">Voltar para tabela</v-btn>
        </Link>
        <v-btn color="primary" @click="showSuccess = false">
          Continuar Cadastrando
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>

  <!-- Dialogo de erro -->
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
