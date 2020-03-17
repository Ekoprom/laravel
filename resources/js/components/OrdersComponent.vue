<template>
<v-row justify="center">
        
            <v-col md="3">
                <date-picker v-model="dateStart" :config="options"></date-picker>
            </v-col>
            <v-col md="3">
                <date-picker v-model="dateEnd" :config="options"></date-picker>
            </v-col>          
            <v-col md="1">
                <v-btn v-on:click="getOrders()" :loading="loading" :disabled="loading" depressed color="primary">Найти</v-btn>
            </v-col>

            <!--<div class="col-md-9 mt-5" v-if="error">
                <div class="alert alert-danger" role="alert">{{ error }}</div>
            </div>-->

            <v-col md="12">
                <v-data-table
                    :headers="headers"
                    :items="orders"
                    :items-per-page="5">
                <template v-slot:item.detail="{ item }">
                    <v-btn to="{ name: 'order', params: { number: order.number, date: order.date }" text small color="primary">Подробнее</v-btn>
                </template>
                </v-data-table>
            </v-col>
</v-row>        
</template>

<script>
    import datePicker from 'vue-bootstrap-datetimepicker';
    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
    import loader from 'vue-spinner/src/GridLoader.vue'
    
    export default {
        data: function() {
            return {
                error: null,
                loading: false,
                orders: [],
                dateStart: new Date(),
                dateEnd: new Date(),
                options: {
                    format: 'DD/MM/YYYY',
                    useCurrent: false,
                },

                page: 1,
                pageCount: 0,
                itemsPerPage: 15,
                headers: [
                    { text: 'Номер', value: 'number' },
                    { text: 'Дата', value: 'date' },
                    { text: 'Сумма', value: 'sum' },
                    { text: 'Клиент', value: 'client' },
                    { text: 'Подробнее', value: 'detail'},
                ],                
            }
        },

        components: {
            datePicker,
            loader
        },

        mounted() {
        },

        methods: {
            getOrders() {
                const app = this;
                const data = {
                    'dateStart' : app.$children[0].dp.date().format('YYYYMMDDHHmmss'),
                    'dateEnd' : app.$children[1].dp.date().format('YYYYMMDDHHmmss'),
                };

                app.orders = [];
                app.loading = true;
                axios.get('/api/orders', { params: data })
                    .then(function(resp) {
                        if (resp.data.error) {
                            app.error = resp.data.error;
                        } else {
                            app.error = null;
                            const orders = resp.data.orders;
                            if (orders) app.orders = orders;
                        }
                        app.loading = false;
                    })
                    .catch(function(error) {
                        app.error = error.message;
                        app.loading = false;
                    });
            }
        }
    }
</script>
