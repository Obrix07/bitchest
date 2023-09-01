<template>
    <div>
        <h1>Créer un nouveau client</h1>

        <!-- Formulaire pour la création -->
        <form @submit.prevent="createClient">
            <input v-model="client.name" placeholder="Nom" required>
            <input v-model="client.email" placeholder="Email" type="email" required>
            <input v-model="client.wallet_balance" placeholder="Portefeuille" type="number" required>
            <input v-model="client.password" placeholder="Mot de passe" type="password" required>
            <button type="submit">Créer</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            client: {
                name: '',
                email: '',
                wallet_balance: 0,
                password: '',
                // ajoutez tous les autres attributs nécessaires
            }
        }
    },
    methods: {
        createClient() {
            axios.post('/api/clients', this.client)
                .then(response => {
                    window.location.href = "/admin";
                })
                .catch(error => {
                    alert('Une erreur s\'est produite:');
                    console.error('Une erreur s\'est produite:', error);
                });
        }
    }
}
</script>
