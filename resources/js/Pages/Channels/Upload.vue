<script setup>
import { ref } from 'vue';
import {Head, useForm} from '@inertiajs/inertia-vue3';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';

const props = defineProps({
    channel: Object,
    selected: {
        type: Boolean,
        default: false,
    }
});

const selected = ref(props.selected);
const videoInput = ref(null);

const form = useForm({
    video: null,
    title: null,
});

const submit = () => {
    if (videoInput.value) {
        form.video = videoInput.value.files[0];
        form.title = form.video.name
    }

    selected.value = true

    form.post(route('channel.video.store', props.channel), {
        errorBag: 'uploadVideo',
        preserveScroll: true,
        onSuccess: () => clearVideoFileInput(),
    });

    console.log(form.video)
};

const uploadVideo = (event) => {
    const video = event.target.files[0];

    if (! video) return;

    const reader = new FileReader();

    reader.onload = (event) => {
        videoInput.video = event.target.result;
    };

    reader.readAsDataURL(video);
};

const clearVideoFileInput = () => {
    if (videoInput.value?.value) {
        videoInput.value.value = null;
    }
};

</script>

<template>
    <Head title="Upload" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">Upload Videos</h2>
                </div>

            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div v-if="!selected" class="px-4 py-5 sm:px-6">
                        <form @submit.prevent="submit">
                            <div class="flex justify-center">
                                <svg class="h-16 w-16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 461 461"><path d="M365.26 67.4H95.74A95.74 95.74 0 0 0 0 163.13v134.73a95.74 95.74 0 0 0 95.74 95.74h269.52A95.74 95.74 0 0 0 461 297.87V163.14a95.74 95.74 0 0 0-95.74-95.75zM300.5 237.05l-126.06 60.12a5.06 5.06 0 0 1-7.24-4.57v-124a5.06 5.06 0 0 1 7.34-4.52l126.06 63.88a5.06 5.06 0 0 1-.1 9.09z" fill="#f61c0d"/></svg>
                            </div>
                            <p class="flex justify-center">Upload Videos</p>

                            <input
                                ref="videoInput"
                                type="file"
                                accept="video/mp4"
                                @change="uploadVideo"
                            >
                            <BreezeButton class="mt-4 flex justify-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Submit
                            </BreezeButton>

                        </form>
                    </div>
                    <div class="px-4 py-5 sm:p-6">

                        <div class="grid grid-rows-3 grid-flow-col gap-4">
                            <div class="row-span-1 col-span-4">
                                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                    {{ form.progress.percentage }}%
                                </progress>
                            </div>
                            <div class="row-span-2 col-span-2 h-48 bg-gray-100">
                                <div class="bg-cyan-500 flex justify-center">
                                    Loading thumbnail ...
                                </div>
                            </div>
                            <div class="row-span-2 col-span-2">My awesome video</div>
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
