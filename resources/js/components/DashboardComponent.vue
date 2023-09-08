<template>
    <div>
      <h1>Tableau de bord</h1>
      <p>Solde du portefeuille: €{{ balance }}</p>
      <h2>Vos Crypto-monnaies</h2>
      <table>
  <thead>
    <tr>
      <th>Nom</th>
      <th>Quantité</th>
      <th>Valeur Actuelle (€)</th>
      <th>Somme (€)</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="crypto in cryptos" :key="crypto.name">
      <td>{{ crypto.name }}</td>
      <td>{{ crypto.quantity }}</td>
      <td>{{ crypto.latest_value }}</td>
      <td>{{ (crypto.latest_value * crypto.quantity).toFixed(2) }}</td>
      <td><button @click="sellCrypto(crypto)">Vendre</button></td>
    </tr>
  </tbody>
</table>
<p>Total des actifs en crypto : €{{ totalCryptoValue.toFixed(2) }}</p>
      <h2>Historique des transactions</h2>
      <table>
        <thead>
          <tr>
            <th>Crypto</th>
            <th>Type</th>
            <th>Quantité</th>
            <th>Valeur lors de la transaction (€)</th>
            <th>Somme (€)</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="transaction in transactions" :key="transaction.created_at">
            <td>{{ transaction.name }}</td>
            <td>{{ transaction.type }}</td>
            <td>{{ transaction.quantity }}</td>
            <td>{{ transaction.value_at_time }}</td>
            <td>{{ (transaction.value_at_time * transaction.quantity).toFixed(2) }}</td>
            <td>{{ dateFormatter(transaction.created_at) }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script>
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
      axios.get('/sanctum/csrf-cookie').then(() => {
    // Login...
    axios.get("/api/client/dashboard").then(response => {
      this.balance = response.data.balance;
      this.cryptos = response.data.cryptos;
      this.transactions = response.data.transactions;
      this.totalCryptoValue = this.cryptos.reduce((acc, crypto) => acc + (crypto.latest_value * crypto.quantity), 0);
    });
});
    },
    methods: {
      async sellCrypto(crypto) {
        const buyingPrice = await this.getBuyingPrice(crypto);
        const currentPrice = await this.getCurrentPrice(crypto);

    const profitOrLoss = (currentPrice - buyingPrice) * crypto.quantity;
      // if (window.confirm(`Êtes-vous sûr de vouloir vendre tous vos ${crypto.name}?`)) {
        if (window.confirm(`Are you sure you want to sell all your ${crypto.name}? Estimated profit/loss: €${profitOrLoss.toFixed(2)}`)) {
        axios.post("/api/sell-crypto", { name: crypto.name })
          .then(response => {
            // Actualisez les données ici, si nécessaire
            this.balance = response.data.balance;
            this.cryptos = response.data.cryptos;
            this.transactions = response.data.transactions;
          })
          .catch(error => {
            console.error("Une erreur s'est produite:", error);
          });
          location.reload();
      }
    },
    getBuyingPrice(crypto) {
    return axios.get(`/api/get-buying-price/${crypto.name}`).then(response => response.data.buyingPrice);
  },
  getCurrentPrice(crypto) {
    return axios.get(`/api/current-price/${crypto.name}`).then(response => response.data.currentPrice);
  },
      dateFormatter(dateString) {
        const date = new Date(dateString);
        return new Intl.DateTimeFormat('default', {dateStyle: 'long'}).format(date);
      },
    }
  };
  </script>
  