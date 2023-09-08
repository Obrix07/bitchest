import './bootstrap';

import Alpine from 'alpinejs';
import { createApp } from 'vue';
import AnotherComponent from './components/AnotherComponent.vue';
import AdminDashboard from './components/AdminDashboard.vue';
import ClientDashboard from './components/ClientDashboard.vue';
import ClientDetails from './components/ClientDetails.vue';
import CreateClient from './components/CreateClient.vue';
import DashboardComponent from './components/DashboardComponent.vue';
import CryptoList from './components/CryptoList.vue';
import CryptoDetail from './components/CryptoDetail.vue';

// import VueApexCharts from 'vue-apexcharts'
import VueApexCharts from "vue3-apexcharts";



const app = createApp({
    components: {
      AnotherComponent,
      AdminDashboard,
      ClientDashboard,
      ClientDetails,
      CreateClient,
      DashboardComponent,
      CryptoList,
      CryptoDetail,
      VueApexCharts,
    },
  });


window.Alpine = Alpine;


app.mount('#app');
Alpine.start();
