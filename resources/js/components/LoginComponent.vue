<template>
<v-container>
    <v-card class="mx-auto" max-width="600">
        <v-card-title>
            <h3>Вход в кабинет дилера</h3>
        </v-card-title>

        <v-card-text>
            <v-slide-y-transition>
            <v-alert v-show="error !== null" type="error">
                {{ error }}
            </v-alert>
            </v-slide-y-transition>
            <v-form ref="form" v-model="valid" lazy-validation>
                <v-text-field 
                    label="Почта"
                    v-model="email"
                    :rules="emailRules"
                    :disabled="loading"
                    required
                ></v-text-field>
                <v-text-field
                    label="Пароль"
                    v-model="password"
                    :type="'password'"
                    :rules="passowrdRules"
                    :disabled="loading"
                    required
                ></v-text-field>

                <v-btn :disabled="!valid" :loading="loading"  @click="login" color="success">Вход</v-btn>
            </v-form>
        </v-card-text>
    </v-card>
</v-container>    
</template>

<script>
export default {
    data: () => ({
        error: null,
        valid: true,
        loading: false,
        email: '',
        emailRules: [
            v => !!v || 'Обязательно для заполнения',
            v => /.+@.+\..+/.test(v) || 'Не валидный адрес почты',
        ],
        password: '',
        passowrdRules: [
            v => !!v || 'Обязательно для заполнения',
      ],
    }),

    methods: {
        login() {
            const app = this;
        
            if (!app.$refs.form.validate()) return;

            app.loading = true;
            axios.post('/login', {
                    email: app.email,
                    password: app.password
                })
                .then(function(resp) {
                    app.loading = false;
                    if (resp.data.error) {
                        app.error = resp.data.error;
                    } else {
                        if (resp.data.auth) window.location = '/app';
                    }
                })
                .catch(function(error) {
                    if (error.response.status == 422) app.error = 'Не верные почта и пароль';
                    if (error.response.status == 429) app.error = 'Слишком много попыток входа';
                    app.loading = false;
                });
        }
    }    
}
</script>