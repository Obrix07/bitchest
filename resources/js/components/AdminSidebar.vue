<template>
    <div class="ml-4 mt-4">
        <button
            @click="isOpen = !isOpen"
            class="lg:hidden px-4 py-2 text-white bg-sky-600 hover:bg-lime-500 rounded absolute"
        >
            Menu
        </button>

        <div
            :class="{ hidden: !isOpen, block: isOpen }"
            class="text-white h-full w-64 fixed top-0 left-0 z-10 lg:block transition-transform transform-gpu"
        >
            <button
                @click="isOpen = false"
                class="lg:hidden absolute top-5 right-2 text-3xl text-sky-600 hover:text-lime-500"
            >
                &#215;
            </button>
            <div
                class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800"
            >
                    <img
                        src="../../../public/images/bitchest_logo.png"
                        class="h-12 mr-3"
                        alt="Bitchest Logo"
                    />
                <ul class="space-y-2 font-medium">
                    <li>
                        <a
                            href="/admin"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                        >
                            <svg
                                class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-lime-500 dark:group-hover:text-white"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor"
                                viewBox="0 0 22 21"
                            >
                                <path
                                    d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"
                                />
                                <path
                                    d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"
                                />
                            </svg>
                            <span class="ml-3">Liste des clients</span>
                        </a>
                    </li>
                    <li>
                        <a
                            href="/admin/list"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                        >
                            <svg
                                class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-lime-500 dark:group-hover:text-white"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor"
                                viewBox="0 0 18 18"
                            >
                                <path
                                    d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"
                                />
                            </svg>
                            <span class="ml-3"
                                >Liste des cryptos</span
                            >
                        </a>
                    </li>
                    <li>
                        <div
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                        >
                            <svg
                                class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-red-400 dark:group-hover:text-white"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 18 16"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3"
                                />
                            </svg>
                            <span class="flex-1 ml-3 whitespace-nowrap">
                                <button @click="logout">Déconnexion</button>
                            </span>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- <button @click="isOpen = false" class="lg:hidden px-4 py-2 absolute top-2 right-2 text-sky-600 hover:text-lime-500">
                Fermer
            </button>

            <div class="p-4 text-xl font-bold border-b border-gray-700">
                <img src="../../../public/images/bitchest_logo.png" alt="Bitchest Logo">
            </div>
            
            <ul>
                <li class="p-4 border-b border-gray-700 hover:bg-lime-700">
                    <a href="#" class="flex items-center text-lime-500 hover:text-sky-600">
                        <i class="mr-2 fas fa-coins"></i> Monnaies
                    </a>
                </li>
                <li class="p-4 border-b border-gray-700 hover:bg-gray-700">
                    <a href="#" class="flex items-center text-lime-500 hover:text-sky-600">
                        <i class="mr-2 fas fa-chart-line"></i> Statistiques
                    </a>
                </li>
                <li class="p-4 border-b border-gray-700 hover:bg-gray-700">
                    <a href="#" class="flex items-center text-lime-500 hover:text-sky-600">
                        <i class="mr-2 fas fa-wallet"></i> Mon Portefeuille
                    </a>
                </li>
                <li class="p-4 border-b border-gray-700 hover:bg-gray-700">
                    <a href="#" class="flex items-center text-lime-500 hover:text-sky-600">
                        <i class="mr-2 fas fa-cogs"></i> Paramètres
                    </a>
                </li>
            </ul>

            <div class="p-4">
                <p class="mb-4 text-lime-500">Votre solde est de: <span class="font-bold">1550€</span></p>
                <form ref="logoutForm" method="POST" action="/logout" class="hidden">
                    @csrf   
                </form>
                <button @click="logout" class="px-4 py-2 text-white bg-sky-600 hover:bg-lime-500 rounded">
                    Déconnexion
                </button>
            </div> -->
        </div>
    </div>
</template>

<script>
const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

export default {
    data() {
        return {
            isOpen: false,
            balance: 0,
        };
    },
    mounted() {
        axios.get("/api/client/dashboard").then((response) => {
                this.balance = response.data.balance;
            });
    },
    methods: {
        logout() {
            const formData = new FormData();
            formData.append("_token", csrfToken); // Ajoutez le jeton CSRF à la requête

            fetch("/logout", {
                method: "POST",
                body: formData,
            }).then((response) => {
                if (response.ok) {
                    window.location = "/"; // Redirigez vers la page d'accueil ou la page de connexion après la déconnexion
                } else {
                    console.error("Erreur lors de la déconnexion");
                }
            });
        },
    },
};
</script>
