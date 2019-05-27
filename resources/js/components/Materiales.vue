<template>
<div>
<div class="container col-md-7">
    <div class="card">
              <div class="card-header">
                <div class="row">
                  <h3 class="card-title col my-auto">Lista de Materiales</h3>
                  <button type="button col my-auto" @click="abrirModal('materiales', 'nuevo')" class="btn btn-secondary float-right mr-4"> 
                    <i class="fas fa-edit"></i> &nbsp; Nuevo
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered">
                  <tbody><tr>
                    <th style="width: 10px">#</th>
                    <th>Código</th>
                    <th>Material</th>
                    <th>Acciones</th>
                  </tr>
                  <tr v-for="material in tableData" :key="material.id">
                    <td v-text="material.id"></td>
                    <td v-text="material.codigo"></td>
                    <td v-text="material.descripcion"></td>
                    <td> 
                      <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-warning btn-sm" @click="abrirModal('materiales', 'editar', material)"> 
                          <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" @click="borrarMaterial(material)"> 
                          <i class="fas fa-trash"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                  
                </tbody></table>
                </div>
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
                        <label class="sr-only" for="inlineFormInputGroup">Código</label>
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              <i class="fas fa-barcode"></i>
                            </div>
                          </div>
                          <input type="text" class="form-control" v-model="codigo" placeholder="Código">
                        </div>
                      </div>
                      <!--/form imput -->
                      <div class="col-auto">
                        <label class="sr-only" for="inlineFormInputGroup">Descripcion</label>
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              <i class="fas fa-align-left"></i>
                            </div>
                          </div>
                          <input type="text" class="form-control" v-model="descripcion" placeholder="Descripción">
                        </div>
                      </div>
                      <!--/form imput -->

                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="cerrarModal()">Close</button>
                    <button type="button" @click="agregarMaterial()" v-if="tipoAccion == 1" class="btn btn-primary">
                      <i class="fas fa-save"></i> Guardar
                    </button>
                    <button type="button" @click="editarMaterial()" v-if="tipoAccion == 2" class="btn btn-primary">
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
      mat_id: 0,
      codigo: '',
      descripcion: '',
      modal: 0,
      tituloModal: '',
      tipoAccion: 0,
      error: 0,
      msjesError: ['error']
    }
  },
  methods: {
    listarMateriales(){
      let me = this;
      axios.get('/materiales/listar')
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

    agregarMaterial(){
        if (this.validarCampos()) {
            return;
        }

        let me = this;
        axios.post('/materiales/agregar', {
          codigo: this.codigo,
          descripcion: this.descripcion
        })
        .then(function (response) {
          me.cerrarModal();
          
        })
        .catch(function (error) {
          console.log(error);
        })
        .finally(function () {
            me.listarMateriales();
        });
    },

    editarMaterial(){
        if (this.validarCampos()) {
          return;
        }

        let me = this;
        axios.post('/materiales/actualizar', {
          id: this.mat_id,
          codigo: this.codigo,
          descripcion: this.descripcion
        })
        .then(function (response) {
          me.cerrarModal();
          
        })
        .catch(function (error) {
          console.log(error);
        })
        .finally(function () {
            me.listarMateriales();
        });
    },

    borrarMaterial(data = []){

        let me = this;
        var uri = '/materiales/eliminar/' + data.id;
        axios.delete(uri)
        .then(function (response) {
          
        })
        .catch(function (error) {
          console.log(error);
        })
        .finally(function () {
            me.listarMateriales();
        });
    },

    abrirModal(modelo, accion, data = []){
      switch (modelo) {
       case 'materiales':{
            switch (accion){
              case 'nuevo':{
                this.modal = 1;
                this.tituloModal = 'Nuevo Material';
                this.codigo = '';
                this.descripcion = '';
                this.tipoAccion = 1;
                break;
              }
              case 'editar':{
                this.modal = 1;
                this.tituloModal = 'Editar Material';
                this.mat_id = data.id;
                this.codigo = data.codigo;
                this.descripcion = data.descripcion;
                this.tipoAccion = 2;
                break;
              }
              case 'borrar':{
                this.mat_id = data.id;
                break;
              }
            }
       }
      }
    },

    cerrarModal(){
      this.modal = 0;
      this.tituloModal = '';
      this.codigo = '';
      this.descripcion = '';
      this.tipoAccion = '';
      this.error = 0;
      this.msjesError = '';
    },

    validarCampos(){
        this.error = 0;
        this.msjesError = [];

        if (!this.codigo) this.msjesError.push("El código de material no puede estar vacío.");
        if (!this.descripcion) this.msjesError.push("La descripción de material no puede estar vacía.");
        if (this.msjesError.length) this.error = 1;

        return this.error;
      }
  },

  mounted() {
            this.listarMateriales();
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
