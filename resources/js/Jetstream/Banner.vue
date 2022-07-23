<script setup>
import { computed, ref, watch } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';

const show = ref(true);
const style = computed(() => usePage().props.value.jetstream.flash?.bannerStyle || 'success');
const message = computed(() => usePage().props.value.jetstream.flash?.banner || '');

watch(message, async () => {
  show.value = true;
});
</script>

<template>
    <div class="absolute bottom-4 right-0 px-4 z-50 w-full max-w-2xl">
        <div v-if="show && message" :class="{ 'bg-green-50 border border-green-500': style == 'success', 'bg-red-50 border border-red-500': style == 'danger' }" class=" rounded overflow-hidden">
            <div class="max-w-screen-xl mx-auto py-3 px-3">
                <div class="flex items-center justify-between flex-wrap">
                    <div class="w-0 flex-1 flex items-center min-w-0 pr-3">
                        <span class="flex p-2 rounded-lg" :class="{ 'text-green-600': style == 'success', 'text-red-600': style == 'danger' }">
                            <svg
                                v-if="style == 'success'"
                                class="h-6 w-6"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>

                            <svg
                                v-if="style == 'danger'"
                                class="h-6 w-6"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                                />
                            </svg>
                        </span>

                        <p 
                            class="ml-1 font-medium text-sm text-white"
                            :class="{ 'text-green-600': style == 'success', 'text-red-600': style == 'danger' }">
                            {{ message }}
                        </p>
                    </div>

                    <div class="shrink-0 mr-3">
                        <button
                            type="button"
                            class="-mr-1 flex p-2 rounded-md focus:outline-none transition"
                            :class="{ 'bg-green-200 text-green-600 hover:bg-green-300 focus:bg-green-600': style == 'success', 'bg-red-200 text-red-600 hover:bg-red-300 focus:bg-red-600': style == 'danger' }"
                            aria-label="Dismiss"
                            @click.prevent="show = false"
                        >
                            <svg
                                class="h-5 w-5"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
