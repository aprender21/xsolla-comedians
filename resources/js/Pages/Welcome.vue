<template>
    <Head title="xSolla Code Challenge" />

    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        <div class="w-full mx-24 my-20 sm:px-6 lg:px-8">
            <button class="text-white" @click="createComedian">
                <DocumentAddIcon class="w-5 h-5 inline mr-2" /> Create Comedian
            </button>

            <div class="mt-8 w-full bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg text-white">
                <table class="divide-solid divide-y text-left w-full">
                    <tr>
                        <th class="px-4 py-4 text-xl">Name</th>
                        <th class="px-4 py-4 text-xl">Description</th>
                        <th class="px-4 py-4 text-xl">Code</th>
                        <th class="px-4 py-4 text-xl">Status</th>
                        <th class="px-4 py-4 text-xl"></th>
                    </tr>

                    <tr v-for="(comedian, index) in comedians">
                        <td class="px-4 py-4">{{ comedian.name }}</td>
                        <td class="px-4 py-4">{{ comedian.description }}</td>
                        <td class="px-4 py-4">{{ comedian.code }}</td>
                        <td class="px-4 py-4">{{ comedian.status }}</td>
                        <td class="px-4 py-4">
                            <button @click="updateComedian(index, comedian)">
                                <PencilIcon class="w-5 h-5 inline mr-2" />
                            </button>
                            <button @click="deleteComedian(index, comedian)">
                                <TrashIcon class="w-5 h-5 inline cursor-pointer" />
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .bg-gray-100 {
        background-color: #f7fafc;
        background-color: rgba(247, 250, 252, var(--tw-bg-opacity));
    }

    .border-gray-200 {
        border-color: #edf2f7;
        border-color: rgba(237, 242, 247, var(--tw-border-opacity));
    }

    .text-gray-400 {
        color: #cbd5e0;
        color: rgba(203, 213, 224, var(--tw-text-opacity));
    }

    .text-gray-500 {
        color: #a0aec0;
        color: rgba(160, 174, 192, var(--tw-text-opacity));
    }

    .text-gray-600 {
        color: #718096;
        color: rgba(113, 128, 150, var(--tw-text-opacity));
    }

    .text-gray-700 {
        color: #4a5568;
        color: rgba(74, 85, 104, var(--tw-text-opacity));
    }

    .text-gray-900 {
        color: #1a202c;
        color: rgba(26, 32, 44, var(--tw-text-opacity));
    }

    @media (prefers-color-scheme: dark) {
        .dark\:bg-gray-800 {
            background-color: #2d3748;
            background-color: rgba(45, 55, 72, var(--tw-bg-opacity));
        }

        .dark\:bg-gray-900 {
            background-color: #1a202c;
            background-color: rgba(26, 32, 44, var(--tw-bg-opacity));
        }

        .dark\:border-gray-700 {
            border-color: #4a5568;
            border-color: rgba(74, 85, 104, var(--tw-border-opacity));
        }

        .dark\:text-white {
            color: #fff;
            color: rgba(255, 255, 255, var(--tw-text-opacity));
        }

        .dark\:text-gray-400 {
            color: #cbd5e0;
            color: rgba(203, 213, 224, var(--tw-text-opacity));
        }
    }
</style>

