<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { reactive, watch } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const form = reactive({
  code: '',
  capacity: '',
  type: '',
});

function submit() {
  if (!validateCapacity()) {
    return;
  }
  router.post(route('bus.store'), form);
}

function generateCode() {
  switch (form.type) {
    case 'deluxe':
      form.code = `DEL${Math.floor(100 + Math.random() * 900)}`;
      break;
    case 'firstclass':
      form.code = `FCL${Math.floor(100 + Math.random() * 900)}`;
      break;
    case 'luxury':
      form.code = `LUX${Math.floor(100 + Math.random() * 900)}`;
      break;
    case 'superdeluxe':
      form.code = `SDL${Math.floor(100 + Math.random() * 900)}`;
      break;
    default:
      // Handle default case if needed
      break;
  }
}

watch(() => form.type, () => {
  generateCode();
  adjustCapacityLimits();
});

function adjustCapacityLimits() {
  switch (form.type) {
    case 'deluxe':
      form.capacity = clamp(form.capacity, 60, 80);
      break;
    case 'firstclass':
      form.capacity = clamp(form.capacity, 40, 50);
      break;
    case 'luxury':
      form.capacity = clamp(form.capacity, 30, 40);
      break;
    case 'superdeluxe':
      form.capacity = clamp(form.capacity, 20, 40);
      break;
    default:
      // Handle default case if needed
      break;
  }
}

function clamp(value, min, max) {
  return Math.min(Math.max(value, min), max);
}

function validateCapacity() {
  let capacityRange = '';
  switch (form.type) {
    case 'deluxe':
      capacityRange = '60-80';
      if (form.capacity < 60 || form.capacity > 80) {
        alert(`De Luxe buses only have a capacity of ${capacityRange}.`);
        return false;
      }
      break;
    case 'firstclass':
      capacityRange = '40-50';
      if (form.capacity < 40 || form.capacity > 50) {
        alert(`First Class buses only have a capacity of ${capacityRange}.`);
        return false;
      }
      break;
    case 'luxury':
      capacityRange = '30-40';
      if (form.capacity < 30 || form.capacity > 40) {
        alert(`Luxury buses only have a capacity of ${capacityRange}.`);
        return false;
      }
      break;
    case 'superdeluxe':
      capacityRange = '20-40';
      if (form.capacity < 20 || form.capacity > 40) {
        alert(`Super De Luxe buses only have a capacity of ${capacityRange}.`);
        return false;
      }
      break;
    default:
      break;
  }
  return true;
}
</script>

<template>
  <Head title="Create Bus" />
  <AuthenticatedLayout>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden ma-8 w-100 bg-red-200 rounded-lg border shadow-xs">
          <div class="flex md:items-center m-6">
            <form class="w-full max-w-sm" @submit.prevent="submit">
              <div class="md:w-1/3">
                <InputLabel for="code" class="" value="Code" />
              </div>
              <div class="block w-full">
                <TextInput id="origin" type="text" v-model="form.code" required readonly />
              </div>
              <InputLabel for="type" class="block font-medium text-gray-700">Select Bus Type:</InputLabel>
              <select id="type" v-model="form.type" class="mt-1 block w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:outline-none focus:border-indigo-500">
                <option value="deluxe">De Luxe</option>
                <option value="firstclass">First Class</option>
                <option value="luxury">Luxury</option>
                <option value="superdeluxe">Super De Luxe</option>
              </select>
              <InputLabel for="capacity" class="block w-1/2 mt-5" value="Capacity" />
              <TextInput
                id="capacity"
                type="number"
                v-model="form.capacity"
                required
              />
              <div class=" py-3 md:w-1/3">
                <PrimaryButton type="submit">Submit</PrimaryButton>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
