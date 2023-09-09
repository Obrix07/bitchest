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
import AdminCryptoList from './components/AdminCryptoList.vue';
import CryptoDetail from './components/AdminCryptoDetail.vue';
import AdminCryptoDetail from './components/CryptoDetail.vue';
import SidebarComponent from './components/SidebarComponent.vue';

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
      AdminCryptoList,
      CryptoDetail,
      AdminCryptoDetail,
      VueApexCharts,
      SidebarComponent,
    },
  });


window.Alpine = Alpine;


app.mount('#app');
Alpine.start();
