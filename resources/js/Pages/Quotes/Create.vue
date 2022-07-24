<template>
  <AppLayout title="Orçamento">
    <template #header>
      <LinkButton tag="button" @click="submit()">Adicionar</LinkButton>
    </template>

    <div class="flex flex-col">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
          <div class="shadow overflow-hidden border border-gray-200 sm:rounded-lg">
            <div class="px-4 py-5 shadow border-b border-gray-200 bg-white sm:px-6 sm:rounded-t-lg">
              <h3 class="text-lg leading-6 font-medium text-gray-900">Detalhes do Orçamento</h3>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-b-lg max-w-full">
              <div class="bg-white">
                <div class="px-4 py-6">
                  <div class="block sm:grid grid-cols-2">

                    <CompInput type="date" name="date" v-model="form.date" :message="errors.date" @keydown="errors.date = null">Data do Orçamento</CompInput>
                    <CompInput name="number" v-model="form.number" autofocus="autofocus" :message="errors.number" @keydown="errors.number = null">Orçamento Nº</CompInput>

                  </div>
                </div>
              </div>
              <div class="px-4 py-5 shadow border-y border-gray-200 bg-white sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Itens do Orçamento</h3>
              </div>
              <div class="bg-white">
                <div class="px-4 py-6">
                  <div class="block sm:grid grid-cols-4">
                    <CompInput name="identifier" :maxlength="10" v-model="form.identifier" :message="errors.identifier" @keydown="errors.identifier = null">Tombamento</CompInput>
                    <CompInput type="date" name="service_date" v-model="form.service_date" :message="errors.service_date" @keydown="errors.service_date = null">Data do Serviço</CompInput>
                    <CompInput @keypress.enter="submit()" name="contract_item_id" v-model="form.contract_item_id" :message="errors.contract_item_id" @keydown="errors.contract_item_id = null">Item</CompInput>
                    <CompInput @keypress.enter="submit()" name="quantity" :min="1" type="number" v-model="form.quantity" :message="errors.quantity" @keydown="errors.quantity = null">Quantidade</CompInput>
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

<script setup>
import { onMounted, reactive, watch } from 'vue';
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
  document.getElementById("number").focus();
})

const form = reactive({
  number: null,
  date: (new Date().getFullYear()+'-'+(new Date().getMonth() + 1).toString().padStart(2, '0')+'-'+new Date().getDate()),
  service_date: (new Date().getFullYear()+'-'+(new Date().getMonth() + 1).toString().padStart(2, '0')+'-'+new Date().getDate()),
  identifier: null,
  contract_item_id: '000',
  quantity: 1,
});

watch(form, async (newNumber, oldNumber) => {
  if(parseInt(oldNumber.contract_item_id, 10) != 0 && !isNaN(parseInt(oldNumber.contract_item_id, 10))) {
    form.contract_item_id = parseInt(oldNumber.contract_item_id, 10).toString().padStart(3, '0')
  }
})

function submit() {
  Inertia.post(route('quotes.store'), this.form, {
    preserveState: (page) => true,
    onSuccess: (page) => {
      document.getElementById("contract_item_id").focus();
      form.contract_item_id = '000'
      form.quantity = 1
    }
  });
}
</script>
