<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import JetActionSection from '@/Jetstream/ActionSection.vue';
import JetConfirmationModal from '@/Jetstream/ConfirmationModal.vue';
import JetDangerButton from '@/Jetstream/DangerButton.vue';
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue';

const props = defineProps({
    team: Object,
});

const confirmingTeamDeletion = ref(false);
const form = useForm();

const confirmTeamDeletion = () => {
    confirmingTeamDeletion.value = true;
};

const deleteTeam = () => {
    form.delete(route('teams.destroy', props.team), {
        errorBag: 'deleteTeam',
    });
};
</script>

<template>
    <JetActionSection>
        <template #title>
            Excluir Unidade
        </template>

        <template #description>
            Excluir permanentemente esta unidade.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600">
                Uma vez que a unidade seja excluída, todos os dados vinculados à esta unidade serão permanentemente apagados. Antes de excluir, certifique-se de salvar qualquer informação que achar importante, referente à esta unidade.
            </div>

            <div class="mt-5">
                <JetDangerButton @click="confirmTeamDeletion">
                    Excluir Unidade
                </JetDangerButton>
            </div>

            <!-- Delete Team Confirmation Modal -->
            <JetConfirmationModal :show="confirmingTeamDeletion" @close="confirmingTeamDeletion = false">
                <template #title>
                    Excluir Unidade
                </template>

                <template #content>
                    Tem certeza que quer excluir esta unidade? Uma vez que excluir, todas as informações serão permanentemente apagadas.
                </template>

                <template #footer>
                    <JetSecondaryButton @click="confirmingTeamDeletion = false">
                        Cancelar
                    </JetSecondaryButton>

                    <JetDangerButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteTeam"
                    >
                        Excluir Unidade
                    </JetDangerButton>
                </template>
            </JetConfirmationModal>
        </template>
    </JetActionSection>
</template>
