<template>
    <div>
        <h1>{{ client.name }}</h1>
        <p>Email: {{ client.email }}</p>
        <p>Portefeuille: {{ client.wallet_balance }} €</p>

        <!-- Formulaire pour la modification -->
        <form @submit.prevent="updateClient">
            <input v-model="client.name" placeholder="Nom">
            <input v-model="client.email" placeholder="Email">
            <input v-model="client.wallet_balance" placeholder="Portefeuille">
            <button type="submit">Modifier</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        client: {
            type: Object,
            required: true
        }
    },
    methods: {
        updateClient() {
            axios.put(`/api/clients/${this.client.id}`, this.client)
                .then(response => {
                    window.location.href = "/admin";
                })
                .catch(error => {
                    alert('Une erreur s\'est produite:');
                });
        }
    }
}
</script>
