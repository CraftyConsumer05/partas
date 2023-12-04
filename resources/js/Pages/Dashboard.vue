<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Carousel from '@/Components/Carousel.vue';
import { Head } from '@inertiajs/vue3';

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="flex justify">
            <div class="p-6 dark:border-gray-700 mt-14 bg-blue-400">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div>
                        <img class="h-auto max-w-full rounded-lg" src="https://placehold.co/600x400?text=IMAGE" alt="example image" width="300" height="150">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg" src="https://placehold.co/600x400?text=IMAGE" alt="Example Image 2" width="300" height="150">
                    </div>
                    <div>
                        <img class="h-auto max-w-full rounded-lg" src="https://placehold.co/600x400?text=IMAGE" alt="Example Image 3" width="300" height="150">
                    </div>   
                </div>
                <div style="margin-top: 20px;">
                        <iframe src="https://maps.google.com/maps?q=Technological+Institute+of+the+Philippines%20Dates%20Products&amp;t=&amp;z=13&amp;ie=UTF8&amp;iwloc=&amp;output=embed" width=1000 height=500 allowfullscreen></iframe>
                </div>
            </div>
        </div>
        
    </AuthenticatedLayout>
    <Div>
        
    </Div>
</template>
