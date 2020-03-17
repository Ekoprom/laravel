<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <h5>Заказ {{ orderNumber }} от {{ orderDate }}</h5>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-9 mt-4" v-if="error">
                <div class="alert alert-danger" role="alert">{{ error }}</div>
            </div>

            <div class="col-md-9 mt-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Артикул</th>
                            <th scope="col">Наименование</th>
                            <th scope="col">Количество</th>
                            <th scope="col">Цена</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in order" v-bind:key="item">
                            <th scope="row">{{ item.art }}</th>
                            <td>{{ item.name }}</td>
                            <td>{{ item.quantity }}</td>
                            <td>{{ item.price }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
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