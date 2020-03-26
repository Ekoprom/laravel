<template>
    <v-simple-table>
        <template v-slot:default>
            <thead>
                <tr>
                    <th class="text-left">Артикул</th>
                    <th class="text-left">Наименование</th>
                    <th class="text-left">Количество</th>
                    <th class="text-left">Цена</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in order" :key="item.name">
                    <td>{{ item.art }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.quantity }}</td>
                    <td>{{ item.price }}</td>
                </tr>
            </tbody>
        </template>
    </v-simple-table>
</template>

<script>
    import moment from 'moment';

    export default {
        data: function() {
            return {
                error: null,
                loading: false,
                orderNumber: '',
                orderDate: '',
                order: [],
            }
        },

        mounted() {
            const app = this;
 
            const data = {
                'number': app.$route.params.number,
                'date': app.$route.params.date,
            }

            app.orderNumber = data.number;
            app.orderDate = data.date.substr(6, 2) + '.' + data.date.substr(4, 2)+ '.' + data.date.substr(0, 4);

            axios.get('/api/order', { params: data })
                .then(function(resp) {
                    if (resp.data.error) {
                        app.error = resp.data.error;
                    } else {
                        app.error = null;
                        const order = resp.data.order;
                        if (order) app.order = order;
                    }
                })
                .catch(function(error) {
                    app.error = error.message;
                });
        }
    }
</script>