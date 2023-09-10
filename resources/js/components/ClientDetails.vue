<template>
    <div class="min-h-screen py-6 flex flex-col justify-center sm:py-12">
        <AdminSidebar class="lg:w-64" />

        <div class="w-4/12 relative py-3 sm:max-w-xl sm:mx-auto">
            <div
                class="absolute inset-0 bg-gradient-to-r from-sky-300 to-lime-500 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl"
            ></div>
            <div
                class="relative px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20"
            >
                <div class="max-w-md mx-auto">
                    <h2
                        class="my-5 text-center text-xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-4xl"
                    >
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r to-lime-600 from-sky-400"
                            >Editer un profil</span
                        >
                    </h2>

                    <form @submit.prevent="updateClient">
                        <div class="divide-y divide-gray-200">
                            <div
                                class="py-4 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7"
                            >
                                <div class="relative">
                                    <input
                                        v-model="client.name"
                                        placeholder="Nom"
                                        class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:borer-rose-600"
                                    />
                                    <label
                                        class="absolute left-0 -top-5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:text-gray-600 peer-focus:text-sm"
                                        >Nom</label
                                    >
                                </div>
                                <div class="relative">
                                    <input
                                        v-model="client.email"
                                        placeholder="Email"
                                        class="mt-5 peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:borer-rose-600"
                                    />
                                    <label
                                        class="mt-5 absolute left-0 -top-5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:text-gray-600 peer-focus:text-sm"
                                        >Email</label
                                    >
                                </div>
                                <div class="relative">
                                    <button
                                        class="relative mt-5 inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-sky-400 to-lime-600 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800"
                                        type="submit"
                                    >
                                        <span
                                            class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0"
                                        >
                                            Modifer
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import AdminSidebar from "./AdminSidebar.vue";

export default {
    props: {
        client: {
            type: Object,
            required: true,
        },
    },
    methods: {
        updateClient() {
            axios
                .put(`/api/clients/${this.client.id}`, this.client)
                .then((response) => {
                    window.location.href = "/admin";
                })
                .catch((error) => {
                    alert("Une erreur s'est produite:");
                });
        },
    },
    components: { AdminSidebar },
};
</script>
