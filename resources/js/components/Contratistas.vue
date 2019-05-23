<template>
<div>
<div class="container col-md-7">
    <div class="card">
              <div class="card-header">
                <div class="row">
                  <h3 class="card-title col my-auto">Lista de Contratistas</h3>
                  <button type="button col my-auto" @click="abrirModal('elementos', 'nuevo')" class="btn btn-secondary float-right mr-4"> 
                    <i class="fas fa-edit"></i> &nbsp; Nuevo
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <tbody><tr>
                    <th style="width: 10px">#</th>
                    <th>Nombre</th>
                    <th>Centro</th>
                    <th>Almacén</th>
                    <th>Acciones</th>
                  </tr>
                  <tr v-for="contratista in tableData" :key="contratista.id">
                    <td v-text="contratista.id"></td>
                    <td v-text="contratista.nombre"></td>
                    <td v-text="contratista.centro_SAP"></td>
                    <td v-text="contratista.almacen_SAP"></td>
                    <td> 
                      <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-warning btn-sm" @click="abrirModal('elementos', 'editar', contratista)"> 
                          <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" @click="borrar(contratista)"> 
                          <i class="fas fa-trash"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                  
                </tbody></table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a class="page-link" href="#">«</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">»</a></li>
                </ul>
              </div>
            </div>
            <!-- /.card-footer -->

    </div>
    <!-- /.card -->

            <!-- Modal -->
            <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" :class="{'mostrar' : modal}">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title"  v-text="tituloModal"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="cerrarModal()">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">

                    <div class="alert alert-warning" v-if="error==1">
                      <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                      <p v-for="(errores, index) in msjesError" :key="index">{{errores}}</p>
                    </div>

                    <form action="">

                      <!-- form imput -->
                      <div class="col-auto">
                        <label class="sr-only" for="inlineFormInputGroup">Nombre</label>
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              <i class="fas fa-barcode"></i>
                            </div>
                          </div>
                          <input type="text" class="form-control" v-model="nombre" placeholder="Nombre">
                        </div>
                      </div>
                      <!--/form imput -->
                      <div class="col-auto">
                        <label class="sr-only" for="inlineFormInputGroup">Centro</label>
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              <i class="fas fa-align-left"></i>
                            </div>
                          </div>
                          <input type="text" class="form-control" v-model="centro_SAP" placeholder="Centro SAP">
                        </div>
                      </div>
                      <!--/form imput -->
                      <div class="col-auto">
                        <label class="sr-only" for="inlineFormInputGroup">Almacen</label>
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              <i class="fas fa-align-left"></i>
                            </div>
                          </div>
                          <input type="text" class="form-control" v-model="almacen_SAP" placeholder="Almacén SAP">
                        </div>
                      </div>
                      <!--/form imput -->

                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="cerrarModal()">Close</button>
                    <button type="button" @click="agregar()" v-if="tipoAccion == 1" class="btn btn-primary">
                      <i class="fas fa-save"></i> Guardar
                    </button>
                    <button type="button" @click="editar()" v-if="tipoAccion == 2" class="btn btn-primary">
                      <i class="fas fa-edit"></i> Editar
                    </button>
                  </div>
                </div>
              </div>
            </div>

 </div>


</template>

<script>
export default {

  data: function(){
    return{
      tableData: [],
      contr_id: 0,
      nombre: '',
      centro_SAP: '',
      almacen_SAP: '',
      modal: 0,
      tituloModal: '',
      tipoAccion: 0,
      error: 0,
      msjesError: ['error']
    }
  },
  methods: {
    listar(){
      let me = this;
      axios.get('/contratistas/listar')
          .then(function (response) {
            // handle success
            me.tableData = response.data; 
          })
          .catch(function (error) {
            // handle error
            console.log(error);
          })
          .finally(function () {
            // always executed
          });
    },

    agregar(){
        if (this.validarCampos()) {
            return;
        }

        let me = this;
        axios.post('/contratistas/agregar', {
          nombre: this.nombre,
          centro_SAP: this.centro_SAP,
          almacen_SAP: this.almacen_SAP
        })
        .then(function (response) {
          me.cerrarModal();
          
        })
        .catch(function (error) {
          console.log(error);
        })
        .finally(function () {
            me.listar();
        });
    },

    editar(){
        if (this.validarCampos()) {
          return;
        }

        let me = this;
        axios.post('/contratistas/actualizar', {
          id: this.contr_id,
          nombre: this.nombre,
          centro_SAP: this.centro_SAP,
          almacen_SAP: this.almacen_SAP
        })
        .then(function (response) {
          me.cerrarModal();
          
        })
        .catch(function (error) {
          console.log(error);
        })
        .finally(function () {
            me.listar();
        });
    },

    borrar(data = []){

        let me = this;
        var uri = '/contratistas/eliminar/' + data.id;
        axios.delete(uri)
        .then(function (response) {
          
        })
        .catch(function (error) {
          console.log(error);
        })
        .finally(function () {
            me.listar();
        });
    },

    abrirModal(modelo, accion, data = []){
      switch (modelo) {
       case 'elementos':{
            switch (accion){
              case 'nuevo':{
                this.modal = 1;
                this.tituloModal = 'Nueva Contratista';
                this.nombre = '';
                this.almacen_SAP = '';
                this.centro_SAP = '';
                this.tipoAccion = 1;
                break;
              }
              case 'editar':{
                this.modal = 1;
                this.tituloModal = 'Editar Contratista';
                this.contr_id = data.id;
                this.nombre = data.nombre;
                this.centro_SAP = data.centro_SAP;
                this.almacen_SAP = data.almacen_SAP;
                this.tipoAccion = 2;
                break;
              }
              case 'borrar':{
                this.contr_id = data.id;
                break;
              }
            }
       }
      }
    },

    cerrarModal(){
      this.modal = 0;
      this.tituloModal = '';
      this.nombre = '';
      this.centro_SAP = '';
      this.almacen_SAP = '';
      this.tipoAccion = '';
      this.error = 0;
      this.msjesError = '';
    },

    validarCampos(){
        this.error = 0;
        this.msjesError = [];

        if (!this.nombre) this.msjesError.push("El nombre no puede estar vacío.");
        if (!this.centro_SAP) this.msjesError.push("El centro no puede estar vacío.");
        if (!this.almacen_SAP) this.msjesError.push("El almacén no puede estar vacío.");
        if (this.msjesError.length) this.error = 1;

        return this.error;
      }
  },

  mounted() {
            this.listar();
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