<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { reactive } from 'vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue';
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import { Inertia } from '@inertiajs/inertia';

const form = reactive({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

function submit() {
  Inertia.post(route('new_user.store'), this.form, {
    preserveState: (page) => Object.keys(page.props.errors).length,
  });
    // form.post(route('new_user'), {
    //     onFinish: () => form.reset('password', 'password_confirmation'),
    // });
};
</script>

<template>
  <AppLayout title="Cadastrar Novo Usuário">
    <template #header>
    </template>
    <Head title="Cadastrar Novo Usuário" />

        <JetValidationErrors class="mb-4" />

    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border border-gray-200 sm:rounded-lg">
                    <div class="px-4 py-5 shadow border-b border-gray-200 bg-white sm:px-6 sm:rounded-t-lg">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Informações do Usuário</h3>
                    </div>
                    <div class="bg-white shadow overflow-hidden sm:rounded-b-lg max-w-full">
                        <div class="bg-white">
                            <div class="px-4 py-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <JetLabel for="name" value="Nome" />
                                    <JetInput
                                        id="name"
                                        v-model="form.name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        required
                                        autofocus
                                        autocomplete="name"
                                    />
                                </div>

                                <div>
                                    <JetLabel for="email" value="Email" />
                                    <JetInput
                                        id="email"
                                        v-model="form.email"
                                        type="email"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                </div>

                                <div>
                                    <JetLabel for="password" value="Senha" />
                                    <JetInput
                                        id="password"
                                        v-model="form.password"
                                        type="password"
                                        class="mt-1 block w-full"
                                        required
                                        autocomplete="new-password"
                                    />
                                </div>

                                <div>
                                    <JetLabel for="password_confirmation" value="Confirmar Senha" />
                                    <JetInput
                                        id="password_confirmation"
                                        v-model="form.password_confirmation"
                                        type="password"
                                        class="mt-1 block w-full"
                                        required
                                        autocomplete="new-password"
                                    />
                                </div>

                                <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
                                    <JetLabel for="terms">
                                        <div class="flex items-center">
                                            <JetCheckbox id="terms" v-model:checked="form.terms" name="terms" />

                                            <div class="ml-2">
                                                I agree to the <a target="_blank" :href="route('terms.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Terms of Service</a> and <a target="_blank" :href="route('policy.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Privacy Policy</a>
                                            </div>
                                        </div>
                                    </JetLabel>
                                </div>

                                <div class="flex items-center justify-end mt-4 md:col-span-2">
                                    <JetButton @click="submit()" class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        Cadastrar Usuário
                                    </JetButton>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </AppLayout>
</template>