<script>
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import { DocumentAddIcon, PencilIcon, TrashIcon } from '@heroicons/vue/outline'

    export default {
        props: {
            // initialComedianList: Array,
            canLogin: Boolean,
            canRegister: Boolean,
        },
        components: {
            Head,
            Link,
            DocumentAddIcon,
            PencilIcon,
            TrashIcon,
        },
        data() {
            return {
                comedians: [],
            }
        },
        mounted() {
            this.getComedians();
        },
        methods: {
            getComedians() {
                axios.get(route('api.comedian.list'))
                    .then(response => {
                        this.comedians = response.data;
                    })
                    .catch(error => {
                        this.$swal.fire({
                            icon: 'error',
                            title: 'Unable to get comedians!',
                            text: 'Something went wrong!',
                        })
                    });
            },
            createComedian() {
                // Show modal form and then submit request to API
                this.$swal.fire({
                    title: 'Edit Comedian',
                    html:
                        '<input id="comedian-name" placeholder="Name" class="swal2-input" />' +
                        '<input id="comedian-description" placeholder="Description" class="swal2-input" />' +
                        '<input id="comedian-code" placeholder="code" class="swal2-input" />' +
                        '<select id="comedian-status" class="swal2-input">' +
                            '<option value="active">Active</option>' +
                            '<option value="inactive">Inactive</option>' +
                        '</select>',
                    focusConfirm: false,
                    showCancelButton: true,
                    confirmButtonText: 'Create',
                }).then((result) => {
                    // Skip if user canceled
                    if (!result.isConfirmed) {
                        return;
                    }

                    // Get params for API request
                    const comedianParams = {
                        name: document.getElementById('comedian-name').value,
                        description: document.getElementById('comedian-description').value,
                        code: document.getElementById('comedian-code').value,
                        status: document.getElementById('comedian-status').value,
                    };

                    // Call API to update comedian
                    axios.post(route('api.comedian.create'), comedianParams)
                        .then(response => {
                            // Add new record to list and show success alert
                            this.comedians.push(response.data);
                            this.$swal.fire('Comedian created!');
                        })
                        .catch(error => {
                            console.log(error.response.data);
                            this.$swal.fire({
                                icon: 'error',
                                title: 'Unable to create comedian!',
                                text: (error.response.status === 422) ? error.response.data.message : 'Something went wrong!',
                            })
                        });
                });
            },
            updateComedian(index, comedian) {
                // Show modal form and then submit request to API
                this.$swal.fire({
                    title: 'Edit Comedian',
                    html:
                        '<input id="comedian-id" class="hidden" value="' + comedian.id + '" />' +
                        '<input id="comedian-name" placeholder="Name" class="swal2-input" value="' + comedian.name + '" />' +
                        '<input id="comedian-description" placeholder="Description" class="swal2-input" value="' + comedian.description + '" />' +
                        '<input id="comedian-code" placeholder="code" class="swal2-input" value="' + comedian.code + '" />' +
                        '<select id="comedian-status" class="swal2-input">' +
                            '<option value="active" ' + ((comedian.status === 'active') ? 'selected="selected"' : '') + '>Active</option>' +
                            '<option value="inactive" ' + ((comedian.status === 'inactive') ? 'selected="selected"' : '') + '>Inactive</option>' +
                        '</select>',
                    focusConfirm: false,
                    showCancelButton: true,
                    confirmButtonText: 'Update',
                }).then((result) => {
                    // Skip if user canceled
                    if (!result.isConfirmed) {
                        return;
                    }

                    // Get params for API request
                    const id = document.getElementById('comedian-id').value;
                    const comedianParams = {
                        name: document.getElementById('comedian-name').value,
                        description: document.getElementById('comedian-description').value,
                        code: document.getElementById('comedian-code').value,
                        status: document.getElementById('comedian-status').value,
                    };

                    // Call API to update comedian
                    axios.put(route('api.comedian.update', id), comedianParams)
                        .then(response => {
                            // Modify updated record in list and show success alert
                            this.comedians.splice(index, 1, comedianParams)
                            this.$swal.fire('Comedian updated!');
                        })
                        .catch(error => {
                            this.$swal.fire({
                                icon: 'error',
                                title: 'Unable to update comedian!',
                                text: (error.response.status === 422) ? error.response.data.message : 'Something went wrong!',
                            })
                        });
                });
            },
            deleteComedian(index, comedian) {
                this.$swal.fire({
                    title: 'Do you want to delete ' + comedian.name + '?',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                }).then((result) => {
                    axios.delete(route('api.comedian.delete', comedian.id))
                        .then(response => {
                            // Remove record from list and show success alert
                            this.comedians.splice(index, 1)
                            this.$swal.fire('Comedian deleted!');
                        })
                        .catch(error => {
                            this.$swal.fire({
                                icon: 'error',
                                title: 'Unable to delete comedian!',
                                text: 'Something went wrong!',
                            })
                        });
                });

            }
        }
    }
</script>
