import './bootstrap';

import { createApp } from 'vue';
import TestComponent from './components/TestComponent.vue';
import AnotherComponent from './components/AnotherComponent.vue';


const app = createApp({
  components: {
    AnotherComponent,
    TestComponent,
  },
});

app.mount("#app")