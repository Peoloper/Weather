<template>
    <div>
        <button type="button" class="btn btn-primary" @click="toggleModal">Add City</button>
        <div
            ref="modal"
            class="modal fade"
            :class="{show, 'd-block': active}"
            tabindex="-1"
            role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">-
                        <h5 class="modal-title">City</h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                            @click="toggleModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="height: 300px">
                        <div>
                            <v-select
                                v-model = "city_name"
                                :options="city"
                                placeholder="Start typing to search"
                                @search = "searchCity"
                                @option:selected="addCity"
                            ></v-select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="active" class="modal-backdrop fade show"></div>
    </div>

    <div class="mt-5">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Nr</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, cities) in cities" :key="item" :index="cities">
                <td>  {{ cities + 1}}</td>
                <td>  {{ item.name }}</td>
                <td>  <button class="btn btn-danger btn-sm" @click="deleteCity(item)">X</button></td>
            </tr>
            </tbody>
        </table>
    </div>

</template>

<script>
import _ from 'lodash';
import Swal from "sweetalert2";

export default {
    name: "WeatherComponent.vue",
    data() {
        return {
            api_key: '5891e06e0b289e466f149ff95b40ce33',
            url_base: "https://api.openweathermap.org/data/2.5/",
            city_name: null,
            city: [],
            cities: [],
            name: '',
            lon: '',
            lat: '',

            active: false,
            show: false
        };
    },

    methods: {
        searchCity: _.debounce(function (city){
            if(city.length)
            {
                this.getLocations(city).
                then((response) => {
                    this.city = response.data.name
                }).catch((errors) => {
                   // console.log(errors)
                })
            }
        }, 1000),

        getLocations(city) {
            const url = `${this.url_base}weather?q=${city},pl&appid=${this.api_key}`;

            return axios.get(url).
                then((response) =>
                {
                    this.lon = response.data.coord.lon
                    this.lat = response.data.coord.lat
                    this.name = response.data.name

                    return response

                }).catch((errors) => {
                  //  console.log(errors)
                })
        },
        getCities() {
            axios.get('dashboard/getCities').
            then((response) => {
                this.cities = response.data
            }).catch((errors) => {
               // console.log(errors)
            });
        },

        getInfoCity()
        {
            const url = `${this.url_base}onecall?lat=${this.lat}&lon=${this.lon}&exclude={part}&units=metric&appid=${this.api_key}`;
            return axios.get(url)
                .then((response) => {
                    return response.data
                }).catch((errors) => {
                   // console.log(errors)
                })
        },

        async addCity() {
            if (this.cities.length < 10)
            {
                let test = await this.getInfoCity()

                axios.post('city/store', {
                    name: this.name,
                    data: test
                }).then((response) => {
                    if(response.data === 404)
                    {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'The specified city already exists\n',
                        })
                    }
                    else
                    {
                        this.cities.push({
                            id: response.data.id,
                            name: response.data.name,
                        })

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'The city has been added\n',
                            showConfirmButton: false,
                            timer: 1000
                        })
                    }
                }).catch((errors) => {
                   // console.log(errors)
                })
            }
            else
            {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'The limit of added cities has been exceeded',
                })

                this.active = false
                this.show = false
            }
        },

        deleteCity(item)
        {
            Swal.fire({
                title: `Are you sure? ${item.name} will be remove?`,
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('city/destroy/' + item.id)
                        .then((res) =>
                        {
                            Swal.fire(
                                'Deleted!',
                                `The City ${item.name} has been deleted.`,
                                'success'
                            )

                            this.cities.splice(this.cities.indexOf(item), 1);

                        }).catch((errors) => {
                        //console.log(errors)
                    });
                }

            })
        },

        toggleModal() {
            const body = document.querySelector("body");
            this.active = !this.active;
            this.active
                ? body.classList.add("modal-open")
                : body.classList.remove("modal-open");
            setTimeout(() => (this.show = !this.show), 10);
        }
    },
    mounted() {
        this.getCities()
    }
}
</script>

<style scoped>

</style>
