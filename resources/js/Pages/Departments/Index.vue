<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

const props = defineProps({
    departments: {type:Object}
});
const form = useForm({
    id:''
});
const deleteDepartment = (id, name) => {
    const alert = Swal.mixin({
        buttonsStyling: true
    });
    alert.fire({
        title: 'Are you sure delete ' + name + ' department?',
        icon:'question',
        showCancelButton: true,
        confirmButtonTex: '<i class="fa-solid fa-check"></i> Yes, delete it!',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> No, cancel!',
    }).then((result) => {
        if(result.isConfirmed){
            form.delete( route('departments.destroy', id) );
        }
    });
}
</script>
<template>
    <Head title="Departments" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Departments</h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center">
                <div class="mt-3 mb-3 flex">
                    <Link :href="route('departments.create')"
                        :class="'px-4 py-2 bg-gray-400 text-white border rounded-md font-semibold text-xs'"
                    >
                    <i class="fa-solid fa-plus-circle"></i> Add
                    </Link>
                </div>
            </div>
            <div class="bg-white grid v-screen place-items-center">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-4">#</th>
                            <th class="px-4 py-4">DEPARTMENT</th>
                            <th class="px-4 py-4"></th>
                            <th class="px-4 py-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="dep, i in departments" :key="dep.id">
                            <td class="border border-gray-400 px-4 py-4">{{ (i+1) }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ dep.name }}</td>
                            <td class="border border-gray-400 px-4 py-4">
                                <Link :href="route('departments.edit', dep.id)"
                                    :class="'px-4 py-2 bg-yellow-400 text-white border rounded-md font-semibold text-xs'"
                                >
                                <i class="fa-solid fa-edit"></i>
                                </Link>
                            </td>
                            <td class="border border-gray-400 px-4 py-4">
                                <DangerButton
                                    @click="deleteDepartment(dep.id, dep.name)"
                                    :class="'px-4 py-2 bg-red-400 text-white border rounded-md font-semibold text-xs'"
                                >
                                <i class="fa-solid fa-trash"></i>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>