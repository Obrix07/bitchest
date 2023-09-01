<template>
    <div>
        <h1>Tableau de bord Admin</h1>
        <div>
            <table class="table-auto">
                <thead>
                    <tr>
                    <th>Nom</th>
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
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            list:[],
        }
    },
    mounted() {
        axios.get('/api/clients')
            .then((response) => {
                this.list = response.data
            })
    },
    methods: {
        goToClientDetails(clientId) {
            window.location.href = `/admin/client/${clientId}`;
        },
        deleteClient(id) {
            axios.delete(`/api/clients/${id}`)
                .then(response => {
                    if (response.data.message === 'Client supprimé avec succès') {
                        this.list = this.list.filter(item => item.id !== id);
                        alert('Client supprimé avec succès');
                    } else {
                        alert('Une erreur s\'est produite');
                    }
                })
                .catch(error => {
                    alert('Une erreur s\'est produite');
                });
        }
    }
}
</script>
