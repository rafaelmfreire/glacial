<template>
	<a @click="confirmingDeletion = true">
		<slot />
	</a>
	<jet-confirmation-modal :show="confirmingDeletion" @close="confirmingDeletion = false">
		<template #title> <slot name="title">Apagar</slot> </template>

		<template #content>
			Tem certeza que deseja apagar? Essa ação não pode ser desfeita. Os dados serão perdidos.
		</template>

		<template #footer>
			<jet-secondary-button @click.native="confirmingDeletion = false"> Cancelar </jet-secondary-button>

			<jet-danger-button class="ml-2" @click.native="deleteItem">
				<!-- :class="{ 'opacity-25': form.processing }"
				:disabled="form.processing" -->
				Apagar
			</jet-danger-button>
		</template>
	</jet-confirmation-modal>
</template>

<script>
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetConfirmationModal from "@/Jetstream/ConfirmationModal.vue";
import { TrashIcon } from "@heroicons/vue/outline";
import { Inertia } from '@inertiajs/inertia';
export default {
	components: {
		JetDialogModal,
		JetDangerButton,
		JetSecondaryButton,
		JetConfirmationModal,
		TrashIcon,
	},
	data() {
		return {
			confirmingDeletion: false,
			idP: this.id,
			routeP: this.route,
		};
	}, 
	props: ['id', 'route'],
	methods: {
		deleteItem() {
			Inertia.delete(this.routeP+this.idP,
				{
					preserveScroll: (page) => true,
				}
			);
		}
	}
};
</script>