<template>
<v-container>
    <v-row justify="center">
        <v-col md="3">
            <v-menu
                ref="dateStartMenu"
                v-model="dateStartMenu"
                :close-on-content-click="false"
                transition="scale-transition"
                offset-y
                max-width="290px"
                min-width="290px"
            >
                <template v-slot:activator="{ on }">
                    <v-text-field
                        v-model="dateStartFormatted"
                        label="Начало периода"
                        @blur="dateStart = parseDate(dateStartFormatted)"
                        v-on="on"
                        :disabled="loading"
                    ></v-text-field>
                </template>
                <v-date-picker v-model="dateStart" no-title @input="dateStartMenu = false"></v-date-picker>
            </v-menu>
        </v-col>

        <v-col md="3">
            <v-menu
                ref="dateEndMenu"
                v-model="dateEndMenu"
                :close-on-content-click="false"
                transition="scale-transition"
                offset-y
                max-width="290px"
                min-width="290px"
            >
                <template v-slot:activator="{ on }">
                    <v-text-field
                        v-model="dateEndFormatted"
                        label="Конец периода"
                        @blur="dateEnd = parseDate(dateEndFormatted)"
                        v-on="on"
                        :disabled="loading"
                    ></v-text-field>
                </template>
                <v-date-picker v-model="dateEnd" no-title @input="dateEndMenu = false"></v-date-picker>
            </v-menu>
        </v-col>        
      
        <v-col md="1">
            <v-btn v-on:click="getOrders()" :loading="loading" :disabled="loading" depressed color="primary">Найти</v-btn>
        </v-col>

            <v-col md="12">
                <v-data-table
                    :headers="headers"
                    :items="orders"
                    :items-per-page="10"
                    :loading="loading"
                >
                <template v-slot:item.detail="{ item }">
                    <router-link :to="{ name: 'order', params: { number: item.number, date: item.date }}" text small color="primary">Подробнее</router-link>
                </template>
                </v-data-table>
            </v-col>
    </v-row>        
</v-container>    
</template>

<script>
    import moment from 'moment';
    import { mapActions } from 'vuex';
    
    export default {
        data: function() {
            return {
                error: null,
                loading: false,
                orders: this.orders ? this.orders : [],

                dateStart: new Date().toISOString().substr(0, 10),
                dateStartFormatted: this.formatDate(new Date().toISOString().substr(0, 10)),
                dateStartMenu: false,
                dateEnd: new Date().toISOString().substr(0, 10),
                dateEndFormatted: this.formatDate(new Date().toISOString().substr(0, 10)),
                dateEndMenu: false,

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

        mounted() {
            
        },

        watch: {
            dateStart (val) {
                this.dateStartFormatted = this.formatDate(this.dateStart);
            },
            dateEnd (val) {
                this.dateStartFormatted = this.formatDate(this.dateEnd);
            },            
        },

        methods: {
            formatDate (date) {
                if (!date) return null
                return moment(date).format('DD.MM.YYYY');
            },
            parseDate (date) {
                if (!date) return null
                const [day, month, year] = date.split('.');
                return moment([year, month, day]).format('YYYY-MM-DD');
            },

            getOrders() {
                const app = this;
                const data = {
                    'dateStart' :  moment(this.dateStart).format('YYYYMMDDHHmmss'),
                    'dateEnd' :  moment(this.dateEnd).format('YYYYMMDDHHmmss'),
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
            },
            mapActions(['showError']),
        }
    }
</script>
