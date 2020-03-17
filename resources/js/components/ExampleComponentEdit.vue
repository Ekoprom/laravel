<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <input v-model="task.name">
                <button class="btn btn-xs btn-primary" v-on:click="saveEntry()">Save</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                task: []
            }
        },

        mounted() {
            const app = this;
            const id = app.$route.params.id;

            axios.get('/api/tasks/' + id)
                .then(function(resp) { 
                    app.task = resp.data
                })
                .catch(function(resp) {
                    console.log(resp)
                });
        },

        methods: {
            saveEntry() {
                const app = this;

                axios.patch('/api/tasks/' + app.task.id, app.task)
                    .then(function(resp) { 
                        app.$router.replace('/app');
                    })
                    .catch(function(resp) {
                        console.log(resp);
                    });
            }
        }
    }
</script>
