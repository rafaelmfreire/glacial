<template>
  <AppLayout :title="airConditioner.room" :smallTitle="false">
    <template #header>
      <div class="flex items-center justify-between">
        <LinkButton tag="a" appearance="edit" :href="route('air_conditioners.edit', airConditioner.id)">Alterar</LinkButton>
      </div>
    </template>

    <div class="flex flex-col">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle flex flex-col-reverse lg:flex-row gap-4 min-w-full sm:px-6 lg:px-8">
          <div class="lg:col-span-2 flex-1 bg-white shadow overflow-hidden sm:rounded-lg">
            <TabsWrapper>

              <Tab title="Chamados">
                <div class="grid grid-cols-1 gap-4">
                  <CompTextarea :withPadding="false" name="problem" rows="3" v-model="formTicket.problem" :message="errors.problem" @keydown="errors.problem = null">Descreva o problema</CompTextarea>
                  <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <CompInput :withPadding="false" name="informed_by" v-model="formTicket.informed_by" :message="errors.informed_by" @keydown="errors.informed_by = null">Informado por</CompInput>
                    <CompInput :withPadding="false" type="date" name="opened_at" v-model="formTicket.opened_at" :message="errors.opened_at" @keydown="errors.opened_at = null">Aberto em</CompInput>
                  </div>
                  <div>
                    <LinkButton tag="button" @click="submitTicket()">Adicionar</LinkButton>
                  </div>
                </div>

                <div class="mt-8">
                  <h2 class="font-medium text-gray-700 text-xl pt-4">Histórico</h2>

                  <ul class="mt-6">
                    <li v-for="ticket in airConditioner.tickets" :key="ticket.id" class="flex items-start relative group">
                      <div class="absolute right-full top-[2.5rem] bottom-0 w-px bg-slate-200 block -mr-5"></div>
                      <SpeakerphoneIcon class="w-10 h-10 text-slate-300 bg-slate-50 border border-slate-200 p-2 mr-5 rounded-full z-10" />
                      <div>
                        <div class="flex items-center space-x-3 mb-2 mt-1">
                          <h3 class="font-bold text-lg">
                            {{ ticket.informed_by }}
                          </h3>
                          <time class="font-medium text-xs text-blue-700 bg-blue-50 ml-2 px-2 py-1 inline-flex items-center rounded-full">
                            <CalendarIcon class="h-4 w-4 mr-1 text-blue-400/60 inline"/>
                            <span>{{ ticket.date_diff }}</span>
                          </time>
                          <time class="text-xs text-white group-hover:text-gray-400">{{ ticket.opened_date }}</time>
                        </div>
                        <p class="text-slate-500 text-sm mb-12 whitespace-pre-line">{{ ticket.problem }}</p>
                      </div>
                      <div class="text-slate-100 group-hover:text-gray-400">
                        <BtnDelete :id="ticket.id" :route="`/air_conditioners/${airConditioner.id}/tickets/`" />
                      </div>
                    </li>
                  </ul>
                </div>
              </Tab>

            </TabsWrapper>
          </div>

          <!-- Panel Right -->
          <div class="bg-white shadow overflow-hidden sm:rounded-lg min-w-[295px]">
            <div class="px-4 py-5 sm:px-6">
              <dl>
                <div class="py-5">
                  <div class="bg-slate-100 p-2 max-w-[250px]">
                    <dt class="text-sm text-gray-500 sr-only">Tombamento</dt>
                    <dd class="text-2xl rounded-lg text-center border border-blue-800 bg-slate-100 py-4 px-2 font-semibold">
                      <span v-if="airConditioner.identifier" class="font-mono flex items-center justify-between text-slate-500 tracking-wider after:content-[''] after:w-5 after:h-5 after:rounded-full after:bg-gray-500 after:border-[6px] after:border-gray-300 after:inline-block before:content-[''] before:w-5 before:h-5 before:rounded-full before:bg-gray-500 before:border-[6px] before:border-gray-300 before:inline-block">{{ airConditioner.identifier }}</span>
                      <span v-else class="font-mono text-sm flex items-center justify-between text-red-400 tracking-wider after:content-[''] after:w-5 after:h-5 after:rounded-full after:bg-gray-500 after:border-[6px] after:border-gray-300 after:inline-block before:content-[''] before:w-5 before:h-5 before:rounded-full before:bg-gray-500 before:border-[6px] before:border-gray-300 before:inline-block">Sem tombamento</span>
                    </dd>
                  </div>
                </div>
                <div>
                  <dt class="text-sm text-gray-500 sr-only">Marca e BTU</dt>
                  <dd class="mt-1 text-gray-900 sm:mt-0 space-x-2"><span class="font-bold uppercase">{{ airConditioner.brand }}</span><span v-if="airConditioner.btu" class="px-3 py-1 font-bold bg-blue-100 rounded-full text-blue-700">{{ airConditioner.btu }} <label class="text-xs font-normal">BTUs</label></span></dd>
                </div>
                <div v-if="airConditioner.cpf" class="py-5 flex items-center gap-4">
                  <dt class="text-sm text-gray-400">CPF</dt>
                  <dd class="text-sm text-gray-900 mt-0">{{ airConditioner.cpf }}</dd>
                </div>
              </dl>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import LinkButton from '@/Components/LinkButton.vue';
import CompInput from '@/Components/Input.vue';
import CompTextarea from '@/Components/Textarea.vue';
import BtnDelete from '@/Components/Delete.vue';
import TabsWrapper from '@/Components/TabsWrapper.vue';
import Tab from '@/Components/Tab.vue';
import { CalendarIcon, SpeakerphoneIcon, TrashIcon  } from '@heroicons/vue/outline';
import { reactive, onMounted } from 'vue';

const formTicket = reactive({
  problem: null,
  opened_at: (new Date().getFullYear()+'-'+(new Date().getMonth() + 1).toString().padStart(2, '0')+'-'+new Date().getDate()),
  informed_by: props.user.name,
});

const props = defineProps({
  user: Object,
  airConditioner: Object,
  errors: Object,
});

async function submitTicket() {
  this.loading = true;
  Inertia.post(route('air_conditioners.tickets.store', props.airConditioner.id), this.formTicket, {
    preserveState: (page) => Object.keys(page.props.errors).length,
  });
  this.loading = false;
}

onMounted(() => {
  document.getElementById("problem")?.focus()
})
</script>
