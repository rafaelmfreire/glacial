<template>
  <AppLayout title="Ares Condionados">
    <template #header>
      <LinkButton tag="button" @click="submit()">Adicionar</LinkButton>
    </template>

    <div class="flex flex-col">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
          <div class="shadow overflow-hidden border border-gray-200 sm:rounded-lg">
            <div class="px-4 py-5 shadow border-b border-gray-200 bg-white sm:px-6 sm:rounded-t-lg">
              <h3 class="text-lg leading-6 font-medium text-gray-900">Detalhes do Aparelho</h3>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-b-lg max-w-full">
              <div class="bg-white">
                <div class="px-4 py-6">
                  <div class="block sm:grid grid-cols-4">
                    <CompInput class="col-span-2" name="room" autofocus v-model="form.room" :message="errors.room" @keydown="errors.room = null">Sala</CompInput>
                    
                    <CompSelect name="brand_id" v-model="form.brand_id" :message="errors.brand_id" @change="errors.brand_id = null" >Marca
                      <template #options>
                        <CompOption v-for="brand in brands" :key="brand.id" :value="brand.id.toString()">
                          {{ brand.name.toUpperCase() }}
                        </CompOption>
                      </template>
                    </CompSelect>

                    <CompInput name="btu" maxlength="5" autofocus v-model="form.btu" :message="errors.btu" @keydown="errors.btu = null">BTU</CompInput>
                  </div>

                  <div class="block sm:grid grid-cols-2">
                    <CompInput name="identifier" maxlength="10" autofocus v-model="form.identifier" :message="errors.identifier" @keydown="errors.identifier = null">Tombamento</CompInput>
                    <CompInput name="cpf" autofocus v-model="form.cpf" :message="errors.cpf" @keydown="errors.cpf = null">CPF</CompInput>
                  </div>
                  
                  <CompTextarea name="observation" rows="3" v-model="form.observation" :message="errors.observation" @keydown="errors.observation = null">Observações</CompTextarea>
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
import { reactive, ref, nextTick, computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import LinkButton from '@/Components/LinkButton.vue';
import CompInput from '@/Components/Input.vue';
import CompSelect from '@/Components/Select.vue';
import CompOption from '@/Components/Option.vue';
import CompTextarea from '@/Components/Textarea.vue';

const loading = ref(false);
const props = defineProps({
  brands: Object,
  errors: Object,
});

const form = reactive({
  room: null,
  btu: null,
  identifier: null,
  cpf: null,
  brand_id: null,
  observation: null
});

function submit() {
  this.loading = true;
  Inertia.post(route('air_conditioners.store'), this.form, {
    preserveState: (page) => Object.keys(page.props.errors).length,
  });
  this.loading = false;
}
</script>
