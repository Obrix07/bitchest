import './bootstrap';

import Alpine from 'alpinejs';
import { createApp } from 'vue';
import TestComponent from './components/TestComponent.vue';
import AnotherComponent from './components/AnotherComponent.vue';
import AdminDashboard from './components/AdminDashboard.vue';
import ClientDashboard from './components/ClientDashboard.vue';
import ClientDetails from './components/ClientDetails.vue';
import CreateClient from './components/CreateClient.vue';


const app = createApp({
    components: {
      AnotherComponent,
      TestComponent,
      AdminDashboard,
      ClientDashboard,
      ClientDetails,
      CreateClient,
    },
  });


window.Alpine = Alpine;


app.mount('#app');
Alpine.start();
