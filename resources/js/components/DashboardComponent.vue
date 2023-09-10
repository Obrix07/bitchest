<template>
    <div class="h-screen flex">
        <SidebarComponent class="lg:w-64" />
        <div class="flex flex-col m-auto text-center justify-center">
            <!-- <h1 class="text-xl bg-black w-3/12 text-white p-2 rounded-md mt-3 m-auto">Tableau de bord</h1> -->
            <!-- <p>Solde du portefeuille: {{ balance }} €</p> -->
            <h2
                class="my-5 text-3xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl"
            >
                <span
                    class="text-transparent bg-clip-text bg-gradient-to-r to-lime-600 from-sky-400"
                    >Tableau de bord</span
                >
            </h2>
            <!-- <h2>Vos Crypto-monnaies</h2> -->
            <h3
                class="mb-5 text-xl font-extrabold leading-none tracking-tight text-gray-900 md:text-xl lg:text-2xl dark:text-white"
            >
                Liste de vos
                <mark class="px-2 text-white bg-lime-500 rounded"
                    >CRYPTO-MONNAIES</mark
                >
            </h3>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table
                    class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
                >
                    <thead
                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                    >
                        <tr>
                            <th scope="col" class="px-6 py-3">Nom</th>
                            <th scope="col" class="px-6 py-3">Quantité</th>
                            <th scope="col" class="px-6 py-3">
                                Cours Actuelle (€)
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Valeur Total (€)
                            </th>
                            <th scope="col" class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                            v-for="crypto in cryptos"
                            :key="crypto.name"
                            @click="goToClientDetails(item.id)"
                        >
                            <th
                                scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                            >
                                {{ crypto.name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ currencyFormatter(crypto.quantity) }}
                            </td>
                            <td class="px-6 py-4">{{ currencyFormatter(crypto.latest_value) }} €</td>
                            <td class="px-6 py-4">
                                {{
                                    currencyFormatter(
                                        crypto.latest_value * crypto.quantity
                                    )
                                }} €
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button
                                    class="font-medium text-lime-600 hover:underline"
                                    @click="sellCrypto(crypto)"
                                >
                                    Vendre
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- <p>
                Total des actifs en crypto : €{{ totalCryptoValue.toFixed(2) }}
            </p> -->
            <p class="text-xl my-5 font-extrabold dark:text-white">
                <small
                    class="ml-2 font-semibold text-gray-500 dark:text-gray-400"
                    >Total des actifs en crypto : </small
                >{{ currencyFormatter(totalCryptoValue) }} €
            </p>
            <hr />
            <!-- <h2>Historique des transactions</h2> -->
            <h3
                class="my-5 text-xl font-extrabold leading-none tracking-tight text-gray-900 md:text-xl lg:text-2xl dark:text-white"
            >
                Historique des
                <mark class="px-2 text-white bg-lime-500 rounded"
                    >TRANSACTIONS</mark
                >
            </h3>
            <div class="mb-5 rouded">
                <select v-model="filterBy" @change="filterValue = ''">
                    <option value="">Filtrer par...</option>
                    <option value="crypto">Crypto</option>
                    <option value="type">Type</option>
                </select>

                <select v-if="filterBy === 'crypto'" v-model="filterValue">
                    <!-- Vous pouvez générer les options dynamiquement depuis votre liste de cryptos -->
                    <option value="">Toutes les cryptos</option>
                    <option value="Bitcoin">Bitcoin</option>
                    <option value="Ethereum">Ethereum</option>
                    <option value="Ripple">Ripple</option>
                    <option value="Bitcoin Cash">Bitcoin Cash</option>
                    <option value="Cardano">Cardano</option>
                    <option value="Litecoin">Litecoin</option>
                    <option value="NEM">NEM</option>
                    <option value="Stellar">Ethereum</option>
                    <option value="IOTA">IOTA</option>
                    <option value="Dash">Dash</option>
                </select>

                <select v-if="filterBy === 'type'" v-model="filterValue">
                    <option value="">Tous les types</option>
                    <option value="buy">Achat</option>
                    <option value="sell">Vente</option>
                </select>
            </div>
            <div class="mb-5 relative overflow-x-auto shadow-md sm:rounded-lg">

                <table
                    class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
                >
                    <thead
                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                    >
                        <tr>
                            <th scope="col" class="px-6 py-3">Crypto</th>
                            <th scope="col" class="px-6 py-3">Type</th>
                            <th scope="col" class="px-6 py-3">Quantité</th>
                            <th scope="col" class="px-6 py-3">
                                Valeur lors de la transaction (€)
                            </th>
                            <th scope="col" class="px-6 py-3">Somme (€)</th>
                            <th
                                scope="col"
                                class="px-6 py-3 cursor-pointer hover:text-lime-500"
                                @click="toggleSortOrder"
                            >
                                Date
                                <span v-if="sortOrder === 'ascending'">⬆️</span>
                                <span v-else>⬇️</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            class="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
                            v-for="transaction in sortedTransactions"
                            :key="transaction.created_at"
                        >
                            <th
                                scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                            >
                                {{ transaction.name }}
                            </th>
                            <td
                                class="px-6 py-4"
                                v-if="transaction.type == 'buy'"
                            >
                                <p class="text-red-400">Achat</p>
                            </td>
                            <td class="px-6 py-4" v-else>
                                <p class="text-lime-500">Vente</p>
                            </td>
                            <td class="px-6 py-4">
                                {{ currencyFormatter(transaction.quantity) }}
                            </td>
                            <td class="px-6 py-4">
                                {{ currencyFormatter(transaction.value_at_time) }} €
                            </td>
                            <td class="px-6 py-4">
                                {{
                                    currencyFormatter(
                                        transaction.value_at_time *
                                        transaction.quantity
                                    )
                                }} €
                            </td>
                            <td class="px-6 py-4">
                                {{ dateFormatter(transaction.created_at) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import SidebarComponent from "./SidebarComponent.vue";

export default {
    data() {
        return {
            balance: 0,
            cryptos: [],
            transactions: [],
            totalCryptoValue: 0,
            total: 0,
            sortBy: "date", // 'date', 'name', etc.
            sortDesc: false, // true ou false
            filterBy: null, // 'crypto', 'type' ou null (pas de filtre)
            filterValue: "",
            sortOrder: "descending",
        };
    },
    mounted() {
        axios.defaults.withCredentials = true;
        axios.get("/sanctum/csrf-cookie").then(() => {
            axios.get("/api/client/dashboard").then((response) => {
                this.balance = response.data.balance;
                this.cryptos = response.data.cryptos;
                this.transactions = response.data.transactions;
                this.totalCryptoValue = this.cryptos.reduce(
                    (acc, crypto) =>
                        acc + crypto.latest_value * crypto.quantity,
                    0
                );
            });
        });
    },
    computed: {
        sortedTransactions() {
            const directionMultiplier = this.sortOrder === "ascending" ? 1 : -1;

            return this.filteredTransactions.sort((a, b) => {
                const dateA = new Date(a.created_at);
                const dateB = new Date(b.created_at);
                return directionMultiplier * (dateA - dateB);
            });
        },
        filteredTransactions() {
            if (!this.filterBy || !this.filterValue) return this.transactions;

            return this.transactions.filter((transaction) => {
                switch (this.filterBy) {
                    case "crypto":
                        return transaction.name === this.filterValue;
                    case "type":
                        return transaction.type === this.filterValue;
                    default:
                        return true;
                }
            });
        },
    },
    methods: {
        async sellCrypto(crypto) {
            const buyingPrice = await this.getBuyingPrice(crypto);
            const currentPrice = await this.getCurrentPrice(crypto);
            const profitOrLoss = (currentPrice - buyingPrice) * crypto.quantity;
            // if (window.confirm(`Êtes-vous sûr de vouloir vendre tous vos ${crypto.name}?`)) {
            if (
                window.confirm(
                    `Etes vous sur de vouloir vendre tous vos ${
                        crypto.name
                    }? profit/perte estimé: ${profitOrLoss.toFixed(2)}€`
                )
            ) {
                axios
                    .post("/api/sell-crypto", { name: crypto.name })
                    .then((response) => {
                        // Actualisez les données ici, si nécessaire
                        this.balance = response.data.balance;
                        this.cryptos = response.data.cryptos;
                        this.transactions = response.data.transactions;
                    })
                    .catch((error) => {
                        console.error("Une erreur s'est produite:", error);
                    });
                location.reload();
            }
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
                return `${formattedIntPart},${digits}`;
            } catch (e) {
                console.error("Error in currencyFormatter:", e);
                return "";
            }
        },
        toggleSortOrder() {
            this.sortOrder =
                this.sortOrder === "ascending" ? "descending" : "ascending";
        },
        changeSort(column) {
            if (this.sortBy === column) {
                this.sortDesc = !this.sortDesc; // Inverse l'ordre si déjà trié par cette colonne
            } else {
                this.sortBy = column;
                this.sortDesc = false;
            }
        },
        getBuyingPrice(crypto) {
            return axios
                .get(`/api/get-buying-price/${crypto.name}`)
                .then((response) => response.data.buyingPrice);
        },
        getCurrentPrice(crypto) {
            return axios
                .get(`/api/current-price/${crypto.name}`)
                .then((response) => response.data.currentPrice);
        },
        dateFormatter(dateString) {
            const date = new Date(dateString);
            return new Intl.DateTimeFormat("default", {
                dateStyle: "long",
            }).format(date);
        },
    },
    components: { SidebarComponent },
};
</script>
