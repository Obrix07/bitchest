<template>
        <div class="h-screen flex">
      <AdminSidebar class="lg:w-64" />
      <div class="flex flex-col m-auto text-center justify-center">
            <h2 class="mt-5 text-3xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl"><span class="text-transparent bg-clip-text bg-gradient-to-r to-lime-600 from-sky-400">Liste des clients</span></h2>
          <div class="m-auto mt-10 overflow-x-auto shadow-md sm:rounded-lg">
            <div class="mb-4">
        <input 
            v-model="searchQuery"
            type="text" 
            placeholder="Rechercher par nom ou email..."
            class="p-2 w-full border rounded"
        >
    </div>
              <table
                  class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
              >
                  <thead
                      class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                  >
                      <tr>
                          <th scope="col" class="px-6 py-3">Nom</th>
                          <th scope="col" class="px-6 py-3">Email</th>
                          <th scope="col" class="px-6 py-3">Portefeuille</th>
                          <th scope="col" class="px-6 py-3"></th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr
                          class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                          v-for="item in filteredList"
                          :key="list.id"
                          @click="goToClientDetails(item.id)"
                      >
                          <th
                              scope="row"
                              class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                          >
                              {{ item.name }}
                          </th>
                          <td class="px-6 py-4">
                              {{ item.email }}
                          </td>
                          <td class="px-6 py-4">{{ item.wallet_balance }} €</td>
                          <td class="px-6 py-4 text-right">
                              <button class="font-medium text-lime-600 hover:underline" @click.stop="deleteClient(item.id)">
                                  Supprimer
                              </button>
                          </td>
                      </tr>
                  </tbody>
              </table>
          </div>
          <div class="flex justify-center my-5">
              <button
                  class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800"
              >
                  <span
                      class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0"
                  >
                      <a href="/admin/create-client" class="button"
                          >Ajouter un client</a
                      >
                  </span>
              </button>
          </div>
      </div>
        <!-- <h1 class="text-white">Tableau de bord Admin</h1>
        <div>
            <table class="table-auto">
                <thead>
                    <tr>
                    <th class="text-red-600">Nom</th>
                    <th>Email</th>
                    <th>Portefeuille</th>
                    </tr>
                </thead>
                <tbody>
                    <tr  v-for="item in list" :key="list.id" @click="goToClientDetails(item.id)">
                    <td>{{ item.name }}</td>
                    <td>{{ item.email }}</td>
                    <td>{{ item.wallet_balance }} €</td>
                    <td>
                        <button @click.stop="deleteClient(item.id)">Supprimer</button>
                    </td>
                    </tr>
                </tbody>
            </table>
            <a href="/admin/create-client" class="button">Ajouter un client</a>
        </div> -->
    </div>
</template>

<script>
import AdminSidebar from "./AdminSidebar.vue";

export default {
    data() {
        return {
            list: [],
            searchQuery: '',
        };
    },
    computed: {
        filteredList() {
            if (this.searchQuery) {
                const searchTerm = this.searchQuery.toLowerCase();
                return this.list.filter(client => 
                    client.name.toLowerCase().includes(searchTerm) || 
                    client.email.toLowerCase().includes(searchTerm)
                );
            }
            return this.list;
        }
    },
    mounted() {
        axios.get("/api/clients").then((response) => {
            this.list = response.data;
        });
    },
    methods: {
        goToClientDetails(clientId) {
            window.location.href = `/admin/client/${clientId}`;
        },
        deleteClient(id) {
            axios
                .delete(`/api/clients/${id}`)
                .then((response) => {
                    if (
                        response.data.message === "Client supprimé avec succès"
                    ) {
                        this.list = this.list.filter((item) => item.id !== id);
                        alert("Client supprimé avec succès");
                    } else {
                        alert("Une erreur s'est produite");
                    }
                })
                .catch((error) => {
                    alert("Une erreur s'est produite");
                });
        },
    },
    components: { AdminSidebar },
};
</script>
