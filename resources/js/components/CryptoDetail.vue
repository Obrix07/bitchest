<template>
  <div class="h-screen flex">
      <SidebarComponent class="lg:w-64" />
      <div class="flex flex-col m-auto text-center justify-center">
          <h2 class="my-5 text-xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl"><span class="text-transparent bg-clip-text bg-gradient-to-r to-lime-600 from-sky-400">{{ crypto.name }} - {{ crypto.symbol }}</span></h2>
          <h3 class="mb-5 text-xl font-extrabold leading-none tracking-tight text-gray-900 md:text-xl lg:text-2xl dark:text-white">Valeur actuelle: <mark class="px-2 text-white bg-lime-500 rounded">{{ currencyFormatter(crypto.values[0].value) }} €</mark></h3>
          <VueApexCharts
              width="700"
              type="line"
              :options="options"
              :series="series"
          ></VueApexCharts>
      </div>
  </div>
</template>

<script>
import VueApexCharts from "vue3-apexcharts";
import SidebarComponent from "./SidebarComponent.vue";

export default {
    props: {
        crypto: {
            type: Object,
            required: true,
        },
    },
    data: function () {
        return {
            options: {
                xaxis: {
                    categories: [],
                },
            },
            series: [
                {
                    name: this.crypto.symbol,
                    data: [],
                },
            ],
        };
    },
    mounted() {
        console.log("Details:", this.crypto);
        
        const sortedValues = [...this.crypto.values].sort((a, b) => new Date(a.value_date) - new Date(b.value_date));
        
        this.options.xaxis.categories = sortedValues.map(item => item.value_date);
        this.series[0].data = sortedValues.map(item => parseFloat(item.value)); // Convertit la chaîne en flottant pour s'assurer que le graphique l'affiche correctement
    },
    methods: {
        currencyFormatter(value) {
            try {
                const numberValue = Number(value); // Convertit la valeur en number
                if (isNaN(numberValue)) {
                    console.error("Value provided is not a number:", value);
                    return "";
                }

                const fixed = numberValue.toFixed(2);
                const [intpart, digits] = fixed.split(".");
                const formattedIntPart = intpart.replace(
                    /\B(?=(\d{3})+(?!\d))/g,
                    "\u00A0"
                );
                return `${formattedIntPart},${digits}`;
            } catch (e) {
                console.error("Error in currencyFormatter:", e);
                return "";
            }
        },
    },
    components: { SidebarComponent, VueApexCharts },
};
</script>
