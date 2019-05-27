<template>
    <div class="container col-md-7 mb-5">
        <div class="card mx-auto">
            <div class="card-header">
                <div class="row">
                    <div class="card-title my-auto col">
                        Agregar Consumo
                    </div>
                    <input type="date" class="form-control col-3 mr-2" v-model="fecha">

                    <select class="custom-select col-3 mr-2" v-model="contr_id">
                        <option v-for="contratista in contratistas" :key="contratista.id" v-bind:value="contratista.id">
                           {{contratista.nombre}}
                        </option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" ref="table" id="table">
                        <thead class="thead-dark">
                            <tr>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                            </tr>
                            
                        </thead>
                        <tbody>
                            <tr v-for="(material) in materiales" :key="material.id" >
                                <td>{{material.codigo}}</td>
                                <td>{{material.descripcion}}</td>
                                <editable v-model="material.consumo"></editable>
                                
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <button type="button" @click="guardarConsumo()" class="btn btn-primary">Guardar</button>
            </div>
        </div>

    </div>
</template>

<script>

export default {

    data: function(){
        return{
            materiales: [],
            consumos: [],
            contratistas: [],
            contr_id: '',
            fecha: ''
        } 
    },

    methods: {
        listarMateriales(){
            let me = this;
            axios.get('/materiales/listar')
                .then(function (response) {
                    
                    me.materiales = response.data;
                
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });
        },
        listarContratistas(){
            let me = this;
            axios.get('/contratistas/listar')
                .then(function (response) {
                    
                    me.contratistas = response.data;
                
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });
        },

        printMateriales(){
            this.consumos = this.materiales.filter(
                (element) => element.consumo
            );

            this.consumos.forEach(
                function(v){ 
                    delete v.created_at;
                    delete v.updated_at;
                });

            
            return this.consumos;
        },

        guardarConsumo(){
        var me = this;
        axios.post('/consumo/agregar', {
                fecha: me.fecha,
                datos_consumo: JSON.stringify(me.printMateriales()),
                contratista_id: me.contr_id

            })
            .then(function (response) {
                console.log(response);
                alert(response);
            })
            .catch(function (error) {
                console.log(error);
                alert(error);
            });
        }   

    },

    

    mounted() {
            this.listarMateriales();
            this.listarContratistas();
        },
}

</script>

<style lang="css">
    
</style>