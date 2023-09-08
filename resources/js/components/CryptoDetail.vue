<template>
  <div class="bg-gray-100 h-screen flex">
      <SidebarComponent class="lg:w-64" />
      <div class="flex overflow-y-auto p-4 mx-auto flex-col lg:mt-5">
          <h1 class="mx-auto">{{ crypto.name }} - {{ crypto.symbol }}</h1>
          <p class="mx-auto">Valeur actuelle: {{ crypto.values[0].value }}</p>
          <VueApexCharts
              width="700"
              type="line"
              :options="options"
              :series="series"
          ></VueApexCharts>
          <p>Symbol: {{ crypto.symbol }}</p>
          <!-- <p v-for="values in crypto.values" :key="values">{{ values }}</p> -->
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
    components: { SidebarComponent, VueApexCharts },
};
</script>
