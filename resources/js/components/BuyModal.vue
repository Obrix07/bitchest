<template>
    <div
        v-if="showModal"
        class="fixed z-10 inset-0 overflow-y-auto"
        aria-labelledby="modal-title"
        role="dialog"
        aria-modal="true"
    >
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed bg-gray-500 bg-opacity-75"></div>

            <div class="bg-white rounded-lg px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <!-- Contenu du modal -->
                <div class="sm:flex sm:items-start">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Acheter {{ currentCrypto.name }}
                    </h3>
                    <div class="mt-2">
                        <label class="block text-gray-700">
                            Quantité:
                            <input
                                v-model="quantity"
                                type="number"
                                class="mt-1 form-input block w-full rounded-md"
                                placeholder="Entrez la quantité à acheter"
                            />
                        </label>
                    </div>
                </div>

                <!-- Pied de page du modal -->
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <button
                        @click="confirmPurchase"
                        type="button"
                        class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
                    >
                        Confirmer l'achat
                    </button>
                    <button @click="closeModal" class="mt-3 sm:mt-0 sm:ml-3">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["showModal", "currentCrypto"],
    data() {
        return {
            quantity: 0,
        };
    },
    methods: {
        closeModal() {
            this.$emit("update:showModal", false);
        },
        confirmPurchase() {
            this.$emit("confirm-purchase", {
                crypto: this.currentCrypto,
                quantity: this.quantity,
            });
        },
    },
};
</script>
