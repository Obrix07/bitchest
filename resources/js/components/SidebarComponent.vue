<template>
    <div class="ml-4 mt-4">
      <button @click="isOpen = !isOpen" class="lg:hidden px-4 py-2 text-white bg-indigo-600 hover:bg-indigo-700 rounded">
        Menu
      </button>
      
      <div :class="{ 'hidden': !isOpen, 'block': isOpen }" class="bg-gray-900 text-white h-full w-64 fixed top-0 left-0 z-10 lg:block transition-transform transform-gpu">
        <button @click="isOpen = false" class="lg:hidden px-4 py-2 absolute top-2 right-2">
          Close
        </button>
  
        <div class="p-4 text-xl font-bold border-b border-gray-700">
          BitChest
        </div>
        
        <ul>
          <li class="p-4 border-b border-gray-700 hover:bg-gray-800">
            <a href="#"><i class="mr-2 fas fa-coins"></i> Monnaies</a>
          </li>
          <li class="p-4 border-b border-gray-700 hover:bg-gray-800">
            <a href="#"><i class="mr-2 fas fa-chart-line"></i> Statistiques</a>
          </li>
          <li class="p-4 border-b border-gray-700 hover:bg-gray-800">
            <a href="#"><i class="mr-2 fas fa-wallet"></i> Mon Portefeuille</a>
          </li>
          <li class="p-4 border-b border-gray-700 hover:bg-gray-800">
            <a href="#"><i class="mr-2 fas fa-cogs"></i> Paramètres</a>
          </li>
        </ul>
        <p>Votre solde est de : 1550€</p>
        <form ref="logoutForm" method="POST" action="/logout" class="hidden">
            @csrf   
        </form>
        <button @click="logout">Déconnexion</button>
      </div>
    </div>
  </template>
  
  <script>
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  export default {
    data() {
      return {
        isOpen: false
      };
    },
    methods: {
        logout() {
        const formData = new FormData();
        formData.append("_token",  csrfToken ); // Ajoutez le jeton CSRF à la requête

        fetch("/logout", {
            method: "POST",
            body: formData
        }).then(response => {
            if (response.ok) {
                window.location = "/"; // Redirigez vers la page d'accueil ou la page de connexion après la déconnexion
            } else {
                console.error("Erreur lors de la déconnexion");
            }
        });
    }
    }
  }
  </script>
  