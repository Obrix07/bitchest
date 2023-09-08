<template>
    <div class="h-screen flex">
        <SidebarComponent class="lg:w-64" />
        <div class="flex flex-col m-auto">
            <h1>Tableau de bord</h1>
            <p>Solde du portefeuille: €{{ balance }}</p>
            <h2>Vos Crypto-monnaies</h2>
            <table
                  class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
              >
                  <thead
                      class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                  >
                      <tr>
                          <th scope="col" class="px-6 py-3">Nom</th>
                          <th scope="col" class="px-6 py-3">Quantité</th>
                          <th scope="col" class="px-6 py-3">Cours Actuelle (€)</th>
                          <th scope="col" class="px-6 py-3">Valeur Total (€)</th>
                          <th scope="col" class="px-6 py-3">Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr
                          class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
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
                              {{ crypto.quantity }}
                          </td>
                          <td class="px-6 py-4">{{ crypto.latest_value }}</td>
                          <td class="px-6 py-4">{{
                                (crypto.latest_value * crypto.quantity).toFixed(
                                    2
                                )
                            }}</td>
                          <td class="px-6 py-4 text-right">
                              <button class="font-medium text-blue-600 dark:text-blue-500 hover:underline" @click="sellCrypto(crypto)">
                                Vendre
                              </button>
                          </td>
                      </tr>
                  </tbody>
              </table>
            <p>
                Total des actifs en crypto : €{{ totalCryptoValue.toFixed(2) }}
            </p>
            <h2>Historique des transactions</h2>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                  Crypto
                </th>
                <th scope="col" class="px-6 py-3">
                  Type
                </th>
                <th scope="col" class="px-6 py-3">
                  Quantité
                </th>
                <th scope="col" class="px-6 py-3">
                  Valeur lors de la transaction (€)
                </th>
                <th scope="col" class="px-6 py-3">
                  Somme (€)
                </th>
                <th scope="col" class="px-6 py-3">
                  Date
                </th>
            </tr>
        </thead>
        <tbody>
            <tr 
              class="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
              v-for="transaction in transactions"
              :key="transaction.created_at"
            >
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  {{ transaction.name }}
                </th>
                <td class="px-6 py-4" v-if="transaction.type == 'buy'">
                  <p>Achat</p>
                </td>
                <td class="px-6 py-4" v-else>
                  <p>Vente</p>
                </td>
                <td class="px-6 py-4">
                  {{ transaction.quantity }}
                </td>
                <td class="px-6 py-4">
                  {{ transaction.value_at_time }}
                </td>
                <td class="px-6 py-4">
                  {{
                    (
                      transaction.value_at_time *
                      transaction.quantity
                      ).toFixed(2)
                    }}
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
        };
    },
    mounted() {
        axios.defaults.withCredentials = true;
        axios.get("/sanctum/csrf-cookie").then(() => {
            // Login...
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
