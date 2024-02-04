//import '/resources/css/app.css';
import {createApp} from 'vue'

import App from './App.vue'
import {createWebHistory,createRouter} from 'vue-router';
import axios from 'axios';
import VueGoodTablePlugin from 'vue-good-table-next';
import '/node_modules/vue-good-table-next/dist/vue-good-table-next.css';


const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/login',
            component: () => import('/resources/views/pages/Login.vue')
        },
        {
            path: '/',
            component: () => import('/resources/views/pages/Home.vue')
        }
    ],
})


const app = createApp(App).use(router).use(VueGoodTablePlugin);

app.mount("#app");