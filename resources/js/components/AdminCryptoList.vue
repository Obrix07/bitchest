<template>
    <div class="h-screen flex">
        <AdminSidebar class="lg:w-64" />
        <div class="flex flex-col m-auto text-center justify-center">
            <h2 class="my-5 text-3xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl"><span class="text-transparent bg-clip-text bg-gradient-to-r to-lime-600 from-sky-400">Liste des Cryptos</span></h2>
            <table class="mt-4">
                <div class="relative mb-5 overflow-x-auto shadow-md sm:rounded-lg">
                    <table
                        class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
                    >
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                        >
                            <tr>
                                <th scope="col" class="px-6 py-3">Nom</th>
                                <th scope="col" class="px-6 py-3">Symbole</th>
                                <th scope="col" class="px-6 py-3">
                                    Dernière Valeur
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                class="cursor-pointer bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                v-for="crypto in cryptos"
                                :key="crypto.id"
                                @click="goToCryptoDetail(crypto.id)"
                            >
                                <th
                                    scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                >
                                    {{ crypto.name }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ crypto.symbol }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ crypto.latest_value }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </table>
        </div>
    </div>
</template>

<script>
import AdminSidebar from "./AdminSidebar.vue";
import SidebarComponent from "./SidebarComponent.vue";
export default {
    data() {
        return {
            cryptos: [],
            showModal: false,
            currentCrypto: null,
            quantity: 0,
        };
    },
    methods: {
        goToCryptoDetail(cryptoId) {
            window.location.href = `/admin/crypto/${cryptoId}`;
        },
    },
    mounted() {
        axios.get("/api/all-cryptos").then((response) => {
            this.cryptos = response.data;
        });
    },
    components: { SidebarComponent, AdminSidebar },
};
</script>
