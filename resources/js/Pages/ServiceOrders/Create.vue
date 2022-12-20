<template>
  <AppLayout title="Ordem de Serviço">
    <template #header>
      <LinkButton tag="button" @click="submit()">Adicionar</LinkButton>
    </template>

    <div class="flex flex-col">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
          <div class="shadow overflow-hidden border border-gray-200 sm:rounded-lg">
            <div class="px-4 py-5 shadow border-b border-gray-200 bg-white sm:px-6 sm:rounded-t-lg">
              <h3 class="text-lg leading-6 font-medium text-gray-900">Detalhes do Dia</h3>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-b-lg max-w-full">
              <div class="bg-white">
                <div class="px-4 py-6">
                  <div class="block sm:grid grid-cols-2">

                    <CompInput type="date" name="done_at" v-model="form.done_at" :message="errors.done_at" @keydown="errors.done_at = null">Realizado em</CompInput>
                    <CompInput @keypress.enter="submit()" name="technicians" v-model="form.technicians" autofocus="autofocus" :message="errors.technicians" @keydown="errors.technicians = null">Equipe</CompInput>

                  </div>
                </div>
              </div>
              <div class="px-4 py-5 shadow border-y border-gray-200 bg-white sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Serviços</h3>
              </div>
              <div class="bg-white">
                <div class="px-4 py-6">
                  <div class="block sm:grid grid-cols-3">
                    <CompInput @keypress.enter="submit()" name="identifier" :maxlength="10" v-model="form.identifier" :message="errors.identifier" @keydown="errors.identifier = null">Tombamento</CompInput>
                    <CompSelect name="status" v-model="form.status" :message="errors.status" @change="errors.status = null" >Status
                      <template #options>
                        <CompOption v-for="(index, item) in statuses" :key="index.toString()" :value="index.toString()">
                          {{ item.toUpperCase() }}
                        </CompOption>
                      </template>
                    </CompSelect>
                    <CompInput @keypress.enter="submit()" type="time" name="done_at_time" v-model="form.done_at_time" :message="errors.done_at_time" @keydown="errors.done_at_time = null">Horário</CompInput>
                  </div>
                  
                  <CompTextarea @keypress.enter.exact.prevent="submit()" name="services" rows="3" v-model="form.services" :message="errors.services" @keydown="errors.services = null">Serviços</CompTextarea>
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
  statuses: Object,
  errors: Object,
});


onMounted(() => {
  document.getElementById("technicians").focus();
})

const form = reactive({
  technicians: null,
  done_at: (new Date().getFullYear()+'-'+(new Date().getMonth() + 1).toString().padStart(2, '0')+'-'+new Date().getDate()),
  done_at_time: null,
  identifier: null,
  status: null,
  services: null,
});

function submit() {
  Inertia.post(route('service_orders.store'), form, {
    preserveState: (page) => true,
    onSuccess: (page) => {
      form.identifier = null
      form.status = null
      form.services = null
      form.done_at_time = null
      let identifier = document.getElementById("identifier");
      identifier.focus()
    }
  });
}
</script>
