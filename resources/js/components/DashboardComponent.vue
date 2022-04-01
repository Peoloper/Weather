<template>
    <div class="container">
        <div class="row">
                <v-select
                    v-model="city_id"
                    :options="cities"
                    label="name"
                    @option:selected="getCity"
                ></v-select>

                <div class="col-md-4 mt-5" v-if="city_id">
                    <ul>
                        <li> Weather in {{city}}</li>
                        <li><img :src="'https://openweathermap.org/img/w/'+weather.current.weather.icon+'.png'"> {{weather.current.temp}}</li>
                        <li> Wind: {{weather.current.wind_speed}} m/s</li>
                        <li>Pressure: {{weather.current.pressure}}</li>
                        <li>Humidity: {{weather.current.humidity}}</li>
                        <li>Sunrise: {{ timestampToDate(weather.current.sunrise)}}</li>
                        <li>Sunset: {{ timestampToDate(weather.current.sunset)}}</li>
                        <li>Geo: {{weather.current.lat}} , {{weather.current.lon}} </li>
                    </ul>
                </div>
                <div class="col-md-8 mt-5" v-if="city_id">
                    <p>8-day forecast</p>
                    <ul>
                        <li v-for="item in weather.daily" :key="item">
                            {{ timestampToDate(item.dt)}} |
                            <img :src="'https://openweathermap.org/img/w/'+item.weather[0].icon+'.png'"> |
                            Temp day {{item.temp.day}}   Temp night {{item.temp.night}} |
                            Wind: {{item.wind_speed}} m/s |
                            Pressure: {{item.pressure}} hpa |
                        </li>
                    </ul>

                </div>
                <div class="col-md d-flex justify-content-center" v-if="city_id">
                    <ul class="mt-5">
                        <p>Hourly forecast</p>
                        <li v-for="item in weather.hourly" :key="item">
                            {{ timestampToDate(item.dt)}} |
                            <img :src="'https://openweathermap.org/img/w/'+item.weather[0].icon+'.png'"> |
                            Temp: day {{item.temp}} |
                            Wind: {{item.wind_speed}} m/s |
                            Pressure: {{item.pressure}} hpa |
                        </li>
                    </ul>
                </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "WeatherComponent.vue",
    data() {
        return {
            city_id: '',
            cities: [],
            city: null,

            weather: {
                current:{
                    lat: '',
                    lon: '',
                    temp: '',
                    weather: {
                        main: '',
                        description: '',
                        icon: ''
                    }
                },
                hourly: {},
                daily: {},
            }
        };
    },

    methods: {
        getCities() {
            axios.get('dashboard/getCities').then((response) => {
                this.cities = response.data

            }).catch((errors) => {
                  // console.log(errors)
            });
        },
        getCity()
        {
            axios.get('dashboard/getCity/' + this.city_id.id, { transformResponse: res => res } ).then((response) => {
                response = JSON.parse(response.data)

                this.weather.current = response.data.current
                this.weather.current.weather.main = response.data.current.weather[0].main
                this.weather.current.weather.description = response.data.current.weather[0].description
                this.weather.current.weather.icon = response.data.current.weather[0].icon
                this.weather.current.lat = response.data.lat
                this.weather.current.lon = response.data.lon
                this.weather.current.temp = response.data.temp
                this.weather.current.dt = response.data.dt

                this.weather.hourly = response.data.hourly
                this.weather.daily = response.data.daily

                this.city = response.name

               // console.log(response)

            }).catch((errors) => {
               // console.log(errors)
            });
        },

        timestampToDate: function( timestamp ){
            let date = new Date(timestamp*1000);
            return date.toLocaleString();
        },
    },
    mounted() {
        this.getCities()
    }


}
</script>
<style scoped>

</style>
