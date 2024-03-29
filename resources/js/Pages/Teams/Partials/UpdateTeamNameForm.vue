<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetFormSection from '@/Jetstream/FormSection.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetLabel from '@/Jetstream/Label.vue';

const props = defineProps({
    team: Object,
    permissions: Object,
});

const form = useForm({
    name: props.team.name,
});

const updateTeamName = () => {
    form.put(route('teams.update', props.team), {
        errorBag: 'updateTeamName',
        preserveScroll: true,
    });
};
</script>

<template>
    <JetFormSection @submitted="updateTeamName">
        <template #title>
            Unidade
        </template>

        <template #description>
            Nome e responsável da unidade
        </template>

        <template #form>
            <!-- Team Name -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="name" value="Nome da Unidade" />

                <JetInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    :class="[!permissions.canUpdateTeam ? 'border-none shadow-none p-0 font-medium text-lg' : '']"
                    :disabled="! permissions.canUpdateTeam"
                />

                <JetInputError :message="form.errors.name" class="mt-2" />
            </div>

            <!-- Team Owner Information -->
            <div class="col-span-6">
                <JetLabel value="Responsável da Unidade" />

                <div class="flex items-center mt-2">
                    <img class="w-12 h-12 rounded-full object-cover" :src="team.owner.profile_photo_url" :alt="team.owner.name">

                    <div class="ml-4 leading-tight">
                        <div>{{ team.owner.name }}</div>
                        <div class="text-gray-700 text-sm">
                            {{ team.owner.email }}
                        </div>
                    </div>
                </div>
            </div>

        </template>

        <template v-if="permissions.canUpdateTeam" #actions>
            <JetActionMessage :on="form.recentlySuccessful" class="mr-3">
                Atualizado.
            </JetActionMessage>

            <JetButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Atualizar
            </JetButton>
        </template>
    </JetFormSection>
</template>
