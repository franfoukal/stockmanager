<template>
<div class="full">
    <div class="container col-md-7">
        <div class="card">
            <div class="card-header">
                <p class="card-title">Lista de usuarios</p>
            </div>
            <div class="card-body">
                <div class="table-responsive" :key="refresh">
                    <table class="table table-bordered" ref="table" id="table">
                        <thead class="thead-dark">
                            <tr>
                                <td>#</td>
                                <td>Nombre</td>
                                <td>e-mail</td>
                                <td>Rol</td>
                                <td>Contratista</td>
                                <td>Acciones</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users" :key="user.id">
                                <td>{{user.id}}</td>
                                <td>{{user.name}}</td>
                                <td>{{user.email}}</td>
                                <td>{{user.roles[0].name}}</td>
                                <td>{{user.contratista[0] == null ? "" : user.contratista[0].nombre}}</td>
                                <td>
                                    <button type="button" class="btn btn-outline-info" @click="openModal(user)">Editar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" :class="{'mostrar' : modal}">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="alert alert-warning" v-if="error==1" :key="error">
            <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
            <p v-for="errores in msjesError" :key="errores">{{errores}}</p>
        </div>
        
        <!--/form imput -->
        <div class="col-auto">
        <label class="sr-only" for="inlineFormInputGroup">Nombre</label>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="fas fa-user"></i>
            </div>
            </div>
            <input type="text" disabled class="form-control" v-model="name" placeholder="Nombre">
        </div>
        </div>
        <!--/form imput -->
        <div class="col-auto">
        <label class="sr-only" for="inlineFormInputGroup">email</label>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="fas fa-envelope"></i>
            </div>
            </div>
            <input type="text" class="form-control" v-model="email" placeholder="e-mail" disabled>
        </div>
        </div>
        <!--/form imput -->
        <div class="col-auto">
        <label class="sr-only" for="inlineFormInputGroup">Rol</label>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="fas fa-user-tag"></i>
            </div>
            </div>
            <select class="form-control" name="" id="" v-model="role">
                <option value="">Elegir Rol...</option>
                <option v-for="role in roles" :key="role.id" :value="role.id">
                    {{role.name}}
                </option>

            </select>
        </div>
        </div>
        <!--/form imput -->
        <div class="col-auto">
        <label class="sr-only" for="inlineFormInputGroup">Rol</label>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="fas fa-truck-pickup"></i>
            </div>
            </div>
            <select class="form-control" v-model="cont">
                <option value="">Elegir Contratista...</option>
                <option v-for="contratista in conts" :key="contratista.id" :value="contratista.id">
                    {{contratista.nombre}} - {{contratista.centro_SAP}}
                </option>
            </select>
        </div>
        </div>
        <!--/form imput -->

        

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeModal()">Close</button>
        <button type="button" class="btn btn-primary" @click="editUser()">Save changes</button>
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
            modal: 0,
            refresh: 0,
            id: '',
            name: '',
            email: '',
            role: '',
            cont:'',
            users:[],
            conts:[],
            roles:[],
            error: 0,
            msjesError: []
        } 
    },

    methods:{

        openModal(user){
            this.id = user.id;
            this.name = user.name;
            this.email = user.email;
            this.role = user.roles[0].id;
            this.cont = user.contratista[0] == null ? "" : user.contratista[0].id;
            this.modal = 1;
        },

        closeModal(){
            this.error = 0;
            this.msjesError = '';
            this.id = '';
            this.name = '';
            this.email = '';
            this.role = '';
            this.cont = '';
            this.modal = 0;
            this.refresh++;
        },

        getAllResponses(){
            var me = this;
            Promise.all([
                axios.get('/user/list'),
                axios.get('/contratistas/listar'),
                axios.get('/user/roles')
                ]).then(axios.spread((userRes, contRes, rolesRes) => {
                    me.users = userRes.data;
                    me.conts = contRes.data;
                    me.roles = rolesRes.data;

                    console.log(userRes, contRes, rolesRes);
                }));
        },

        validarCampos(){
        this.error = 0;
        this.msjesError = [];

        if (!this.id) this.msjesError.push("Error, reintentar.");
        if (!this.role) this.msjesError.push("El rol del usuario debe estar definido.");
        if (this.msjesError.length) this.error = 1;

        return this.error;
      },

      editUser(){
          var me = this;
            if (this.validarCampos()) {
            return;
            }
            console.log(this.id, this.role, this.cont);
            axios.post('/user/config', {
                    id: this.id,
                    id_role: this.role,
                    id_cont: this.cont == null ? '' : this.cont
                })
                .then(function (response) {
                    me.getAllResponses();
                    me.closeModal();
                })
                .catch(function (error) {
                    console.log(error);
                })
                .finally(function () {
                    
                });

        },

        update() {

            this.$forceUpdate();  
        }
        
    },

    mounted(){
        this.getAllResponses();
    }
}
</script>

<style>
.modal-content{
  width: 100% !important;
  position: absolute !important;
}
  .mostrar{
    display: list-item !important;
    opacity: 1 !important;
    position: absolute !important;
    background-color: #3c29297A;

  }
</style>