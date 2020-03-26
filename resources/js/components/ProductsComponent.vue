<template>
    <v-row justify="center">
        <v-col class="d-flex" cols="12" sm="6">
            <v-select
                label="Склад"
                :items="warehouses"
                :loading="!warehouses.length"
                :disabled="!warehouses.length"
                v-model="warehouseId"
                @change="warehouseChange"
            ></v-select>
        </v-col>
        <v-col md="12">
            <v-data-table 
                hide-default-footer
                :headers="headers" 
                :items="products"
                :items-per-page="itemsPerPage"
                :page.sync="page"
                :loading="!products.length || remainsLoading"
                @current-items="getItems" 
                @page-count="pageCount = $event"
            >
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
                remainsLoading: false,
                categories: [],
                products: [],
                cities: [],
                warehouses: [],
                warehouseId: null,
                currentItems: [],
                
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
            warehouseChange(id) {
                const app = this;
                
                app.products.forEach(element => {
                    element.free = null;
                    element.reserve = null;
                    element.quantity = null;
                })
                app.warehouseId = id;
                app.updateItems(app.currentItems);
            },

            updateItems(items) {
                const app = this;
                
                if (!items.length || !app.warehouseId) return;

                app.remainsLoading = true;
                const data = { items: [], warehouseId: app.warehouseId };
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
                            app.remainsLoading = false;
                        }
                    })
                    .catch(function(error) {
                        app.error = error.message;
                    });
            },

            getItems(items) {
                const app = this;
                app.currentItems = items;
                app.updateItems(app.currentItems);
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

            axios.get('/api/products', { params: {} })
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

            app.warehouseId = app.$state.warehouseId;
            app.warehouses = app.$state.warehouses;
            if (!app.warehouses.length) {
                axios.get('/api/warehouses')
                .then(function(resp) {
                    if (resp.data.error) {
                        app.error = resp.data.error;
                    } else {
                        app.error = null;
                        const warehousesData = resp.data.warehouses;

                        warehousesData.forEach(city => {
                            city.warehouses.forEach(item => {
                                app.warehouses.push({
                                    text: city.name + ' - ' + item.name,
                                    value: item.id,
                                });
                            });
                        });
                    }
                })
                .catch(function(error) {
                    app.error = error.message;
                });
            }
        },

        watch: {
            warehouses(newData) {
                const app = this;
                app.$state.warehouses = newData;
            },
            warehouseId(newData) {
                const app = this;
                app.$state.warehouseId = newData;
            }            
        }        
    }
</script>