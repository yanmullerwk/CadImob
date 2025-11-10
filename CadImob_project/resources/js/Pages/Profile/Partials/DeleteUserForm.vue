<script setup>
import DangerButton from '@/Components/DangerButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import Modal from '@/Components/Modal.vue'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
})

const confirmingToggle = ref(false)
const form = useForm({})

const openModal = () => {
    confirmingToggle.value = true
}

const closeModal = () => {
    confirmingToggle.value = false
    form.clearErrors()
    form.reset()
}

const toggleUser = () => {
    form.post(route('user.toggleActivate', props.user.id), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
    })
}
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ user.activate === 'S' ? 'Desativar Usuário' : 'Ativar Usuário' }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{
                    user.activate === 'S'
                        ? 'Ao desativar este usuário, ele perderá acesso à aplicação. No entanto, seus dados continuarão armazenados conforme a política da empresa.'
                        : 'Ativar este usuário permitirá que ele volte a acessar a aplicação normalmente.'
                }}
            </p>
        </header>

        <button
            @click="openModal"
            class="px-4 py-2 rounded font-semibold text-white transition"
            :class="user.activate === 'S' ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700'"
        >
            {{ user.activate === 'S' ? 'Desativar Conta' : 'Ativar Conta' }}
        </button>

        <Modal :show="confirmingToggle" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    {{
                        user.activate === 'S'
                            ? 'Tem certeza que deseja desativar este usuário?'
                            : 'Tem certeza que deseja ativar este usuário?'
                    }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{
                        user.activate === 'S'
                            ? 'O usuário perderá acesso à aplicação imediatamente, mas seus dados continuarão armazenados conforme as normas da empresa.'
                            : 'O usuário voltará a ter acesso total à aplicação.'
                    }}
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        Cancelar
                    </SecondaryButton>

                    <button
                        class="ms-3 px-4 py-2 rounded text-white font-semibold transition"
                        :class="{
                            'bg-red-600 hover:bg-red-700': user.activate === 'S',
                            'bg-green-600 hover:bg-green-700': user.activate === 'N',
                            'opacity-25': form.processing,
                        }"
                        :disabled="form.processing"
                        @click="toggleUser"
                    >
                        {{ user.activate === 'S' ? 'Desativar' : 'Ativar' }}
                    </button>
                </div>
            </div>
        </Modal>
    </section>
</template>
