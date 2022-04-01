

require('./bootstrap')

import { createApp } from 'vue'

import WeatherComponent from './components/WeatherComponent'
import DashboardComponent from './components/DashboardComponent'
import UserCityComponent from './components/UserCityComponent'

import VueSweetalert2 from 'vue-sweetalert2';
import vSelect from "vue-select";
import 'sweetalert2/dist/sweetalert2.min.css';

const app = createApp({})

app.use(VueSweetalert2);


app.component('weather-component', WeatherComponent)
app.component('dashboard-component', DashboardComponent)
app.component('user-city-component', UserCityComponent)
app.component('v-select', vSelect)


app.mount('#app')
