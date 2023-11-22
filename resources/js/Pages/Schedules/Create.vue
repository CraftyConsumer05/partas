<script setup>
import { onMounted , ref } from 'vue';
import { formatISO, addHours, addDays } from 'date-fns';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { reactive } from 'vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
  routes: Object,
  buses: Object
});

const form = reactive({
  departure_time: "",
  arrival_time: "",
  price: "",
  bus_id: "",
  route_id: ""
});

const warningMessage1 = ref('');
const warningMessage2 = ref('');

function submit() {

    // for validation error
    setTimeout(() => {
    warningMessage1.value = '';
    warningMessage2.value = '';
  }, 2000);

  // Get the current time in UTC with the timezone offset of the Philippines (UTC+8)
  const currentUTC = formatISO(addHours(new Date(), 8)).slice(0, 16);

  // Check if the departure_time is in the past or arrival_time is less than 2 days ahead
  if (form.departure_time < currentUTC) {
    warningMessage1.value = "Cannot submit form with a past departure time";
    return;
  }

  const minArrivalTime = formatISO(addDays(new Date(), 2)).slice(0, 16);

  if (form.arrival_time <= minArrivalTime) {
    warningMessage2.value = "Cannot submit form with arrival time less than 2 days ahead";
    return;
  }

  // If both conditions are satisfied, proceed with form submission
  router.post(route("schedule.store"), form);
}

onMounted(() => {
  // Get the current time in UTC with the timezone offset of the Philippines (UTC+8)
  const currentUTC = formatISO(addHours(new Date(), 24)).slice(0, 16);

  form.departure_time = currentUTC;

  // Set arrival_time to at least 2 days ahead
  form.arrival_time = formatISO(addDays(new Date(), 2)).slice(0, 16);
});

</script>

<template>
  <Head title="Create Bus " />

  <AuthenticatedLayout>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden ma-8 w-100 bg-red-200 rounded-lg border shadow-xs">
          <div class="flex md:items-center m-6">
            <form class="w-full max-w-sm" @submit.prevent="submit">
                <div class="md:w-1/3 relative">
    <InputLabel for="departure_time" class="" value="Departure Time" />
    <p v-show="warningMessage1" class="absolute text-xs bg-red-100 text-red-600 p-1 top-0 right-0 z-10">{{ warningMessage1 }}</p>
</div>
<div class="block w-full">
    <TextInput id="departure_time" type="datetime-local" v-model="form.departure_time" required />
</div>

<div class="md:w-1/3 relative">
    <InputLabel for="arrival_time" value="Arrival Time" />
    <p v-show="warningMessage2" class="absolute text-xs bg-red-100 text-red-600 p-1 top-0 right-0 z-10">{{ warningMessage2 }}</p>
</div>
<div class="block w-full">
    <TextInput id="arrival_time" type="datetime-local" v-model="form.arrival_time" required />
</div>

                                <div>
                                    <InputLabel for="price"  value="Price"/>
                                </div>
                                <div class="block w-full">
                                    <TextInput  id="price"  type="number" v-model="form.price" required />
                                </div>
                                <InputLabel for="route" class="block font-medium text-gray-700">Select Bus Route:</InputLabel>
                                <select id="route" v-model="form.route_id" class="mt-1 block w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:outline-none focus:border-indigo-500">
                                    <option v-for="route in routes"  :value="route.id">{{ route.origin }} - {{ route.destination }}</option>
                                 </select>

                                 <InputLabel for="bus" class="block font-medium text-gray-700">Select Bus </InputLabel>
                                <select id="route" v-model="form.bus_id" class="mt-1 block w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:outline-none focus:border-indigo-500">
                                    <option v-for="bus in buses"  :value="bus.id">{{ bus.code }} - {{ bus.type }}</option>
                                 </select>

                                <div class=" py-3 md:w-1/3">
                                <PrimaryButton type="submit"> Submit  </PrimaryButton>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>