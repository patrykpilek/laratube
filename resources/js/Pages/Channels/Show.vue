<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';

const props = defineProps({
    channel: Object,
});

const form = useForm({
    _method: 'PATCH',
    name: props.channel.name,
    description: props.channel.description,
    image: props.channel.image,
});

const submit = () => {
    console.log('Update channel');
};

</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Channel
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit" class="divide-y divide-gray-200 lg:col-span-9">
                            <div class="py-6 px-4 sm:p-6 lg:pb-8">
                                <div class="mt-6 flex justify-center lg:mt-0 lg:ml-6 lg:flex-grow-0 lg:flex-shrink-0 ">
                                    <div class="mt-1 lg:hidden">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 inline-block rounded-full overflow-hidden h-12 w-12" aria-hidden="true">
                                                <div v-if="form.image">
                                                    <img class="rounded-full h-full w-full" :src="form.image" :alt="form.name" />
                                                </div>
                                                <div v-else>
                                                    <svg class="rounded-full h-full w-full text-gray-300 border border-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-5 rounded-md shadow-sm">
                                                <div class="group relative border border-gray-300 rounded-md py-2 px-3 flex items-center justify-center hover:bg-gray-50 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-sky-500">
                                                    <label for="mobile-channel-image" class="relative text-sm leading-4 font-medium text-gray-700 pointer-events-none">
                                                        <span>Change</span>
                                                        <span class="sr-only">channel image</span>
                                                    </label>
                                                    <input id="mobile-channel-image" name="channel-image" type="file" class="absolute w-full h-full opacity-0 cursor-pointer border-gray-300 rounded-md" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hidden relative rounded-full overflow-hidden lg:block">
                                        <div v-if="form.image">
                                            <img class="relative rounded-full w-40 h-40" :src="form.image" :alt="form.name" />
                                        </div>
                                        <div v-else>
                                            <svg class="relative rounded-full w-40 h-40 text-gray-300 border border-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                            <label for="desktop-channel-image" class="absolute inset-0 w-full h-full bg-black bg-opacity-75 flex items-center justify-center text-sm font-medium text-white opacity-0 hover:opacity-100 focus-within:opacity-100">
                                                <span>Change</span>
                                                <span class="sr-only">channel image</span>
                                                <input type="file" id="desktop-channel-image" name="channel-image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer border-gray-300 rounded-md" />
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6 flex flex-col lg:flex-row">
                                    <div class="flex-grow space-y-6">
                                        <div>
                                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                            <input type="text" v-model="form.name" id="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm" />
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6 flex flex-col lg:flex-row">
                                    <div class="flex-grow space-y-6">
                                        <div>
                                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                            <div class="mt-1">
                                                <textarea id="description" v-model="form.description" rows="4" class="shadow-sm focus:ring-sky-500 focus:border-sky-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" />
                                            </div>
                                            <p class="mt-2 text-sm text-gray-500">Brief description for your channel.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 py-4 px-4 flex justify-end sm:px-6">
                                <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Update Channel
                                </BreezeButton>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
