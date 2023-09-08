<template>
  <div class="bg-gray-100 h-screen flex">
      <SidebarComponent class="lg:w-64" />
      <div class="flex ">
          <h1>Liste des Cryptos</h1>
          <table>
              <thead>
                  <tr>
                      <th>Nom</th>
                      <th>Symbole</th>
                      <th>Dernière Valeur</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for="crypto in cryptos" :key="crypto.id" @click="goToCryptoDetail(crypto.id)">
                      <td>{{ crypto.name }}</td>
                      <!-- <td><a :href="'/crypto/' + crypto.id">{{ crypto.name }}</a></td> -->
                      <td>{{ crypto.symbol }}</td>
                      <td>{{ crypto.latest_value }}</td>
                      <td><button @click.stop="openModal(crypto)">Acheter</button></td>
                  </tr>
              </tbody>
  
              <div v-if="showModal">
                  Combien de {{ currentCrypto.name }} souhaitez-vous acheter ?
                  <input type="number" v-model="quantity" />
                  <button @click="buyCrypto">Confirmer</button>
                  <button @click="showModal = false">Annuler</button>
              </div>
          </table>
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
