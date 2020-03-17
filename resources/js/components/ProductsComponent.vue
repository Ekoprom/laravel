<template>
<v-row justify="center">
    <v-col md="12">
        <v-data-table :headers="headers" :items="products" @current-items="getItems" 
            :items-per-page="itemsPerPage"
            hide-default-footer
            :page.sync="page"
            :custom-filter="filter"
            @page-count="pageCount = $event">
            <template v-slot:item.free="{ item }">
                <v-chip :color="getColor(item.free)" dark>{{ item.free }}</v-chip>
            </template>
        </v-data-table>
        <div class="text-center pt-2">
            <v-pagination v-model="page" :length="pageCount" :total-visible="7" circle></v-pagination>
        </div>
    </v-col>
</v-row>
</template>

<script>
    export default {
        data: function() {
            return {
                error: null,
                loading: true,
                categories: [],
                products: [],

                page: 1,
                pageCount: 0,
                itemsPerPage: 15,
                headers: [
                    { text: 'Артикул', value: 'article' },
                    { text: 'Наименование', value: 'name' },
                    { text: 'Свободно', value: 'free' },
                    { text: 'В резерве', value: 'reserve' },
                    { text: 'Остаток', value: 'quantity' },
                ],
            }
        },

        methods: {
            activeCategoty(cat) {
                console.log(cat);
            },

            filter(value, search, item) {
                console.log('ggggg');
                /*return value != null &&
                search != null &&
                typeof value === 'string' &&
                value.toString().toLocaleUpperCase().indexOf(search) !== -1*/
                return true;
            },

            getItems(items) {
                if (!items.length) return
                const data = { items: [] };
                items.forEach(element => {
                    data.items.push(element.article);
                });

                axios.get('/api/products/remains', { params: data })
                    .then(function(resp) {
                        if (resp.data.error) {
                            app.error = resp.data.error;
                        } else {
                            app.error = null;
                            
                            resp.data.remains.forEach(element => {
                                const article = String(element.art);
                                let item = (items.find(el => el.article == article));
                                if (item) {
                                    item.quantity = element.quantity;
                                    item.free = element.free;
                                    item.reserve = element.reserve;
                                }
                            });
                        }
                    })
                    .catch(function(error) {
                        app.error = error.message;
                    });
            },

            getColor (num) {
                if (num == null) return 'transparent'
                else if (num < 5) return 'red'
                else if (num < 10) return 'orange'
                else return 'green'
            },                         
        },

        mounted() {
            const app = this;

            const data = {
            }

            axios.get('/api/products', { params: data })
                .then(function(resp) {
                    if (resp.data.error) {
                        app.error = resp.data.error;
                    } else {
                        app.error = null;
                        app.products = resp.data.items;
                        app.categories = resp.data.categories;
                    }
                })
                .catch(function(error) {
                    app.error = error.message;
                });
        }
    }
</script>