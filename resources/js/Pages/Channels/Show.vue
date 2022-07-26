<script setup>
import { ref } from 'vue';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

const props = defineProps({
    data: Object,
});

const photoPreview = ref(null);
const photoInput = ref(null);

const form = useForm({
    _method: 'PATCH',
    name: props.data.channel.name,
    description: props.data.channel.description,
    image: null,
});

const submit = () => {

    if (photoInput.value) {
        form.image = photoInput.value.files[0];
    }

    form.post(route('channels.update', props.data.channel), {
        errorBag: 'updateChannel',
        preserveScroll: true,
        onSuccess: () => clearPhotoFileInput(),
    });

    console.log('Update channel');
};

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0];

    if (! photo) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };

    reader.readAsDataURL(photo);
};

const clearPhotoFileInput = () => {
    if (photoInput.value?.value) {
        photoInput.value.value = null;
    }
};

const toogleSubscription = () => {
    console.log("subsciption");
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
                                    <div class="relative rounded-full lg:block">
                                        <!-- Profile Photo File Input -->
                                        <input ref="photoInput" type="file" class="hidden" @change="updatePhotoPreview">
                                        <!-- Current Profile Photo -->
                                        <div v-show="! photoPreview" class="mt-2">
                                            <div v-if="props.data.image_url">
                                                <img class="relative rounded-full w-40 h-40 object-cover" :src="props.data.image_url" :alt="form.name" />
                                            </div>
                                            <div v-else>
                                                <svg class="relative rounded-full w-40 h-40 object-cover text-gray-300 border border-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <!-- New Profile Photo Preview -->
                                        <div v-show="photoPreview" class="mt-2">
                                            <span class="block rounded-full w-40 h-40 bg-cover bg-no-repeat bg-center" :style="'background-image: url(\'' + photoPreview + '\');'" />
                                        </div>
                                        <InputError :message="form.errors.image" class="mt-2" />
                                    </div>
                                </div>

                                <div class="mt-4 flex justify-center lg:mt-0 lg:ml-6 lg:flex-grow-0 lg:flex-shrink-0">
                                    <BreezeButton class="mt-6" type="button" @click.prevent="selectNewPhoto">
                                        Select A New Photo
                                    </BreezeButton>
                                </div>

                                <div class="mt-6 flex flex-col lg:flex-row">
                                    <div class="flex-grow space-y-6">
                                        <div>
                                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                            <input type="text" v-model="form.name" id="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm" />
                                            <InputError :message="form.errors.name" class="mt-2" />
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


                            <div class="flex justify-between">
                                <div class="py-6 px-5 flex justify-start">

                                    <button type="button" @click="toogleSubscription" class="inline-flex items-center px-3 py-2 border border-red-300 shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        Unsubscribe 7k
                                    </button>

                                </div>

                                <div class="py-6 px-5 flex justify-end">
                                    <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        Update Channel
                                    </BreezeButton>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
