<template>
<div class="full">
    <div class="container col-md-7">
        <div class="card">
            <div class="card-header">
                <p class="card-title">Lista de usuarios</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" ref="table" id="table">
                        <thead class="thead-dark">
                            <tr>
                                <td>Id</td>
                                <td>Nombre</td>
                                <td>e-mail</td>
                                <td>Rol</td>
                                <td>Contratista</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users" :key="user.id">
                                <td>{{user.id}}</td>
                                <td>{{user.name}}</td>
                                <td>{{user.email}}</td>
                                <td>{{}}</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    
    data: function(){
        return {
            users:[],
            roles_user: []
        } 
    },

    methods:{
        getUsers(){
            let me = this;
            axios.get('/user/list')
                .then(function (response) {
                    // handle success
                    me.users = response.data;
                    console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });
        },
        getRole(){
            let me = this;
            axios.get('/user/roles')
                .then(function (response) {
                    // handle success
                    me.roles_user = response.data;
                    console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });
        },
    },

    mounted(){
        this.getUsers();
    }
}
</script>

<style>

</style>