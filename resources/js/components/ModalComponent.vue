<template>
    <div
        v-if="isOpen"
        class="fixed z-10 inset-0 overflow-y-auto"
        aria-labelledby="modal-title"
        role="dialog"
        aria-modal="true"
    >
        <div
            class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0"
        >
            <!-- Fond du modal -->
            <div
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                aria-hidden="true"
            ></div>

            <!-- Conteneur du modal -->
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
            >
                <!-- Contenu du modal -->
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3
                        class="text-lg leading-6 font-medium text-gray-900"
                        id="modal-title"
                    >
                    Etes vous sur de vouloir vendre tous vos {{ crypto.name }}
                    
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            Profit/perte estimé: {{ profitOrLoss.toFixed(2) }}€
                        </p>
                    </div>
                </div>

                <!-- Pied de page du modal -->
                <div
                    class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse"
                >
                    <button
                        @click="closeModal"
                        type="button"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
                    >
                        Fermer
                    </button>
                    <button @click="confirmSale">Confirmer la vente</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isOpen: false,
        };
    },
    props: ["crypto", "profitOrLoss"],
    methods: {
        openModal() {
            this.isOpen = true;
        },
        closeModal() {
            this.isOpen = false;
        },
        confirmSale() {
            this.$emit("confirm-sale", this.crypto);
        },
    },
};
</script>
