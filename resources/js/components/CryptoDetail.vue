<template>
  <div>
      <h1>{{ crypto.name }}</h1>
      <apexchart width="500" type="bar" :options="options" :series="series"></apexchart>
      <p>Symbol: {{ crypto.symbol }}</p>
      <p>Last Value: {{ crypto.latest_value }}</p>
      <!-- <p v-for="values in crypto.values">{{ values }}</p> -->

  </div>
</template>

<script>
export default {
  props: {
      crypto: {
          type: Object,
          required: true
      }
  },
  data: function() {
    return {
      options: {
        chart: {
          id: 'vuechart-example'
        },
        xaxis: {
          categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998]
        }
      },
      series: [{
        name: 'series-1',
        data: [30, 40, 45, 50, 49, 60, 70, 91]
      }]
    }
  },
  mounted() {
      console.log("Details:", this.crypto);
  }
}
</script>
