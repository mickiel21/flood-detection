<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import NewDropdown from '@/Components/NewDropdown.vue';

const props = defineProps({
    sensor : Object
});

const form = useForm({
    id: props.sensor.id, // Sensor ID
    name: props.sensor.name, // Sensor name
    type: props.sensor.type, // Sensor type
    location: props.sensor.location, // Sensor location
    status: props.sensor.status, // Sensor status (e.g., active/inactive)
    min_value: props.sensor.min_value, // Minimum sensor value
    max_value: props.sensor.max_value, // Maximum sensor value
    installation_date: props.sensor.installation_date, // Installation date
});

const statusOptions = ['active', 'inactive']; // Severity dropdown options
const submit = () => {
     form.put(route("sensors.update", props.sensor.id));
};
</script>
<template>
    <Head title="Edit Sensor" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Sensor</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <section>
                    <form @submit.prevent="submit" class="mt-6 space-y-6">
                        <div>
                            <InputLabel for="name" value="Name" />

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                                autofocus
                            />

                            <InputError class="mt-2" :message="form.errors.heading" />
                        </div>

                        <div>
                            <InputLabel for="type" value="Type" />

                            <TextInput
                                id="type"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.type"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.type" />
                        </div>

                        <div>
                            <InputLabel for="location" value="Location" />

                            <TextInput
                                id="location"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.location"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.location" />
                        </div>
                        <div>
                            <InputLabel for="status" value="Status" />
                            <NewDropdown id="severity" class="mt-1 block w-full" v-model="form.status" :options="statusOptions" required />

                            <InputError class="mt-2" :message="form.errors.status" />
                        </div>
                        <div>
                            <InputLabel for="min_value" value="Min Value" />

                            <TextInput
                                id="min_value"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.min_value"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.min_value" />
                        </div>
                        <div>
                            <InputLabel for="max_value" value="Max Value" />

                            <TextInput
                                id="max_value"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.max_value"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.max_value" />
                        </div>
                        <div>
                            <InputLabel for="installation_date" value="Installation Date" />

                            <TextInput
                                id="installation_date"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.installation_date"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.installation_date" />
                        </div>

                        <div class="flex items-center gap-4">
                            <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                            <Transition
                                enter-active-class="transition ease-in-out"
                                enter-from-class="opacity-0"
                                leave-active-class="transition ease-in-out"
                                leave-to-class="opacity-0"
                            >
                                <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                            </Transition>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </AuthenticatedLayout>
</template>