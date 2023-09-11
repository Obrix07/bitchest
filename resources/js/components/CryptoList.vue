<template>
    <div class="h-screen flex">
        <SidebarComponent class="lg:w-64" />
        <div class="flex flex-col m-auto text-center justify-center">
            <h2
                class="my-5 text-3xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl"
            >
                <span
                    class="text-transparent bg-clip-text bg-gradient-to-r to-lime-600 from-sky-400"
                    >Liste des Cryptos</span
                >
            </h2>
            <table class="mt-4">
                <div
                    class="relative mb-5 overflow-x-auto shadow-md sm:rounded-lg"
                >
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
                                <th scope="col" class="px-6 py-3">Action</th>
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
                                    {{ currencyFormatter(crypto.latest_value) }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button
                                        @click.stop="openModal(crypto)"
                                        class="font-medium text-lime-600 hover:underline"
                                    >
                                        Acheter
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </table>
            <div
                v-if="showModal"
                class="flex flex-col relative mb-5 overflow-x-auto shadow-md sm:rounded-lg"
            >
                <p class="mt-4">
                    Combien de "{{ currentCrypto.name }}" souhaitez-vous acheter
                    ?
                </p>
                <input
                    class="w-6/12 m-auto mt-4"
                    type="number"
                    v-model="quantity"
                    min="0"
                    step="0.1"
                />
                <div class="my-4">
                    <button
                        class="mx-3 font-medium text-lime-600 hover:underline"
                        @click="buyCrypto"
                    >
                        Confirmer
                    </button>
                    <button
                        class="mx-3 font-medium text-red-600 hover:underline"
                        @click="showModal = false"
                    >
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
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
        openModal(crypto) {
            this.currentCrypto = crypto;
            this.showModal = true;
        },
        goToCryptoDetail(cryptoId) {
            window.location.href = `/crypto/${cryptoId}`;
        },
        buyCrypto() {
            if (this.quantity <= 0) {
                alert("Veuillez entrer une quantité valide.");
                return;
            }
            axios
                .post("/api/buy-crypto", {
                    cryptoId: this.currentCrypto.id,
                    quantity: this.quantity,
                })
                .then((response) => {
                    this.showModal = false;
                })
                .catch((error) => {
                    console.error(
                        "Une erreur est survenue lors de l'achat:",
                        error
                    );
                });
            location.reload();
        },
        currencyFormatter(value) {
            try {
                const numberValue = Number(value); // Convertit la valeur en number
                if (isNaN(numberValue)) {
                    console.error("Value provided is not a number:", value);
                    return "";
                }

                const fixed = numberValue.toFixed(2);
                const [intpart, digits] = fixed.split(".");
                const formattedIntPart = intpart.replace(
                    /\B(?=(\d{3})+(?!\d))/g,
                    "\u00A0"
                );
                return `${formattedIntPart},${digits}€`;
            } catch (e) {
                console.error("Error in currencyFormatter:", e);
                return "";
            }
        },
    },
    mounted() {
        axios.get("/api/all-cryptos").then((response) => {
            this.cryptos = response.data;
        });
    },
    components: { SidebarComponent },
};
</script>
