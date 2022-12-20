<template>
  <AppLayout title="Chamados">
    <template #header>
      <LinkButton tag="button" @click="submit()">Adicionar</LinkButton>
    </template>

    <div class="flex flex-col">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
          <div class="shadow overflow-hidden border border-gray-200 sm:rounded-lg">
            <div class="px-4 py-5 shadow border-b border-gray-200 bg-white sm:px-6 sm:rounded-t-lg">
              <h3 class="text-lg leading-6 font-medium text-gray-900">Detalhes do Chamado</h3>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-b-lg max-w-full">
              <div class="bg-white">
                <div class="px-4 py-6">
                  <div class="block sm:grid grid-cols-3">

                    <CompInput type="date" name="opened_at" v-model="form.opened_at" :message="errors.opened_at" @keydown="errors.opened_at = null">Aberto em</CompInput>
                    <CompInput @keypress.enter="submit()" name="informed_by" v-model="form.informed_by" autofocus="autofocus" :message="errors.informed_by" @keydown="errors.informed_by = null">Informado Por</CompInput>
                    <CompInput @keypress.enter="submit()" :maxlength="10" name="identifier" v-model="form.identifier" autofocus="autofocus" :message="errors.identifier" @keydown="errors.identifier = null">Tombamento</CompInput>

                  </div>
                  <CompTextarea @keypress.enter.exact.prevent="submit()" name="problem" rows="3" v-model="form.problem" :message="errors.problem" @keydown="errors.problem = null">Descreva o problema</CompTextarea>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { onMounted, reactive } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import LinkButton from '@/Components/LinkButton.vue';
import CompInput from '@/Components/Input.vue';
import CompSelect from '@/Components/Select.vue';
import CompOption from '@/Components/Option.vue';
import CompTextarea from '@/Components/Textarea.vue';

const props = defineProps({
  errors: Object,
});


onMounted(() => {
  document.getElementById("informed_by").focus();
})

const form = reactive({
  informed_by: null,
  opened_at: (new Date().getFullYear()+'-'+(new Date().getMonth() + 1).toString().padStart(2, '0')+'-'+new Date().getDate()),
  identifier: null,
  problem: null,
});

function submit() {
  Inertia.post(route('tickets.store'), form, {
    preserveState: (page) => true,
    onSuccess: (page) => {
      form.identifier = null
      form.problem = null
      document.getElementById("identifier").focus();
    }
  });
}
</script>
