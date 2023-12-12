require('./bootstrap');
import { createApp } from 'vue';
import * as VueRouter from "vue-router";
import VueAxios from "vue-axios";
import axios from "axios";
import { routes } from "./routes";
import App from "./App.vue";
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory("/"),
    routes,
});

const app = createApp(App);

app.use(VueSweetalert2);
app.use(VueAxios, axios);
app.use(router);
app.mount("#app");