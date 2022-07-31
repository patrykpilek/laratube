<script setup>
import { ref, computed } from 'vue';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
import InputError from '@/Components/InputError.vue';
import { Link, Head, useForm } from '@inertiajs/inertia-vue3';
import numeral from 'numeral';
import {Inertia} from "@inertiajs/inertia";

const props = defineProps({
    data: Object,
    auth: Object,
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
    if(owner.value) {
        return alert('You cannot subscribe to your channel.')
    }

    if(subscription.value) {
        console.log("Delete")
        Inertia.delete(route('subscriptions.destroy', [props.data.channel.id, subscription.value.id]))
    } else {
        console.log("post")
        Inertia.post(route('subscriptions.store', props.data.channel.id))
    }

};

const owner = computed(() => {
    return !!(props.auth.user && props.data.channel.user_id === props.auth.user.id);
})

const subscription = computed(() => {
    if(! props.auth.user || props.data.channel.user_id === props.auth.user.id) return false
    return props.data.channel.subscriptions.find(subscription => subscription.user_id === props.auth.user.id)
})

const count = computed(() => {

    return numeral(props.data.channel.subscriptions.length).format('0a')

})
</script>

<template>
    <Head title="My Channel" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">My Channel</h2>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <Link :href="route('channel.upload', props.data.channel)" method="get" as="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Upload Videos</Link>
                </div>
            </div>
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

                                    <div v-show="owner">
                                        <button type="button" @click="toogleSubscription" class="inline-flex items-center px-3 py-2 border border-red-300 shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            {{ count }} {{ owner ? 'Subscribers' : '' }}
                                        </button>
                                    </div>

                                    <div v-show="!owner">
                                        <button type="button" @click="toogleSubscription" class="inline-flex items-center px-3 py-2 border border-red-300 shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            {{ subscription ? 'Unsubscribe' : 'Subscribe' }}
                                        </button>
                                    </div>

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
