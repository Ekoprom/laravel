<template>
    <div class="container">
        <input v-model="name">
        <button class="btn btn-xs btn-primary" v-on:click="addTask()">Add</button>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" v-for="task, index in tasks">
                    <div class="card-header">{{ task.name }} ({{ task.id }})</div>
                    <div class="card-body">
                        <router-link :to="{ name: 'task', params: { id: task.id }}" class="btn btn-xs btn-default">Edit</router-link>
                        <button class="btn btn-xs btn-danger" v-on:click="deleteEntry(task.id, index)">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                tasks: [],
                name
            }
        },
   
        mounted() {
            var app = this;
            axios.get('/api/tasks')
                .then(function(resp) { 
                    app.tasks = resp.data
                })
                .catch(function(resp) {
                    console.log(resp)
                });
        },

        methods: {
            addTask() {
                const app = this;
                const data = { 'name' : app.name };
                axios.post('/api/tasks', data)
                    .then(function(resp) { 
                        app.tasks.push(resp.data);
                        app.name = '';
                    })
                    .catch(function(resp) {
                        console.log(resp)
                    });
            },
            deleteEntry(id, index) {
                const app = this;
                axios.delete('/api/tasks/' + id)
                    .then(function(resp) { 
                        app.tasks.splice(index, 1);
                    })
                    .catch(function(resp) {
                        console.log(resp)
                    });
            }
        }
    }
</script>
