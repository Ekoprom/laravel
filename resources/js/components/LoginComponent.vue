<template>
    <v-btn v-on:click="login()">LOGIN</v-btn>
</template>

<script>
export default {
    methods: {
        login() {
            const data = {
                'user': 'admin',
                'password': '12345678',
                'token': $('meta[name="csrf-token"]').attr('content')
            };

                axios.post('/login', { params: data,
                   headers: {
        'Authorization': 'Bearer '+ $('meta[name="csrf-token"]').attr('content'),
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
                })
                    .then(function(resp) {
                        if (resp.data.error) {
                            app.error = resp.data.error;
                        } else {
                            app.error = null;
                            console.log(resp.data);
                            app.remainsLoading = false;
                        }
                    })
                    .catch(function(error) {
                        app.error = error.message;
                    });
        }
    }    
}
</script>