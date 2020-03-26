<template>
   <v-row>
        <v-col>
            <v-text-field
                v-model="user.name"
                label="Имя"
                disabled
            ></v-text-field>
        </v-col>
        <v-col>  
            <v-text-field
                v-model="user.email"
                label="Почта"
                disabled
            ></v-text-field>    
        </v-col>
    </v-row>
</template>

<script>
    export default {
        data: () => ({
            user: {}
        }),

        mounted() {
            const app = this;

            app.user = app.$state.user;
            if (!app.user.length) {
            axios.get('/api/user')
                .then(function(resp) {
                    if (resp.data.error) {
                        app.error = resp.data.error;
                    } else {
                        app.error = null;
                        app.user = resp.data;
                    }
                })
                .catch(function(error) {
                    app.error = error.message;
                });
            }
        },

        watch: {
            user(newData) {
                const app = this;
                app.$state.user = newData;
            }
        }
    }
</script>