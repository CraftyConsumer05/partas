<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,router  } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { reactive,ref } from 'vue'

import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import { onMounted } from 'vue';
import { watchEffect } from 'vue';
import { propsToAttrMap } from '@vue/shared';

const $toast = useToast();


  const form=reactive({
      origin: "",
      destination: "",
  })

  function submit() {
    if(form.origin === form.destination){
        // alert("Origin and Destination cannot be the same");
        
        $toast.info("Origin and Destination cannot be the same", {
        position: "top",
        dismissible: true,
        duration: 3000
        });
        return;
    }

    if(!form.origin || !form.destination){
        // alert("All fields are required");
        
        $toast.info("All fields are required", {
        position: "top",
        dismissible: true,
        duration: 3000
        });
        return;
    }

    router.post(route("busroutes.store"),form);
    // alert("Route created");

  }
  defineProps({
    locations: Object,
})


</script>

<template>
    <Head title="Create Bus Route" />

    <AuthenticatedLayout>


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden ma-8 w-100  bg-red-200 rounded-lg border shadow-xs">
                    <div class="p-3 flex justify-center">
                        <h1>ADD NEW ROUTE</h1>
                    </div>
                    <div class="overflow-x-auto  m-5">
                        <form class="w-full max-w-sm"  @submit.prevent="submit">
                            <div class="mb-4">
                                <InputLabel for="origin" class="block font-medium text-gray-700">Select Origin:</InputLabel>
                                <select id="route" v-model="form.origin" class="mt-1 block w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:outline-none focus:border-indigo-500">
                                    <option v-for="location in locations"  :value="location.location">
                                        {{ location.location }} </option>
                                 </select>

                                 <InputLabel for="destination" class="block font-medium text-gray-700">Select Destination </InputLabel>
                                <select id="route" v-model="form.destination" class="mt-1 block w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:outline-none focus:border-indigo-500">
                                    <template v-for="location in locations">
                                        <option v-if="location.location != form.origin" :value="location.location">
                                        {{ location.location }}</option>
                                    </template>
                                    
                                 </select>
                            </div>
                                <PrimaryButton type="submit" class="flex items-center bg-blue-500 hover:bg-blue-700 text-white font-semibold px-3 py-2 rounded mx-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Submit
                                </PrimaryButton>
                            </form>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>