<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import NewDropdown from '@/Components/NewDropdown.vue';
import CustomCheckbox from '@/Components/CustomCheckbox.vue';

const props = defineProps({
    role : Object,
    permissions: Array,
    role_permissions: Array,
});

const form = useForm({
    id: props.role.id, // Role ID
    name: props.role.name, // Role name
    permissions: props.role_permissions,
});

const submit = () => {
     form.put(route("roles.update", props.role.id));
};
</script>
<template>
    <Head title="Edit Role" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Role</h2>
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

                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div>
                            <InputLabel for="permissions" value="Permissions" />
                            <div class="mt-2 space-y-2">
                             
                               <div :class="permissions.length > 5 ? 'grid grid-cols-2 gap-4' : 'space-y-2'">
                                    <div v-for="permission in permissions" :key="permission.id">
                                        <CustomCheckbox :value="permission.name" :checked="form.permissions" @update:checked="form.permissions = $event" />
                                        <label class="ml-2">{{ permission.name }}</label>
                                    </div>
                                </div>


                            </div>
                            <InputError class="mt-2" :message="form.errors.permissions" />
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