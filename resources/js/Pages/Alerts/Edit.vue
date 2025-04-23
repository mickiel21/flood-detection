<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import NewDropdown from '@/Components/NewDropdown.vue';

const page = usePage();
const sensors = page.props.sensors; // Get sensors for dropdown
const severityOptions = ['Low', 'Medium', 'High', 'Critical']; // Severity dropdown options

const props = defineProps({
    alert: Object, // Alert data
});

const form = useForm({
    sensor_id: props.alert.sensor_id, // Sensor selection
    type: props.alert.type,
    severity: props.alert.severity,
    message: props.alert.message,
});

const submit = () => {
    form.put(route("alerts.update", props.alert.id));
};
</script>

<template>
    <Head title="Edit Alert" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Alert</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <section>
                    <form @submit.prevent="submit" class="mt-6 space-y-6">
                        <!-- Sensor Dropdown -->
                        <div>
                            <InputLabel for="sensor_id" value="Select Sensor" />
                            <select
                                id="sensor_id"
                                v-model="form.sensor_id"
                                class="mt-1 block w-full rounded-md form-select focus:border-indigo-600"
                                required
                            >
                                <option value="" disabled>Select a Sensor</option>
                                <option v-for="sensor in sensors" :key="sensor.id" :value="sensor.id">
                                    {{ sensor.name }} ({{ sensor.location }})
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.sensor_id" />
                        </div>

                        <!-- Type Input -->
                        <div>
                            <InputLabel for="type" value="Type" />
                            <TextInput id="type" type="text" class="mt-1 block w-full" v-model="form.type" required />
                            <InputError class="mt-2" :message="form.errors.type" />
                        </div>

                        <!-- Severity Dropdown -->
                        <div>
                            <InputLabel for="severity" value="Severity" />
                            <NewDropdown id="severity" class="mt-1 block w-full" v-model="form.severity" :options="severityOptions" required />
                            <InputError class="mt-2" :message="form.errors.severity" />
                        </div>

                        <!-- Message Input -->
                        <div>
                            <InputLabel for="message" value="Message" />
                            <TextInput id="message" type="text" class="mt-1 block w-full" v-model="form.message" required />
                            <InputError class="mt-2" :message="form.errors.message" />
                        </div>

                        <!-- Submit -->
                        <div class="flex items-center gap-4">
                            <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
                            <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0" leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                                <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                            </Transition>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </AuthenticatedLayout>
</template>